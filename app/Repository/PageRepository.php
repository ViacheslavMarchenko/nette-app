<?php

declare(strict_types=1);

namespace App\Repository;

use Exception;
use Nette\Application\BadRequestException;
use Nette\InvalidArgumentException;
use Nette\Database\Context;
use Nette\Database\Table\IRow;
use Nette\InvalidStateException;
use Nette\Utils\ArrayHash;
use Nette\Utils\Strings;
use Nette\Utils\FileSystem;
use Nette\Http\Session;
use Nette\Http\SessionSection;
use Tracy\Debugger;
use Tracy\Logger;
use App\Repository\RecordNotFoundException;
use App\Model\Page;
use App\Repository\FavoriteRepository;
use App\Repository\UploadRepository;
use App\Repository\UserRepository;

/**
 * Class PageRepository
 */
class PageRepository extends BasicRepository
{
	/**
	 * @var string
	 */
	private const TABLE_NAME = 'pages';
    
    /**
	 * @var UserRepository @inject
	 */
	public $userRepository;
    
    /**
	 * @var UploadRepository @inject
	 */
	public $uploadRepository;

    /**
	 * @var FavoriteRepository @inject
	 */
	public $favoriteRepository;

	/**
	 * @var Context
	 */
	public $context;
    
    /**
	 * @var int
	 */
    public $user_id;
    
	/**
	 * PageRepository constructor.
	 * @param Context $context
	 */
	public function __construct(Context $context, Session $session)
	{
		$this->context = $context;
        $this->uploadRepository = new UploadRepository($context, NULL);
        $this->userRepository = new UserRepository($context);
        $this->favoriteRepository = new FavoriteRepository($context);
        
        $section = $session->getSection('param');
        $this->user_id = (int)$section->get("user");
        
        //print_r($session->getSection("param")->user);
	}

    /**
	 * @return Page[]
     * @param $favorite int -1 | 0 | 1
	 */
	public function findAll($limit = 100, $offset = 0, $s = "", $favorite = -1): array
	{
	    $where_favorite = "1";
        if ($favorite != -1) {
            $where_favorite = ($favorite == 1 
                ? " id = (SELECT post_id FROM favorites WHERE post_id = pages.id AND author = " . $this->user_id . ")" 
                : " id NOT IN (SELECT post_id FROM favorites WHERE author = " . $this->user_id . ")");    
        }
        
        $rows = $this->context->table(self::TABLE_NAME)
            ->where("type = ? AND title LIKE ? AND $where_favorite", 'page', "%$s%")
            ->order("menu_order ASC")
            ->limit($limit, $offset)
			->fetchAll();
                      
		return $this->mapCollection($rows);
	}
    	
    /**
	 * @param int $id
	 * @throws RecordNotFoundException
	 * @return Page
	 */
    public function findOneById(int $id): Page
	{
		$row = $this->context->table(self::TABLE_NAME)
			->where('id = ? AND type = ?', $id, 'page')
			->fetch();

		if (!$row) {
			throw new RecordNotFoundException(
				sprintf('No record found with ID "%d".', $id)
			);
		}
		return $this->mapEntity($row);
	}
    	
    /**
	 * @param string $slug
	 * @throws RecordNotFoundException
	 * @return Page
	 */
    public function findOneBySlug(string $slug): Page
	{
		$row = $this->context->table(self::TABLE_NAME)
			->where('slug = ? AND type = ?', $slug, 'page')
			->fetch();

		if (!$row) {
			throw new RecordNotFoundException(
				sprintf('No record found with ID "%s".', $slug)
			);
		}
        
		return $this->mapEntity($row);
	}
    
    /**
	 * @return int
	 */
	public function countRows(): int
	{
		return $this->context->table(self::TABLE_NAME)
			->count('*');
	}
    
    /**
	 * @param int $id
	 * @throws RecordNotFoundException
	 */
	public function decreaseOrderNumberById(int $id): void
	{
		$entity = $this->findOneById($id);

		$this->context->beginTransaction();

		$row = $this->context->table(self::TABLE_NAME)
			->where('menu_order = ?', $entity->getOrderMenu() - 1)
			->fetch();
		if (!$row) {
			throw new InvalidStateException('There is no record to replace order number with.');
		}
		$this->context->table(self::TABLE_NAME)
			->where('id = ?', $row['id'])
			->update([
				'menu_order' => ($row['menu_order'] + 1)
			]);

		$this->context->table(self::TABLE_NAME)
			->where('id = ?', $entity->getId())
			->update([
				'menu_order' => $entity->getOrderMenu() - 1
			]);

		$this->context->commit();
	}

	/**
	 * @param int $id
	 * @throws RecordNotFoundException
	 */
	public function increaseOrderNumberById(int $id): void
	{
		$entity = $this->findOneById($id);

		$this->context->beginTransaction();

		$row = $this->context->table(self::TABLE_NAME)
			->where('menu_order = ?', $entity->getOrderMenu() + 1)
			->fetch();
		if (!$row) {
			throw new InvalidStateException('There is no record to replace order number with.');
		}
		$this->context->table(self::TABLE_NAME)
			->where('id = ?', $row['id'])
				->update([
				'menu_order' => ($row['menu_order'] - 1)
			]);

		$this->context->table(self::TABLE_NAME)
			->where('id = ?', $entity->getId())
			->update([
				'menu_order' => $entity->getOrderMenu() + 1
			]);

		$this->context->commit();
	}

	/**
	 * @param Page $page
	 */
	public function remove(Page $page): void
	{
            $this->context->table(self::TABLE_NAME)
    			->where('id = ?', $page->getId())
    			->delete();
	}
    
    /**
	 * @param ArrayHash $values
	 * @return Page
	 */
	public function create(ArrayHash $values)
	{
	    $slug = (empty(trim($values['slug'])) ? (Strings::webalize($values['title'])) : $values['slug']);
        $title = $values['title'];
        
        $row = $this->context->table(self::TABLE_NAME)
			->where('title = ? AND slug = ?', $title, $slug)
			->fetch();
        
        if ($row) {
            $values['slug'] = $slug . "_1"; 
			return $this->create($values);
		}
        
	    $insert = array(
            'title'         => $title,
            'slug'          => $slug,
            'content'       => $values['content'],
            'sitemap'       => property_exists($values, 'sitemap') ? $values['sitemap'] : 1,
            'type'          => 'page',
            'feature_image' => $values['feature_image'],
            'activeinactive' => $values['activeinactive'],
            'menu_order'    => $this->getLastOrderNumber($this->context, self::TABLE_NAME) + 1
        );
        
        $row = $this->context->table(self::TABLE_NAME)
			->insert($insert);

		return $this->mapEntity($row);
	}
    
    /**
	 * @param Page $page
	 * @param ArrayHash $values
	 */
	public function update(Page $page, ArrayHash $values): bool
	{
	    $id = $page->getId();
        
        $slug = (empty(trim($values['slug'])) ? (Strings::webalize($values['title'])) : $values['slug']);
        $title = $values['title'];
        
        $row = $this->context->table(self::TABLE_NAME)
			->where('title = ? AND slug = ? AND id != ?', $title, $slug, $id)
			->fetch();

		if ($row) {
            $values['slug'] .= "_1"; 
			return $this->update($page, $values);
		}
            
        $update = array(
            'title'         => $title,
            'slug'          => $slug,
            'content'       => $values['content'],
            'feature_image' => $values['feature_image'],
            'sitemap'       => property_exists($values, 'sitemap') ? $values['sitemap'] : 1,
            'activeinactive' => $values['activeinactive']
        );
        
		$row = $this->context->table(self::TABLE_NAME)
            ->where('id = ?', $id)
			->update($update);

		return true;
	}
    
    public function changeFavoriteAdv($id, $user): int
    {
        $page = $this->findOneById( intval($id) );
                
        if ($this->favoriteRepository->existsFavorite($page, $user))
        {
            $this->favoriteRepository->removeByPost($page, $user);
            return 0;
        }
        
        $this->favoriteRepository->createByPost($page, $user);
        return 1;
    }

	/**
	 * @param IRow $row
	 * @return Page
	 */
	protected function mapEntity(IRow $row): Page
	{
		return Page::createFromRow(
            $row, 
            $this->context,
            $this->userRepository,
            $this->favoriteRepository,
            $this->uploadRepository);
	}
}