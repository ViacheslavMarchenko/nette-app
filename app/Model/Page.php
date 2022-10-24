<?php

declare(strict_types=1);

namespace App\Model;

use Nette;
use App\Model\AbstractModel;
use App\Model\Upload;
use App\Model\User;
use App\Model\Favorite;
use Nette\SmartObject;
use Nette\Database\Context;
use Nette\Database\Row;
use Nette\Database\Table\IRow;
use DateTimeInterface;
use Nette\Utils\DateTime;
use App\Repository\UploadRepository;
use App\Repository\UserRepository;
use App\Repository\FavoriteRepository;

final class Page
{	
    /**
     * @var Contect
     */
    protected $context; 
    
    /**
	 * @var int
	 */
	protected $id;

    /**
	 * @var string
	 */
	protected $title;

	/**
	 * @var int
	 */
	protected $menu_order;
    
    /**
	 * @var string
	 */
	protected $slug;
    
    /**
     * @var string
     */
    protected $excerpt;
    
    /**
     * @var $content
     */
    protected $content;
    
    /**
	 * @var int
	 */
	protected $feature_image;
    
    /**
     * @var bool
     */
    protected $previewImagDefault = false;
    
    /**
     * @var string
	 */
	protected $gallery;
    
    /**
	 * @var string
	 */
	protected $type; 
    
    /**
     * @var int
     */
    protected $sitemap; 
    
    /**
	 * @var int
	 */
	protected $activeinactive;
    
	/**
	 * @var DateTimeInterface
	 */
	protected $modifydate;
        
	/**
	 * @var IRow
	 */
	private $row;
    
    /**
	 * @var UploadRepository @inject
	 */
	public $uploadRepository;
    
    /**
	 * @var UserRepository @inject
	 */
	public $userRepository;
    
    /**
	 * @var FavoriteRepository @inject
	 */
	public $favoriteRepository;
    
	/**
	 * @param IRow $row
	 * @return self
	 */
	public function setRow($row): self
	{
		$this->row = $row;
		return $this;
	}
    
    /**
     * @param Context $context
     * @return self
     */
    public function setContext(Context $context): self
    {
        $this->context = $context;
		return $this;
    }
    
    /**
     * @param UploadRepository $uploadRepository
     * @return self
     */
    public function setUploadRepository(UploadRepository $uploadRepository): self
    {
        $this->uploadRepository = $uploadRepository;
		return $this;
    }
    
    /**
     * @param UserRepository $userRepository
     * @return self
     */
    public function setUserRepository(UserRepository $userRepository): self
    {
        $this->userRepository = $userRepository;
		return $this;
    }
    
    /**
     * @param FavoriteRepository $favoriteRepository
     * @return self
     */
    public function setFavoriteRepository(FavoriteRepository $favoriteRepository): self
    {
        $this->favoriteRepository = $favoriteRepository;
		return $this;
    }
    
	/**
	 * @param int $id
	 * @return self
	 */
	public function setId(int $id): self
	{
		$this->id = $id;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getId(): int
	{
		return $this->id;
	}

	/**
	 * @param string $title
	 * @return self
	 */
	public function setTitle(string $title): self
	{
		$this->title = $title;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getTitle(): string
	{
		return $this->title;
	}

	/**
	 * @return string
	 */
	public function getSlug(): string
	{
		return $this->slug;
	}

	/**
	 * @param string $slug
	 * @return Post
	 */
	public function setSlug(string $slug): self
	{
		$this->slug = $slug;
		return $this;
	}
    
    /**
	 * @return string
	 */
	public function getExcerpt(): string
	{
		return $this->excerpt ?? "";
	}

	/**
	 * @param string $excerpt
	 * @return Post
	 */
	public function setExcerpt(?string $excerpt): self
	{
		$this->excerpt = $excerpt;
		return $this;
	}
    
    /**
	 * @return string
	 */
	public function getContent(): string
	{
		return $this->content;
	}

	/**
	 * @param string $content
	 * @return Post
	 */
	public function setContent(string $content): self
	{
		$this->content = $content;
		return $this;
	}
    
    /**
	 * @return int
	 */
	public function getFeatureImage(): int
	{
		return $this->feature_image;
	}

	/**
	 * @param int $feature_image
	 * @return self
	 */
	public function setFeatureImage(int $feature_image): self
	{
		$this->feature_image = $feature_image;
		return $this;
	}
    
    /**
	 * @return string
	 */
	public function FeatureImage($size = 'thumb'): string
	{
        $row = $this->context->table('uploads')->where('id = ?', $this->feature_image)
			->fetch();
        
        if (!$row) 
        {
            $this->previewImagDefault = true;
            
            return "/uploads/2022/5/8870-default.png";
        }
           
        $upload = Upload::createFromRow($row);
        
        return $upload->getUrl($size);
	}
    
    /**
	 * @return bool
	 */
    public function isPreviewImagDefault(): bool
    {
        return $this->previewImagDefault;
    }
    
	/**
	 * @param int $orderMenu
	 * @return self
	 */
	public function setOrderMenu(int $orderMenu): self
	{
		$this->menu_order = $orderMenu;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getOrderMenu(): int
	{
		return $this->menu_order;
	}
    
    public function isFavorite($user): bool
    {
        return $this->favoriteRepository->existsFavorite($this, $user);
    }
    
    /**
	 * @param string $type
	 * @return self
	 */
	public function setType(string $type): self
	{
		$this->type = $type;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getType(): string
	{
	    return $this->type;
	}
    
    /**
	 * @param int $activeinactive
	 * @return self
	 */
	public function setActiveInactive(int $activeinactive): self
	{
		$this->activeinactive = $activeinactive;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getActiveInactive(): int
	{
		return $this->activeinactive;
	}
    
    /**
	 * @param int $sitemap
	 * @return self
	 */
	public function setSitemap(int $sitemap): self
    {
        $this->sitemap = $sitemap;
        return $this;
    }

	/**
	 * @return int
	 */
	public function getSitemap(): int
	{
		return $this->sitemap;
	}
    
    /**
	 * @param DateTimeInterface $modifydate
	 * @return self
	 */
	public function setModifydate(DateTimeInterface $modifydate): self
	{
		$this->modifydate = $modifydate;
		return $this;
	}

	/**
	 * @return DateTimeInterface
	 */
	public function getModifydate(): DateTimeInterface
	{
		return $this->modifydate;
	}
    
    /**
	 * @return string
	 */
	public function getDate(): string
	{
		return date_format($this->getModifydate(), "d. m. Y");
	}

	/**
	 * @return array
	 */
	public function toArray(): array
	{
		return [
			'title' => $this->getTitle(),
            'slug' => $this->getSlug(),
            'excerpt' => $this->getExcerpt(),
            'content' => $this->getContent(),
            'feature_image' => $this->getFeatureImage(),
            'type' => $this->getType(),
            'sitemap' => $this->getSitemap(),
            'activeinactive' => $this->getActiveInactive(),
		];
	}
    
	/**
	 * @param IRow $row
	 * @return Page
	 */
	public static function createFromRow(
        $row, 
        Context $context, 
        UserRepository $userRepository, 
        FavoriteRepository $favoriteRepository,
        UploadRepository $uploadRepository): self
	{
	    $entity = new self;
		$entity->setId($row->offsetGet('id'))
			->setRow($row)
            ->setContext($context)
            ->setUploadRepository($uploadRepository)
            ->setFavoriteRepository($favoriteRepository)
            ->setUserRepository($userRepository)
            ->setTitle($row->offsetGet('title'))
            ->setExcerpt($row->offsetGet('excerpt'))
            ->setContent($row->offsetGet('content'))
            ->setFeatureImage($row->offsetGet('feature_image'))
            ->setSlug($row->offsetGet('slug'))
            ->setSitemap($row->offsetGet('sitemap'))
            ->setType($row->offsetGet('type'))
            ->setOrderMenu($row->offsetGet('menu_order'))
            ->setActiveInactive($row->offsetGet('activeinactive'))
            ->setModifydate(DateTime::from($row->offsetGet('modifydate')));
        
		return $entity;
	}
}
