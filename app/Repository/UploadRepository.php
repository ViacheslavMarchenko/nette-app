<?php

declare(strict_types=1);

namespace App\Repository;

use App\Repository\RecordNotFoundException;
use App\Service\UploadService;
use App\Model\Upload;
use Exception;
use Nette\Application\BadRequestException;
use Nette\Database\Context;
use Nette\Database\Table\IRow;
use Nette\Http\FileUpload;
use Nette\InvalidStateException;
use Nette\Utils\ArrayHash;
use Nette\Utils\FileSystem;
use Tracy\Debugger;
use Tracy\Logger;

/**
 * Class UploadRepository
 */
class UploadRepository
{

	const UPLOAD_PATH = __DIR__ . '/../../www/uploads';

	/**
	 * @var string
	 */
	private const TABLE_NAME = 'uploads';

	/**
	 * @var Context
	 */
	private $context;

	/**
	 * @var FilesUploadService
	 */
	public $uploadService;

	/**
	 * FilesRepository constructor.
	 * @param Context $context
	 * @param UploadService $uploadService
	 */
	public function __construct(Context $context, ?UploadService $uploadService)
	{
		$this->context = $context;
		$this->uploadService = $uploadService;
	}

        /**
	 * @return Service[]
	 */
	public function findAll($limit = 100, $offset = 0, $s = ""): array
	{
		$rows = $this->context->table(self::TABLE_NAME)
            ->where('filename LIKE ?', "%$s%")
			->order('sort_id DESC')
            ->limit($limit, $offset)
			->fetchAll();
                        
		return $this->mapCollection($rows);
	}
 
	/**
	 * @param int $id
	 * @throws RecordNotFoundException
	 * @return Upload
	 */
	public function findOneById(int $id): ?Upload
	{
		$row = $this->context->table(self::TABLE_NAME)
			->where('id = ?', $id)
			->fetch();

		if (!$row) {
			return null;
		}
		return $this->mapEntity($row);
	}

	/** 
	 * @param string $name
	 * @throws RecordNotFoundException
	 * @return IRow
	 */
	public function findOneByName(string $name): ?IRow
	{
		$row = $this->context->table(self::TABLE_NAME)
			->where('filename = ?', $name)
			->fetch();

		if (!$row) {
			return NULL;
		}
        
		return $row;
	}
    
    /**
	 * @param int $id
	 * @return String
	 */
    public function getMediaUrlById(int $id, $size = 'thumb')
    {
        if (empty($id))
        {
            return "";
        }
        
        try
        {
            $upload = $this->findOneById($id);
        }
        catch (RecordNotFoundException $e)
        {
            return "";
        }
        
        if ($upload == NULL)
        {
            return "";
        }
        
        return $upload->getUrl($size);
    }
    
    public function getMediasUrlByIds(string $pids)
    {
        $result = [];
        $ids = explode(',', trim($pids, ","));
        
        foreach ($ids as $id) {
            $mediaUrl = $this->getMediaUrlById( intval($id) );
            
            if (!empty($mediaUrl))
                $result[$id] = $this->getMediaUrlById( intval($id) );
            
        }
        
        return $result;
    }
    
    /**
	 * @return int
	 */
	public function countRows($filename): int
	{
		return $this->context->table(self::TABLE_NAME)
            ->where('filename LIKE ?', "%$filename%")
			->count('*');
	}
    
    /**
	 * @return int
	 */
	public function countByNameAndPath(int $id, $filename, $filepath): int
	{
		return $this->context->table(self::TABLE_NAME)
            ->where('id != ? AND filename = ? AND filepath = ?', $id, $filename, $filepath)
			->count('*');
	}
    
	/**
	 * @param ArrayHash $values
	 * @throws Exception
	 */
	public function create(ArrayHash $values): array
	{
		/** @var FilesUpload[] $files */
		$files = $values['files'];
        $watermark = property_exists($values, 'watermark') ? $values['watermark'] : false;
        $rows = [];
        
		foreach ($files as $file) {
            
            $row = $this->findOneByName($file->name);
            $this->context->beginTransaction();
    		
            if ($row == NULL)
            {      
    			if($file->hasFile() && !$file->isOk()) {
    				throw new InvalidStateException('There was a problem uploading the file to server.');
    			}
            }

			try {
			     if ($row == NULL)
                 {
                    $compim = 1;
    				$filename = $this->uploadService->upload($file, 'uploads/' . date("Y") . '/' . date('m'), $compim, $watermark, (string) rand(4444, 9999));
    
    				$row = $this->context->table(self::TABLE_NAME)
    					->insert([
    						'filename' => $filename,
                            'filepath' => 'uploads/' . date("Y") . '/' . date('m'),
    						'filesize' => $file->getSize() * $compim,
                            'mime_type'  => $file->getContentType(),
    						'sort_id'  => $this->getLastSortId() + 1
    					]);
                }

                $rows[] = $row;
			} catch (Exception $e) {
				$this->context->rollBack();
				throw $e;
			}

			$this->context->commit();
		}
        
        return $this->mapCollection($rows);
	}
    
    /**
	 * @param Upload $file
     * @param string $filename
	 */
    public function updateFilename(Upload $file, string $filename)
    {
        $uid = $file->getId();
        $row = $this->context->table(self::TABLE_NAME)
            ->where('id = ?', $uid)
			->update(['filename' => $filename]);
    }

	/**
	 * @param Upload $file
	 */
	public function remove(Upload $file): void
	{
		$this->uploadService->removeAllSize($file->getFilepath(), $file->getFilename());
        
		$this->context->table(self::TABLE_NAME)
			->where('id = ?', $file->getId())
			->delete();
	}

	/**
	 * @return int
	 */
	private function getLastSortId(): int
	{
		$row = $this->context->table(self::TABLE_NAME)
			->order('sort_id DESC')
			->fetch();

		if ($row === null) {
			return 0;
		}

		return (int) $row->sort_id;
	}

	/**
	 * @param int $id
	 * @throws RecordNotFoundException
	 */
	public function increaseSortIdById(int $id): void
	{
		$entity = $this->findOneById($id);

		$this->context->beginTransaction();

		$row = $this->context->table(self::TABLE_NAME)
			->where('sort_id = ?', $entity->getSortId() - 1)
			->fetch();
		if (!$row) {
			// throw new InvalidStateException('There is no record to replace order number with.');
		} else {
			$this->context->table(self::TABLE_NAME)
				->where('id = ?', $row['id'])
				->update([
					'sort_id' => ($row['sort_id'] + 1)
				]);
		}

		$this->context->table(self::TABLE_NAME)
			->where('id = ?', $entity->getId())
			->update([
				'sort_id' => $entity->getSortId() - 1
			]);

		$this->context->commit();
	}

	/**
	 * @param int $id
	 * @throws RecordNotFoundException
	 */
	public function decreaseSortIdById(int $id): void
	{
		$entity = $this->findOneById($id);

		$this->context->beginTransaction();

		$row = $this->context->table(self::TABLE_NAME)
			->where('sort_id = ?', $entity->getSortId() + 1)
			->fetch();
		if (!$row) {
			// throw new InvalidStateException('There is no record to replace order number with.');
		} else {
			$this->context->table(self::TABLE_NAME)
				->where('id = ?', $row['id'])
				->update([
					'sort_id' => ($row['sort_id'] - 1)
				]);
		}

		$this->context->table(self::TABLE_NAME)
			->where('id = ?', $entity->getId())
			->update([
				'sort_id' => $entity->getSortId() + 1
			]);

		$this->context->commit();
	}

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
	 * @param IRow $row
	 * @return Upload
	 */
	public function mapEntity(IRow $row): Upload
	{
		return Upload::createFromRow($row);
	}
}