<?php

declare(strict_types=1);

namespace App\Model;

use Nette;
use App\Model\AbstractModel;
use Nette\SmartObject;
use Nette\Database\Context;
use Nette\Database\Table\IRow;
use DateTimeInterface;
use Nette\Utils\DateTime;

final class Option
{	
	/**
     * @var Contect
     */
    protected $context; 
    
    /**
	 * @var int
	 */
	protected $option_id;

    /**
	 * @var string
	 */
	protected $option_value;

	/**
	 * @var int
	 */
	protected $option_key;
            
	/**
	 * @var IRow
	 */
	private $row;

	/**
	 * @param IRow $row
	 * @return Options
	 */
	public function setRow(IRow $row): self
	{
		$this->row = $row;
		return $this;
	}
    
    public function setContext(Context $context): self
    {
        $this->context = $context;
		return $this;
    }

	/**
	 * @return int
	 */
	public function getOptionId(): int
	{
		return $this->option_id;
	}
    
	/**
	 * @param int $option_id
	 * @return self
	 */
	public function setOptionId(int $option_id): self
	{
		$this->option_id = $option_id;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getOptionValue()
	{
		return $this->option_value;
	}

	/**
	 * @param string $option_value
	 * @return Options
	 */
	public function setOptionValue(string $option_value): self
	{
		$this->option_value = $option_value;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getOptionKey(): string
	{
		return $this->option_key;
	}

	/**
	 * @param string $option_key
	 * @return Options
	 */
	public function setOptionKey(string $option_key): self
	{
		$this->option_key = $option_key;
		return $this;
	}
    
	/**
	 * @param IRow $row
	 * @return Options
	 */
	public static function createFromRow(IRow $row, Context $context): self
	{
	    $entity = new self;
		$entity->setOptionId($row->offsetGet('option_id'))
			->setRow($row)
            ->setContext($context)
			->setOptionValue($row->offsetGet('option_value'))
            ->setOptionKey($row->offsetGet('option_key'));
            
		return $entity;
	}
}
