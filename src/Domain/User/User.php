<?php

namespace App\Domain\User;

class User
{
	public function __construct(
		private string $id,
		private string $email,
		private string $passwordHash
	) {}

	public function getId(): string { return $this->id; }
	public function getEmail(): string { return $this->email; }
	public function verifyPassword(string $password): bool {
		return password_verify($password, $this->passwordHash);
	}
}
