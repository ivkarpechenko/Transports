<?php

namespace App\Service;

interface GetLogisticsHistoryServiceInterface
{
    public function getHistoryOrder(int $id): array;
}