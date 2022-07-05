<?php

namespace App\Message;

class SendLogisticsMessage
{
    public function __construct(
        public readonly int    $id,
        public readonly int    $orderId,
        public readonly int    $price,
        public readonly string $name
    )
    {
    }
}