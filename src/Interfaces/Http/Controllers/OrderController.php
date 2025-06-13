<?php

namespace App\Interfaces\Http\Controllers;

use App\Application\Order\CreateOrderService;
use App\Application\Order\DeleteOrderService;
use App\Application\Order\ListOrdersService;

class OrderController
{
    public function __construct(
        private readonly CreateOrderService $service,
	    private readonly ListOrdersService $serviceList,
	    private readonly ?DeleteOrderService $serviceDelete = null
    ) {}

	public function create(): void
	{
		$data = $_POST ?: json_decode(file_get_contents('php://input'), true);

		$title = $data['title'] ?? null;
		$description = $data['description'] ?? null;

		if (!$title) {
			http_response_code(400);
			echo 'Title is required';
			return;
		}

		$order = $this->service->execute($title, $description);

		if (isset($_POST['title'])) {
			header('Location: /orders'); // after HTML form
		} else {
			header('Content-Type: application/json');
			echo json_encode($order);
		}
	}


	public function list(): void
	{
		$orders = $this->serviceList->execute();

		http_response_code(200);
		header('Content-Type: text/html; charset=utf-8');

		echo '<h1>Orders</h1>';
		if (empty($orders)) {
			echo '<p>No orders found.</p>';
			return;
		}

		echo '<ul>';
		foreach ($orders as $order) {
			echo "<li><strong>{$order->getTitle()}</strong> — {$order->getDescription()} ";
			echo "<a href='/orders/delete/{$order->getId()}' style='color: red;' onclick='return confirm(\"Are you sure?\")'>Delete</a></li>";
		}

		echo '</ul>';
	}

	public function delete(string $id): void
	{
		if (!$this->serviceDelete) {
			http_response_code(500);
			echo "Delete service not configured";
			return;
		}

		$this->serviceDelete->execute($id);
		header('Location: /orders');
	}

}
