<?php

namespace App\Service;

use App\Dto\SetStatusDto;

interface SetStatusLogisticsServiceInterface
{
    public function setStatusLogistics(SetStatusDto $dto): ?int;
}