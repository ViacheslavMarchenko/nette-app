<?php

declare(strict_types=1);

namespace App\Presenters\Admin;

use App\Forms\SignInFormFactory;
use App\Forms\ResetPassFormFactory;
use App\Presenters\AbstractPresenter;
use App\Repository\UserRepository;
use App\Mail\MailFactory;
use Nette\Application\AbortException;
use Nette\Application\UI\Form;
use Nette\Security\AuthenticationException;
use Nette\Utils\ArrayHash;
use Nette\Http\SessionSection;

/**
 * Class AuthPresenter
 */
final class AuthPresenter extends AbstractPresenter
{

	/**
	 * @throws AbortException
	 */
	public function startup()
	{
		parent::startup();
        
        if ($this->user->isLoggedIn()) {
    		$this->redirect('Dashboard:');
		}
        
        if (!$this->isAjax())
            $this->template->signform = true;
	}

	/**
	 * @var SignInFormFactory @inject
	 */
	public $signInFormFactory;

	/**
	 * @var ResetPassFormFactory @inject
	 */
	public $resetPassFormFactory;

	/**
	 * @var UserRepository @inject
	 */
	public $userRepository;
    
    /**
	 * @var MailFactory @inject
	 */
	public $mailFactory;
    
	/**
	 * @return Form
	 */
	public function createComponentSignInForm(): Form
	{
		$form = $this->signInFormFactory->create();

		$form->onSuccess[] = function(Form $form, ArrayHash $values) {
		    if (!empty($values['password']))
            {
    			try {
    				$this->user->login($values['email'], $values['password']);
                    
                    $session = $this->getSession();
                    $section = $session->getSection('param');
                    $section->set('user', $this->user->id);
                    
    				$this->redirect('Dashboard:');
    			} catch (AuthenticationException $e) {
    				$this->flashMessage($e->getMessage(), 'error');
    			}
            }
            else
            {
                $this->flashMessage('Nemáte přístupu k administrací', 'error');
            }
		};

		return $form;
	}

	/**
	 * @return Form
	 */
	public function createComponentResetPassForm(): Form
	{
		$form = $this->resetPassFormFactory->create();

		$form->onError[] = function(Form $form) {
			foreach ($form->getErrors() as $error) {
				$this->flashMessage($error, 'error');
			}
		};
        
		$form->onSuccess[] = function(Form $form, ArrayHash $values) {
		    if (isset($values['email']))
            {
                $user = $this->userRepository->existsEmail($values['email']);
                
                if ($user)
                {
                    $hash = $this->userRepository->generatePassword($values['email']);
                    
                    try {
        				$this->mailFactory::mailRessetPass($values['email'], 
                            "Obnovení hesla na webu.", 
                            sprintf("Dobrý den %s<br /><br />Podrobnosti o vašem účtu jsou následující:<br />
                                Email: %s<br />
                                Heslo: %s<strong></strong><br /><br />
                            Vaše aktuální heslo bylo automaticky vygenerováno. Doporučujeme změnit heslo na něco, co je snáze zapamatovatelné a bezpečnější.", 
                            $user->getName(), $values['email'], $hash));
                            
    				    $this->flashMessage('Na Váš email bylo odeslano nové heslo.', 'success');
        			} catch (AuthenticationException $e) {
        				$this->flashMessage($e->getMessage(), 'error');
                        $this->template->signform = false;
        			}
                }
                else
                {
                    $this->flashMessage("Uvedený e-mail neexistuje. Zkontrolujte a zkuste znovu.", 'error');
                    $this->template->signform = false;
                }
            }
            else
            {
                $this->flashMessage('Nemáte přístupu k administrací', 'error');
            }
		};

		return $form;
	}

    public function handleResetPassword()
    {
        $this->flashMessage('');
        $this->template->signform = false;
        $this->redrawControl('authform');
    }
    
    public function handleLoginForm()
    {
        $this->flashMessage('');
        $this->template->signform = true;
        $this->redrawControl('authform');
    }
}
