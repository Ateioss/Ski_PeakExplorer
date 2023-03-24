<?php

namespace App\Entity;

use App\Repository\PisteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PisteRepository::class)]
class Piste
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;



    #[ORM\Column]
    private ?bool $ouverture = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $horaire_ouverture = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $horaire_fermeture = null;


    #[ORM\Column]
    private ?bool $block = null;

    #[ORM\Column(length: 255)]
    private ?string $difficulte = null;

    #[ORM\ManyToOne(inversedBy: 'pistes')]
    private ?StationSki $station = null;

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



    public function getOuverture(): ?bool
    {
        return $this->ouverture;
    }

    public function setOuverture(bool $ouverture): self
    {
        $this->ouverture = $ouverture;

        return $this;
    }

    public function getHoraireOuverture(): ?\DateTimeInterface
    {
        return $this->horaire_ouverture;
    }

    public function setHoraireOuverture(\DateTimeInterface $horaire_ouverture): self
    {
        $this->horaire_ouverture = $horaire_ouverture;

        return $this;
    }

    public function getHoraireFermeture(): ?\DateTimeInterface
    {
        return $this->horaire_fermeture;
    }

    public function setHoraireFermeture(\DateTimeInterface $horaire_fermeture): self
    {
        $this->horaire_fermeture = $horaire_fermeture;

        return $this;
    }



    public function isBlock(): ?bool
    {
        return $this->block;
    }

    public function setBlock(bool $block): self
    {
        $this->block = $block;

        return $this;
    }

    public function getDifficulte(): ?string
    {
        return $this->difficulte;
    }

    public function setDifficulte(string $difficulte): self
    {
        $this->difficulte = $difficulte;

        return $this;
    }

    public function getStation(): ?StationSki
    {
        return $this->station;
    }

    public function setStation(?StationSki $station): self
    {
        $this->station = $station;

        return $this;
    }
}
