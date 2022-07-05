<?php

namespace App\Service;

use App\Dto\LogisticsDto;
use App\Dto\OrderDto;
use App\Entity\Logistics;
use App\Repository\CompanyRepository;
use App\Repository\LogisticsRepository;

class CreateLogisticsService implements CreateLogisticsServiceInterface
{
    public function __construct(
        private LogisticsRepository $logisticsRepository,
        private CompanyRepository   $companyRepository
    )
    {
    }

    public function create(OrderDto $dto): LogisticsDto
    {
        $company = $this->companyRepository->findProfitByVolumeAndWeight($dto->volume, $dto->weight);
        $logistics = new Logistics($this->companyRepository->find($company["id"]), $dto->id, (new \DateTime())->format(DATE_ATOM), $company["min"]);
        $this->logisticsRepository->add($logistics);
        return new LogisticsDto($logistics->getId(), $company["min"], $company["name"], $logistics->getStatus(), $logistics->getCreatedAt());
    }
}