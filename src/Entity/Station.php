<?php

namespace App\Entity;

use App\Repository\StationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StationRepository::class)]
class Station
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\OneToMany(mappedBy: 'station', targetEntity: Remontée::class)]
    private Collection $remontee;

    public function __construct()
    {
        $this->remontee = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection<int, Remontée>
     */
    public function getRemontee(): Collection
    {
        return $this->remontee;
    }

    public function addRemontee(Remontée $remontee): self
    {
        if (!$this->remontee->contains($remontee)) {
            $this->remontee->add($remontee);
            $remontee->setStation($this);
        }

        return $this;
    }

    public function removeRemontee(Remontée $remontee): self
    {
        if ($this->remontee->removeElement($remontee)) {
            // set the owning side to null (unless already changed)
            if ($remontee->getStation() === $this) {
                $remontee->setStation(null);
            }
        }

        return $this;
    }
}
