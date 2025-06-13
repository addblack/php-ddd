<?php

namespace App\Application\Order;

use App\Domain\Order\Order;
use App\Domain\Order\OrderRepositoryInterface;

class ListOrdersService
{
	public function __construct(
		private readonly OrderRepositoryInterface $repository
	) {}

	/**
	 * @return Order[]
	 */
	public function execute(): array
	{
		return $this->repository->all();
	}
}
