<?php

declare(strict_types=1);

namespace App\Forms;

use Nette\Application\UI\Form;

/**
 * Class SignInForm
 */
class ResetPassFormFactory
{

	/**
	 * @return Form
	 */
	public function create(): Form
	{
		$form = new Form;

		$form->addText('email', 'E-mailová adresa')
			->setHtmlAttribute('placeholder', 'E-mail');
            
		$form->addSubmit('submit', 'Resetovst');

		return $form;
	}
}