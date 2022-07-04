<?php

namespace App\Serializer\Denormalizer;

use App\Dto\OrderDto;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class OrderDtoDenormalizer implements DenormalizerInterface
{

    public function denormalize(mixed $data, string $type, string $format = null, array $context = []): OrderDto
    {
        return new OrderDto($data["id"], $data["volume"], $data["weight"]);
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null): bool
    {
        return $type === OrderDto::class;
    }
}