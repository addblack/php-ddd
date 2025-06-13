<?php

namespace App\Infrastructure\Order;

use App\Domain\Order\Order;
use App\Domain\Order\OrderRepositoryInterface;

class InMemoryOrderRepository implements OrderRepositoryInterface
{
    private array $orders = [];

    public function save(Order $order): void
    {
        $this->orders[$order->id] = $order;
    }

    public function all(): array
    {
        return $this->orders;
    }
}
