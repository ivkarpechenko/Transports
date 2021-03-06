<?php

namespace App\Dto;

class LogisticsDto
{
    public function __construct(
        public readonly int    $id,
        public readonly int    $price,
        public readonly string $name,
        public readonly string $status,
        public readonly string $createdAt
    )
    {
    }
}