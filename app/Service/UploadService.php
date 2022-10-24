<?php

namespace App\Service;


use App\Repository\RecordNotFoundException;
use Exception;
use Nette\Application\BadRequestException;
use Nette\InvalidArgumentException;
use Nette\InvalidStateException;
use Nette\Http\FileUpload;
use Nette\Utils\FileSystem;
use Nette\Utils\Image;
use Nette\Utils\ImageException;
use Nette\Utils\UnknownImageFileException;

/**
 * Class UploadService
 */
class UploadService
{

	private const UPLOAD_PATH = __DIR__ . '/../../www/';

	private const SIZES = [
		'thumb-detail' => [
			480, 480
		],
		'medium' => [
			980, 980
		]
	];

	/**
	 * @param FileUpload $file
	 * @param string $namespace
	 * @param string|null $prefix
	 * @throws UnknownImageFileException
	 * @throws ImageException
	 * @return string
	 */
	public function upload(FileUpload $file, string $namespace, &$compim, $watermark = true, string $prefix = null): string
	{
		if ($prefix !== null) {
			$prefix .= '-';
		}
		$filename = $prefix . $file->getSanitizedName();
		$destination = self::UPLOAD_PATH . $namespace . '/' . $filename;
                
        $file->move($destination);
        
		if ($file->isImage()) {
		    if ($watermark) {
                $this->addWatermark($destination);
		    }
                
			$this->createThumbnails($destination);
		}

		return $filename;
	}

	/**
	 * @param string $filepath
	 * @throws ImageException
	 * @throws UnknownImageFileException
	 */
	public function resizeFile(&$compim, string $filename, string $filepath): void
	{
		$ext = strtolower(pathinfo($filepath, PATHINFO_EXTENSION));

		if ($ext === 'png') {
			$quality = 8;
		} else {
			$quality = 80;
		}
        
        list($width, $height, $type, $attr) = getimagesize($filepath);
        $newWidth = $width;
        $newHeight = $height;
        
        if ($width > 1920 || $height > 1920)
        {
            if ($width > $height)
            {
                $ratio = $height / $width;
                $newWidth = 1920;
                $newHeight = 1920 * $ratio;
            }
            else
            {
                $ratio = $width / $height;
                $newHeight = 1920;
                $newWidth = 1920 * $ratio;
            }
                
            $compim = $newWidth / $width;
        }

		$image = Image::fromFile($filepath);
		$image->resize((int)$newWidth, (int)$newHeight, Image::EXACT);
		$image->sharpen();
        
		$image->save($filepath, $quality);
	}

	/**
	 * @param string $filepath
	 * @throws ImageException
	 * @throws UnknownImageFileException
	 */
	public function createThumbnails(string $filepath): void
	{
		$ext = strtolower(pathinfo($filepath, PATHINFO_EXTENSION));

		if ($ext === 'png') {
			$quality = 7;
		} else {
			$quality = 70;
		}

        list($width, $height, $type, $attr) = getimagesize($filepath);
        $originalWidth = $width;
        $originalHeight = $height;
        
        $orientation = ($originalWidth > $originalHeight) ? "h" : "v";
        
		foreach (self::SIZES as $folder => $size) {
		    list($width, $height) = $size;
            
            if ( $folder != 'thumb-detail' ) {
                $ratio = ($orientation == "h" ? $originalWidth / $width : $originalHeight / $height);
                
                if ($orientation == "h") {
                    $height = $height / $ratio;
                } else {
                    $width = $width / $ratio;
                }
            }

			$image = Image::fromFile($filepath);
			$image->resize((int)$width, (int)$height, Image::EXACT);
			$image->sharpen();

			$filename = basename($filepath);
			$location = dirname($filepath);

			if (!file_exists($location . '/' . $folder)) {
				FileSystem::createDir($location . '/' . $folder);
			}

			$image->save($location . '/' . $folder . '/' . $filename, $quality);
		}
	}
    
    public function removeAllSize(string $path, string $name): void
    {
        $location = self::UPLOAD_PATH . $path;
        $file = $location . '/' . $name;
        
        if (file_exists($file)) {
			FileSystem::delete($file);
		}
            
        foreach (self::SIZES as $folder => $size) {
            $file = $location . '/' . $folder . '/' . $name;
            
			if (file_exists($file)) {
				FileSystem::delete($file);
			}
        }
    }
    
    private function addWatermark($filename)
    {
        $stamp = Image::fromFile(self::UPLOAD_PATH . 'assets/img/inzeruj_lb.png');
        $im = Image::fromFile($filename);
        
        // Set the margins for the stamp and get the height/width of the stamp image
        $sx = $im->getWidth() * 0.4;
        $sy = $im->getWidth() * 0.4 / ($stamp->getWidth() / $stamp->getHeight());
        $stamp->resize((int)$sx, (int)$sy, Image::EXACT);
        
        imagefilter($stamp->getImageResource(), IMG_FILTER_GRAYSCALE);
        
        $color = imagecolorallocatealpha($stamp->getImageResource(), 0, 0, 0, 127);
        imagefill($stamp->getImageResource(), 0, 0, $color);
        
        $top = ($im->getWidth() - $stamp->getWidth())/2;
        $left = ($im->getHeight() - $stamp->getHeight())/2;
        
        
        $im->place($stamp, (int)$top, (int)$left, 20);
        $im->save($filename);
    }
    
    public function updateFileName($path, $oldName, $newName)
    {
        $result = false;
        $oldFilePath = self::UPLOAD_PATH . "/" . $path . "/" . $oldName;
        $newFilePath = self::UPLOAD_PATH . "/" . $path . "/" . $newName;
        
        if (file_exists($oldFilePath)) {
            FileSystem::rename($oldFilePath, $newFilePath);
            $result = true;
        }
        
        foreach (self::SIZES as $folder => $size) {
            $oldFilePath = self::UPLOAD_PATH . "/" . $path . "/" . $folder . "/" . $oldName;
            $newFilePath = self::UPLOAD_PATH . "/" . $path . "/" . $folder . "/" . $newName;
        
            if (file_exists($oldFilePath)) {
                FileSystem::rename($oldFilePath, $newFilePath);
            }
        }
        
        return $result;
    }
}