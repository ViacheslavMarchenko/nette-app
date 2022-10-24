<?php

declare(strict_types=1);

namespace App\Repository;

use App\Repository\RecordNotFoundException;
use App\Model\Category;
use Exception;
use Nette\Application\BadRequestException;
use Nette\InvalidArgumentException;
use Nette\Database\Context;
use Nette\Database\Table\IRow;
use Nette\Http\FileUpload;
use Nette\InvalidStateException;
use Nette\Utils\ArrayHash;
use Nette\Utils\Strings;
use Nette\Utils\FileSystem;
use Tracy\Debugger;
use Tracy\Logger;

/**
 * Class BasicRepository
 */
class BasicRepository
{
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
	 * @return int
	 */
	protected function getLastOrderNumber($context, $table): int
	{
		$row = $context->table($table)
			->order('menu_order DESC')
			->fetch();

		if ($row === null) {
			return 0;
		}

		return (int) $row->menu_order;
	}
    
    public function getIP()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            return $_SERVER['REMOTE_ADDR'];
        }
    }
 }