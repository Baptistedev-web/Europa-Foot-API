<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\TypeCompetitionRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TypeCompetitionRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(
            description: 'Récupère une collection de ressources Type de Compétition.',
            normalizationContext: ['groups' => ['TypeCompetitions: read']],
        ),
        new Get(
            description: 'Récupère une ressource Type de Compétition.',
            normalizationContext: ['groups' => ['TypeCompetitions: read']],
        ),
        new Post(
            description: 'Crée une ressource Type de Compétition.',
            denormalizationContext: ['groups' => ['TypeCompetitions: write']],
            security: "is_granted('ROLE_ADMIN')"
        ),
        new Put(
            description: 'Met à jour une ressource Type de Compétition.',
            denormalizationContext: ['groups' => ['TypeCompetitions: write']],
            security: "is_granted('ROLE_ADMIN')"
        ),
        new Delete(
            description: 'Supprime une ressource Type de Compétition.',
            security: "is_granted('ROLE_ADMIN')"
        ),
    ],
    paginationItemsPerPage: 10,
    paginationMaximumItemsPerPage: 100,
    normalizationContext: ['groups' => ['TypeCompetitions: read']],
    denormalizationContext: ['groups' => ['TypeCompetitions: write']],
    formats: ['jsonld', 'json'],
    cacheHeaders: [
        'max_age' => 3600, // Cache pour 1 heure
        'shared_max_age' => 3600,
        'vary' => ['Authorization', 'Accept-Language'],
    ],
)]
class TypeCompetition
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['TypeCompetitions: read', 'TypeCompetitions: write'])]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    #[Assert\NotBlank(message: 'Le libellé ne doit pas être vide.')]
    #[Assert\Length(
        min: 5,
        minMessage: 'Le libellé doit contenir au moins {{ limit }} caractères.',
        max: 30,
        maxMessage: 'Le libellé ne doit pas dépasser {{ limit }} caractères.'
    )]
    #[Groups(['TypeCompetitions: read', 'TypeCompetitions: write'])]
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
    #[Groups(['TypeCompetitions: read'])]
    public function getLinks(): array
    {
        return [
            'self' => '/api/type_competitions/' . $this->id,
            'update' => '/api/type_competitions/' . $this->id,
            'delete' => '/api/type_competitions/' . $this->id,
        ];
    }
}
