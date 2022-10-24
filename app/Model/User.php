<?php

declare(strict_types=1);

namespace App\Model;

use Nette\SmartObject;
use Nette\Database\Context;
use Nette\Database\Table\IRow;
use DateTimeInterface;
use Nette\Utils\DateTime;

/**
 * Class User
 */
class User
{

	/**
	 * @var int
	 */
	public $id;

	/**
	 * @var string
	 */
	protected $name;

	/**
	 * @var string
	 */
	protected $email;
    
    /**
     * @var string
     */
    protected $phone;

	/**
	 * @var string
	 */
	protected $password;

    /**
	 * @var string
	 */
	protected $hash;
    
	/**
	 * @var int
	 */
	protected $roleId;
    
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
	 * @return Service
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
	 * @var int
	 */
	protected $activeinactive;

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
	 * @param string $name
	 * @return self
	 */
	public function setName(string $name): self
	{
		$this->name = $name;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getName(): string
	{
		return $this->name;
	}

	/**
	 * @param string $email
	 * @return self
	 */
	public function setEmail(string $email): self
	{
		$this->email = $email;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getEmail(): string
	{
		return $this->email;
	}

	/**
	 * @param string $phone
	 * @return self
	 */
	public function setPhone(string $phone): self
	{
		$this->phone = $phone;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getPhone(): string
	{
		return $this->phone;
	}

	/**
	 * @param string $password
	 * @return self
	 */
	public function setPassword(string $password): self
	{
		$this->password = $password;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getPassword(): string
	{
		return $this->password;
	}

	/**
	 * @param string $hash
	 * @return self
	 */
	public function setHash(string $hash): self
	{
		$this->hash = $hash;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getHash(): string
	{
		return $this->hash;
	}

	/**
	 * @param int $role
	 * @return self
	 */
	public function setRole(int $roleId): self
	{
		$this->roleId = $roleId;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getRoleId(): int
	{
		return $this->roleId;
	}

    /**
	 * @return string
	 */
	public function getRoleTitle(): string
	{
	    $row = $this->context->table('roles')->where('id = ?', $this->getRoleId())
			->fetch();
            
		return $row['title'];
	}
    
    /**
	 * @return string
	 */
	public function getRole(): string
	{
	    $row = $this->context->table('roles')->where('id = ?', $this->getRoleId())
			->fetch();
            
		return $row['slug'];
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
    
    public function getIdentity()
    {
        return $this;
    }

	/**
	 * @return array
	 */
	public function toArray(): array
	{
		return [
			'name' => $this->getName(),
            'email' => $this->getEmail(),
            'role' => $this->getRoleId(),
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
		$entity->setId($row->id)
            ->setRow($row)
            ->setContext($context)
			->setName($row->name)
			->setPassword($row->password)
			->setEmail($row->email)
            ->setPhone($row->phone)
			->setRole($row->role)
            ->setHash($row->hash)
            ->setActiveInactive($row->offsetGet('activeinactive'));
		return $entity;
	}
}