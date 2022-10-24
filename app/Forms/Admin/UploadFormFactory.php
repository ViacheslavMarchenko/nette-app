<?php

declare(strict_types=1);

namespace App\Forms\Admin;

use Nette\Application\UI\Form;

/**
 * Class UploadFormFactory
 */
class UploadFormFactory
{

	/**
	 * @param bool $imagesOnly
	 * @return Form
	 */
	public function create(): Form
	{
		$form = new Form;

		$form->addMultiUpload('files', 'Soubory')
			->addRule(Form::MIME_TYPE, 'Typ nahraného souboru není podporovaný.', [ 'image/*' ])
			->addRule(Form::MAX_FILE_SIZE, 'Maximální velikost souboru je 1 Mb.', 1 * 1024 * 1024);
        
        //$form->addCheckbox('watermark', 'Přídat vodoznak');
		$form->addSubmit('submit', 'Nahrát soubor');

		return $form;
	}
}