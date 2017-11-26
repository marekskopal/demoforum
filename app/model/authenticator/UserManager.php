<?php

namespace App\Model\Authenticator;

use Nette;
use Nette\Security\Passwords;
use App\Model\Repository\UserRepository;

/**
 * User manager
 *
 * @package demoforum
 * @author Marek Skopal <marek.skopal@gmail.com>
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class UserManager implements Nette\Security\IAuthenticator
{
	use Nette\SmartObject;

	/**
	 * @var UserRepository
	 */
	public $userRepository;

	public function __construct(UserRepository $userRepository)
	{
		$this->userRepository = $userRepository;
	}

	/**
	 * Performs an authentication.
	 * @return Nette\Security\Identity
	 * @throws Nette\Security\AuthenticationException
	 */
	public function authenticate(array $credentials)
	{
		list($username, $password) = $credentials;

		$user = $this->userRepository->findUserByUsername($username);

		if ($user === null) {
			throw new Nette\Security\AuthenticationException('The username is incorrect.', self::IDENTITY_NOT_FOUND);

		} elseif (!Passwords::verify($password, $user->getPassword())) {
			throw new Nette\Security\AuthenticationException('The password is incorrect.', self::INVALID_CREDENTIAL);

		} 

		return new Nette\Security\Identity($user->getId(), 'user', $user);
	}

	/**
	 * Adds new user.
	 * @param string
	 * @param string
	 * @return void
	 * @throws DuplicateNameException
	 */
	public function add(string $username, string $password)
	{
		try {
			$user = new \App\Model\Entity\User();
			$user->setUsername($username);
			$user->setPassword(Passwords::hash($password));		
	
			$this->userRepository->persist($user);
		} catch (\Doctrine\DBAL\Exception\UniqueConstraintViolationException $e) {
			throw new Exception\DuplicateNameException;
		}
	}
}
