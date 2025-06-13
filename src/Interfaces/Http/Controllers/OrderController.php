<?php

namespace App\Interfaces\Http\Controllers;

use App\Application\Order\CreateOrderService;
use App\Application\Order\ListOrdersService;

class OrderController
{
    public function __construct(
        private readonly CreateOrderService $service,
	    private readonly ListOrdersService $serviceList
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
			echo sprintf(
				'<li><strong>%s</strong><br/>%s<br/><small>ID: %s</small></li>',
				htmlspecialchars($order->title),
				htmlspecialchars($order->description ?? 'No description'),
				htmlspecialchars($order->id)
			);
		}
		echo '</ul>';
	}

}
