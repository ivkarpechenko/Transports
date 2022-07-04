<?php

namespace App\Controller;

use App\Dto\LogisticsDto;
use App\Dto\OrderDto;
use App\Dto\SetStatusDto;
use App\Message\LogisticsChangeStatusMessage;
use App\Message\LogisticsMessage;
use App\Message\SendLogisticsMessage;
use App\Response\LogisticsResponse;
use App\Serializer\JsonSerializer;
use App\Service\CreateLogisticsServiceInterface;
use App\Service\GetCompanyServiceInterface;
use App\Service\GetHistoryLogisticsServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Config\Framework\LockConfig;

class LogisticsController extends AbstractController
{

    public function __construct(
        private CreateLogisticsServiceInterface     $createLogisticsService,
        private GetHistoryLogisticsServiceInterface $historyLogisticsService,
        private GetCompanyServiceInterface          $getCompanyService,
        private EntityManagerInterface              $entityManager,
        private MessageBusInterface                 $bus
    )
    {
    }

    public function setStatusLogistics(SetStatusDto $dto): JsonResponse
    {
        $this->bus->dispatch(new LogisticsChangeStatusMessage($dto->getId(), $dto->getStatus()));
        return new JsonResponse(["LogisticsId" => $dto->getId()]);
    }

    public function createLogistics(OrderDto $dto): LogisticsResponse
    {
        $logisticsDto = $this->createLogisticsService->create($dto);
        $this->entityManager->flush();
        $this->bus->dispatch(new LogisticsMessage($logisticsDto->getId()));
        $this->bus->dispatch(new SendLogisticsMessage($logisticsDto->getId(), $dto->getId(), $logisticsDto->getPrice(), $logisticsDto->getName()));
        return new LogisticsResponse($logisticsDto);
    }

    public function showHistoryLogistics(int $id): JsonResponse
    {
        $logisticsHistory = $this->historyLogisticsService->getHistoryOrder($id);
        $logHistory = [];
        foreach ($logisticsHistory as $logistics) {
            $company = $this->getCompanyService->getCompany($logistics->getCompany()->getId());
            $logHistory[] = new LogisticsDto($logistics->getId(), $logistics->getTotalPrice(), $company->getName(), $logistics->getStatus(), $logistics->getCreatedAt());
        }
        $ser = (new JsonSerializer([new ObjectNormalizer()]))->serialize($logHistory);
        return new JsonResponse($ser, 200, [], true);
    }
}
