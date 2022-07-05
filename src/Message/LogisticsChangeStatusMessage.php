<?php

namespace App\Message;

class LogisticsChangeStatusMessage
{
    public function __construct(
        public readonly int    $id,
        public readonly string $status
    )
    {
    }
}