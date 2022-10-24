<?php

declare(strict_types=1);

namespace App\Presenters\Front;

use Nette\Application\UI\Form;
use Nette\Application\AbortException;
use Nette\Utils\ArrayHash;
use Nette\Security\AuthenticationException;
use App\Presenters\AbstractPresenter;
use App\Repository\UserRepository;
use App\Mail\MailFactory;

/**
 * Class BasicPresenter
 */
trait BasicPresenter
{
    /**
	 * @var MailFactory @inject
	 */
	public $mailFactory;
    
    public $slug;
    
	/**
	 * @throws AbortException
	 */
	public function handleLogout(): void
	{
		$this->user->logout(true);
        $this->redirect('Homepage:');
	}
    
    public function getIP()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            return $_SERVER['REMOTE_ADDR'];
        }
    }
}