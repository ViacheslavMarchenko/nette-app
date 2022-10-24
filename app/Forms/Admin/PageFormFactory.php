<?php

declare(strict_types=1);

namespace App\Forms\Admin;

use Nette\Application\UI\Form;
use Nette\Forms\Container;

/**
 * Class PageForm
 */
class PageFormFactory
{
    /**
	 * @return Form
	 */
	public function create(): Form
	{
	    $form = new Form;

		$form->addText('title', 'Název stránky')
			->setRequired('Prosím zadejte název.');
        
        $form->addText('slug', 'Permalink');
        
        $form->addTextArea('content', 'Text')
            ->setHtmlAttribute('rows', 20);
        
        $form->addCheckbox('activeinactive', 'Označte uživatele jako aktivní nebo neaktivní')
            ->setDefaultValue(1);
            
        $form->addCheckbox('sitemap', 'Přídat do mapy webu')
            ->setDefaultValue(1);
    
        $form->addHidden('feature_image');
        
		$form->addSubmit('submit', 'Uložit');
        
		return $form;
	}
}