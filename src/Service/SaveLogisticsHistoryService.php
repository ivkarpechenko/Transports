<?php

namespace App\Service;

use App\Dto\LogisticsDto;
use App\Entity\LogisticsHistory;
use App\Repository\LogisticsHistoryRepository;

class SaveLogisticsHistoryService implements SaveLogisticsHistoryServiceInterface
{
    public function __construct(
        private LogisticsHistoryRepository $logisticsHistoryRepository
    )
    {
    }

    public function save(LogisticsDto $dto): LogisticsHistory
    {
        $logisticsHistory = new LogisticsHistory($dto->id, $dto->status, (new \DateTime())->format(DATE_ATOM));
        $this->logisticsHistoryRepository->add($logisticsHistory);
        return $logisticsHistory;
    }
}