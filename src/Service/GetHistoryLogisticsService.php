<?php

namespace App\Service;

use App\Repository\LogisticsRepository;

class GetHistoryLogisticsService implements GetHistoryLogisticsServiceInterface
{

    public function __construct(
        private LogisticsRepository $logisticsRepository
    )
    {
    }

    public function getHistoryOrder(int $id): array
    {
        return $this->logisticsRepository->findHistoryById($id);
    }
}