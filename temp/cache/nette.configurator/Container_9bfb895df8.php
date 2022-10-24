<?php
// source: /var/www/html/config/common.neon
// source: /var/www/html/config/services.neon
// source: /var/www/html/config/local.neon
// source: array

/** @noinspection PhpParamsInspection,PhpMethodMayBeStaticInspection */

declare(strict_types=1);

class Container_9bfb895df8 extends Nette\DI\Container
{
	protected $tags = [
		'nette.inject' => [
			'016' => true,
			'application.1' => true,
			'application.10' => true,
			'application.11' => true,
			'application.12' => true,
			'application.13' => true,
			'application.2' => true,
			'application.3' => true,
			'application.4' => true,
			'application.5' => true,
			'application.6' => true,
			'application.7' => true,
			'application.8' => true,
			'application.9' => true,
		],
	];

	protected $types = ['container' => 'Nette\DI\Container'];

	protected $aliases = [
		'application' => 'application.application',
		'cacheStorage' => 'cache.storage',
		'database.default' => 'database.default.connection',
		'httpRequest' => 'http.request',
		'httpResponse' => 'http.response',
		'nette.cacheJournal' => 'cache.journal',
		'nette.database.default' => 'database.default',
		'nette.database.default.context' => 'database.default.context',
		'nette.httpRequestFactory' => 'http.requestFactory',
		'nette.latteFactory' => 'latte.latteFactory',
		'nette.mailer' => 'mail.mailer',
		'nette.presenterFactory' => 'application.presenterFactory',
		'nette.templateFactory' => 'latte.templateFactory',
		'nette.userStorage' => 'security.userStorage',
		'session' => 'session.session',
		'user' => 'security.user',
	];

	protected $wiring = [
		'Nette\DI\Container' => [['container']],
		'Nette\Application\Application' => [['application.application']],
		'Nette\Application\IPresenterFactory' => [['application.presenterFactory']],
		'Nette\Application\LinkGenerator' => [['application.linkGenerator']],
		'Nette\Caching\Storages\Journal' => [['cache.journal']],
		'Nette\Caching\Storage' => [['cache.storage']],
		'Nette\Database\Connection' => [['database.default.connection']],
		'Nette\Database\IStructure' => [['database.default.structure']],
		'Nette\Database\Structure' => [['database.default.structure']],
		'Nette\Database\Conventions' => [['database.default.conventions']],
		'Nette\Database\Conventions\DiscoveredConventions' => [['database.default.conventions']],
		'Nette\Database\Explorer' => [['database.default.context']],
		'Nette\Http\RequestFactory' => [['http.requestFactory']],
		'Nette\Http\IRequest' => [['http.request']],
		'Nette\Http\Request' => [['http.request']],
		'Nette\Http\IResponse' => [['http.response']],
		'Nette\Http\Response' => [['http.response']],
		'Nette\Bridges\ApplicationLatte\LatteFactory' => [['latte.latteFactory']],
		'Nette\Application\UI\TemplateFactory' => [['latte.templateFactory']],
		'Nette\Bridges\ApplicationLatte\TemplateFactory' => [['latte.templateFactory']],
		'Nette\Mail\Mailer' => [['mail.mailer']],
		'Nette\Security\Passwords' => [['security.passwords']],
		'Nette\Security\UserStorage' => [['security.userStorage']],
		'Nette\Security\IUserStorage' => [['security.legacyUserStorage']],
		'Nette\Security\User' => [['security.user']],
		'Nette\Http\Session' => [['session.session']],
		'Tracy\ILogger' => [['tracy.logger']],
		'Tracy\BlueScreen' => [['tracy.blueScreen']],
		'Tracy\Bar' => [['tracy.bar']],
		'Nette\Security\IAuthenticator' => [['authenticator']],
		'App\User\Authenticator' => [['authenticator']],
		'Nette\Security\Authorizator' => [['authorizatorFactory']],
		'Nette\Security\Permission' => [['authorizatorFactory']],
		'App\Router\RouterFactory' => [['routerFactory']],
		'Nette\Routing\RouteList' => [['router']],
		'Nette\Routing\Router' => [['router']],
		'ArrayAccess' => [
			2 => [
				'router',
				'application.1',
				'application.2',
				'application.3',
				'application.4',
				'application.5',
				'application.6',
				'application.7',
				'application.9',
				'application.10',
				'application.11',
			],
		],
		'Countable' => [2 => ['router']],
		'IteratorAggregate' => [2 => ['router']],
		'Traversable' => [2 => ['router']],
		'Nette\Application\Routers\RouteList' => [['router']],
		'App\Repository\UploadRepository' => [['01']],
		'App\Repository\BasicRepository' => [['02', '03', '05', '06', '07']],
		'App\Repository\UserRepository' => [['02']],
		'App\Repository\RoleRepository' => [['03']],
		'App\Repository\OptionRepository' => [['04']],
		'App\Repository\LanguageRepository' => [['05']],
		'App\Repository\FavoriteRepository' => [['06']],
		'App\Repository\PageRepository' => [['07']],
		'App\Forms\SignInFormFactory' => [['08']],
		'App\Forms\ResetPassFormFactory' => [['09']],
		'App\Forms\Admin\UserFormFactory' => [['010']],
		'App\Forms\Admin\UploadFormFactory' => [['011']],
		'App\Forms\Admin\OptionFormFactory' => [['012']],
		'App\Forms\Admin\SearchFormFactory' => [['013']],
		'App\Forms\Admin\PageFormFactory' => [['014']],
		'App\Service\UploadService' => [['015']],
		'App\Mail\MailFactory' => [['016']],
		'App\Utils\Configuration' => [['017']],
		'App\Presenters\AbstractPresenter' => [
			2 => [
				'application.1',
				'application.2',
				'application.3',
				'application.4',
				'application.5',
				'application.6',
				'application.9',
				'application.10',
				'application.11',
			],
		],
		'Nette\Application\UI\Presenter' => [
			2 => [
				'application.1',
				'application.2',
				'application.3',
				'application.4',
				'application.5',
				'application.6',
				'application.7',
				'application.9',
				'application.10',
				'application.11',
			],
		],
		'Nette\Application\UI\Control' => [
			2 => [
				'application.1',
				'application.2',
				'application.3',
				'application.4',
				'application.5',
				'application.6',
				'application.7',
				'application.9',
				'application.10',
				'application.11',
			],
		],
		'Nette\Application\UI\Component' => [
			2 => [
				'application.1',
				'application.2',
				'application.3',
				'application.4',
				'application.5',
				'application.6',
				'application.7',
				'application.9',
				'application.10',
				'application.11',
			],
		],
		'Nette\ComponentModel\Container' => [
			2 => [
				'application.1',
				'application.2',
				'application.3',
				'application.4',
				'application.5',
				'application.6',
				'application.7',
				'application.9',
				'application.10',
				'application.11',
			],
		],
		'Nette\ComponentModel\Component' => [
			2 => [
				'application.1',
				'application.2',
				'application.3',
				'application.4',
				'application.5',
				'application.6',
				'application.7',
				'application.9',
				'application.10',
				'application.11',
			],
		],
		'Nette\ComponentModel\IComponent' => [
			2 => [
				'application.1',
				'application.2',
				'application.3',
				'application.4',
				'application.5',
				'application.6',
				'application.7',
				'application.9',
				'application.10',
				'application.11',
			],
		],
		'Nette\ComponentModel\IContainer' => [
			2 => [
				'application.1',
				'application.2',
				'application.3',
				'application.4',
				'application.5',
				'application.6',
				'application.7',
				'application.9',
				'application.10',
				'application.11',
			],
		],
		'Nette\Application\UI\SignalReceiver' => [
			2 => [
				'application.1',
				'application.2',
				'application.3',
				'application.4',
				'application.5',
				'application.6',
				'application.7',
				'application.9',
				'application.10',
				'application.11',
			],
		],
		'Nette\Application\UI\StatePersistent' => [
			2 => [
				'application.1',
				'application.2',
				'application.3',
				'application.4',
				'application.5',
				'application.6',
				'application.7',
				'application.9',
				'application.10',
				'application.11',
			],
		],
		'Nette\Application\UI\Renderable' => [
			2 => [
				'application.1',
				'application.2',
				'application.3',
				'application.4',
				'application.5',
				'application.6',
				'application.7',
				'application.9',
				'application.10',
				'application.11',
			],
		],
		'Nette\Application\IPresenter' => [
			2 => [
				'application.1',
				'application.2',
				'application.3',
				'application.4',
				'application.5',
				'application.6',
				'application.7',
				'application.8',
				'application.9',
				'application.10',
				'application.11',
				'application.12',
				'application.13',
			],
		],
		'App\Presenters\Admin\AuthPresenter' => [2 => ['application.1']],
		'App\Presenters\AuthorizedPresenter' => [
			2 => ['application.2', 'application.3', 'application.4', 'application.5', 'application.6'],
		],
		'App\Presenters\Admin\DashboardPresenter' => [2 => ['application.2']],
		'App\Presenters\Admin\OptionsPresenter' => [2 => ['application.3']],
		'App\Presenters\Admin\PagesPresenter' => [2 => ['application.4']],
		'App\Presenters\Admin\UploadsPresenter' => [2 => ['application.5']],
		'App\Presenters\Admin\UsersPresenter' => [2 => ['application.6']],
		'App\Presenters\Error4xxPresenter' => [2 => ['application.7']],
		'App\Presenters\ErrorPresenter' => [2 => ['application.8']],
		'App\Presenters\Front\HomepagePresenter' => [2 => ['application.9']],
		'App\Presenters\Front\PagePresenter' => [2 => ['application.10']],
		'App\Presenters\Front\SitemapPresenter' => [2 => ['application.11']],
		'NetteModule\ErrorPresenter' => [2 => ['application.12']],
		'NetteModule\MicroPresenter' => [2 => ['application.13']],
	];


	public function __construct(array $params = [])
	{
		parent::__construct($params);
		$this->parameters += [
			'admin_page' => 'signin',
			'site_name' => 'five',
			'site_logo' => null,
			'collapsed' => 1,
			'appDir' => '/var/www/html/app',
			'wwwDir' => '/var/www/html/www',
			'vendorDir' => '/var/www/html/vendor',
			'debugMode' => true,
			'productionMode' => false,
			'consoleMode' => false,
			'tempDir' => '/var/www/html/temp',
		];
	}


	public function createService01(): App\Repository\UploadRepository
	{
		return new App\Repository\UploadRepository($this->getService('database.default.context'), $this->getService('015'));
	}


	public function createService02(): App\Repository\UserRepository
	{
		return new App\Repository\UserRepository($this->getService('database.default.context'));
	}


	public function createService03(): App\Repository\RoleRepository
	{
		return new App\Repository\RoleRepository($this->getService('database.default.context'));
	}


	public function createService04(): App\Repository\OptionRepository
	{
		return new App\Repository\OptionRepository($this->getService('database.default.context'));
	}


	public function createService05(): App\Repository\LanguageRepository
	{
		return new App\Repository\LanguageRepository($this->getService('database.default.context'));
	}


	public function createService06(): App\Repository\FavoriteRepository
	{
		return new App\Repository\FavoriteRepository($this->getService('database.default.context'));
	}


	public function createService07(): App\Repository\PageRepository
	{
		return new App\Repository\PageRepository($this->getService('database.default.context'), $this->getService('session'));
	}


	public function createService08(): App\Forms\SignInFormFactory
	{
		return new App\Forms\SignInFormFactory;
	}


	public function createService09(): App\Forms\ResetPassFormFactory
	{
		return new App\Forms\ResetPassFormFactory;
	}


	public function createService010(): App\Forms\Admin\UserFormFactory
	{
		return new App\Forms\Admin\UserFormFactory;
	}


	public function createService011(): App\Forms\Admin\UploadFormFactory
	{
		return new App\Forms\Admin\UploadFormFactory;
	}


	public function createService012(): App\Forms\Admin\OptionFormFactory
	{
		return new App\Forms\Admin\OptionFormFactory;
	}


	public function createService013(): App\Forms\Admin\SearchFormFactory
	{
		return new App\Forms\Admin\SearchFormFactory;
	}


	public function createService014(): App\Forms\Admin\PageFormFactory
	{
		return new App\Forms\Admin\PageFormFactory;
	}


	public function createService015(): App\Service\UploadService
	{
		return new App\Service\UploadService;
	}


	public function createService016(): App\Mail\MailFactory
	{
		return new App\Mail\MailFactory;
	}


	public function createService017(): App\Utils\Configuration
	{
		return new App\Utils\Configuration([
			'admin_page' => 'signin',
			'site_name' => 'five',
			'site_logo' => null,
			'collapsed' => 1,
			'appDir' => '/var/www/html/app',
			'wwwDir' => '/var/www/html/www',
			'vendorDir' => '/var/www/html/vendor',
			'debugMode' => true,
			'productionMode' => false,
			'consoleMode' => false,
			'tempDir' => '/var/www/html/temp',
		]);
	}


	public function createServiceApplication__1(): App\Presenters\Admin\AuthPresenter
	{
		$service = new App\Presenters\Admin\AuthPresenter;
		$service->injectPrimary(
			$this,
			$this->getService('application.presenterFactory'),
			$this->getService('router'),
			$this->getService('http.request'),
			$this->getService('http.response'),
			$this->getService('session.session'),
			$this->getService('security.user'),
			$this->getService('latte.templateFactory')
		);
		$service->userRepository = $this->getService('02');
		$service->signInFormFactory = $this->getService('08');
		$service->resetPassFormFactory = $this->getService('09');
		$service->optionRepository = $this->getService('04');
		$service->mailFactory = $this->getService('016');
		$service->configuration = $this->getService('017');
		$service->invalidLinkMode = 5;
		return $service;
	}


	public function createServiceApplication__10(): App\Presenters\Front\PagePresenter
	{
		$service = new App\Presenters\Front\PagePresenter;
		$service->injectPrimary(
			$this,
			$this->getService('application.presenterFactory'),
			$this->getService('router'),
			$this->getService('http.request'),
			$this->getService('http.response'),
			$this->getService('session.session'),
			$this->getService('security.user'),
			$this->getService('latte.templateFactory')
		);
		$service->pageRepository = $this->getService('07');
		$service->optionRepository = $this->getService('04');
		$service->mailFactory = $this->getService('016');
		$service->configuration = $this->getService('017');
		$service->invalidLinkMode = 5;
		return $service;
	}


	public function createServiceApplication__11(): App\Presenters\Front\SitemapPresenter
	{
		$service = new App\Presenters\Front\SitemapPresenter;
		$service->injectPrimary(
			$this,
			$this->getService('application.presenterFactory'),
			$this->getService('router'),
			$this->getService('http.request'),
			$this->getService('http.response'),
			$this->getService('session.session'),
			$this->getService('security.user'),
			$this->getService('latte.templateFactory')
		);
		$service->response = $this->getService('http.response');
		$service->pageRepository = $this->getService('07');
		$service->optionRepository = $this->getService('04');
		$service->configuration = $this->getService('017');
		$service->invalidLinkMode = 5;
		return $service;
	}


	public function createServiceApplication__12(): NetteModule\ErrorPresenter
	{
		return new NetteModule\ErrorPresenter($this->getService('tracy.logger'));
	}


	public function createServiceApplication__13(): NetteModule\MicroPresenter
	{
		return new NetteModule\MicroPresenter($this, $this->getService('http.request'), $this->getService('router'));
	}


	public function createServiceApplication__2(): App\Presenters\Admin\DashboardPresenter
	{
		$service = new App\Presenters\Admin\DashboardPresenter;
		$service->injectPrimary(
			$this,
			$this->getService('application.presenterFactory'),
			$this->getService('router'),
			$this->getService('http.request'),
			$this->getService('http.response'),
			$this->getService('session.session'),
			$this->getService('security.user'),
			$this->getService('latte.templateFactory')
		);
		$service->searchFormFactory = $this->getService('013');
		$service->optionRepository = $this->getService('04');
		$service->configuration = $this->getService('017');
		$service->invalidLinkMode = 5;
		return $service;
	}


	public function createServiceApplication__3(): App\Presenters\Admin\OptionsPresenter
	{
		$service = new App\Presenters\Admin\OptionsPresenter;
		$service->injectPrimary(
			$this,
			$this->getService('application.presenterFactory'),
			$this->getService('router'),
			$this->getService('http.request'),
			$this->getService('http.response'),
			$this->getService('session.session'),
			$this->getService('security.user'),
			$this->getService('latte.templateFactory')
		);
		$service->searchFormFactory = $this->getService('013');
		$service->optionRepository = $this->getService('04');
		$service->optionFormFactory = $this->getService('012');
		$service->configuration = $this->getService('017');
		$service->invalidLinkMode = 5;
		return $service;
	}


	public function createServiceApplication__4(): App\Presenters\Admin\PagesPresenter
	{
		$service = new App\Presenters\Admin\PagesPresenter;
		$service->injectPrimary(
			$this,
			$this->getService('application.presenterFactory'),
			$this->getService('router'),
			$this->getService('http.request'),
			$this->getService('http.response'),
			$this->getService('session.session'),
			$this->getService('security.user'),
			$this->getService('latte.templateFactory')
		);
		$service->uploadRepository = $this->getService('01');
		$service->searchFormFactory = $this->getService('013');
		$service->pageRepository = $this->getService('07');
		$service->pageFormFactory = $this->getService('014');
		$service->optionRepository = $this->getService('04');
		$service->configuration = $this->getService('017');
		$service->invalidLinkMode = 5;
		return $service;
	}


	public function createServiceApplication__5(): App\Presenters\Admin\UploadsPresenter
	{
		$service = new App\Presenters\Admin\UploadsPresenter;
		$service->injectPrimary(
			$this,
			$this->getService('application.presenterFactory'),
			$this->getService('router'),
			$this->getService('http.request'),
			$this->getService('http.response'),
			$this->getService('session.session'),
			$this->getService('security.user'),
			$this->getService('latte.templateFactory')
		);
		$service->uploadRepository = $this->getService('01');
		$service->uploadFormFactory = $this->getService('011');
		$service->searchFormFactory = $this->getService('013');
		$service->optionRepository = $this->getService('04');
		$service->configuration = $this->getService('017');
		$service->invalidLinkMode = 5;
		return $service;
	}


	public function createServiceApplication__6(): App\Presenters\Admin\UsersPresenter
	{
		$service = new App\Presenters\Admin\UsersPresenter;
		$service->injectPrimary(
			$this,
			$this->getService('application.presenterFactory'),
			$this->getService('router'),
			$this->getService('http.request'),
			$this->getService('http.response'),
			$this->getService('session.session'),
			$this->getService('security.user'),
			$this->getService('latte.templateFactory')
		);
		$service->userRepository = $this->getService('02');
		$service->userFormFactory = $this->getService('010');
		$service->searchFormFactory = $this->getService('013');
		$service->roleRepository = $this->getService('03');
		$service->optionRepository = $this->getService('04');
		$service->mailFactory = $this->getService('016');
		$service->configuration = $this->getService('017');
		$service->invalidLinkMode = 5;
		return $service;
	}


	public function createServiceApplication__7(): App\Presenters\Error4xxPresenter
	{
		$service = new App\Presenters\Error4xxPresenter;
		$service->injectPrimary(
			$this,
			$this->getService('application.presenterFactory'),
			$this->getService('router'),
			$this->getService('http.request'),
			$this->getService('http.response'),
			$this->getService('session.session'),
			$this->getService('security.user'),
			$this->getService('latte.templateFactory')
		);
		$service->invalidLinkMode = 5;
		return $service;
	}


	public function createServiceApplication__8(): App\Presenters\ErrorPresenter
	{
		return new App\Presenters\ErrorPresenter($this->getService('tracy.logger'));
	}


	public function createServiceApplication__9(): App\Presenters\Front\HomepagePresenter
	{
		$service = new App\Presenters\Front\HomepagePresenter;
		$service->injectPrimary(
			$this,
			$this->getService('application.presenterFactory'),
			$this->getService('router'),
			$this->getService('http.request'),
			$this->getService('http.response'),
			$this->getService('session.session'),
			$this->getService('security.user'),
			$this->getService('latte.templateFactory')
		);
		$service->uploadRepository = $this->getService('01');
		$service->signInFormFactory = $this->getService('08');
		$service->pageRepository = $this->getService('07');
		$service->optionRepository = $this->getService('04');
		$service->mailFactory = $this->getService('016');
		$service->configuration = $this->getService('017');
		$service->invalidLinkMode = 5;
		return $service;
	}


	public function createServiceApplication__application(): Nette\Application\Application
	{
		$service = new Nette\Application\Application(
			$this->getService('application.presenterFactory'),
			$this->getService('router'),
			$this->getService('http.request'),
			$this->getService('http.response')
		);
		$service->catchExceptions = null;
		$service->errorPresenter = 'Error';
		Nette\Bridges\ApplicationDI\ApplicationExtension::initializeBlueScreenPanel(
			$this->getService('tracy.blueScreen'),
			$service
		);
		$this->getService('tracy.bar')->addPanel(new Nette\Bridges\ApplicationTracy\RoutingPanel(
			$this->getService('router'),
			$this->getService('http.request'),
			$this->getService('application.presenterFactory')
		));
		return $service;
	}


	public function createServiceApplication__linkGenerator(): Nette\Application\LinkGenerator
	{
		return new Nette\Application\LinkGenerator(
			$this->getService('router'),
			$this->getService('http.request')->getUrl()->withoutUserInfo(),
			$this->getService('application.presenterFactory')
		);
	}


	public function createServiceApplication__presenterFactory(): Nette\Application\IPresenterFactory
	{
		$service = new Nette\Application\PresenterFactory(new Nette\Bridges\ApplicationDI\PresenterFactoryCallback($this, 5, '/var/www/html/temp/cache/nette.application/touch'));
		$service->setMapping(['*' => 'App\Presenters\*\*Presenter']);
		return $service;
	}


	public function createServiceAuthenticator(): App\User\Authenticator
	{
		return new App\User\Authenticator($this->getService('02'), $this->getService('security.passwords'));
	}


	public function createServiceAuthorizatorFactory(): Nette\Security\Permission
	{
		return App\User\AuthorizationFactory::create();
	}


	public function createServiceCache__journal(): Nette\Caching\Storages\Journal
	{
		return new Nette\Caching\Storages\SQLiteJournal('/var/www/html/temp/cache/journal.s3db');
	}


	public function createServiceCache__storage(): Nette\Caching\Storage
	{
		return new Nette\Caching\Storages\FileStorage('/var/www/html/temp/cache', $this->getService('cache.journal'));
	}


	public function createServiceContainer(): Container_9bfb895df8
	{
		return $this;
	}


	public function createServiceDatabase__default__connection(): Nette\Database\Connection
	{
		$service = new Nette\Database\Connection('mysql:host=mysql;dbname=nubium', 'via', 'via', []);
		Nette\Database\Helpers::initializeTracy(
			$service,
			true,
			'default',
			true,
			$this->getService('tracy.bar'),
			$this->getService('tracy.blueScreen')
		);
		return $service;
	}


	public function createServiceDatabase__default__context(): Nette\Database\Explorer
	{
		return new Nette\Database\Explorer(
			$this->getService('database.default.connection'),
			$this->getService('database.default.structure'),
			$this->getService('database.default.conventions'),
			$this->getService('cache.storage')
		);
	}


	public function createServiceDatabase__default__conventions(): Nette\Database\Conventions\DiscoveredConventions
	{
		return new Nette\Database\Conventions\DiscoveredConventions($this->getService('database.default.structure'));
	}


	public function createServiceDatabase__default__structure(): Nette\Database\Structure
	{
		return new Nette\Database\Structure($this->getService('database.default.connection'), $this->getService('cache.storage'));
	}


	public function createServiceHttp__request(): Nette\Http\Request
	{
		return $this->getService('http.requestFactory')->fromGlobals();
	}


	public function createServiceHttp__requestFactory(): Nette\Http\RequestFactory
	{
		$service = new Nette\Http\RequestFactory;
		$service->setProxy([]);
		return $service;
	}


	public function createServiceHttp__response(): Nette\Http\Response
	{
		$service = new Nette\Http\Response;
		$service->cookieSecure = $this->getService('http.request')->isSecured();
		return $service;
	}


	public function createServiceLatte__latteFactory(): Nette\Bridges\ApplicationLatte\LatteFactory
	{
		return new class ($this) implements Nette\Bridges\ApplicationLatte\LatteFactory {
			private $container;


			public function __construct(Container_9bfb895df8 $container)
			{
				$this->container = $container;
			}


			public function create(): Latte\Engine
			{
				$service = new Latte\Engine;
				$service->setTempDirectory('/var/www/html/temp/cache/latte');
				$service->setAutoRefresh(true);
				$service->setContentType('html');
				Nette\Utils\Html::$xhtml = false;
				return $service;
			}
		};
	}


	public function createServiceLatte__templateFactory(): Nette\Bridges\ApplicationLatte\TemplateFactory
	{
		$service = new Nette\Bridges\ApplicationLatte\TemplateFactory(
			$this->getService('latte.latteFactory'),
			$this->getService('http.request'),
			$this->getService('security.user'),
			$this->getService('cache.storage'),
			null
		);
		Nette\Bridges\ApplicationDI\LatteExtension::initLattePanel($service, $this->getService('tracy.bar'), false);
		return $service;
	}


	public function createServiceMail__mailer(): Nette\Mail\Mailer
	{
		return new Nette\Mail\SendmailMailer;
	}


	public function createServiceRouter(): Nette\Application\Routers\RouteList
	{
		return $this->getService('routerFactory')->create([
			'admin_page' => 'signin',
			'site_name' => 'five',
			'site_logo' => null,
			'collapsed' => 1,
			'appDir' => '/var/www/html/app',
			'wwwDir' => '/var/www/html/www',
			'vendorDir' => '/var/www/html/vendor',
			'debugMode' => true,
			'productionMode' => false,
			'consoleMode' => false,
			'tempDir' => '/var/www/html/temp',
		]);
	}


	public function createServiceRouterFactory(): App\Router\RouterFactory
	{
		return new App\Router\RouterFactory($this->getService('database.default.context'), $this->getService('session'));
	}


	public function createServiceSecurity__legacyUserStorage(): Nette\Security\IUserStorage
	{
		return new Nette\Http\UserStorage($this->getService('session.session'));
	}


	public function createServiceSecurity__passwords(): Nette\Security\Passwords
	{
		return new Nette\Security\Passwords;
	}


	public function createServiceSecurity__user(): Nette\Security\User
	{
		$service = new Nette\Security\User(
			$this->getService('security.legacyUserStorage'),
			$this->getService('authenticator'),
			$this->getService('authorizatorFactory'),
			$this->getService('security.userStorage')
		);
		$this->getService('tracy.bar')->addPanel(new Nette\Bridges\SecurityTracy\UserPanel($service));
		return $service;
	}


	public function createServiceSecurity__userStorage(): Nette\Security\UserStorage
	{
		return new Nette\Bridges\SecurityHttp\SessionStorage($this->getService('session.session'));
	}


	public function createServiceSession__session(): Nette\Http\Session
	{
		$service = new Nette\Http\Session($this->getService('http.request'), $this->getService('http.response'));
		$service->setExpiration('14 days');
		$service->setOptions(['readAndClose' => null, 'cookieSamesite' => 'Lax']);
		return $service;
	}


	public function createServiceTracy__bar(): Tracy\Bar
	{
		return Tracy\Debugger::getBar();
	}


	public function createServiceTracy__blueScreen(): Tracy\BlueScreen
	{
		return Tracy\Debugger::getBlueScreen();
	}


	public function createServiceTracy__logger(): Tracy\ILogger
	{
		return Tracy\Debugger::getLogger();
	}


	public function initialize()
	{
		// di.
		(function () {
			$this->getService('tracy.bar')->addPanel(new Nette\Bridges\DITracy\ContainerPanel($this));
		})();
		// http.
		(function () {
			$response = $this->getService('http.response');
			$response->setHeader('X-Powered-By', 'Nette Framework 3');
			$response->setHeader('Content-Type', 'text/html; charset=utf-8');
			$response->setHeader('X-Frame-Options', 'SAMEORIGIN');
			Nette\Http\Helpers::initCookie($this->getService('http.request'), $response);
		})();
		// session.
		(function () {
			$this->getService('session.session')->autoStart(false);
		})();
		// tracy.
		(function () {
			if (!Tracy\Debugger::isEnabled()) { return; }
			Tracy\Debugger::getLogger()->mailer = [
				new Tracy\Bridges\Nette\MailSender($this->getService('mail.mailer'), null),
				'send',
			];
		})();
	}
}
