<?php

namespace App\Application\Order;

use App\Domain\Order\OrderRepositoryInterface;

class DeleteOrderService
{
	public function __construct(
		private readonly OrderRepositoryInterface $repository
	) {}

	public function execute(string $id): void
	{
		$this->repository->delete($id);
	}
}
