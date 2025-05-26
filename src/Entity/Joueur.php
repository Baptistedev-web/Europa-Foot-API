<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\JoueurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: JoueurRepository::class)]
#[ApiResource(
    paginationItemsPerPage: 10,
    paginationMaximumItemsPerPage: 100,
    normalizationContext: ['groups' => ['Joueurs: read']],
    denormalizationContext: ['groups' => ['Joueurs: write']],
    operations: [
        new GetCollection(
            description: 'Récupère une collection de ressources Joueur.',
            normalizationContext: ['groups' => ['Joueurs: read']]
        ),
        new Get(
            description: 'Récupère une ressource Joueur.',
            normalizationContext: ['groups' => ['Joueurs: read']]
        ),
        new Post(
            description: 'Crée une ressource Joueur.',
            denormalizationContext: ['groups' => ['Joueurs: write']],
            security: "is_granted('ROLE_ADMIN')",
            securityMessage: "Vous devez être administrateur pour créer un joueur."
        ),
        new Put(
            description: 'Met à jour une ressource Joueur.',
            normalizationContext: ['groups' => ['Joueurs: read']],
            denormalizationContext: ['groups' => ['Joueurs: write']],
            security: "is_granted('ROLE_ADMIN')",
            securityMessage: "Vous devez être administrateur pour mettre à jour un joueur."
        ),
        new Delete(
            description: 'Supprime une ressource Joueur.',
            security: "is_granted('ROLE_ADMIN')",
            securityMessage: "Vous devez être administrateur pour supprimer un joueur."
        ),
    ],
    formats: ['jsonld', 'json'],
    cacheHeaders: [
        'max_age' => 3600, // Cache pour 1 heure
        'shared_max_age' => 3600,
        'vary' => ['Authorization', 'Accept-Language'],
    ],
)]
class Joueur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['Joueurs: read', 'Joueurs: write', 'Placements: read'])]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    #[Groups(['Joueurs: read', 'Joueurs: write', 'Placements: read'])]
    private ?string $nom = null;

    #[ORM\Column(length: 30)]
    private ?string $prenom = null;

    /**
     * @var Collection<int, Placement>
     */
    #[ORM\ManyToMany(targetEntity: Placement::class, inversedBy: 'joueurs')]
    #[Groups(['Joueurs: read', 'Joueurs: write'])]
    private Collection $placement;

    public function __construct()
    {
        $this->placement = new ArrayCollection();
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * @return Collection<int, Placement>
     */
    public function getPlacement(): Collection
    {
        return $this->placement;
    }

    public function addPlacement(Placement $placement): static
    {
        if (!$this->placement->contains($placement)) {
            $this->placement->add($placement);
        }

        return $this;
    }

    public function removePlacement(Placement $placement): static
    {
        $this->placement->removeElement($placement);

        return $this;
    }

    #[Groups(['Placements: read', 'Joueurs: read'])]
    public function getLinks(): array
    {
        return [
            'self' => '/api/joueurs/' . $this->id,
            'update' => '/api/joueurs/' . $this->id,
            'delete' => '/api/joueurs/' . $this->id,
        ];
    }
}
