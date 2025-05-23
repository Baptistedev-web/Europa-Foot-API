<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\CompetitionSaisonRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CompetitionSaisonRepository::class)]
#[ApiResource(
    paginationItemsPerPage: 10,
    paginationMaximumItemsPerPage: 100,
    normalizationContext: ['groups' => ['CompetitionSaisons: read']],
    denormalizationContext: ['groups' => ['CompetitionSaisons: write']],
    operations: [
        new GetCollection(
            description: 'Récupère une collection de ressources Saison de Compétition.',
            normalizationContext: ['groups' => ['CompetitionSaisons: read']],
        ),
        new Get(
            description: 'Récupère une ressource Saison de Compétition.',
            normalizationContext: ['groups' => ['CompetitionSaisons: read']],
        ),
        new Post(
            description: 'Crée une ressource Saison de Compétition.',
            denormalizationContext: ['groups' => ['CompetitionSaisons: write']],
            security: "is_granted('ROLE_ADMIN')",
            securityMessage: "Vous devez être administrateur pour créer cette ressource.",
        ),
        new Put(
            description: 'Remplace la ressource Saison de Compétition.',
            normalizationContext: ['groups' => ['CompetitionSaisons: read']],
            denormalizationContext: ['groups' => ['CompetitionSaisons: write']],
            security: "is_granted('ROLE_ADMIN')",
            securityMessage: "Vous devez être administrateur pour modifier cette ressource.",
        ),
        new Delete(
            description: 'Supprime la ressource Saison de Compétition.',
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
class CompetitionSaison
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['CompetitionSaisons: read', 'saison: read', 'competition: read'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'competitionSaisons')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['CompetitionSaisons: read', 'CompetitionSaisons: write'])]
    private ?Saison $saison = null;

    #[ORM\ManyToOne(inversedBy: 'competitionSaisons')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['CompetitionSaisons: read', 'CompetitionSaisons: write'])]
    private ?Competition $competition = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSaison(): ?Saison
    {
        return $this->saison;
    }

    public function setSaison(?Saison $saison): static
    {
        $this->saison = $saison;

        return $this;
    }

    public function getCompetition(): ?Competition
    {
        return $this->competition;
    }

    public function setCompetition(?Competition $competition): static
    {
        $this->competition = $competition;

        return $this;
    }
    #[Groups(['saison: read', 'competition: read', 'CompetitionSaisons: read'])]
    public function getLinks(): array
    {
        return [
            'self' => '/api/competition_saisons/' . $this->id,
            'update' => '/api/competition_saisons/' . $this->id,
            'delete' => '/api/competition_saisons/' . $this->id,
        ];
    }
}
