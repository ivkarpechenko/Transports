<?php

namespace App\Entity;

use App\Repository\CompanyRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompanyRepository::class)]
class Company
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'integer')]
    private $volumeCost;

    #[ORM\Column(type: 'integer')]
    private $weightCost;

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

    /**
     * @return mixed
     */
    public function getVolumeCost()
    {
        return $this->volumeCost;
    }

    /**
     * @param mixed $volumeCost
     */
    public function setVolumeCost($volumeCost): void
    {
        $this->volumeCost = $volumeCost;
    }

    /**
     * @return mixed
     */
    public function getWeightCost()
    {
        return $this->weightCost;
    }

    /**
     * @param mixed $weightCost
     */
    public function setWeightCost($weightCost): void
    {
        $this->weightCost = $weightCost;
    }

}
