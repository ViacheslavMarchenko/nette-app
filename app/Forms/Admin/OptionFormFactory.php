<?php

declare(strict_types=1);

namespace App\Forms\Admin;

use Nette\Application\UI\Form;
use Nette\Forms\Container;

/**
 * Class OptionForm
 */
class OptionFormFactory
{
    /**
	 * @return Form
	 */
	public function create(): Form
	{
		$form = new Form;

		$form->addText('adminemail', 'E-mail administratora');
        
        $form->addInteger('post_per_page', 'Příspěvků na stránce');
        
        $form->addSubmit('submit', 'Uložit');

		return $form;
	}
}