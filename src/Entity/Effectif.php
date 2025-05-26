<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\EffectifRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: EffectifRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(
            uriTemplate: '/effectifs',
            description: 'Récupère une collection de ressources Effectif.',
            normalizationContext: ['groups' => ['Effectifs: read']]
        ),
        new Get(
            uriTemplate: '/effectifs/{id}',
            description: 'Récupère une ressource Effectif.',
            normalizationContext: ['groups' => ['Effectifs: read']]
        ),
        new Post(
            uriTemplate: '/effectifs',
            description: 'Crée une ressource Effectif.',
            denormalizationContext: ['groups' => ['Effectifs: write']],
            security: "is_granted('ROLE_ADMIN')",
            securityMessage: "Vous devez être administrateur pour créer un effectif."
        ),
        new Put(
            uriTemplate: '/effectifs/{id}',
            description: 'Met à jour une ressource Effectif.',
            denormalizationContext: ['groups' => ['Effectifs: write']],
            security: "is_granted('ROLE_ADMIN')",
            securityMessage: "Vous devez être administrateur pour mettre à jour un effectif."
        ),
        new Delete(
            uriTemplate: '/effectifs/{id}',
            description: 'Supprime une ressource Effectif.',
            security: "is_granted('ROLE_ADMIN')",
            securityMessage: "Vous devez être administrateur pour supprimer un effectif."
        )
    ],
    paginationItemsPerPage: 10,
    paginationMaximumItemsPerPage: 100,
    normalizationContext: ['groups' => ['Effectifs: read']],
    denormalizationContext: ['groups' => ['Effectifs: write']],
    formats: ['jsonld', 'json'],
    cacheHeaders: [
        'max_age' => 3600, // Cache pour 1 heure
        'shared_max_age' => 3600,
        'vary' => ['Authorization', 'Accept-Language'],
    ],
)]
class Effectif
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['Effectifs: read', 'Effectifs: write', 'Joueurs: read', 'ClubCompetitionSaisons: read'])]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'Le numéro du joueur ne peut pas être vide.')]
    #[Assert\Positive(message: 'Le numéro du joueur doit être un nombre positif.')]
    #[Assert\Range(
        min: 1,
        max: 99,
        notInRangeMessage: 'Le numéro du joueur doit être compris entre {{ min }} et {{ max }}.'
    )]
    #[Groups(['Effectifs: read', 'Effectifs: write', 'Joueurs: read', 'ClubCompetitionSaisons: read'])]
    private ?int $numero = null;

    #[ORM\ManyToOne(inversedBy: 'effectifs')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull(message: 'La saison du club ne peut pas être vide.')]
    #[Groups(['Effectifs: read', 'Effectifs: write', 'Joueurs: read'])]
    private ?ClubCompetitionSaison $clubSaison = null;

    #[ORM\ManyToOne(inversedBy: 'effectifs')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull(message: 'Le joueur ne peut pas être vide.')]
    #[Groups(['Effectifs: read', 'Effectifs: write', 'ClubCompetitionSaisons: read'])]
    private ?Joueur $joueur = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumero(): ?int
    {
        return $this->numero;
    }

    public function setNumero(int $numero): static
    {
        $this->numero = $numero;

        return $this;
    }

    public function getClubSaison(): ?ClubCompetitionSaison
    {
        return $this->clubSaison;
    }

    public function setClubSaison(?ClubCompetitionSaison $clubSaison): static
    {
        $this->clubSaison = $clubSaison;

        return $this;
    }

    public function getJoueur(): ?Joueur
    {
        return $this->joueur;
    }

    public function setJoueur(?Joueur $joueur): static
    {
        $this->joueur = $joueur;

        return $this;
    }

    #[Groups(['ClubCompetitionSaisons: read', 'Joueurs: read', 'Effectifs: read'])]
    public function getLinks(): array
    {
        return [
            'self' => '/api/effectifs/' . $this->id,
            'update' => '/api/effectifs/' . $this->id,
            'delete' => '/api/effectifs/' . $this->id,
        ];
    }
}
