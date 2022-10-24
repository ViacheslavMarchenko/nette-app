<?php

declare(strict_types=1);

namespace App\Repository;

use App\Repository\RecordNotFoundException;
use App\Model\Option;
use Exception;
use Nette\Application\BadRequestException;
use Nette\InvalidArgumentException;
use Nette\Database\Context;
use Nette\Database\Table\IRow;
use Nette\InvalidStateException;
use Nette\Utils\ArrayHash;
use Tracy\Debugger;
use Tracy\Logger;

/**
 * Class OptionRepository
 */
class OptionRepository
{
    /**
	 * @var string
	 */
	private const TABLE_NAME = 'options';

	/**
	 * @var Context
	 */
	private $context;

	/**
	 * FilesRepository constructor.
	 * @param Context $context
	 */
	public function __construct(Context $context)
	{
		$this->context = $context;
	}
    
    /**
	 * @return int
	 */
	public function countRows($option_value): int
	{
		return $this->context->table(self::TABLE_NAME)
            ->where('option_key = ?', $option_value)
			->count('*');
	}
    
    /**
	 * @param int $id
	 * @return string
	 */
    public function getOptionByKey($key)
    {
        $row = $this->context->table(self::TABLE_NAME)
			->where('option_key = ?', $key)
			->fetch();

		if (!$row) {
			return NULL;
		}
        
		$option = $this->mapEntity($row);
        
        return $option->getOptionValue();
    }
    /**
	 * @param int $id
	 * @return string
	 */
    public function updateOptionByKey($key, $value)
    {
        $this->context->table(self::TABLE_NAME)
			->where('option_key = ?', $key)
			->update([
				'option_value' => $value,
			]);
    }
    
    /**
	 * @param int $id
	 * @return Option
	 */
    public function get($key)
    {
        return $this->getOptionByKey($key);
    }
    
    /**
	 * @param int $id
	 * @return array
	 */
    public function getAll(): array
    {
        $rows = $this->context->table(self::TABLE_NAME)
			->fetchAll();
            
        return $this->mapCollection($rows);
    }
    
    /**
	 * @param ArrayHash $values
	 */
	public function update(ArrayHash $values): bool
	{
        foreach ($values as $key => $value)
        {
            if ($this->countRows($key))
            {
                $this->context->table(self::TABLE_NAME)
        			->where('option_key = ?', $key)
        			->update([
        				'option_value' => $value,
        			]);
            }
            else
            {
                $this->context->table(self::TABLE_NAME)
        			->insert([
                        'option_key' => $key,
        				'option_value' => $value,
        			]);
            }
        }
            
        return true;
	}
    
	/**
	 * @param array $rows
	 * @return array
	 */
	protected function mapCollection(array $rows): array
	{
		$collection = [];
		foreach ($rows as $row) {
			$collection[] = $this->mapEntity($row);
		}
		return $collection;
	}
    	
    /**
	 * @param IRow $row
	 * @return Option
	 */
	protected function mapEntity(IRow $row): Option
	{
		return Option::createFromRow($row, $this->context);
	}
 }