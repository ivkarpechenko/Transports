<?php

namespace App\Serializer\Normalizer;

use App\Dto\LogisticsDto;
use App\Repository\CompanyRepository;
use Symfony\Component\Serializer\Exception\CircularReferenceException;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Exception\LogicException;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class LogisticsDtoNormalizer implements NormalizerInterface
{

    public function normalize(mixed $object, string $format = null, array $context = []): bool|array
    {
        if(!$this->supportsNormalization($object)){
            return false;
        }
        return [
            "id" => $object->getID(),
            "name" => $object->getName(),
            "totalPrice" => $object->getPrice()
        ];
    }

    public function supportsNormalization(mixed $data, string $format = null): bool
    {
        return $data instanceof LogisticsDto;
    }
}