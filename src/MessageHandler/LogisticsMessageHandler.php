<?php

namespace App\MessageHandler;

use App\Message\LogisticsMessage;
use App\Repository\LogisticsRepository;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class LogisticsMessageHandler implements MessageHandlerInterface
{
    public function __construct(
        private LogisticsRepository $logisticsRepository,
        private ?LoggerInterface    $logger = null
    )
    {
    }

    public function __invoke(LogisticsMessage $logisticsMessage)
    {
        $logistics = $this->logisticsRepository->find($logisticsMessage->getId());
        $this->logger->info('Logistics change status', ['LogisticsId' => $logistics->getId(), 'status' => $logistics->getStatus()]);
    }
}