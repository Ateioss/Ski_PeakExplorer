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

<<<<<<< HEAD
    #[ORM\OneToMany(mappedBy: 'station', targetEntity: Piste::class)]
    private Collection $pistes;

    public function __construct()
    {
        $this->pistes = new ArrayCollection();
=======
    #[ORM\OneToMany(mappedBy: 'station', targetEntity: Remontée::class)]
    private Collection $remontee;

    public function __construct()
    {
        $this->remontee = new ArrayCollection();
>>>>>>> e4dceca349dee6fa0e42f775a1a98c5b12f6a006
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
<<<<<<< HEAD
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
=======
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
>>>>>>> e4dceca349dee6fa0e42f775a1a98c5b12f6a006
        }

        return $this;
    }

<<<<<<< HEAD
    public function removePiste(Piste $piste): self
    {
        if ($this->pistes->removeElement($piste)) {
            // set the owning side to null (unless already changed)
            if ($piste->getStation() === $this) {
                $piste->setStation(null);
=======
    public function removeRemontee(Remontée $remontee): self
    {
        if ($this->remontee->removeElement($remontee)) {
            // set the owning side to null (unless already changed)
            if ($remontee->getStation() === $this) {
                $remontee->setStation(null);
>>>>>>> e4dceca349dee6fa0e42f775a1a98c5b12f6a006
            }
        }

        return $this;
    }
}
