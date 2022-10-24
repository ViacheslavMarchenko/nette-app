<?php

declare(strict_types=1);

namespace App\Repository;

use App\Repository\RecordNotFoundException;
use App\Model\Role;
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
 * Class RoleRepository
 */
class RoleRepository extends BasicRepository
{
	/**
	 * @var string
	 */
	private const TABLE_NAME = 'roles';

	/**
	 * @var Context
	 */
	private $context;

	/**
	 * RoleRepository constructor.
	 * @param Context $context
	 */
	public function __construct(Context $context)
	{
		$this->context = $context;
	}

    /**
	 * @return Role[]
	 */
	public function findAll(): array
	{
        $rows = $this->context->table(self::TABLE_NAME)
			->fetchAll();
                        
		return $this->mapCollection($rows);
	}

	/**
	 * @param IRow $row
	 * @return Role
	 */
	protected function mapEntity(IRow $row): Role
	{
		return Role::createFromRow($row, $this->context);
	}
}