<?php

declare(strict_types=1);

namespace App\Forms\Admin;

use Nette\Application\UI\Form;
use Nette\Forms\Container;

/**
 * Class UserForm
 */
class UserFormFactory
{
    private $roles = [];
    
    private $companies = [];
    
    /**
	 * @return Form
	 */
	public function create(): Form
	{
		$form = new Form;

		$form->addText('name', 'Jméno uživatele')
			->setRequired('Prosím zadejte jméno uživatele.');
        
        $form->addText('email', 'E-mail uživatele')
			->setRequired('Prosím zadejte email uživatele.');
        
        $form->addPassword('password', 'Heslo uživatele');
        	//->addRule($form::MIN_LENGTH, 'Heslo musí mít alespoň %d znaků', 8)
        	//->addRule($form::PATTERN, 'Musí obsahovat číslici', '.*[0-9].*');
          
        $form->addSelect('role', 'Role', $this->roles);
            
        $form->addCheckbox('activeinactive', 'Označte uživatele jako aktivní nebo neaktivní');
    
		$form->addSubmit('submit', 'Uložit');

		return $form;
	}
    
    /**
     */
    public function setRoles(array $roles)
    {
        $this->roles = $roles;
    }
    
    /**
     */
    public function setCompanies(array $companies)
    {
        $this->companies = $companies;
    }
}