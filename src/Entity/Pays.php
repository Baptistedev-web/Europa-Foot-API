<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\PaysRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PaysRepository::class)]
#[ORM\UniqueConstraint(
    name: "nom_unique",
    columns: ["nom"]
)]
#[ApiResource(
    operations: [
        new GetCollection(
            description: "Récupère une collection de ressources Pays.",
            normalizationContext: ['groups' => ['Pays: read']],
        ),
        new Get(
            description: "Récupère une ressource Pays.",
            normalizationContext: ['groups' => ['Pays: read']],
        ),
        new Post(
            description: "Crée une ressource Pays.",
            denormalizationContext: ['groups' => ['Pays: write']],
            security: "is_granted('ROLE_ADMIN')"
        ),
        new Put(
            description: "Met à jour une ressource Pays.",
            normalizationContext: ['groups' => ['Pays: read']],
            denormalizationContext: ['groups' => ['Pays: write']],
            security: "is_granted('ROLE_ADMIN')"
        ),
        new Delete(
            description: "Supprime une ressource Pays.",
            security: "is_granted('ROLE_ADMIN')"
        ),
    ],
    paginationItemsPerPage: 10,
    paginationMaximumItemsPerPage: 100,
    normalizationContext: ['groups' => ['Pays: read']],
    denormalizationContext: ['groups' => ['Pays: write']],
    formats: ['jsonld', 'json'],
    cacheHeaders: [
        'max_age' => 3600, // Cache pour 1 heure
        'shared_max_age' => 3600,
        'vary' => ['Authorization', 'Accept-Language'],
    ],
)]
class Pays
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['Pays: read', 'Pays: write'])]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: "Le nom du pays ne peut pas être vide.")]
    #[Assert\Length(
        min: 3,
        minMessage: "Le nom du pays doit contenir au moins {{ limit }} caractères.",
        max: 100,
        maxMessage: "Le nom du pays ne peut pas dépasser {{ limit }} caractères."
    )]
    #[Assert\Regex(
        pattern: "/^[A-Z][a-zA-Zéèêëàâäîïôöùûüç' \-]{2,99}$/u",
        message: "Le nom du pays ne peut contenir que des lettres, des accents, des espaces, des apostrophes ou des tirets, et doit commencer par une majuscule."
    )]
    private ?string $nom = null;

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

    #[Groups(['Pays: read'])]
    public function getLinks(): array
    {
        return [
            'self' => '/api/pays/' . $this->id,
            'update' => '/api/pays/' . $this->id,
            'delete' => '/api/pays/' . $this->id,
        ];
    }
}
