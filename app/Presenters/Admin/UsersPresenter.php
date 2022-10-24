<?php

declare(strict_types=1);

namespace App\Presenters\Admin;

use Nette;
use Nette\Application\UI\Form;
use App\Model\User;
use App\Model\Role;
use App\Forms\Admin\UserFormFactory;
use App\Forms\Admin\SearchFormFactory;
use App\Repository\RecordNotFoundException;
use App\Repository\UserRepository;
use App\Repository\RoleRepository;
use App\Repository\OptionRepository;
use Nette\Utils\ArrayHash;
use App\Mail\MailFactory;
use App\Presenters\AuthorizedPresenter;

class UsersPresenter extends AuthorizedPresenter
{
    use BasicPresenter;
    
    /**
	 * @var UserRepository @inject
	 */
	public $userRepository;
    
    /**
	 * @var RoleRepository @inject
	 */
	public $roleRepository;
    
    /**
	 * @var OptionRepository @inject
	 */
	public $optionRepository;
    
    /**
	 * @var UserFormFactory @inject
	 */
	public $userFormFactory;
    
    /**
	 * @var SearchFormFactory @inject
	 */
	public $searchFormFactory;
    
    /**
	 * @var MailFactory @inject
	 */
	public $mailFactory;
    
    private $subscriber;
    
    public function renderDefault(int $page = 1, string $s = ""): void
    {
        $paginator = new Nette\Utils\Paginator;
		$paginator->setItemCount( $this->userRepository->countRows($s) ); 
		$paginator->setItemsPerPage( (int)$this->optionRepository->get('post_per_page') ?? 16 ); 
		$paginator->setPage($page); 
        
        $this->template->users = $this->userRepository->findAll($this->user, $paginator->getLength() + 1, $paginator->getOffset(), $s);
        $this->template->paginator = $paginator;
        $this->template->s = $s;
    }
    
	/**
	 */
	public function renderCreate(): void
	{
	    if (!$this->user->isAllowed("users", "create"))
        {
            $this->redirect(':default');
        }
        
	    if (!$this->isAjax())
        {
            $this->template->newpassword = "";
        } 
	}
    
	/**
	 */
	public function renderEdit(): void
	{
	    if (!$this->isAjax())
        {
            $this->template->newpassword = "";
        } 
		$this->setView('create');
	}
    
    /**
	 * @param int $id
	 * @throws BadRequestException
	 */
	public function actionEdit(int $id): void
	{
	    try {
            $this->template->subscriber = $this->subscriber = $this->userRepository->findOneById($id);
            $this->template->flashMessage = 'Služba byla úspěšně odstraněna.';
		} catch (RecordNotFoundException $e) {
			throw new BadRequestException('No service was found with provided ID.');
		}
	}
    
    /**
	 * @param int $id
	 * @throws AbortException
	 * @throws RecordNotFoundException
	 */
	public function actionRemove(int $pid): void
	{
        if ($this->user->isAllowed("users", "delete"))
        {
    	    $service = $this->userRepository->findOneById($id);
    		$this->userRepository->remove($service);
    
    		$this->flashMessage('Soubor byl úspěšně odstraněn.');
        }
        else
        {
            $this->flashMessage('Nemáte práva odstraňovat soubor.', 'error');
        }
		$this->redirect(':default');
	}
    
    /**
	 * @return Form
	 */
	public function createComponentUserForm(): Form
	{
	    $this->setRoles();
        $form = $this->userFormFactory->create();
        
        if ($this->subscriber) {
			$form->setDefaults($this->subscriber->toArray());
		}
        
		$form->onError[] = function(Form $form) {
			foreach ($form->getErrors() as $error) {
				$this->flashMessage($error, 'error');
			}
		};
        
        $form->onSuccess[] = function(Form $form, ArrayHash $values) {
			if ($this->subscriber) 
            {
				$updated = $this->userRepository->update($this->subscriber, $values);
                if ($updated)
                {
                    //$this->mailFactory::mailUpdateUser($values['email'], $values['password']);
				    $this->flashMessage('User was successfully updated.', 'success');
                }
                else
                    $this->flashMessage('This user exists.', 'error');
			} 
            else 
            {
                if ($this->userRepository->existsEmail($values['email']))
                {
                    $this->flashMessage('Thу user цшер  exists.', 'error');
                    $form->onError[] = $this;
                    
                    return $form;
                }
                
				$this->subscriber = $this->userRepository->create($values);
                if ( $this->subscriber != null )
                {
                    //$this->mailFactory::mailNewUser($values['email'], $values['password']);
				    $this->flashMessage('User was successfully create.', 'success');
                }
                else
                {
                    $this->flashMessage('This user exists.', 'error');
                    $this->redirect(':create');
                }
			}
            
			$this->redirect(':edit', $this->subscriber->getId());
		};
        
		return $form;
	}
    
    private function setRoles() {
        $roles = [];
        
        foreach ($this->roleRepository->findAll() as $role) 
        {
            $roles[$role->getId()] = $role->getTitle();
		}
        
	    $this->userFormFactory->setRoles($roles);
    }
    
    private function getDefaultRole()
    {
        return $this->subscriber->getRoleId();
    }
}