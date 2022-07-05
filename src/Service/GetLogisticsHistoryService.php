<?php

namespace App\Service;

use App\Repository\LogisticsHistoryRepository;

class GetLogisticsHistoryService implements GetLogisticsHistoryServiceInterface
{

    public function __construct(
        private LogisticsHistoryRepository $logisticsHistoryRepository
    )
    {
    }

    public function getHistoryOrder(int $id): array
    {
        return $this->logisticsHistoryRepository->findBy(['logisticsId' => $id]);
    }
}