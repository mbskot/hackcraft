<?php
namespace Models;

use Doctrine\ORM\EntityRepository,
	Models\User\UserModel,
	Nette\Object,
	Nette\Security as NS;

class Authenticator extends Object implements NS\IAuthenticator
{
	/** @var Models\User\UserModel */
	private $userModel;
	
	/**
	 * @param Models\User\UserModel
	 * @return Models\Authenticator
	 */
	public function __construct(UserModel $userModel)
	{
		$this->userModel = $userModel;
	}
	
	/**
	 * Performs an authentication
	 * @param  array
	 * @return Nette\Security\Identity
	 * @throws Nette\Security\AuthenticationException
	 */
	public function authenticate(array $credentials)
	{
		list($username, $password) = $credentials;
		$user = $this->userModel->findOneBy(array('username' => $username));

		if(!$user)
		{
			throw new NS\AuthenticationException("User '$username' not found.", self::IDENTITY_NOT_FOUND);
		}

		if($user->password !== $this->calculateHash($password))
		{
			throw new NS\AuthenticationException("Invalid password.", self::INVALID_CREDENTIAL);
		}

		return new NS\Identity($user->id, $user->role, array(
			'username' => $user->username,
			'email' => $user->email,
		));
	}
	
	/**
	 * Computes salted password hash.
	 * @param  string
	 * @return string
	 */
	public function calculateHash($password)
	{
		return md5($password . str_repeat('*enter any random salt here*', 10));
	}

}
