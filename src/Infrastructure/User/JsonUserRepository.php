<?php

use App\Domain\User\User;

class JsonUserRepository implements UserRepositoryInterface
{
	private string $file;

	public function __construct()
	{
		$this->file = ROOT_PATH . '/storage/users.json';
		if (!file_exists($this->file)) {
			file_put_contents($this->file, json_encode([]));
		}
	}

	public function findByEmail(string $email): ?User { /* ... */ }
	public function save(User $user): void { /* ... */ }
}
