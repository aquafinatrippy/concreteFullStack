<?php

namespace App\Entity;

use App\Repository\TruckRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TruckRepository::class)
 */
class Truck
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $licensePlate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $loaded;

    /**
     * @ORM\Column(type="integer")
     */
    private $maxLoad;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLicensePlate(): ?string
    {
        return $this->licensePlate;
    }

    public function setLicensePlate(string $licensePlate): self
    {
        $this->licensePlate = $licensePlate;

        return $this;
    }

    public function getLoaded(): ?string
    {
        return $this->loaded;
    }

    public function setLoaded(?string $loaded): self
    {
        $this->loaded = $loaded;

        return $this;
    }

    public function getMaxLoad(): ?int
    {
        return $this->maxLoad;
    }

    public function setMaxLoad(int $maxLoad): self
    {
        $this->maxLoad = $maxLoad;

        return $this;
    }
}
