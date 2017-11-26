<?php

namespace App\Forms;

use Nette;
use Nette\Application\UI\Form;
use Nette\Security\User;
use App\Model\Repository;

/**
 * Response form factory
 *
 * @package demoforum
 * @author Marek Skopal <marek.skopal@gmail.com>
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class ResponseFormFactory
{
	use Nette\SmartObject;

	/** @var FormFactory */
	private $factory;

	/** @var Repository\CommentRepository */
	private $commentRepository;

	/** @var Repository\UserRepository */
	private $userRepository;

	/** @var User */
	private $user;

	public function __construct(
		FormFactory $factory, 
		Repository\CommentRepository $commentRepository,
		Repository\UserRepository $userRepository, 
		User $user
	) {
		$this->factory = $factory;
		$this->commentRepository = $commentRepository;
		$this->userRepository = $userRepository;
		$this->user = $user;
	}

	/**
	 * @return Form
	 */
	public function create(int $commentId, callable $onSuccess)
	{
		$form = $this->factory->create();
		$form->getElementPrototype()->addAttributes(
			[
				'class' => 'ajax'
			]
		);

		$form->addTextarea('message', 'Message:')
			->setRequired('Write some funny message.');
		$form->addHidden('parentComment', $commentId);
		$form->addSubmit('send', 'Send response');

		$form->onSuccess[] = function (Form $form, $values) use ($onSuccess) {
			$comment = $this->commentRepository->findCommentById((int) $values->parentComment);
			$user = $this->userRepository->findUserById((int) $this->user->getId());
			
			if (isset($comment) && isset($user)) {
				$response = new \App\Model\Entity\Comment();
				$response->setUser($user);
				$response->setCreationDate(new \DateTime());
				$response->setMessage($values->message);

				$comment->addresponse($response);

				$this->commentRepository->persist($comment);
			}

			$onSuccess();
		};

		return $form;
	}
}
