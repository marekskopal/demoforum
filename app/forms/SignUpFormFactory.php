<?php

namespace App\Forms;

use App\Model\Authenticator;
use Nette;
use Nette\Application\UI\Form;

/**
 * Sign up form factory
 */
class SignUpFormFactory
{
	use Nette\SmartObject;

	const PASSWORD_MIN_LENGTH = 6;

	/** @var FormFactory */
	private $factory;

	/** @var Authenticator\UserManager */
	private $userManager;

	public function __construct(FormFactory $factory, Authenticator\UserManager $userManager)
	{
		$this->factory = $factory;
		$this->userManager = $userManager;
	}

	/**
	 * @return Form
	 */
	public function create(callable $onSuccess)
	{
		$form = $this->factory->create();
		$form->addText('username', 'Pick a username:')
			->setRequired('Please pick a username.');

		$form->addPassword('password', 'Password:')
			->setOption('description', sprintf('at least %d characters', self::PASSWORD_MIN_LENGTH))
			->setRequired('Please create a password.')
			->addRule($form::MIN_LENGTH, null, self::PASSWORD_MIN_LENGTH);

		$form->addPassword('password_check', 'Password again:')
			->addRule(Form::FILLED, 'Plese enter password again.')
			->addRule(Form::EQUAL, 'Passwords do not match', $form['password']); 

		$form->addSubmit('send', 'Sign up');

		$form->onSuccess[] = function (Form $form, $values) use ($onSuccess) {
			try {
				$this->userManager->add($values->username, $values->password);
			} catch (Authenticator\Exception\DuplicateNameException $e) {
				$form['username']->addError('Username is already taken.');
				return;
			}
			$onSuccess();
		};

		return $form;
	}
}
