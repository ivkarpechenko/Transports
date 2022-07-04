<?php

namespace App\MessageHandler;

use App\Message\LogisticsMessage;
use App\Message\SendLogisticsMessage;
use App\Repository\LogisticsRepository;
use Doctrine\ORM\EntityManagerInterface;
use GuzzleHttp\Client;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Workflow\WorkflowInterface;

class SendLogisticsMessageHandler implements MessageHandlerInterface
{
    public function __construct(
        private LogisticsRepository   $logisticsRepository,
        private ?LoggerInterface      $logger = null,
        private ParameterBagInterface $parameterBag
    )
    {
    }

    public function __invoke(SendLogisticsMessage $sendLogisticsMessage)
    {
        $logistics = $this->logisticsRepository->find($sendLogisticsMessage->getId());
        $this->logger->info('Logistics change status', ['LogisticsId' => $logistics->getId(), 'status' => $logistics->getStatus()]);

        $client = new Client(['base_uri' => $this->parameterBag->get("set_logistics_url")]);
        $request = $client->request('POST', $this->parameterBag->get("set_logistics_url"), [
            'json' => [
                'id' => $sendLogisticsMessage->getId(),
                'idOrder' => $sendLogisticsMessage->getIdOrder(),
                'price' => $sendLogisticsMessage->getPrice(),
                'name' => $sendLogisticsMessage->getName()
            ]
        ]);

        if ($request->getStatusCode() == 200) {
            $this->logger->info('Send to order', ['orderId' => $sendLogisticsMessage->getIdOrder()]);
        }
    }
}