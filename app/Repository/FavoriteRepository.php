<?php

declare(strict_types=1);

namespace App\Repository;

use App\Repository\RecordNotFoundException;
use App\Model\Page;
use App\Model\Favorite;
use Exception;
use Nette\Application\BadRequestException;
use Nette\InvalidArgumentException;
use Nette\Database\Context;
use Nette\Database\Table\IRow;
use Nette\InvalidStateException;
use Nette\Utils\ArrayHash;
use Nette\Utils\Strings;
use Nette\Utils\FileSystem;
use Tracy\Debugger;
use Tracy\Logger;

/**
 * Class FavoriteRepository
 */
class FavoriteRepository extends BasicRepository
{
	/**
	 * @var string
	 */
	private const TABLE_NAME = 'favorites';

	/**
	 * @var Context
	 */
	private $context;

	/**
	 * FavoriteRepository constructor.
	 * @param Context $context
	 */
	public function __construct(Context $context)
	{
		$this->context = $context;
	}
    
    /**
	 * @param Page $page
	 * @return Favorite
	 */
	public function createByPost(Page $page, $user)
	{
	    $row = $this->context->table(self::TABLE_NAME)
			->insert([
				'post_id' => $page->getId(),
                'author' => $user->getId(),
			]);

		return $this->mapEntity($row);
	}
    
    /**
	 * @param Page $page
	 */
	public function removeByPost(Page $page, $user): void
	{
		$this->context->table(self::TABLE_NAME)
			->where('post_id = ? AND author = ?', $page->getId(), $user->getId())
			->delete();
	}
    
    /**
     * @param Page $page
	 * @return bool
	 */
	public function existsFavorite(Page $page, $user): bool
	{
		$row = $this->context->table(self::TABLE_NAME)
			->where("post_id = ? AND author = ?", $page->getId(), $user->id)
			->fetch();

		if ($row === null) {
			return false;
		}

		return true;
	}

	/**
	 * @param IRow $row
	 * @return Favorite
	 */
	protected function mapEntity(IRow $row): Favorite
	{
		return Favorite::createFromRow($row, $this->context);
	}
}