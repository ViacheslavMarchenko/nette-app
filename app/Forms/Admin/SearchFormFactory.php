<?php

declare(strict_types=1);

namespace App\Forms\Admin;

use Nette\Application\UI\Form;

/**
 * Class SearchInForm
 */
class SearchFormFactory
{

	/**
	 * @return Form
	 */
	public function create(): Form
	{
		$form = new Form;

		$form->addText('s', 'Výhledat');

		$form->addSubmit('submit', 'Přihlásit se');

		return $form;
	}
}