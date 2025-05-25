<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\MatchFootRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: MatchFootRepository::class)]
#[Assert\Expression(
    "this.getClubRecevant() == null or this.getClubExterieur() == null or this.getClubRecevant().getId() != this.getClubExterieur().getId()",
    message: "Le club recevant et le club extérieur doivent être différents."

)]
#[ApiResource(
    paginationItemsPerPage: 10,
    paginationMaximumItemsPerPage: 100,
    normalizationContext: ['groups' => ['MatchsFoot: read']],
    denormalizationContext: ['groups' => ['MatchsFoot: write']],
    operations: [
        new GetCollection(
            uriTemplate: '/matchs-foot',
            description: 'Récupère une collection de ressources MatchFoot.',
            normalizationContext: ['groups' => ['MatchsFoot: read']]
        ),
        new Get(
            uriTemplate: '/match-foot/{id}',
            description: 'Récupère une ressource MatchFoot.',
            normalizationContext: ['groups' => ['MatchsFoot: read']]
        ),
        new Post(
            uriTemplate: '/match-foot',
            description: 'Crée une ressource MatchFoot.',
            denormalizationContext: ['groups' => ['MatchsFoot: write']],
            security: "is_granted('ROLE_ADMIN')",
            securityMessage: "Vous devez être administrateur pour créer cette ressource."
        ),
        new Put(
            uriTemplate: '/match-foot/{id}',
            description: 'Met à jour une ressource MatchFoot.',
            normalizationContext: ['groups' => ['MatchsFoot: read']],
            denormalizationContext: ['groups' => ['MatchsFoot: write']],
            security: "is_granted('ROLE_ADMIN')",
            securityMessage: "Vous devez être administrateur pour mettre à jour cette ressource."
        ),
        new Delete(
            uriTemplate: '/match-foot/{id}',
            description: 'Supprime une ressource MatchFoot.',
            security: "is_granted('ROLE_ADMIN')",
            securityMessage: "Vous devez être administrateur pour supprimer cette ressource."
        ),
    ],
    formats: ['jsonld', 'json'],
    cacheHeaders: [
        'max_age' => 3600, // Cache pour 1 heure
        'shared_max_age' => 3600,
        'vary' => ['Authorization', 'Accept-Language'],
    ],
)]
class MatchFoot
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['MatchsFoot: read', 'MatchsFoot: write', 'Clubs: read', 'CompetitionSaisons: read', 'Statuts: read'])]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: "Le score de l'équipe recevant ne peut pas être vide.")]
    #[Assert\PositiveOrZero(message: "Le score de l'équipe recevant doit être un nombre positif ou zéro.")]
    #[Groups(['MatchsFoot: read', 'MatchsFoot: write', 'Clubs: read', 'CompetitionSaisons: read', 'Statuts: read'])]
    private ?int $scoreEquipeRecevant = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: "Le score de l'équipe extérieure ne peut pas être vide.")]
    #[Assert\PositiveOrZero(message: "Le score de l'équipe extérieure doit être un nombre positif ou zéro.")]
    #[Groups(['MatchsFoot: read', 'MatchsFoot: write', 'Clubs: read', 'CompetitionSaisons: read', 'Statuts: read'])]
    private ?int $scoreEquipeExterieur = null;

    #[ORM\Column(length: 50, nullable: true)]
    #[Assert\Length(
        min: 5,
        max: 50,
        minMessage: "Le stade doit comporter au moins {{ limit }} caractères.",
        maxMessage: "Le stade ne peut pas dépasser {{ limit }} caractères."
    )]
    #[Assert\Regex(
        pattern: '/^[\p{L}0-9\s]+$/u',
        message: "Le nom du stade ne doit contenir que des lettres (y compris avec accents), des chiffres et des espaces."
    )]
    #[Groups(['MatchsFoot: read', 'MatchsFoot: write', 'Clubs: read', 'CompetitionSaisons: read', 'Statuts: read'])]
    private ?string $stade = null;

    #[ORM\ManyToOne(inversedBy: 'matchFoots')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank(message: "Le statut du match ne doit pas être vide.")]
    #[Groups(['MatchsFoot: read', 'MatchsFoot: write'])]
    private ?Statut $statut = null;

    #[ORM\ManyToOne(inversedBy: 'matchFoots')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank(message: "La saison de la compétition ne doit pas être vide.")]
    #[Groups(['MatchsFoot: read', 'MatchsFoot: write'])]
    private ?CompetitionSaison $competitionSaison = null;

    #[ORM\ManyToOne(inversedBy: 'matchFoots')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank(message: "Le club recevant ne doit pas être vide.")]
    #[Groups(['MatchsFoot: read', 'MatchsFoot: write', 'Clubs: read'])]
    private ?Club $clubRecevant = null;

    #[ORM\ManyToOne(inversedBy: 'matchFoots')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank(message: "Le club extérieur ne doit pas être vide.")]
    #[Groups(['MatchsFoot: read', 'MatchsFoot: write', 'Clubs: read'])]
    private ?Club $clubExterieur = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getScoreEquipeRecevant(): ?int
    {
        return $this->scoreEquipeRecevant;
    }

    public function setScoreEquipeRecevant(int $scoreEquipeRecevant): static
    {
        $this->scoreEquipeRecevant = $scoreEquipeRecevant;

        return $this;
    }

    public function getScoreEquipeExterieur(): ?int
    {
        return $this->scoreEquipeExterieur;
    }

    public function setScoreEquipeExterieur(int $scoreEquipeExterieur): static
    {
        $this->scoreEquipeExterieur = $scoreEquipeExterieur;

        return $this;
    }

    public function getStade(): ?string
    {
        return $this->stade;
    }

    public function setStade(?string $stade): static
    {
        $this->stade = $stade;

        return $this;
    }

    public function getStatut(): ?Statut
    {
        return $this->statut;
    }

    public function setStatut(?Statut $statut): static
    {
        $this->statut = $statut;

        return $this;
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

    public function getClubRecevant(): ?Club
    {
        return $this->clubRecevant;
    }

    public function setClubRecevant(?Club $clubRecevant): static
    {
        $this->clubRecevant = $clubRecevant;

        return $this;
    }

    public function getClubExterieur(): ?Club
    {
        return $this->clubExterieur;
    }

    public function setClubExterieur(?Club $clubExterieur): static
    {
        $this->clubExterieur = $clubExterieur;

        return $this;
    }

    #[Groups(['MatchsFoot: read','Statuts: read', 'CompetitionSaisons: read', 'Clubs: read'])]
    public function getLinks(): array
    {
        return [
            'self' => '/api/match-foot/' . $this->id,
            'update' => '/api/match-foot/' . $this->id,
            'delete' => '/api/match-foot/' . $this->id,
        ];
    }
}
