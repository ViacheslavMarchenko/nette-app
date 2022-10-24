<?php

declare(strict_types=1);

namespace App\Model;

use Nette\Database\Context;
use Nette\Database\Table\IRow;
use DateTimeInterface;
use Nette\Utils\DateTime;


/**
 * Class Favorite
 */
class Favorite
{
	/**
	 * @var int
	 */
	public $id;

	/**
	 * @var int
	 */
	public $post_id;

	/**
	 * @var int
	 */
	protected $author;
    
    /**
     * @var Context
     */
    public $context;
    
	/**
	 * @var IRow
	 */
	private $row;
    
    /**
	 * @param IRow $row
	 * @return self
	 */
	public function setRow(IRow $row): self
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
	 * @param int $post_id
	 * @return self
	 */
	public function setPostId(int $post_id): self
	{
		$this->post_id = $post_id;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getPostId(): int
	{
		return $this->$post_id;
	}
    
    /**
	 * @return int
	 */
	public function getAuthor(): int
	{
		return $this->author;
	}

	/**
	 * @param int $author
	 * @return self
	 */
	public function setAuthor(int $author): self
	{
		$this->author = $author;
		return $this;
	}

	/**
	 * @return array
	 */
	public function toArray(): array
	{
		return [
			'post_id' => $this->getPostId(),
            'author' => $this->getAuthor(),
		];
	}

	/**
	 * @param IRow $row
	 * @return User
	 */
	public static function createFromRow(IRow $row, Context $context): self
	{
		$entity = new self;
		$entity->setId($row->offsetGet('id'))
            ->setRow($row)
            ->setContext($context)
			->setPostId($row->offsetGet('post_id'))
			->setAuthor($row->offsetGet('author'));
		return $entity;
	}
}