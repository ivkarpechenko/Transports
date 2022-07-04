<?php

namespace App\Service;

use App\Entity\Company;

interface GetCompanyServiceInterface
{
    public function getCompany(int $id): Company;
}