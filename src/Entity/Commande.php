<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use DateTimeImmutable;

#[ApiResource(
        operations: [
        new GetCollection(security: "is_granted('ROLE_PATRON') || is_granted('ROLE_BARMAN')"),
        new Post(),
        new Get(security: "is_granted('ROLE_PATRON') || is_granted('ROLE_BARMAN')"),
        new Patch(security: "is_granted('ROLE_PATRON') || is_granted('ROLE_BARMAN') || is_granted('ROLE_SERVEUR')"),
        new Delete(security: "is_granted('ROLE_PATRON')"),
    ],
)]
#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $createdDate = null;

    #[ORM\Column(type: Types::ARRAY)]
    private array $orderedDrinks = [];

    #[ORM\Column]
    private ?int $tableNumber = null;

    #[ORM\ManyToOne(inversedBy: 'commandes')]
    private ?User $serveur = null;

    #[ORM\ManyToOne(inversedBy: 'commandes')]
    private ?User $barman = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    public function __construct()
    {
        // Automatically set the createdDate to the current date and time
        $this->createdDate = new DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedDate(): ?\DateTimeInterface
    {
        return $this->createdDate;
    }

    public function setCreatedDate(\DateTimeInterface $createdDate): static
    {
        $this->createdDate = $createdDate;

        return $this;
    }

    public function getOrderedDrinks(): array
    {
        return $this->orderedDrinks;
    }

    public function setOrderedDrinks(array $orderedDrinks): static
    {
        $this->orderedDrinks = $orderedDrinks;

        return $this;
    }

    public function getTableNumber(): ?int
    {
        return $this->tableNumber;
    }

    public function setTableNumber(int $tableNumber): static
    {
        $this->tableNumber = $tableNumber;

        return $this;
    }

    public function getServeur(): ?User
    {
        return $this->serveur;
    }

    public function setServeur(?User $serveur): static
    {
        $this->serveur = $serveur;

        return $this;
    }

    public function getBarman(): ?User
    {
        return $this->barman;
    }

    public function setBarman(?User $barman): static
    {
        $this->barman = $barman;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $validStatuses = ['en cours de préparation', 'prête', 'payée'];

        if (!in_array($status, $validStatuses)) {
            throw new \InvalidArgumentException(sprintf('Invalid status "%s". Allowed statuses are %s.', $status, implode(', ', $validStatuses)));
        }

        $this->status = $status;

        return $this;
    }
}