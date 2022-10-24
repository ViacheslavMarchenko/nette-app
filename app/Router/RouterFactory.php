<?php

declare(strict_types=1);

namespace App\Router;
 
use Nette;
use Nette\Application\Routers\RouteList;
use Nette\Database\Context;
use Nette\Routing\Route;
use Nette\Http\Session;
use Nette\Http\SessionSection;
use App\Utils\Configuration;
use App\Repository\PageRepository;

final class RouterFactory
{
	use Nette\StaticClass;
    
    /**
	 * @var PageRepository @inject
	 */
	public $pageRepository;
        
    private $context;
    
    public function __construct(\Nette\Database\Context $context, Session $session)
	{
        $this->context= $context;
        $this->pageRepository = new PageRepository($context, $session);
	}

	public function create(array $params): RouteList
	{
		$router = new RouteList;
        $configuration = new Configuration($params);
        
        $router->addRoute('', [
			'module' => 'Front',
			'presenter' => 'Homepage',
			'action' => 'default'
		]);
        
        $router->addRoute('admin[/<presenter>][/<action>][/<id>]', [
			'module' => 'Admin',
			'presenter' => 'Dashboard',
			'action' => 'default'
		]);
        
        $router->addRoute('sitemap.xml', [
            'module' => 'Front',
			'presenter' => 'Sitemap',
			'action' => 'default'
        ]);
        
        $router->addRoute('robots.txt', [
            'module' => 'Front',
			'presenter' => 'Sitemap',
			'action' => 'robots'
        ]);
        
        foreach($this->pageRepository->findAll() as $page)
        {
            $action = str_replace("-", "", $page->getSlug());
            
            if (!file_exists(__DIR__ . '/../templates/Front/Page/' . $action . '.latte')) 
            {
                $action = "default";
            }
            
            $router->addRoute($page->getSlug(), [
                'module' => 'Front',
    			'presenter' => 'Page',
    			'action' => $action,
                'slug' => $page->getSlug()
    		]); 
        }
        
        return $router;
	}
}
