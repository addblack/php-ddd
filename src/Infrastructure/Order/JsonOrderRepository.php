<?php

namespace App\Infrastructure\Order;

use App\Domain\Order\Order;
use App\Domain\Order\OrderRepositoryInterface;

class JsonOrderRepository implements OrderRepositoryInterface
{
	private string $file;

	public function __construct()
	{
		$this->file = ROOT_PATH . '/storage/orders.json';

		if (!file_exists($this->file)) {
			file_put_contents($this->file, json_encode([]));
		}
	}

	public function save(Order $order): void
	{
		$orders = $this->all();
		$orders[] = $order;
		file_put_contents($this->file, json_encode($orders, JSON_PRETTY_PRINT));
	}

	public function delete(string $id): void
	{
		$orders = $this->all();
		$orders = array_filter($orders, fn(Order $o) => $o->getId() !== $id);
		file_put_contents($this->file, json_encode(array_values($orders), JSON_PRETTY_PRINT));
	}


	public function all(): array
	{
		if (!file_exists($this->file)) {
			return [];
		}

		$content = file_get_contents($this->file);
		$decoded = json_decode($content, true);

		if (!is_array($decoded)) {
			return [];
		}

		return array_map(
			fn($item) => new Order(
				$item['id'],
				$item['title'],
				$item['description'] ?? null
			),
			$decoded
		);
	}
}