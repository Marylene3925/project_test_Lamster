<?php

namespace App\Entity;

use App\Repository\TypeHoraireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeHoraireRepository::class)]
class TypeHoraire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'typeHoraire', targetEntity: Horaire::class, orphanRemoval: true)]
    private Collection $horaire;

    public function __construct()
    {
        $this->horaire = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Horaire>
     */
    public function getHoraire(): Collection
    {
        return $this->horaire;
    }

    public function addHoraire(Horaire $horaire): self
    {
        if (!$this->horaire->contains($horaire)) {
            $this->horaire->add($horaire);
            $horaire->setTypeHoraire($this);
        }

        return $this;
    }

    public function removeHoraire(Horaire $horaire): self
    {
        if ($this->horaire->removeElement($horaire)) {
            // set the owning side to null (unless already changed)
            if ($horaire->getTypeHoraire() === $this) {
                $horaire->setTypeHoraire(null);
            }
        }

        return $this;
    }
}
