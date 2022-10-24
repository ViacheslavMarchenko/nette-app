<?php

declare(strict_types=1);

namespace App\Model;

class Configuration{

    /** 
     * @var array 
    */
    protected $configuration;

    public function __construct(array $configuration){
        $this->configuration = $configuration;
    }

    /** 
     * @return mixed 
    */
    public function __get(string $name){
        return $this->configuration[$name];
    }

}