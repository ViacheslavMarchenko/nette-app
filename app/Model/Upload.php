<?php

declare(strict_types=1);

namespace App\Model;

use App\Model\AbstractModel;
use Nette\Database\Context;
use Nette\Database\Table\IRow;
use Nette\Utils\Strings;

/**
 * Class Upload
 */
class Upload
{
	/**
	 * @var int
	 */
	protected $id;

	/**
	 * @var string
	 */
	protected $filename;

	/**
	 * @var string
	 */
	protected $filepath;

	/**
	 * @var int
	 */
	protected $filesize;

    /**
	 * @var int
	 */
	protected $user;

	/**
	 * @var int
	 */
	protected $sortId;
        
	/**
	 * @var IRow
	 */
	private $row;

	/**
	 * @param int $id
	 * @return Upload
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
	 * @param string $filename
	 * @return Upload
	 */
	public function setFilename(string $filename): self
	{
		$this->filename = $filename;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getFilename(): string
	{
		return $this->filename;
	}
    
    /**
	 * @param string $filepath
	 * @return File
	 */
	public function setFilepath(string $filepath): self
	{
		$this->filepath = $filepath;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getFilepath(): string
	{
		return $this->filepath;
	}
    
    /**
     * @return string
     */
    public function getUrl($size = 'thumb')
    {
        switch ($size) {
            case 'large':
                $size = '';
                break;
                
            case 'thumb-2x1':
                $size = 'thumb-2x1/';
                break;
                
            case 'thumb':
                $size = 'thumb-detail/';
                break; 
        }
        
        if (strpos($this->getMimeType(), 'svg') !== false)
            return sprintf("/%s/%s", $this->getFilepath(), $this->getFilename());
            
        return sprintf("/%s/$size%s", $this->getFilepath(), $this->getFilename());
    }

	/**
	 * @param int $filesize
	 * @return Upload
	 */
	public function setFilesize(int $filesize): self
	{
		$this->filesize = $filesize;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getFilesizeInMb(): int
	{
		return $this->filesize;
	}

	/**
	 * @param string $mime_type
	 * @return Upload
	 */
	public function setMimeType(string $mime_type): self
	{
		$this->mime_type = $mime_type;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getMimeType(): string
	{
		return $this->mime_type;
	}
    
    /**
	 * @return int
	 */
	public function getUser(): int
	{
		return $this->user;
	}

	/**
	 * @param int $user
	 * @return self
	 */
	public function setUser(int $user): self
	{
		$this->user = $user;
		return $this;
	}

	/**
	 * @param int|null $sortId
	 * @return self
	 */
	public function setSortId(?int $sortId): self
	{
		$this->sortId = $sortId;
		return $this;
	}

	/**
	 * @return int|null
	 */
	public function getSortId(): ?int
	{
		return $this->sortId;
	}
    
	/**
	 * @param IRow $row
	 * @return self
	 */
	public function setRow(IRow $row): self
	{
		$this->row = $row;
		return $this;
	}

	/**
	 * @param IRow $row
	 * @return self
	 */
	public static function createFromRow(IRow $row): self
	{

		$entity = new self;
		$entity->setId($row->offsetGet('id'))
			->setRow($row)
			->setFilename($row->offsetGet('filename'))
            ->setFilepath($row->offsetGet('filepath'))
			->setFilesize($row->offsetGet('filesize'))
            ->setMimeType($row->offsetGet('mime_type'))
            ->setUser($row->offsetGet('user'))
			->setSortId($row->offsetGet('sort_id'))
		;
		return $entity;
	}
}