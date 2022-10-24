<?php

declare(strict_types=1);

namespace App\Repository;

use App\Repository\RecordNotFoundException;
use App\Model\User;
use Exception;
use Nette\Application\BadRequestException;
use Nette\InvalidArgumentException;
use Nette\Database\Context;
use Nette\Database\Table\IRow;
use Nette\InvalidStateException;
use Nette\Utils\ArrayHash;
use Nette\Utils\Strings;
use Nette\Utils\FileSystem;
use Nette\Security\Passwords;
use Tracy\Debugger;
use Tracy\Logger;

/**
 * Class UserRepository
 */
class UserRepository extends BasicRepository
{

	/**
	 * @var string
	 */
	private const TABLE_NAME = 'users';

	/**
	 * @var Context
	 */
	private $context;

	/**
	 * UserRepository constructor.
	 * @param Context $context
	 */
	public function __construct(Context $context)
	{
		$this->context = $context;
	}

    /**
	 * @return Users[]
	 */
	public function findAll($user, $limit = 100, $offset = 0, $s = ""): array
	{
	    if ($user == NULL || !$user->isLoggedIn())
        {
            return [];
        }
        
        if ($user->isInRole('superadmin')) {
            $rows = $this->context->table(self::TABLE_NAME)
    			->where('name LIKE ? OR email LIKE ?', "%$s%", "%$s%")
                ->limit($limit, $offset)
    			->fetchAll();
        }
        else if ($user->isInRole('guest')) 
        {
	       return $this->findAllByUser($user, $limit, $offset, $s);
	    }
        else {
            return [];
        }
        
		return $this->mapCollection($rows);
	}

    /**
	 * @return Users[]
	 */
	public function findAllByUser($user, $limit = 100, $offset = 0, $s = ""): array
	{
	    if ($user->isInRole('guest'))
        {
            return [$this->findOneById($user->id)];
        }
        
        $rows = $this->context->table(self::TABLE_NAME)
			->where("(name LIKE ? OR email LIKE ?) AND id_company = (SELECT id_company FROM users WHERE id = ?)", "%$s%", "%$s%", $user->id)
            ->limit($limit, $offset)
			->fetchAll();
                       
		return $this->mapCollection($rows);
	}
    	
    /**
	 * @param int $id
	 * @throws RecordNotFoundException
	 * @return User
	 */
    public function findOneById(int $id): User
	{
		$row = $this->context->table(self::TABLE_NAME)
			->where('id = ?', $id)
			->fetch();

		if (!$row) {
			throw new RecordNotFoundException(
				sprintf('No record found with ID "%d".', $id)
			);
		}
		return $this->mapEntity($row);
	}

	/**
	 * @param string $email
	 * @return User|null
	 */
	public function findOneByEmail(string $email): ?User
	{
	    $row = $this->context->table(self::TABLE_NAME)
			->where('email = ?', $email)
			->fetch();

		if ($row === null) {
			return null;
		}

		return $this->mapEntity($row);
	}

	/**
	 * @param string $email
     * @param string $phone
	 * @return array
	 */
	public function findOneByEmailAndPhone(string $email, string $phone): array
	{
	    $rows = $this->context->table(self::TABLE_NAME)
			->where('(email = ? OR REPLACE (phone, " ", "") = ?) AND role = ?', $email, str_replace(' ', '', $phone), 3)
			->fetchAll();

		if ($rows === null) {
			return [];
		}

		return $this->mapCollection($rows);
	}
    
	/**
	 * @param User $user
	 */
	public function remove(User $user): void
	{
		$this->context->table(self::TABLE_NAME)
			->where('id = ?', $page->getId())
			->delete();
	}
    
    /**
	 * @return int
	 */
	public function countRows($s = ""): int
	{
		return $this->context->table(self::TABLE_NAME)
            ->where('name LIKE ? OR email LIKE ?', "%$s%", "%$s%")
			->count('*');
	}
    
    public function existsEmail($email): bool
	{
		return $this->context->table(self::TABLE_NAME)
            ->where('email LIKE ?', "$email")
			->count('*') != 0;
	}

	/**
	 * @param User $user
	 * @param ArrayHash $values
	 */
	public function update(User $user, ArrayHash $values): bool
	{
        $id = $user->getId();
        
        $row = $this->context->table(self::TABLE_NAME)
			->where('id = ?', $id)
			->fetch();

		if (!$row) {
			return false;
		}
        
        $updated_values = [
			'name' => $values['name'],
            'email' => $values['email'],
            'phone' => (property_exists($values, 'phone') ? $values['phone'] : ''),
            'hash' => (property_exists($values, 'hash') ? $values['hash'] : ''),
            'role' => (property_exists($values, 'role') ? $values['role'] : 3),
            'activeinactive' => (property_exists($values, 'activeinactive') ? $values['activeinactive'] : 1),
		];
        
        if (!empty($values['password'])) 
        {
            $updated_values['password'] = $this->hashPass($values['password']);
        }
        
	    $this->context->table(self::TABLE_NAME)
			->where('id = ?', $id)
			->update($updated_values);
            
        return true;
	}
    
    /**
	 * @param ArrayHash $values
	 * @return User
	 */
	public function create(ArrayHash $values)
	{
	    $insert = [
			'name' => $values['name'],
            'password' => $this->hashPass($values['password']),
            'email' => $values['email'],
            'id_company' => (property_exists($values, 'id_company') ? $values['id_company'] : 0),
            'hash' => (property_exists($values, 'hash') ? $values['hash'] : ''),
            'phone' => (property_exists($values, 'phone') ? $values['phone'] : ''),
            'role' => (property_exists($values, 'role') ? $values['role'] : 3),
		];
        
	    $row = $this->context->table(self::TABLE_NAME)
			->insert($insert);

		return $this->mapEntity($row);
	}
    
    /**
	 * @param string $email
	 * @return string
	 */
    public function generatePassword($email): string
    {
        $hash = hash('crc32b', $email . rand());
        $password = new Passwords(PASSWORD_BCRYPT, ['cost' => 12]);
        $this->context->table(self::TABLE_NAME)
			->where('email = ?', $email)
			->update(array(
                'password' => $password
            ));
        
        return $hash;
    }
    
    /**
	 * @param string $pass
	 * @return string
	 */
    public function hashPass(string $pass): string
    {
        $passwords = new Passwords(PASSWORD_BCRYPT, ['cost' => 12]);
        return $passwords->hash($pass);
    }

	/**
	 * @param IRow $row
	 * @return User
	 */
	protected function mapEntity(IRow $row): User
	{
		return User::createFromRow($row, $this->context);
	}
}