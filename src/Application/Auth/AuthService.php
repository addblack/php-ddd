<?php

namespace App\Application\Auth;

use App\Domain\User\User;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use JsonUserRepository;

class AuthService
{
	private string $secret = 'super_secret_jwt_key';

	public function __construct(
		private JsonUserRepository $repo
	) {}

	public function register(string $email, string $password): string
	{
		$user = new User(Uuid::v4(), $email, password_hash($password, PASSWORD_DEFAULT));
		$this->repo->save($user);
		return $this->createToken($user);å
	}

	/**
	 * @throws Exception
	 */
	public function login(string $email, string $password): string
	{
		$user = $this->repo->findByEmail($email);
		if (!$user || !$user->verifyPassword($password)) {
			throw new Exception('Invalid credentials');
		}
		return $this->createToken($user);
	}

	private function createToken(User $user): string
	{
		return JWT::encode(
			['id' => $user->getId(), 'email' => $user->getEmail()],
			$this->secret,
			'HS256'
		);
	}

	public function verify(string $token): \stdClass {
		return JWT::decode($token, new Key($this->secret, 'HS256'));
	}
}
