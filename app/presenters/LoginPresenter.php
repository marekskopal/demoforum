<?php

namespace App\Presenters;

use Nette\Application\UI;
use Nette\Application\UI\Multiplier;
use Nette\Forms\Form;
use App\Forms;

/**
 * Login presenter
 *
 * @package demoforum
 * @author Marek Skopal <marek.skopal@gmail.com>
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class LoginPresenter extends BasePresenter
{

	/** @var Forms\SignInFormFactory */
	private $signInFactory;
	
	/** @var Forms\SignUpFormFactory */
	private $signUpFactory;

	public function __construct(Forms\SignInFormFactory $signInFactory, Forms\SignUpFormFactory $signUpFactory)
	{
		$this->signInFactory = $signInFactory;
		$this->signUpFactory = $signUpFactory;
	} 

	/**
	 * Before render
	 * @return void
	 */
	protected function beforeRender()
	{
		$user = $this->getUser();
		if ($user->isLoggedIn()) {
			$this->redirect('Forum:default');
		}
	}

	/**
	 * Sign-in form factory.
	 * @return Form
	 */
	protected function createComponentSignInForm()
	{
		return $this->signInFactory->create(function () {
			$this->redirect('Forum:default');
		});
	}

	/**
	 * Sign-up form factory.
	 * @return Form
	 */
	protected function createComponentSignUpForm()
	{
		return $this->signUpFactory->create(function () {
			$this->redirect('Forum:default');
		});
	}

	/**
	 * Logout action
	 * @return void
	 */
	public function actionLogout()
	{
		$this->getUser()->logout();
		$this->redirect('Login:sign-in');
	} 


}
