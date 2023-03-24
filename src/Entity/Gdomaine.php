<?php

namespace App\Entity;

use App\Repository\GdomaineRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GdomaineRepository::class)]
class Gdomaine
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\OneToMany(mappedBy: 'domain', targetEntity: StationSki::class)]
    private Collection $stationSkis;

    public function __construct()
    {
        $this->stationSkis = new ArrayCollection();
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
     * @return Collection<int, StationSki>
     */
    public function getStationSkis(): Collection
    {
        return $this->stationSkis;
    }

    public function addStationSki(StationSki $stationSki): self
    {
        if (!$this->stationSkis->contains($stationSki)) {
            $this->stationSkis->add($stationSki);
            $stationSki->setDomain($this);
        }

        return $this;
    }

    public function removeStationSki(StationSki $stationSki): self
    {
        if ($this->stationSkis->removeElement($stationSki)) {
            // set the owning side to null (unless already changed)
            if ($stationSki->getDomain() === $this) {
                $stationSki->setDomain(null);
            }
        }

        return $this;
    }
}
