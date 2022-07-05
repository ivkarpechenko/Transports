<?php

namespace App\Service;

use App\Dto\LogisticsDto;
use App\Entity\LogisticsHistory;

interface SaveLogisticsHistoryServiceInterface
{
    public function save(LogisticsDto $dto): LogisticsHistory;
}