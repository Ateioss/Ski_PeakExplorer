<?php

namespace App\Entity;

use App\Repository\RemontéeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RemontéeRepository::class)]
class Remontée
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column]
    private ?bool $ouverture = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $HoraireOuverture = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $HoraireFermeture = null;

    #[ORM\ManyToOne(inversedBy: 'remontee')]
    #[ORM\JoinColumn(nullable: false)]
    private ?station $station = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function isOuverture(): ?bool
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
        return $this->HoraireOuverture;
    }

    public function setHoraireOuverture(\DateTimeInterface $HoraireOuverture): self
    {
        $this->HoraireOuverture = $HoraireOuverture;

        return $this;
    }

    public function getHoraireFermeture(): ?\DateTimeInterface
    {
        return $this->HoraireFermeture;
    }

    public function setHoraireFermeture(\DateTimeInterface $HoraireFermeture): self
    {
        $this->HoraireFermeture = $HoraireFermeture;

        return $this;
    }

    public function getStation(): ?station
    {
        return $this->station;
    }

    public function setStation(?station $station): self
    {
        $this->station = $station;

        return $this;
    }
}
