<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\CompetitionSaisonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
    #[Groups(['CompetitionSaisons: read', 'saison: read', 'Competitions: read', 'MatchsFoot: read', 'ClubCompetitionSaisons: read'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'competitionSaisons')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['CompetitionSaisons: read', 'CompetitionSaisons: write', 'MatchsFoot: read', 'Competitions: read', 'ClubCompetitionSaisons: read'])]
    private ?Saison $saison = null;

    #[ORM\ManyToOne(inversedBy: 'competitionSaisons')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['CompetitionSaisons: read', 'CompetitionSaisons: write', 'MatchsFoot: read', 'saison: read', 'ClubCompetitionSaisons: read'])]
    private ?Competition $competition = null;

    /**
     * @var Collection<int, MatchFoot>
     */
    #[ORM\OneToMany(targetEntity: MatchFoot::class, mappedBy: 'competitionSaison', orphanRemoval: true)]
    #[Groups(['CompetitionSaisons: read'])]
    private Collection $matchFoots;

    /**
     * @var Collection<int, ClubCompetitionSaison>
     */
    #[ORM\OneToMany(targetEntity: ClubCompetitionSaison::class, mappedBy: 'competitionSaison', orphanRemoval: true)]
    #[Groups(['CompetitionSaisons: read'])]
    private Collection $clubCompetitionSaisons;

    public function __construct()
    {
        $this->matchFoots = new ArrayCollection();
        $this->clubCompetitionSaisons = new ArrayCollection();
    }

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
    #[Groups(['saison: read', 'Competitions: read', 'CompetitionSaisons: read', 'MatchsFoot: read', 'ClubCompetitionSaisons: read'])]
    public function getLinks(): array
    {
        return [
            'self' => '/api/competition_saisons/' . $this->id,
            'update' => '/api/competition_saisons/' . $this->id,
            'delete' => '/api/competition_saisons/' . $this->id,
        ];
    }

    /**
     * @return Collection<int, MatchFoot>
     */
    public function getMatchFoots(): Collection
    {
        return $this->matchFoots;
    }

    public function addMatchFoot(MatchFoot $matchFoot): static
    {
        if (!$this->matchFoots->contains($matchFoot)) {
            $this->matchFoots->add($matchFoot);
            $matchFoot->setCompetitionSaison($this);
        }

        return $this;
    }

    public function removeMatchFoot(MatchFoot $matchFoot): static
    {
        if ($this->matchFoots->removeElement($matchFoot)) {
            // set the owning side to null (unless already changed)
            if ($matchFoot->getCompetitionSaison() === $this) {
                $matchFoot->setCompetitionSaison(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ClubCompetitionSaison>
     */
    public function getClubCompetitionSaisons(): Collection
    {
        return $this->clubCompetitionSaisons;
    }

    public function addClubCompetitionSaison(ClubCompetitionSaison $clubCompetitionSaison): static
    {
        if (!$this->clubCompetitionSaisons->contains($clubCompetitionSaison)) {
            $this->clubCompetitionSaisons->add($clubCompetitionSaison);
            $clubCompetitionSaison->setCompetitionSaison($this);
        }

        return $this;
    }

    public function removeClubCompetitionSaison(ClubCompetitionSaison $clubCompetitionSaison): static
    {
        if ($this->clubCompetitionSaisons->removeElement($clubCompetitionSaison)) {
            // set the owning side to null (unless already changed)
            if ($clubCompetitionSaison->getCompetitionSaison() === $this) {
                $clubCompetitionSaison->setCompetitionSaison(null);
            }
        }

        return $this;
    }
}
