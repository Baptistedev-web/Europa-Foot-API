<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\PlacementRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: PlacementRepository::class)]
#[ORM\UniqueConstraint(
    name: "code_unique",
    columns: ["code"]
)]
#[ORM\UniqueConstraint(
    name: "nom_unique",
    columns: ["nom"]
)]
#[ApiResource(
    operations: [
        new GetCollection(
            description: "Récupère une collection de ressources Placement.",
            normalizationContext: ['groups' => ['Placements: read']],
        ),
        new Get(
            description: "Récupère une ressource Placement.",
            normalizationContext: ['groups' => ['Placements: read']],
        ),
        new Post(
            description: "Crée une ressource Placement.",
            denormalizationContext: ['groups' => ['Placements: write']],
            security: "is_granted('ROLE_ADMIN')",
            securityMessage: "Vous devez être administrateur pour créer un placement."
        ),
        new Put(
            description: "Met à jour une ressource Placement.",
            normalizationContext: ['groups' => ['Placements: read']],
            denormalizationContext: ['groups' => ['Placements: write']],
            security: "is_granted('ROLE_ADMIN')",
            securityMessage: "Vous devez être administrateur pour mettre à jour un placement."
        ),
        new Delete(
            description: "Supprime une ressource Placement.",
            security: "is_granted('ROLE_ADMIN')",
            securityMessage: "Vous devez être administrateur pour supprimer un placement."
        )
    ],
    paginationItemsPerPage: 10,
    paginationMaximumItemsPerPage: 100,
    normalizationContext: ['groups' => ['Placements: read']],
    denormalizationContext: ['groups' => ['Placements: write']],
    formats: ['jsonld', 'json'],
    cacheHeaders: [
        'max_age' => 3600, // Cache pour 1 heure
        'shared_max_age' => 3600,
        'vary' => ['Authorization', 'Accept-Language'],
    ],
)]
class Placement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['Placements: read', 'Placements: write'])]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: 'Le nom ne doit pas être vide.')]
    #[Assert\Length(
        min: 3,
        max: 100,
        minMessage: 'Le nom doit contenir au moins {{ limit }} caractères.',
        maxMessage: 'Le nom ne peut pas dépasser {{ limit }} caractères.'
    )]
    #[Assert\Regex(
        pattern: '/^[a-zA-Z\s\-]+$/',
        message: 'Le nom ne peut contenir que des lettres, des espaces et des tirets.'
    )]
    #[Groups(['Placements: read', 'Placements: write'])]
    private ?string $nom = null;

    #[ORM\Column(length: 5)]
    #[Assert\NotBlank(message: 'Le code ne doit pas être vide.')]
    #[Assert\Length(
        min: 2,
        max: 5,
        minMessage: 'Le code doit contenir au moins {{ limit }} caractères.',
        maxMessage: 'Le code ne peut pas dépasser {{ limit }} caractères.'
    )]
    #[Assert\Regex(
        pattern: '/^[A-Z]+$/',
        message: 'Le code ne peut contenir que des lettres majuscules.'
    )]
    #[Groups(['Placements: read', 'Placements: write'])]
    private ?string $code = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
    }

    #[Groups(['Placements: read'])]
    public function getLinks(): array
    {
        return [
            'self' => '/api/placements/' . $this->id,
            'update' => '/api/placements/' . $this->id,
            'delete' => '/api/placements/' . $this->id,
        ];
    }
}
