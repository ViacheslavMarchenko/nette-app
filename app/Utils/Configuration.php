<?php

namespace App\Utils;

use Nette;

class Configuration
{
	/** 
     * @var array 
    */
	protected $configuration;

	/**
	 * @param array
	 */
	public function __construct($configuration)
	{
		$this->configuration = $configuration;
	}

	/**
	 * @param string
	 * @return mixed
	 */
	public function getParameter($name)
	{
		return $this->configuration[$name];
	}
}