<?php

namespace App\Service;

use App\Dto\LogisticsDto;
use App\Dto\OrderDto;
use App\Entity\Logistics;

interface CreateLogisticsServiceInterface
{
    public function create(OrderDto $dto): LogisticsDto;
    public function saveInHistory(?Logistics $logistics): void;
}