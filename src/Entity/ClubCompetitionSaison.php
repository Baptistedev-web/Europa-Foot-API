<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\ClubCompetitionSaisonRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ClubCompetitionSaisonRepository::class)]
#[ApiResource(
    paginationItemsPerPage: 10,
    paginationMaximumItemsPerPage: 100,
    normalizationContext: ['groups' => ['ClubCompetitionSaisons: read']],
    denormalizationContext: ['groups' => ['ClubCompetitionSaisons: write']],
    operations: [
        new GetCollection(
            uriTemplate: '/club-competition_saisons',
            description: 'Récupère une collection de ressources ClubCompetitionSaison.',
            normalizationContext: ['groups' => ['ClubCompetitionSaisons: read']],
        ),
        new Get(
            uriTemplate: '/club-competition_saisons/{id}',
            description: 'Récupère une ressource ClubCompetitionSaison.',
            normalizationContext: ['groups' => ['ClubCompetitionSaisons: read']],
        ),
        new Post(
            uriTemplate: '/club-competition_saisons',
            description: 'Crée une ressource ClubCompetitionSaison.',
            denormalizationContext: ['groups' => ['ClubCompetitionSaisons: write']],
            security: "is_granted('ROLE_ADMIN')",
            securityMessage: "Vous devez être administrateur pour créer une ressource ClubCompetitionSaison.",
        ),
        new Put(
            uriTemplate: '/club-competition_saisons/{id}',
            description: 'Met à jour une ressource ClubCompetitionSaison.',
            normalizationContext: ['groups' => ['ClubCompetitionSaisons: read']],
            denormalizationContext: ['groups' => ['ClubCompetitionSaisons: write']],
            security: "is_granted('ROLE_ADMIN')",
            securityMessage: "Vous devez être administrateur pour mettre à jour une ressource ClubCompetitionSaison.",
        ),
        new Delete(
            uriTemplate: '/club-competition_saisons/{id}',
            description: 'Supprime une ressource ClubCompetitionSaison.',
            security: "is_granted('ROLE_ADMIN')",
            securityMessage: "Vous devez être administrateur pour supprimer une ressource ClubCompetitionSaison.",
        ),
    ],
    formats: ['jsonld', 'json'],
    cacheHeaders: [
        'max_age' => 3600, // Cache pour 1 heure
        'shared_max_age' => 3600,
        'vary' => ['Authorization', 'Accept-Language'],
    ],
)]
class ClubCompetitionSaison
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['ClubCompetitionSaisons: read', 'ClubCompetitionSaisons: write', 'Clubs: read', 'CompetitionSaisons: read'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'clubCompetitionSaisons')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull]
    #[Groups(['ClubCompetitionSaisons: read', 'ClubCompetitionSaisons: write', 'Clubs: read'])]
    private ?CompetitionSaison $competitionSaison = null;

    #[ORM\ManyToOne(inversedBy: 'clubCompetitionSaisons')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull]
    #[Groups(['ClubCompetitionSaisons: read', 'ClubCompetitionSaisons: write', 'CompetitionSaisons: read'])]
    private ?Club $club = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompetitionSaison(): ?CompetitionSaison
    {
        return $this->competitionSaison;
    }

    public function setCompetitionSaison(?CompetitionSaison $competitionSaison): static
    {
        $this->competitionSaison = $competitionSaison;

        return $this;
    }

    public function getClub(): ?Club
    {
        return $this->club;
    }

    public function setClub(?Club $club): static
    {
        $this->club = $club;

        return $this;
    }
    #[Groups(['ClubCompetitionSaisons: read', 'CompetitionSaisons: read', 'Clubs: read'])]
    public function getLinks(): array
    {
        return [
            'self' => '/api/club-competition_saisons/' . $this->id,
            'update' => '/api/club-competition_saisons/' . $this->id,
            'delete' => '/api/club-competition_saisons/' . $this->id,
        ];
    }
}
