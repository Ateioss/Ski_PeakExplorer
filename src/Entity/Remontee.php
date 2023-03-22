<?php

namespace App\Entity;

use App\Repository\RemonteeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RemonteeRepository::class)]
class Remontee
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?bool $open = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $open_time = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $close_time = null;

    #[ORM\ManyToOne(inversedBy: 'remontees')]
    private ?Station $station = null;

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

    public function isOpen(): ?bool
    {
        return $this->open;
    }

    public function setOpen(bool $open): self
    {
        $this->open = $open;

        return $this;
    }

    public function getOpenTime(): ?\DateTimeInterface
    {
        return $this->open_time;
    }

    public function setOpenTime(\DateTimeInterface $open_time): self
    {
        $this->open_time = $open_time;

        return $this;
    }

    public function getCloseTime(): ?\DateTimeInterface
    {
        return $this->close_time;
    }

    public function setCloseTime(\DateTimeInterface $close_time): self
    {
        $this->close_time = $close_time;

        return $this;
    }

    public function getStation(): ?Station
    {
        return $this->station;
    }

    public function setStation(?Station $station): self
    {
        $this->station = $station;

        return $this;
    }
}
