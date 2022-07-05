<?php

namespace App\Dto;

class LogisticsHistoryDto
{
    public function __construct(
        public readonly string $status,
        public readonly string $createdAt
    )
    {
    }
}