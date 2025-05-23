<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\StatutRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: StatutRepository::class)]
#[ORM\UniqueConstraint(
    name: "libelle_unique",
    columns: ["libelle"]
)]
#[ApiResource(
    paginationItemsPerPage: 10,
    paginationMaximumItemsPerPage: 100,
    normalizationContext: ['groups' => ['Statuts: read']],
    denormalizationContext: ['groups' => ['Statuts: write']],
    operations: [
        new GetCollection(
            description: 'Récupère une collection de ressources Statut.',
            normalizationContext: ['groups' => ['Statuts: read']]
        ),
        new Get(
            description: 'Récupère une ressource Statut.',
            normalizationContext: ['groups' => ['Statuts: read']]
        ),
        new Post(
            description: 'Crée une ressource Statut.',
            denormalizationContext: ['groups' => ['Statuts: write']],
            security: "is_granted('ROLE_ADMIN')",
            securityMessage: "Vous devez être administrateur pour créer cette ressource.",
        ),
        new Put(
            description: 'Remplace la ressource Statut.',
            normalizationContext: ['groups' => ['Statuts: read']],
            denormalizationContext: ['groups' => ['Statuts: write']],
            security: "is_granted('ROLE_ADMIN')",
            securityMessage: "Vous devez être administrateur pour modifier cette ressource.",
        ),
        new Delete(
            description: 'Supprime la ressource Statut.',
            security: "is_granted('ROLE_ADMIN')",
            securityMessage: "Vous devez être administrateur pour supprimer cette ressource.",
        ),
    ],
    formats: ['jsonld', 'json'],
    cacheHeaders: [
        'max_age' => 3600, // Cache pour 1 heure
        'shared_max_age' => 3600,
        'vary' => ['Authorization', 'Accept-Language'],
    ],
)]
class Statut
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['Statuts: read'])]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: 'Le libellé ne peut pas être vide.')]
    #[Assert\Length(
        min: 2,
        minMessage: 'Le libellé doit contenir au moins {{ limit }} caractères.',
        max: 50,
        maxMessage: 'Le libellé ne peut pas dépasser {{ limit }} caractères.'
    )]
    #[Assert\Regex(
        pattern: '/^[a-zA-Z\s]+$/',
        message: 'Le libellé ne peut contenir que des lettres et des espaces.'
    )]
    #[Groups(['Statuts: read', 'Statuts: write'])]
    private ?string $libelle = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): static
    {
        $this->libelle = $libelle;

        return $this;
    }

    #[Groups(['Statuts: read'])]
    public function getLinks(): array
    {
        return [
            'self' => '/api/statuts/' . $this->id,
            'update' => '/api/statuts/' . $this->id,
            'delete' => '/api/statuts/' . $this->id,
        ];
    }
}
