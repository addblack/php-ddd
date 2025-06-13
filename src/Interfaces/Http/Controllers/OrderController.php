<?php

namespace App\Interfaces\Http\Controllers;

use App\Application\Order\CreateOrderService;

class OrderController
{
    public function __construct(
        private readonly CreateOrderService $service
    ) {}

    public function create(): void
    {
        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data['title'])) {
            http_response_code(400);
            echo json_encode(['error' => 'title is required']);
            return;
        }

        $order = $this->service->execute(
            $data['title'],
            $data['description'] ?? null
        );

        http_response_code(201);
        header('Content-Type: application/json');
        echo json_encode([
            'id' => $order->id,
            'title' => $order->title,
            'description' => $order->description
        ]);
    }
}
