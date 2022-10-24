<?php

declare(strict_types=1);

namespace App\Presenters\Front;

use Nette;
use Nette\Application\UI\Form;
use Nette\Utils\ArrayHash;
use Nette\Security\AuthenticationException;
use App\Forms\SignInFormFactory;
use App\Presenters\AbstractPresenter;
use App\Repository\PageRepository;
use App\Repository\UploadRepository;

final class HomepagePresenter extends AbstractPresenter
{
    use BasicPresenter;
    
    /**
	 * @var PageRepository @inject
	 */
	public $pageRepository;
    
    /**
	 * @var UploadRepository @inject
	 */
	public $uploadRepository;

	/**
	 * @var SignInFormFactory @inject
	 */
	public $signInFormFactory;
    
    /**
	 * @var Page
	 */
    private $page;
    
	public function renderDefault(): void
    {
        $this->template->page = $this->page = $this->pageRepository->findOneBySlug('hlavni');
        $this->setView('signin');
    }
    
    public function renderHomepage(): void
    {
    	$this->setView('signin');
    }
    
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
                    
    				$this->redirect(':Admin:Dashboard:');
    			} catch (AuthenticationException $e) {
    				$this->flashMessage($e->getMessage(), 'error');
    			}
            }
            else
            {
                $this->flashMessage('Nemáte pøístupu k administrací', 'error');
            }
		};

		return $form;
	}
}