<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette\Application\Helpers;
use Nette\Application\UI\Presenter;
use App\Repository\OptionRepository;
use App\Utils\Configuration;

/**
 * Class AbstractPresenter
 */
abstract class AbstractPresenter extends Presenter
{
    /**
	 * @var OptionRepository @inject
	 */
	public $optionRepository;
        
    /**
	 * @var Configuration @inject
	 */
	public $configuration;
        
	/**
	 * Formats layout template file names.
	 */
	public function formatLayoutTemplateFiles(): array
	{
		if (preg_match('#/|\\\\#', (string) $this->layout)) {
			return [$this->layout];
		}
        
		[$module,] = Helpers::splitName($this->getName());
		$layout = $this->layout ? $this->layout : 'layout';
		$list = [
			__DIR__ . '/../../templates/' . $module . '/@' . $layout . '.latte',
			__DIR__ . '/../../templates/@' . $layout . '.latte'
		];
        
		return $list;
	}

	/**
	 * Formats view template file names.
	 */
	public function formatTemplateFiles(): array
	{
		[$module, $presenter] = Helpers::splitName($this->getName());
        
		return [
			__DIR__ . '/../../templates/' . $module . '/' . $presenter . '/' . $this->view . '.latte',
			__DIR__ . '/../../templates/' . $presenter . '/' . $this->view . '.latte'
		];
	}
    
    public function beforeRender(): void
	{
        parent::beforeRender();
	}
    
    /**
	 * @throws AbortException
	 */
	public function startup()
	{
		parent::startup();
        
        $this->template->admin_page = $this->configuration->getParameter('admin_page');
        $this->template->site_name = $this->configuration->getParameter('site_name');
        $this->template->site_logo = $this->configuration->getParameter('site_logo');
	}

    /**
     * @param int $page
     * @param int $s
     * @param string $db_key - klic jako pole v DB 
     */
    public function Paginator(int $page, string $s, $repository, string $db_key)
    {
        $paginator = new Paginator;
		$paginator->setItemCount( $repository->countRows($this->user, $s) ); // celkovı pocet clánku
		$paginator->setItemsPerPage( (int)$this->optionRepository->get($db_key) ); // pocet poloek na stránce
		$paginator->setPage($page); // císlo aktuální stránky
        
        return $paginator; 
    }
}