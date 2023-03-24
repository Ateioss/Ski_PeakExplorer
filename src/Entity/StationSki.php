<?php

namespace App\Entity;

use App\Repository\StationSkiRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StationSkiRepository::class)]
class StationSki
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;


    #[ORM\Column(length: 255)]
    private ?string $location = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Image = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?User $owner = null;

    #[ORM\OneToMany(mappedBy: 'station', targetEntity: Piste::class)]
    private Collection $pistes;

    #[ORM\OneToMany(mappedBy: 'station', targetEntity: Remontee::class)]
    private Collection $remontees;

        #[ORM\ManyToOne(inversedBy: 'stationSkis')]
    private ?Gdomaine $domain = null;

    public function __construct()
    {
        $this->pistes = new ArrayCollection();
        $this->remontees = new ArrayCollection();
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




    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->Image;
    }

    public function setImage(?string $Image): self
    {
        $this->Image = $Image;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * @return Collection<int, Piste>
     */
    public function getPistes(): Collection
    {
        return $this->pistes;
    }

    public function addPiste(Piste $piste): self
    {
        if (!$this->pistes->contains($piste)) {
            $this->pistes->add($piste);
            $piste->setStation($this);
        }

        return $this;
    }

    public function removePiste(Piste $piste): self
    {
        if ($this->pistes->removeElement($piste)) {
            // set the owning side to null (unless already changed)
            if ($piste->getStation() === $this) {
                $piste->setStation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Remontee>
     */
    public function getRemontees(): Collection
    {
        return $this->remontees;
    }

    public function addRemontee(Remontee $remontee): self
    {
        if (!$this->remontees->contains($remontee)) {
            $this->remontees->add($remontee);
            $remontee->setStation($this);
        }

        return $this;
    }

    public function removeRemontee(Remontee $remontee): self
    {
        if ($this->remontees->removeElement($remontee)) {
            // set the owning side to null (unless already changed)
            if ($remontee->getStation() === $this) {
                $remontee->setStation(null);
            }
        }

        return $this;
    }

    public function getDomain(): ?Gdomaine
    {
        return $this->domain;
    }

    public function setDomain(?Gdomaine $domain): self
    {
        $this->domain = $domain;

        return $this;
    }
    
}
