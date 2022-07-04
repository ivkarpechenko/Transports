<?php

namespace App\Response;

use App\Dto\LogisticsDto;
use App\Serializer\Normalizer\LogisticsDtoNormalizer;
use Symfony\Component\HttpFoundation\JsonResponse;

class LogisticsResponse extends JsonResponse
{
    public function __construct(LogisticsDto $dto)
    {
        $normaliser = new LogisticsDtoNormalizer();
        $data = $normaliser->normalize($dto);
        parent::__construct($data, 200, []);
    }
}