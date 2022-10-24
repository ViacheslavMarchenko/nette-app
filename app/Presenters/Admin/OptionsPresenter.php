<?php

declare(strict_types=1);

namespace App\Presenters\Admin;

use Nette;
use Nette\Application\UI\Form;
use App\Model\Option;
use App\Repository\RecordNotFoundException;
use App\Forms\Admin\OptionFormFactory;
use App\Repository\OptionRepository;
use Nette\Utils\ArrayHash;
use Nette\Application\Request;
use App\Presenters\AuthorizedPresenter;

class OptionsPresenter extends AuthorizedPresenter
{
    use BasicPresenter;
    
    /**
	 * @var OptionRepository @inject
	 */
	public $optionRepository;
    
    /**
	 * @var OptionFormFactory @inject
	 */
	public $optionFormFactory;
    
    private $options = [];
    
    /**
	 */
	public function renderDefault(): void
	{
	    if (!$this->user->isAllowed("full"))
        {
            $this->redirect('Dashboard:default');
        }
        
        foreach ($this->optionRepository->getAll() as $row)
        {
            $this->options[ $row->getOptionKey() ] = $row->getOptionValue();
        }
	}   
    
    /**
	 * @return Form
	 */
	public function createComponentOptionForm(): Form
	{
	    $form = $this->optionFormFactory->create();
        
        if ($this->options) {
			$form->setDefaults($this->optionsDefault());
		}
        
		$form->onError[] = function(Form $form) {
			foreach ($form->getErrors() as $error) {
				$this->flashMessage($error, 'error');
			}
		};
        
        $form->onSuccess[] = function(Form $form, ArrayHash $values) {
			$this->optionRepository->update($values);
            $this->redirect(':default');
		};
        
        
		return $form;
	}        
    
    private function optionsDefault()
    {
        $options = [];
        
        foreach ($this->optionRepository->getAll() as $row)
        {
            $options[ $row->getOptionKey() ] = $row->getOptionValue();
        }
        
        return $options;
    }
}