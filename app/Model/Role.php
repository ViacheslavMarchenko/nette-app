<?php

declare(strict_types=1);

namespace App\Model;

use Nette\SmartObject;
use Nette\Database\Context;
use Nette\Database\Table\IRow;
use DateTimeInterface;
use Nette\Utils\DateTime;


/**
 * Class Role
 */
class Role
{

	/**
	 * @var int
	 */
	public $id;

	/**
	 * @var string
	 */
	public $title;

	/**
	 * @var string
	 */
	protected $slug;

	/**
	 * @var int
	 */
	protected $activainactive;
    
    /**
	 * @var string
	 */
	protected $role;
    
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
	 * @param string $slug
	 * @return self
	 */
	public function setSlug(string $slug): self
	{
		$this->slug = $slug;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getSlug(): string
	{
		return $this->slug;
	}
    
	/**
	 * @return int
	 */
	public function getActiveInactive(): int
	{
		return $this->activeinactive;
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
	 * @return array
	 */
	public function toArray(): array
	{
		return [
			'title' => $this->getTitle(),
            'slug' => $this->getSlug(),
            'activeinactive' => $this->getActiveInactive(),
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
			->setTitle($row->offsetGet('title'))
			->setSlug($row->offsetGet('slug'))
            ->setActiveInactive($row->offsetGet('activeinactive'));
		return $entity;
	}
}