<?php

namespace App\Message;

class SendCompletedOrderMessage
{
    public function __construct(
        public readonly int    $id,
        public readonly string $status
    )
    {
    }
}