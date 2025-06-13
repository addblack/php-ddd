<?php

namespace App\Domain\Order;

class Order
{
    public function __construct(
        public readonly string $id,
        public string $title,
        public ?string $description = null
    ) {}
}
