<?php

namespace App\MessageHandler;

use App\Dto\LogisticsDto;
use App\Entity\Logistics;
use App\Message\LogisticsChangeStatusMessage;
use App\Message\LogisticsMessage;
use App\Message\SendCompletedOrderMessage;
use App\Repository\LogisticsRepository;
use App\Service\SaveLogisticsHistoryServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Workflow\WorkflowInterface;

class LogisticsChangeStatusMessageHandler implements MessageHandlerInterface
{
    public function __construct(
        private EntityManagerInterface               $entityManager,
        private LogisticsRepository                  $logisticsRepository,
        private MessageBusInterface                  $bus,
        private SaveLogisticsHistoryServiceInterface $saveLogisticsHistoryService,
        private WorkflowInterface                    $logisticsStateMachine,
        private ?LoggerInterface                     $logger = null
    )
    {
    }

    public function __invoke(LogisticsChangeStatusMessage $logisticsChangeStatusMessage)
    {
        $logistics = $this->logisticsRepository->find($logisticsChangeStatusMessage->id);
        if ($this->logisticsStateMachine->can($logistics, 'worked') && $logisticsChangeStatusMessage->status == "Processed") {
            $transaction = 'worked';
            $this->saveInHistory($logistics, $transaction);
        } elseif ($this->logisticsStateMachine->can($logistics, 'to_place') && $logisticsChangeStatusMessage->status == "Handed over to the pickup point") {
            $transaction = 'to_place';
            $this->saveInHistory($logistics, $transaction);
        } elseif ($this->logisticsStateMachine->can($logistics, 'complete') && $logisticsChangeStatusMessage->status == "Delivered") {
            $transaction = 'complete';
            $this->saveInHistory($logistics, $transaction);
            $this->bus->dispatch(new SendCompletedOrderMessage($logistics->getIdOrder(), "Completed"));
        } elseif ($this->logger) {
            $this->logger->alert('Dropping order message', ['orderID' => $logisticsChangeStatusMessage->status, 'status' => $logisticsChangeStatusMessage->status]);
        }
    }

    public function saveInHistory(?Logistics $logistics, string $transaction): void
    {
        $this->logisticsStateMachine->apply($logistics, $transaction);

        $this->saveLogisticsHistoryService->save(
            new LogisticsDto(
                $logistics->getId(),
                $logistics->getTotalPrice(),
                $logistics->getCompany()->getName(),
                $logistics->getStatus(),
                $logistics->getCreatedAt()
            )
        );
        $this->entityManager->flush();
        $this->bus->dispatch(new LogisticsMessage($logistics->getId()));
    }
}