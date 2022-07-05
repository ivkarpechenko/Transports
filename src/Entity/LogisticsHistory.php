<?php

namespace App\Entity;

use App\Repository\LogisticsHistoryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LogisticsHistoryRepository::class)]
class LogisticsHistory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    private $logisticsId;

    #[ORM\Column(type: 'string', length: 255)]
    private $status;

    #[ORM\Column(type: 'string', length: 255)]
    private $createdAt;

    /**
     * @param $logisticsId
     * @param $status
     * @param $createdAt
     */
    public function __construct($logisticsId, $status, $createdAt)
    {
        $this->logisticsId = $logisticsId;
        $this->status = $status;
        $this->createdAt = $createdAt;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLogisticsId(): ?int
    {
        return $this->logisticsId;
    }

    public function setLogisticsId(int $logisticsId): self
    {
        $this->logisticsId = $logisticsId;

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

    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    public function setCreatedAt(string $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
