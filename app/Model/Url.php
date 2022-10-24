<?php

declare(strict_types=1);

namespace App\Model;

use Nette\SmartObject;
use Nette\Database\Context;
use Nette\Database\Table\IRow;
use DateTimeInterface;
use Nette\Utils\DateTime;

/**
 * Class Url
 */
class Url
{
	public $loc;
	public $lastmod;
	public $frequency;
	public $priority;

	public function __construct(string $loc, DateTime $lastmod, string $frequency, float $priority)
	{
		$this->loc = $loc;
		$this->lastmod = $lastmod;
		$this->frequency = $frequency;
		$this->priority = $priority;
	}
}