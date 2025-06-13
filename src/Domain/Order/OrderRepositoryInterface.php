<?php

namespace App\Domain\Order;

interface OrderRepositoryInterface
{
    public function save(Order $order): void;
}
