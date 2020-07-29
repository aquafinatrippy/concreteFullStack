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
     * @ORM\Column(type="integer")
     */
    private $maxLoad;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $loaded;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getLoaded(): ?bool
    {
        return $this->loaded;
    }

    public function setLoaded(?bool $loaded): self
    {
        $this->loaded = $loaded;

        return $this;
    }
}
