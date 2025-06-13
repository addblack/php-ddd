<?php

namespace App\Domain\Order;

class Order
{
    public function __construct(
        public readonly string $id,
        public string $title,
        public ?string $description = null
    ) {}

	public function getId(): string
	{
		return $this->id;
	}

	public function getTitle(): string
	{
		return $this->title;
	}

	public function getDescription(): ?string
	{
		return $this->description;
	}
}
