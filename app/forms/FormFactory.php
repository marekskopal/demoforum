<?php

namespace App\Forms;

use Nette;
use Nette\Application\UI\Form;

/**
 * Form factory
 */
class FormFactory
{
	use Nette\SmartObject;

	/**
	 * @return Form
	 */
	public function create()
	{
		$form = new Form;
		$form->setRenderer(new Renderer\BootstrapRenderer);
		return $form;
	}
}
