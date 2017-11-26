<?php

namespace App\Presenters;

use Nette\Application\UI;
use Nette\Application\UI\Multiplier;
use App\Model\Repository;
use App\Forms;

/**
 * Forum presenter
 *
 * @package demoforum
 * @author Marek Skopal <marek.skopal@gmail.com>
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class ForumPresenter extends BasePresenter
{

	/** @var Repository\CommentRepository */
	protected $commentRepository;

	/** @var Forms\SignUpFormFactory */
	private $commentFormFactory;

	/** @var Forms\SignUpFormFactory */
	private $responseFormFactory;

	public function __construct(
		Repository\CommentRepository $commentRepository, 
		Forms\CommentFormFactory $commentFormFactory, 
		Forms\ResponseFormFactory $responseFormFactory
	) {
		$this->commentRepository = $commentRepository;
		$this->commentFormFactory = $commentFormFactory;
		$this->responseFormFactory = $responseFormFactory;
	} 

	/**
	 * Before render
	 * @return void
	 */
	protected function beforeRender()
	{
		$user = $this->getUser();
		if (!$user->isLoggedIn()) {
			$this->redirect('Login:signIn');
		}
	}

	/**
	 * Default render
	 * @return void
	 */
	public function renderDefault()
	{
		$comments = $this->commentRepository->findAllComments();

		$this->template->comments = $comments;
	}

	/**
	 * Comment form factory
	 * @return Nette\Application\UI\Form
	 */
	protected function createComponentCommentForm()
	{
		return $this->commentFormFactory->create(function () {
			$this->flashMessage('Comment was send.');

			if ($this->isAjax()) {
				$this->redrawControl('comments');
			} else {
				$this->redirect('Forum:default');
			}
		});
	}

	/**
	 * Response form factory
	 * @return Multiplier
	 */
	protected function createComponentResponseForm()
	{
		return new Multiplier(function ($commentId) {
			return $this->responseFormFactory->create($commentId, function () {
				$this->flashMessage('Response was send.');
	
				if ($this->isAjax()) {
					$this->redrawControl('comments');
				} else {
					$this->redirect('Forum:default');
				}
			});
		});
	}

}
