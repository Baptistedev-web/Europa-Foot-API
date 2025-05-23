<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\SaisonRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Doctrine\ORM\Mapping\PrePersist;

#[ORM\Entity(repositoryClass: SaisonRepository::class)]
#[ORM\UniqueConstraint(
    name: "saison_unique",
    columns: ["label"]
)]
#[ApiResource(
    operations: [
        new GetCollection(
            uriTemplate: '/saisons',
            description: 'Récupère une collection de ressources Saison.',
            normalizationContext: ['groups' => ['saison: read']],
        ),
        new Get(
            uriTemplate: '/saisons/{id}',
            description: 'Récupère une ressource Saison.',
            normalizationContext: ['groups' => ['saison: read']],
        ),
        new Post(
            uriTemplate: '/saisons',
            description: 'Crée une ressource Saison.',
            denormalizationContext: ['groups' => ['saison: write']],
            security: "is_granted('ROLE_ADMIN')",
        ),
        new Put(
            uriTemplate: '/saisons/{id}',
            description: 'Met à jour une ressource Saison.',
            normalizationContext: ['groups' => ['saison: read']],
            denormalizationContext: ['groups' => ['saison: write']],
            security: "is_granted('ROLE_ADMIN')",
        ),
        new Delete(
            uriTemplate: '/saisons/{id}',
            description: 'Supprime une ressource Saison.',
            security: "is_granted('ROLE_ADMIN')",
        )
    ],
    paginationItemsPerPage: 10,
    paginationMaximumItemsPerPage: 100,
    normalizationContext: ['groups' => ['saison: read']],
    denormalizationContext: ['groups' => ['saison: write']],
    formats: ['jsonld', 'json'],
    cacheHeaders: [
        'max_age' => 3600, // Cache pour 1 heure
        'shared_max_age' => 3600,
        'vary' => ['Authorization', 'Accept-Language'],
    ],
)]
#[ORM\HasLifecycleCallbacks]
class Saison
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['saison: read'])]
    private ?int $id = null;

    #[ORM\Column(length: 9)]
    #[Assert\Length(
        min: 9,
        max: 9,
        exactMessage: 'Le label doit contenir exactement {{ limit }} caractères.'
    )]
    #[Assert\Regex(
        pattern: '/^(19|20)\d{2}-(19|20)\d{2}$/',
        message: 'Le label doit être au format YYYY-YYYY.'
    )]
    #[ApiProperty(openapiContext: [
        'type' => 'string',
        'format' => 'YYYY-YYYY+1',
        'example' => '2025-2026'
    ])]
    #[Groups(['saison: read', 'saison: write'])]
    private ?string $label = null;

    #[ORM\Column(length: 10)]
    #[Assert\Regex(
        pattern: '/^\d{4}-\d{2}-\d{2}$/',
        message: 'La date de début doit être au format YYYY-MM-DD.'
    )]
    #[Groups(['saison: read'])]
    private ?string $debut = null;

    #[ORM\Column(length: 10)]
    #[Assert\Regex(
        pattern: '/^\d{4}-\d{2}-\d{2}$/',
        message: 'La date de fin doit être au format YYYY-MM-DD.'
    )]
    #[Groups(['saison: read'])]
    private ?string $fin = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;
        $this->updateDatesFromLabel();
        return $this;
    }

    public function getDebut(): ?string
    {
        return $this->debut;
    }

    public function setDebut(?string $debut): static
    {
        $this->debut = $debut;
        return $this;
    }

    public function getFin(): ?string
    {
        return $this->fin;
    }

    public function setFin(?string $fin): static
    {
        $this->fin = $fin;
        return $this;
    }

    #[Assert\Callback]
    public function validateLabel(ExecutionContextInterface $context)
    {
        if ($this->label) {
            if (!preg_match('/^(19|20)\d{2}-(19|20)\d{2}$/', $this->label)) {
                return;
            }
            [$start, $end] = explode('-', $this->label);
            if (((int)$end - (int)$start) !== 1) {
                $context->buildViolation('L\'année de fin doit être l\'année de début + 1.')
                    ->atPath('label')
                    ->addViolation();
            }
        }
    }

    #[Assert\Callback]
    public function validateDebut(ExecutionContextInterface $context)
    {
        if ($this->label && $this->debut) {
            [$start, ] = explode('-', $this->label);
            $expected = $start . '-08-01';
            if ($this->debut !== $expected) {
                $context->buildViolation('La date de début doit être le 01/08 de l\'année de début du label.')
                    ->atPath('debut')
                    ->addViolation();
            }
        }
    }

    #[Assert\Callback]
    public function validateFin(ExecutionContextInterface $context)
    {
        if ($this->label && $this->fin) {
            [, $end] = explode('-', $this->label);
            $expected = $end . '-07-01';
            if ($this->fin !== $expected) {
                $context->buildViolation('La date de fin doit être le 01/07 de l\'année de fin du label.')
                    ->atPath('fin')
                    ->addViolation();
            }
        }
    }

    /**
     * Met à jour les dates debut et fin à partir du label si celui-ci est valide.
     * Les dates sont stockées comme objets DateTime, mais aussi comme chaînes pour la désérialisation.
     */
    private function updateDatesFromLabel(): void
    {
        if ($this->label && preg_match('/^(19|20)\d{2}-(19|20)\d{2}$/', $this->label)) {
            [$start, $end] = explode('-', $this->label);
            $this->debut = $start . '-08-01';
            $this->fin = $end . '-07-01';
        }
    }

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function prePersistOrUpdate(): void
    {
        $this->updateDatesFromLabel();
    }

    #[Groups(['saison: read'])]
    public function getLinks(): array
    {
        return [
            'self' => '/api/saisons/' . $this->id,
            'update' => '/api/saisons/' . $this->id,
            'delete' => '/api/saisons/' . $this->id,
        ];
    }
}
