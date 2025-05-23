<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\CompetitionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CompetitionRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(
            uriTemplate: '/competitions',
            description: 'Récupère une collection de ressources Compétition.',
            normalizationContext: ['groups' => ['Competitions: read']]
        ),
        new Get(
            uriTemplate: '/competitions/{id}',
            description: 'Récupère une ressource Compétition.',
            normalizationContext: ['groups' => ['Competitions: read']]
        ),
        new Post(
            uriTemplate: '/competitions',
            description: 'Crée une ressource Compétition.',
            denormalizationContext: ['groups' => ['Competitions: write']],
            security: "is_granted('ROLE_ADMIN')"
        ),
        new Put(
            uriTemplate: '/competitions/{id}',
            description: 'Met à jour une ressource Compétition.',
            normalizationContext: ['groups' => ['Competitions: read']],
            denormalizationContext: ['groups' => ['Competitions: write']],
            security: "is_granted('ROLE_ADMIN')"
        ),
        new Delete(
            uriTemplate: '/competitions/{id}',
            description: 'Supprime une ressource Compétition.',
            security: "is_granted('ROLE_ADMIN')"
        )
    ],
    paginationItemsPerPage: 10,
    paginationMaximumItemsPerPage: 100,
    normalizationContext: ['groups' => ['Competitions: read']],
    denormalizationContext: ['groups' => ['Competitions: write']],
    formats: ['jsonld', 'json'],
    cacheHeaders: [
        'max_age' => 3600, // Cache pour 1 heure
        'shared_max_age' => 3600,
        'vary' => ['Authorization', 'Accept-Language'],
    ],
)]
class Competition
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['Competitions: read', 'Competitions: write', 'TypeCompetitions: read', 'Pays: read', 'CompetitionSaisons: read'])]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    #[Assert\NotBlank]
    #[Assert\Length(
        min: 3,
        max: 30,
        minMessage: 'Le nom de la compétition doit contenir au moins {{ limit }} caractères.',
        maxMessage: 'Le nom de la compétition ne peut pas dépasser {{ limit }} caractères.'
    )]
    #[Assert\Regex(
        pattern: '/^[a-zA-Z0-9\s]+$/',
        message: 'Le nom de la compétition ne doit contenir que des lettres, des chiffres et des espaces.'
    )]
    #[Groups(['Competitions: read', 'Competitions: write', 'TypeCompetitions: read', 'Pays: read', 'CompetitionSaisons: read'])]
    private ?string $nom = null;

    #[ORM\ManyToOne(inversedBy: 'competitions')]
    #[Assert\NotNull(message: "Le pays ne doit pas être null.")]
    #[Groups(['Competitions: read', 'Competitions: write'])]
    private ?Pays $pays = null;

    #[ORM\ManyToOne(inversedBy: 'competitions')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull(message: "Le type de compétition ne doit pas être null.")]
    #[Groups(['Competitions: read', 'Competitions: write'])]
    private ?TypeCompetition $typeCompetition = null;

    /**
     * @var Collection<int, CompetitionSaison>
     */
    #[ORM\OneToMany(targetEntity: CompetitionSaison::class, mappedBy: 'competition', orphanRemoval: true)]
    #[Groups(['Competitions: read'])]
    private Collection $competitionSaisons;

    public function __construct()
    {
        $this->competitionSaisons = new ArrayCollection();
    }

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

    public function getPays(): ?Pays
    {
        return $this->pays;
    }

    public function setPays(?Pays $pays): static
    {
        $this->pays = $pays;

        return $this;
    }

    public function getTypeCompetition(): ?TypeCompetition
    {
        return $this->typeCompetition;
    }

    public function setTypeCompetition(?TypeCompetition $typeCompetition): static
    {
        $this->typeCompetition = $typeCompetition;

        return $this;
    }
    #[Groups(['Competitions: read', 'Pays: read', 'TypeCompetitions: read', 'CompetitionSaisons: read'])]
    public function getLinks(): array
    {
        return [
            'self' => '/api/competitions/' . $this->id,
            'update' => '/api/competitions/' . $this->id,
            'delete' => '/api/competitions/' . $this->id,
        ];
    }

    /**
     * @return Collection<int, CompetitionSaison>
     */
    public function getCompetitionSaisons(): Collection
    {
        return $this->competitionSaisons;
    }

    public function addCompetitionSaison(CompetitionSaison $competitionSaison): static
    {
        if (!$this->competitionSaisons->contains($competitionSaison)) {
            $this->competitionSaisons->add($competitionSaison);
            $competitionSaison->setCompetition($this);
        }

        return $this;
    }

    public function removeCompetitionSaison(CompetitionSaison $competitionSaison): static
    {
        if ($this->competitionSaisons->removeElement($competitionSaison)) {
            // set the owning side to null (unless already changed)
            if ($competitionSaison->getCompetition() === $this) {
                $competitionSaison->setCompetition(null);
            }
        }

        return $this;
    }
}
