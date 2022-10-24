<?php
declare(strict_types=1);

namespace App\User;

use Nette;
use Nette\Database\Context;
use Nette\Database\Table\IRow;

class AuthorizationFactory
{
    private $context;
    
    public static function create(): Nette\Security\Permission
    {
        $permission = new \Nette\Security\Permission;
        $permission->addRole('guest');
        $permission->addRole('banker', 'guest');
        $permission->addRole('developer', 'guest');
        $permission->addRole('superadmin', 'banker', 'developer'); 
        
        $permission->addResource('full');
        $permission->addResource('pages');
        $permission->addResource('users');
        
        //superadmin
        $permission->allow('superadmin', 'full');
        $permission->allow('superadmin', 'pages', ['create', 'edit', 'delete']);
        $permission->allow('superadmin', 'users', ['create', 'edit', 'delete']);
        
        //guest
        $permission->deny('guest', 'full');
        $permission->deny('guest', 'pages', ['create', 'delete']);
        $permission->deny('guest', 'users', ['create', 'delete']);
        $permission->allow('guest', 'users', ['edit']);
        $permission->allow('guest', 'pages', ['edit']);
        
        return $permission;
    }
}