<?php

namespace App\Serializer\Resolver;

use App\Dto\OrderDto;
use App\Serializer\Denormalizer\OrderDtoDenormalizer;
use App\Serializer\JsonDeserializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class OrderDtoResolver implements  ArgumentValueResolverInterface
{

    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        return $argument->getType() === OrderDto::class;
    }

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $dto = (new JsonDeserializer([new OrderDtoDenormalizer()]))->deserialize(
            $request->getContent(),
            OrderDto::class
        );
        yield $dto;
    }
}