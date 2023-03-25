<?php

namespace App\Entity;

use App\Repository\PisteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\Column(length: 255)]
    private ?string $difficulte = null;

    #[ORM\Column]
    private ?bool $ouverture = null;


    #[ORM\Column]
    private ?bool $block = null;

    #[ORM\ManyToOne(inversedBy: 'pistes')]
    private ?StationSki $station = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $fermeture_expectionelle = null;

    #[ORM\ManyToMany(targetEntity: Defis::class, mappedBy: 'piste')]
    private Collection $defis;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $horaire_ouverture = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $horaire_fermeture = null;

    public function __construct()
    {
        $this->defis = new ArrayCollection();
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

    public function getDifficulte(): ?string
    {
        return $this->difficulte;
    }

    public function setDifficulte(string $difficulte): self
    {
        $this->difficulte = $difficulte;

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




    public function isBlock(): ?bool
    {
        return $this->block;
    }


    public function getBlock(): ?bool

    {
        return $this->block;
    }

    public function setBlock(bool $block): self
    {
        $this->block = $block;

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


    public function getFermetureExpectionelle(): ?string
    {
        return $this->fermeture_expectionelle;
    }

    public function setFermetureExpectionelle(?string $fermeture_expectionelle): self
    {
        $this->fermeture_expectionelle = $fermeture_expectionelle;
        return $this;
    }

    /**
     * @return Collection<int, Defis>
     */
    public function getDefis(): Collection
    {
        return $this->defis;
    }

    public function addDefi(Defis $defi): self
    {
        if (!$this->defis->contains($defi)) {
            $this->defis->add($defi);
            $defi->addPiste($this);
        }

        return $this;
    }

    public function removeDefi(Defis $defi): self
    {
        if ($this->defis->removeElement($defi)) {
            $defi->removePiste($this);
        }
        return $this;
    }


    const PISTE_STATUS_OPEN = 'open';
    const PISTE_STATUS_CLOSE = 'close';
    const PISTE_STATUS_OPEN_BLOCKED = 'open_blocked';
    const PISTE_STATUS_CLOSE_BLOCKED = 'close_blocked';

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $pisteStatus = self::PISTE_STATUS_CLOSE;

    public function getPisteStatus(): ?string
    {
        return $this->pisteStatus;
    }

    public function setPisteStatus(string $pisteStatus): self
    {
        $this->pisteStatus = $pisteStatus;
    }

    public function __toString()
    {
        return $this->name;
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


    public function isOpen(): bool
    {
        return $this->pisteStatus === self::PISTE_STATUS_OPEN || $this->pisteStatus === self::PISTE_STATUS_OPEN_BLOCKED;
    }

    public function isClose(): bool
    {
        return $this->pisteStatus === self::PISTE_STATUS_CLOSE || $this->pisteStatus === self::PISTE_STATUS_CLOSE_BLOCKED;
    }

    public function isBlocked(): bool
    {
        return $this->pisteStatus === self::PISTE_STATUS_OPEN_BLOCKED || $this->pisteStatus === self::PISTE_STATUS_CLOSE_BLOCKED;
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

}
