<?php

namespace App\Service;

use App\Dto\LogisticsDto;
use App\Dto\OrderDto;

interface CreateLogisticsServiceInterface
{
    public function create(OrderDto $dto): LogisticsDto;
}