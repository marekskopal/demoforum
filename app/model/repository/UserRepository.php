<?php

namespace App\Model\Repository;

use Kdyby\Doctrine\EntityManager;
use App\Model\Entity\User;

/**
 * User repository
 *
 * @package demoforum
 * @author Marek Skopal <marek.skopal@gmail.com>
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class UserRepository
{
	/** @var \Kdyby\Doctrine\EntityManager */
	private $em;

	/** @var \Doctrine\ORM\EntityRepository */
	private $repository;

	public function __construct(EntityManager $em)
	{
		$this->em = $em;
		$this->repository = $em->getRepository(User::class);
	}

	/**
	 * Finds user by its id
	 * @param id $id
	 * @return User|null
	 */
	public function findUserById(int $id)
	{
		return $this->repository->find($id);
	}

	/**
	 * Finds user by its username
	 * @param string $username
	 * @return User|null
	 */
	public function findUserByUsername(string $username)
	{
		return $this->repository->findOneBy(
			[
				'username' => $username
			]
		);
	}

	/**
	 * Persist user into database
	 * @param User $user
	 * @return void
	 */
	public function persist(User $user)
	{
		$this->em->persist($user);
		$this->em->flush();
	}
}
