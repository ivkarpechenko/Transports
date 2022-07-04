<?php

namespace App\Dto;

class LogisticsDto
{
    private int $id;
    private int $price;
    private string $name;
    private string $status;
    private \DateTimeInterface $createdAt;

    /**
     * @param int $id
     * @param int $price
     * @param string $name
     * @param string $status
     * @param \DateTimeInterface $createdAt
     */
    public function __construct(int $id, int $price, string $name, string $status, \DateTimeInterface $createdAt)
    {
        $this->id = $id;
        $this->price = $price;
        $this->name = $name;
        $this->status = $status;
        $this->createdAt = $createdAt;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
    }

    /**
     * @param int $price
     */
    public function setPrice(int $price): void
    {
        $this->price = $price;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTimeInterface $createdAt
     */
    public function setCreatedAt(\DateTimeInterface $createdAt): void
    {
        $this->createdAt = $createdAt;
    }


}