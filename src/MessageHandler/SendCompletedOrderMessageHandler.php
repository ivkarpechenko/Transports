<?php

namespace App\MessageHandler;

use App\Message\SendCompletedOrderMessage;
use GuzzleHttp\Client;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class SendCompletedOrderMessageHandler implements MessageHandlerInterface
{
    public function __construct(
        private ?LoggerInterface      $logger = null,
        private ParameterBagInterface $parameterBag
    )
    {
    }

    public function __invoke(SendCompletedOrderMessage $completedOrderMessage)
    {
        $client = new Client(['base_uri' => $this->parameterBag->get("set_status_url")]);
        $request = $client->request('POST', $this->parameterBag->get("set_status_url"), [
            'json' => [
                'id' => $completedOrderMessage->getId(),
                'status' => "Completed"
            ]
        ]);
        if ($request->getStatusCode() == 200) {
            $this->logger->info('Send to order', ['orderId' => $completedOrderMessage->getId()]);
        }
    }
}