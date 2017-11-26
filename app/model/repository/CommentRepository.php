<?php

namespace App\Model\Repository;

use Kdyby\Doctrine\EntityManager;
use App\Model\Entity\Comment;

/**
 * Comment repository
 *
 * @package demoforum
 * @author Marek Skopal <marek.skopal@gmail.com>
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class CommentRepository
{
	/** @var \Kdyby\Doctrine\EntityManager */
	private $em;

	/** @var \Doctrine\ORM\EntityRepository */
	private $repository;

	public function __construct(EntityManager $em)
	{
		$this->em = $em;
		$this->repository = $em->getRepository(Comment::class);
	}

	/**
	 * Finds all comments
	 * @return array|null
	 */
	public function findAllComments()
	{
		return $this->repository->findBy(
			[
				'parentComment' => null
			], 
			[
				'id' => 'DESC'
			]
		);
	}

	/**
	 * Finds comment by its id
	 * @param id $id
	 * @return Comment|null
	 */
	public function findCommentById(int $id)
	{
		return $this->repository->find($id);
	}

	/**
	 * Persist comment into database
	 * @param Comment $comment
	 * @return void
	 */
	public function persist(Comment $comment)
	{
		$this->em->persist($comment);
		$this->em->flush();
	}
}
