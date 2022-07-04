<?php

namespace App\Service;

use App\Entity\Company;
use App\Repository\CompanyRepository;
use function PHPUnit\Framework\returnArgument;

class GetCompanyService implements GetCompanyServiceInterface
{
    public function __construct(
        private CompanyRepository $companyRepository
    )
    {
    }

    public function getCompany(int $id): Company
    {
        return $this->companyRepository->find($id);
    }
}