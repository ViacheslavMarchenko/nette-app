<?php

declare(strict_types=1);

namespace App\Presenters\Front;

use Nette;
use Nette\Http\IResponse;
use Nette\Security\AuthenticationException;
use DateTimeInterface;
use Nette\Utils\DateTime;
use App\Model\Url;
use App\Presenters\AbstractPresenter;
use App\Repository\PageRepository;

class SitemapPresenter extends AbstractPresenter
{
    /**
	 * @var PageRepository @inject
	 */
	public $pageRepository;
    
	/** 
     * @var IResponse @inject 
    */
	public $response;

	public function renderDefault()
	{
	    //echo $this->link('Homepage:default');
		$this->response->setContentType('text/xml');
		$this->template->urls = [
			new Url($this->link('Homepage:default'), new DateTime(), 'always', 1),
		];
        
        foreach ($this->pageRepository->findAll() as $page)
        {
            if (!empty($page->getSitemap()))
                $this->template->urls[] = new Url(("/" . $page->getSlug()), new DateTime(), 'always', 0.7);
        }
	}
    
    public function renderRobots()
    {
        $this->response->setContentType('text/txt');
    }
}