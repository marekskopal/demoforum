<?php

namespace App\Forms;

use Nette;
use Nette\Application\UI\Form;
use Nette\Security\User;
use App\Model\Repository;

/**
 * Comment form factory
 *
 * @package demoforum
 * @author Marek Skopal <marek.skopal@gmail.com>
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class CommentFormFactory
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
	public function create(callable $onSuccess)
	{
		$form = $this->factory->create();
		$form->getElementPrototype()->addAttributes(
			[
				'class' => 'ajax'
			]
		);

		$form->addText('title', 'Title:');
		$form->addTextarea('message', 'Message:')
			->setRequired('Write some funny message.');
		$form->addSubmit('send', 'Send comment');

		$form->onSuccess[] = function (Form $form, $values) use ($onSuccess) {
			$user = $this->userRepository->findUserById((int) $this->user->getId());
			
			if (isset($user)) {
				$comment = new \App\Model\Entity\Comment();
				$comment->setUser($user);
				$comment->setTitle($values->title);
				$comment->setCreationDate(new \DateTime());
				$comment->setMessage($values->message);

				$this->commentRepository->persist($comment);
			}

			$onSuccess();
		};

		return $form;
	}
}
