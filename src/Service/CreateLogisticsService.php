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
        $logistics = new Logistics();

        $company = $this->companyRepository->findProfitByVolumeAndWeight($dto->getVolume(), $dto->getWeight());
        $logistics->setCompany($this->companyRepository->find($company["id"]));
        $logistics->setCreatedAt(new \DateTime());
        $logistics->setTotalPrice($company["min"]);
        $logistics->setIdOrder($dto->getId());

        $this->logisticsRepository->add($logistics);
        return new LogisticsDto($logistics->getId(), $company["min"], $company["name"] , $logistics->getStatus(), $logistics->getCreatedAt());
    }

    public function saveInHistory(?Logistics $logistics): void
    {
        $oldStatusLogistics = new Logistics();
        $oldStatusLogistics->setParent($logistics->getId());
        $oldStatusLogistics->setCompany($logistics->getCompany());
        $oldStatusLogistics->setStatus($logistics->getStatus());
        $oldStatusLogistics->setCreatedAt($logistics->getCreatedAt());
        $oldStatusLogistics->setTotalPrice($logistics->getTotalPrice());
        $oldStatusLogistics->setIdOrder($logistics->getIdOrder());
        $this->logisticsRepository->add($oldStatusLogistics);
    }

}