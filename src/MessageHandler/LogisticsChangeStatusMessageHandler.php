<?php

namespace App\MessageHandler;

use App\Entity\Logistics;
use App\Message\LogisticsChangeStatusMessage;
use App\Message\LogisticsMessage;
use App\Message\SendCompletedOrderMessage;
use App\Repository\LogisticsRepository;
use App\Service\CreateLogisticsService;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Workflow\WorkflowInterface;

class LogisticsChangeStatusMessageHandler implements MessageHandlerInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private LogisticsRepository    $logisticsRepository,
        private MessageBusInterface    $bus,
        private CreateLogisticsService $createLogisticsService,
        private WorkflowInterface      $orderStateMachine,
        private ?LoggerInterface       $logger = null
    )
    {
    }

    public function __invoke(LogisticsChangeStatusMessage $logisticsChangeStatusMessage)
    {
        $logistics = $this->logisticsRepository->find($logisticsChangeStatusMessage->getId());
        if ($this->orderStateMachine->can($logistics, 'worked') && $logisticsChangeStatusMessage->getStatus() == "Processed") {
            $transaction = 'worked';
            $this->saveInHistory($logistics, $transaction);
        } elseif ($this->orderStateMachine->can($logistics, 'to_place') && $logisticsChangeStatusMessage->getStatus() == "Handed over to the pickup point") {
            $transaction = 'to_place';
            $this->saveInHistory($logistics, $transaction);
        } elseif ($this->orderStateMachine->can($logistics, 'complete') && $logisticsChangeStatusMessage->getStatus() == "Delivered") {
            $transaction = 'complete';
            $this->saveInHistory($logistics, $transaction);
            $this->bus->dispatch(new SendCompletedOrderMessage($logistics->getIdOrder(), "Completed"));
        } elseif ($this->logger) {
            $this->logger->alert('Dropping order message', ['orderID' => $logisticsChangeStatusMessage->getId(), 'status' => $logisticsChangeStatusMessage->getStatus()]);
        }
    }

    public function saveInHistory(?Logistics $logistics, string $transaction): void
    {
        $this->createLogisticsService->saveInHistory($logistics);
        $this->orderStateMachine->apply($logistics, $transaction);
        $logistics->setCreatedAt(new \DateTime());
        $this->logisticsRepository->add($logistics);
        $this->entityManager->flush();
        $this->bus->dispatch(new LogisticsMessage($logistics->getId()));
    }

}