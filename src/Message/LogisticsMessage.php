<?php

namespace App\Message;

class LogisticsMessage
{
    public function __construct(
        public readonly int $id
    )
    {
    }
}