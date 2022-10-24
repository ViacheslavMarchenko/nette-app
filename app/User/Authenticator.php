<?php

declare(strict_types=1);

namespace App\User;

use Nette\Security\AuthenticationException;
use Nette\Security\IAuthenticator;
use Nette\Security\Identity;
use Nette\Security\IIdentity;
use Nette\Security\Passwords;
use App\Repository\UserRepository;

/**
 * Class Authenticator
 */
class Authenticator implements IAuthenticator
{
	/**
	 * @var UserRepository
	 */
	private $userRepository;

	/**
	 * @var Passwords
	 */
	private $passwords;

	/**
	 * Authenticator constructor.
	 * @param UserRepository $userRepository
	 * @param Passwords $passwords
	 */
	public function __construct(UserRepository $userRepository, Passwords $passwords)
	{
		$this->userRepository = $userRepository;
		$this->passwords = $passwords;
	}

	/**
	 * @param array $credentials
	 * @throws AuthenticationException
	 * @return IIdentity
	 */
	public function authenticate(array $credentials): IIdentity
	{
		[$email, $password] = $credentials;

        $user = $this->userRepository->findOneByEmail($email);
        
		if (!$user) {
			throw new AuthenticationException('User with provided email was not found.');
		}

		if (!$this->passwords->verify($password, $user->getPassword())) {
			throw new AuthenticationException('Invalid password entered.');
		}
        
		return new Identity($user->getId(), $user->getRole(), [
			'name' => $user->getName(),
			'email' => $user->getEmail(),
            'role' => $user->getRole(),
		]);
	}
}