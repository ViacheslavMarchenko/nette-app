<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Presenters\AuthPresenter;
use App\Presenters\AbstractPresenter;
use Nette\Application\AbortException;

/**
 * Class AuthorizedPresenter
 */
abstract class AuthorizedPresenter extends AbstractPresenter
{
	/**
	 * @throws AbortException
	 */
	public function startup()
	{
		parent::startup();
        
		if (!$this->user->isLoggedIn()) {
			$this->redirect('Auth:');
		}
	}

	/**
	 * @throws AbortException
	 */
	public function handleLogout(): void
	{
		$this->user->logout(true);
		$this->redirect('Auth:');
	}
}