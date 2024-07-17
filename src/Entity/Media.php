<?php

namespace App\Entity;

use App\Repository\MediaRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;

#[ApiResource()]
#[ORM\Entity(repositoryClass: MediaRepository::class)]
class Media
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $chemin = null;

    #[ORM\OneToOne(mappedBy: 'photo', cascade: ['persist', 'remove'])]
    private ?Boisson $boisson = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getChemin(): ?string
    {
        return $this->chemin;
    }

    public function setChemin(?string $chemin): static
    {
        $this->chemin = $chemin;

        return $this;
    }

    public function getBoisson(): ?Boisson
    {
        return $this->boisson;
    }

    public function setBoisson(?Boisson $boisson): static
    {
        // unset the owning side of the relation if necessary
        if ($boisson === null && $this->boisson !== null) {
            $this->boisson->setPhoto(null);
        }

        // set the owning side of the relation if necessary
        if ($boisson !== null && $boisson->getPhoto() !== $this) {
            $boisson->setPhoto($this);
        }

        $this->boisson = $boisson;

        return $this;
    }
}
