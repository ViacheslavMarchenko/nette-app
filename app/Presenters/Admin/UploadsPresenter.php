<?php

declare(strict_types=1);

namespace App\Presenters\Admin;

use App\Model\Upload;
use App\Forms\Admin\UploadFormFactory;
use App\Repository\RecordNotFoundException;
use App\Repository\UploadRepository;
use App\Service\UploadService;
use Nette\Application\AbortException;
use Nette\Application\BadRequestException;
use Nette\Application\UI\Form;
use Nette\Utils\ArrayHash;
use Nette\Utils\ImageException;
use Nette\Utils\UnknownImageFileException;
use App\Presenters\AuthorizedPresenter;

/**
 * Class UploadsPresenter
 */
final class UploadsPresenter extends AuthorizedPresenter
{
    use BasicPresenter;
    
	/**
	 * @var UploadRepository @inject
	 */
	public $uploadRepository;

	/**
	 * @var UploadFormFactory @inject
	 */
	public $uploadFormFactory;

	/**
	 */
	public $uploadService;

	/**
	 * @var Service
	 */
	private $upload;

	/**
	 */
	public function renderDefault(int $page = 1, string $s = ""): void
	{
	    if (!$this->user->isAllowed("full"))
        {
            $this->redirect('Dashboard:default');
        }
        
	    $paginator = new \Nette\Utils\Paginator;
		$paginator->setItemCount( $this->uploadRepository->countRows($s) ); // celkový počet článků
		$paginator->setItemsPerPage(26); // počet položek na stránce
		$paginator->setPage($page); // číslo aktuální stránky
        
		$this->template->uploads = $this->upload = $this->uploadRepository->findAll($paginator->getLength() + 1, $paginator->getOffset(), $s);
        $this->template->paginator = $paginator;
	}

	/**
	 */
	public function renderLayout(): void
	{
		$this->template->uploads = $this->upload = $this->uploadRepository->findAll();
	}
    
    /**
	 * @return Form
	 */
	public function createComponentUploadForm(): Form
	{
		$form = $this->uploadFormFactory->create();
		$form->onError[] = function(Form $form) {
			foreach ($form->getErrors() as $error) {
				$this->flashMessage($error, 'error');
			}
		};
		$form->onSuccess[] = function(Form $form, ArrayHash $values) {
			$this->uploadRepository->create($values);
            $this->redirect(':default');
		};
		return $form;
	}
    
    	/**
	 * @param int $id
	 * @throws RecordNotFoundException
	 */
	public function handleMovePrev(int $id): void
	{
		$this->uploadRepository->decreaseSortIdById($id);
		$this->redrawControl('uploads');
	}

	/**
	 * @param int $id
	 * @throws RecordNotFoundException
	 */
	public function handleMoveNext(int $id): void
	{
		$this->uploadRepository->increaseSortIdById($id);
		$this->redrawControl('uploads');
	}

	/**
	 * @param int $id
	 * @throws AbortException
	 * @throws RecordNotFoundException
	 */
	public function handleRemoveUpload(int $id): void
	{
		$vis = $this->uploadRepository->findOneById($id);
		$uploadId = $vis->getId();

		$this->uploadRepository->remove($vis);
		$this->flashMessage('Vizualizace byla úspěšně odstraněna.', 'success');
        $this->redrawControl('uploads');
	}

	/**
	 */
	private function fetchUploadsList(): void
	{
		$this->template->uploads = $this->uploadRepository->findAll();
	}

	/**
	 * @param int $id
	 * @throws AbortException
	 * @throws RecordNotFoundException
	 */
	public function actionRemove(int $id): void
	{
		$upload = $this->uploadRepository->findOneById($id);
		$this->uploadRepository->remove($upload);

		$this->flashMessage('Soubor byl úspěšně odstraněn.');
		$this->redirect(':default');
	}
    
    /**
	 * @param int $id
	 * @throws AbortException
	 * @throws RecordNotFoundException
	 */
	public function handleRemove($pid): void
	{
	    $upload = $this->uploadRepository->findOneById((int)$pid);
        $uploadId = $upload->getId();
		$this->uploadRepository->remove($upload);

		$this->flashMessage('Prvek byl úspěšně odstraněn.');
		$this->redrawControl('uploads');
	}
}
