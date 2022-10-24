<?php

declare(strict_types=1);

namespace App\Forms;

use Nette\Application\UI\Form;

/**
 * Class SignInForm
 */
class SignInFormFactory
{

	/**
	 * @return Form
	 */
	public function create(): Form
	{
		$form = new Form;

		$form->addText('email', 'E-mailová adresa')
			->setHtmlAttribute('placeholder', 'E-mail');

		$form->addPassword('password', 'Heslo')
			->setHtmlAttribute('placeholder', 'Heslo');

        /**
 * $form->addReCaptcha(
 *         	'recaptcha', // control name
 *         	'reCAPTCHA for you', // label
 *         	"Please prove you're not a robot." // error message
 *         );
 */
                
		$form->addSubmit('submit', 'Přihlásit se');

		return $form;
	}
}