<?php

namespace App\Controller;

use App\Dto\LogisticsHistoryDto;
use App\Dto\OrderDto;
use App\Dto\SetStatusDto;
use App\Message\LogisticsChangeStatusMessage;
use App\Message\LogisticsMessage;
use App\Message\SendLogisticsMessage;
use App\Response\LogisticsResponse;
use App\Serializer\JsonSerializer;
use App\Service\CreateLogisticsServiceInterface;
use App\Service\GetLogisticsHistoryServiceInterface;
use App\Service\SaveLogisticsHistoryServiceInterface;
use App\Service\SetStatusLogisticsServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class LogisticsController extends AbstractController
{

    public function __construct(
        private CreateLogisticsServiceInterface      $createLogisticsService,
        private GetLogisticsHistoryServiceInterface  $getLogisticsHistoryService,
        private SaveLogisticsHistoryServiceInterface $saveLogisticsHistoryService,
        private SetStatusLogisticsServiceInterface   $setStatusLogisticsService,
        private EntityManagerInterface               $entityManager,
        private MessageBusInterface                  $bus
    )
    {
    }

    public function createLogistics(OrderDto $dto): LogisticsResponse
    {
        $logisticsDto = $this->createLogisticsService->create($dto);
        $this->saveLogisticsHistoryService->save($logisticsDto);
        $this->entityManager->flush();
        $this->bus->dispatch(new LogisticsMessage($logisticsDto->id));
        $this->bus->dispatch(new SendLogisticsMessage($logisticsDto->id, $dto->id, $logisticsDto->price, $logisticsDto->name));
        return new LogisticsResponse($logisticsDto);
    }

    public function showHistoryLogistics(int $id): JsonResponse
    {
        $logisticsHistory = $this->getLogisticsHistoryService->getHistoryOrder($id);
        $logHistory = [];
        foreach ($logisticsHistory as $logistics) {
            $logHistory[] = new LogisticsHistoryDto($logistics->getStatus(), $logistics->getCreatedAt());
        }
        $serializer = (new JsonSerializer([new ObjectNormalizer()]))->serialize($logHistory);
        return new JsonResponse($serializer, 200, [], true);
    }

    public function setStatusLogistics(SetStatusDto $dto): JsonResponse
    {
        $id = $this->setStatusLogisticsService->setStatusLogistics($dto);
        return new JsonResponse(["LogisticsId" => $id]);
    }


}
