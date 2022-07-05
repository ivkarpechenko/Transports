<?php

namespace App\MessageHandler;

use App\Message\SendLogisticsMessage;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class SendLogisticsMessageHandler implements MessageHandlerInterface
{
    public function __construct(
        private ParameterBagInterface $parameterBag,
        private ?LoggerInterface      $logger = null
    )
    {
    }

    public function __invoke(SendLogisticsMessage $sendLogisticsMessage)
    {
        $client = new Client(['base_uri' => $this->parameterBag->get("set_logistics_url")]);
        try {
            $request = $client->request('POST', $this->parameterBag->get("set_logistics_url"), [
                'json' => [
                    'id' => $sendLogisticsMessage->id,
                    'orderId' => $sendLogisticsMessage->orderId,
                    'price' => $sendLogisticsMessage->price,
                    'name' => $sendLogisticsMessage->name
                ]
            ]);
            $this->logger->info('Send to order', ['orderId' => $sendLogisticsMessage->orderId]);
        } catch (GuzzleException $e) {
            $this->logger->error('Error', ['message' => $e->getMessage()]);
        }
    }
}