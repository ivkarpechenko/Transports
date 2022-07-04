<?php

namespace App\Service;

interface GetHistoryLogisticsServiceInterface
{
    public function getHistoryOrder(int $id): array;

}