<?php

namespace App\Entity;

use App\Repository\TruckRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @Assert\Range(
     * min = 1000,
     * max = 8000,
     * minMessage = "Minimum number is 1000",
     * maxMessage = "Maximum number is 8000"
     * )
     * @Assert\NotBlank()
     */
    private $maxLoad;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $loaded;

    /**
     * @ORM\Column(type="integer")
     */
    private $transportPrice;

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

    public function getTransportPrice(): ?int
    {
        return $this->transportPrice;
    }

    public function setTransportPrice(int $transportPrice): self
    {
        $this->transportPrice = $transportPrice;

        return $this;
    }
}
