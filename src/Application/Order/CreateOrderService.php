<?php

namespace App\Application\Order;

use App\Domain\Order\Order;
use App\Domain\Order\OrderRepositoryInterface;

class CreateOrderService
{
    public function __construct(
        private readonly OrderRepositoryInterface $repository
    ) {}

    public function execute(string $title, ?string $description = null): Order
    {
        $order = new Order(
            id: uniqid(),
            title: $title,
            description: $description
        );

        $this->repository->save($order);

        return $order;
    }
}
