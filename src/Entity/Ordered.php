<?php

namespace App\Entity;

use App\Repository\OrderedRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderedRepository::class)
 */
class Ordered
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $Tax;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $timetoarrive;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $reduce;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTax(): ?float
    {
        return $this->Tax;
    }

    public function setTax(?float $Tax): self
    {
        $this->Tax = $Tax;

        return $this;
    }

    public function getTimetoarrive(): ?string
    {
        return $this->timetoarrive;
    }

    public function setTimetoarrive(string $timetoarrive): self
    {
        $this->timetoarrive = $timetoarrive;

        return $this;
    }

    public function getReduce(): ?float
    {
        return $this->reduce;
    }

    public function setReduce(?float $reduce): self
    {
        $this->reduce = $reduce;

        return $this;
    }
}
