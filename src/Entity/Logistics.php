<?php

namespace App\Entity;

use App\Repository\LogisticsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LogisticsRepository::class)]
class Logistics
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Company::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $company;

    #[ORM\Column(type: 'integer')]
    private $idOrder;

    #[ORM\Column(type: 'string', length: 255, options: ["default" => 'Created'])]
    private $status = 'Created';

    #[ORM\Column(type: 'string', length: 255)]
    private $createdAt;

    #[ORM\Column(type: 'integer')]
    private $totalPrice;

    public function __construct($company, $idOrder, $createdAt, $totalPrice)
    {
        $this->company = $company;
        $this->idOrder = $idOrder;
        $this->createdAt = $createdAt;
        $this->totalPrice = $totalPrice;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function getIdOrder(): ?int
    {
        return $this->idOrder;
    }

    public function setIdOrder(int $idOrder): self
    {
        $this->idOrder = $idOrder;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function setCreatedAt(string $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getTotalPrice(): ?int
    {
        return $this->totalPrice;
    }

    public function setTotalPrice(int $totalPrice): self
    {
        $this->totalPrice = $totalPrice;

        return $this;
    }
}
