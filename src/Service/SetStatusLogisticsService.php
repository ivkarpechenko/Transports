<?php

namespace App\Service;

use App\Dto\SetStatusDto;
use App\Message\LogisticsChangeStatusMessage;
use App\Repository\LogisticsRepository;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Workflow\WorkflowInterface;

class SetStatusLogisticsService implements SetStatusLogisticsServiceInterface
{
    public function __construct(
        private LogisticsRepository $logisticsRepository,
        private WorkflowInterface   $logisticsStateMachine,
        private MessageBusInterface $bus
    )
    {
    }

    public function setStatusLogistics(SetStatusDto $dto): ?int
    {
        $logistics = $this->logisticsRepository->find($dto->id);
        foreach ($this->logisticsStateMachine->getEnabledTransitions($logistics) as $enabledTransition) {
            foreach ($enabledTransition->getTos() as $to) {
                if ($to == $dto->status) {
                    $this->bus->dispatch(new LogisticsChangeStatusMessage($dto->id, $dto->status));
                    return $dto->id;
                }
            }
        }
        return null;
    }
}