<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\ClubRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ClubRepository::class)]
#[ORM\UniqueConstraint(
    name: "club_unique",
    columns: ["nom"]
)]
#[ApiResource(
    paginationItemsPerPage: 10,
    paginationMaximumItemsPerPage: 100,
    normalizationContext: ['groups' => ['Clubs: read']],
    denormalizationContext: ['groups' => ['Clubs: write']],
    operations: [
        new GetCollection(
            uriTemplate: '/clubs',
            description: 'Récupère une collection de ressources Club.',
            normalizationContext: ['groups' => ['Clubs: read']]
        ),
        new Get(
            uriTemplate: '/clubs/{id}',
            description: 'Récupère une ressource Club.',
            normalizationContext: ['groups' => ['Clubs: read']]
        ),
        new Post(
            uriTemplate: '/clubs',
            description: 'Crée une ressource Club.',
            denormalizationContext: ['groups' => ['Clubs: write']],
            security: "is_granted('ROLE_ADMIN')",
            securityMessage: "Vous devez être administrateur pour créer cette ressource."
        ),
        new Put(
            uriTemplate: '/clubs/{id}',
            description: 'Met à jour une ressource Club.',
            normalizationContext: ['groups' => ['Clubs: read']],
            denormalizationContext: ['groups' => ['Clubs: write']],
            security: "is_granted('ROLE_ADMIN')",
            securityMessage: "Vous devez être administrateur pour mettre à jour cette ressource."
        ),
        new Delete(
            uriTemplate: '/clubs/{id}',
            description: 'Supprime une ressource Club.',
            security: "is_granted('ROLE_ADMIN')",
            securityMessage: "Vous devez être administrateur pour supprimer cette ressource."
        )
    ],
    formats: ['jsonld', 'json'],
    cacheHeaders: [
        'max_age' => 3600, // Cache pour 1 heure
        'shared_max_age' => 3600,
        'vary' => ['Authorization', 'Accept-Language'],
    ],
)]
class Club
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['Clubs: read', 'MatchsFoot: read','ClubCompetitionSaisons: read'])]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: 'Le nom du club ne peut pas être vide.')]
    #[Assert\Length(
        min: 2,
        max: 50,
        minMessage: 'Le nom du club doit comporter au moins {{ limit }} caractères.',
        maxMessage: 'Le nom du club ne peut pas dépasser {{ limit }} caractères.'
    )]
    #[Assert\Regex(
        pattern: '/^[a-zA-Z0-9\s]+$/',
        message: 'Le nom du club ne peut contenir que des lettres, des chiffres et des espaces.',
    )]
    #[Groups(['Clubs: read', 'Clubs: write', 'Pays: read', 'MatchsFoot: read', 'ClubCompetitionSaisons: read'])]
    private ?string $nom = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: 'Le nom du stade ne peut pas être vide.')]
    #[Assert\Length(
        min: 5,
        max: 50,
        minMessage: 'Le nom du stade doit comporter au moins {{ limit }} caractères.',
        maxMessage: 'Le nom du stade ne peut pas dépasser {{ limit }} caractères.',
    )]
    #[Assert\Regex(
        pattern: '/^[\p{L}0-9\s]+$/u',
        message: 'Le nom du stade ne doit contenir que des lettres (y compris avec accents), des chiffres et des espaces.',
    )]
    #[Groups(['Clubs: read', 'Clubs: write', 'Pays: read', 'MatchsFoot: read', 'ClubCompetitionSaisons: read'])]
    private ?string $stade = null;

    #[ORM\ManyToOne(inversedBy: 'clubs')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank(message: 'Le pays ne peut pas être vide.')]
    #[Groups(['Clubs: read', 'Clubs: write', 'MatchsFoot: read', 'ClubCompetitionSaisons: read'])]
    private ?Pays $pays = null;

    /**
     * @var Collection<int, MatchFoot>
     */
    #[ORM\OneToMany(targetEntity: MatchFoot::class, mappedBy: 'clubRecevant', orphanRemoval: true)]
    #[Groups(['Clubs: read'])]
    private Collection $matchFoots;

    /**
     * @var Collection<int, ClubCompetitionSaison>
     */
    #[ORM\OneToMany(targetEntity: ClubCompetitionSaison::class, mappedBy: 'club', orphanRemoval: true)]
    #[Groups(['Clubs: read'])]
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

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getStade(): ?string
    {
        return $this->stade;
    }

    public function setStade(string $stade): static
    {
        $this->stade = $stade;

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
    #[Groups(['Clubs: read', 'Pays: read', 'MatchsFoot: read', 'ClubCompetitionSaisons: read'])]
    public function getLinks(): array
    {
        return [
            'self' => '/api/saisons/' . $this->id,
            'update' => '/api/saisons/' . $this->id,
            'delete' => '/api/saisons/' . $this->id,
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
            $matchFoot->setClubRecevant($this);
        }

        return $this;
    }

    public function removeMatchFoot(MatchFoot $matchFoot): static
    {
        if ($this->matchFoots->removeElement($matchFoot)) {
            // set the owning side to null (unless already changed)
            if ($matchFoot->getClubRecevant() === $this) {
                $matchFoot->setClubRecevant(null);
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
            $clubCompetitionSaison->setClub($this);
        }

        return $this;
    }

    public function removeClubCompetitionSaison(ClubCompetitionSaison $clubCompetitionSaison): static
    {
        if ($this->clubCompetitionSaisons->removeElement($clubCompetitionSaison)) {
            // set the owning side to null (unless already changed)
            if ($clubCompetitionSaison->getClub() === $this) {
                $clubCompetitionSaison->setClub(null);
            }
        }

        return $this;
    }
}
