<?php

declare(strict_types=1);

namespace App\Repository;

use App\Repository\RecordNotFoundException;
use App\Model\Language;
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
 * Class LanguageRepository
 */
class LanguageRepository extends BasicRepository
{
	/**
	 * @var Context
	 */
	private $context;

	/**
	 * LanguageRepository constructor.
	 * @param Context $context
	 */
	public function __construct(Context $context)
	{
		$this->context = $context;
	}
}