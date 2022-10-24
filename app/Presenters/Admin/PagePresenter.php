<?php

declare(strict_types=1);

namespace App\Presenters\Admin;

use Nette;
use Nette\Application\UI\Form;
use App\Model\Page;
use App\Repository\RecordNotFoundException;
use Nette\Utils\ArrayHash;
use App\Mail\MailFactory;
use App\Presenters\AuthorizedPresenter;
use App\Forms\Admin\PageFormFactory;
use App\Repository\PageRepository;
use App\Repository\UploadRepository;
use App\Repository\OptionRepository;

class PagesPresenter extends AuthorizedPresenter
{
    use BasicPresenter;
    
    /**
	 * @var PageRepository @inject
	 */
	public $pageRepository;
    
    /**
	 * @var UploadRepository @inject
	 */
	public $uploadRepository;
    
    /**
	 * @var OptionRepository @inject
	 */
	public $optionRepository;
        
    /**
	 * @var PageFormFactory @inject
	 */
	public $pageFormFactory;
    
    /**
     * @var Post
     */
    private $page;
        
    public function renderDefault(int $page = 1, string $s = ""): void
    {
        $paginator = new Nette\Utils\Paginator;
        $paginator->setItemCount( $this->pageRepository->countRows($s) ); 
        $paginator->setItemsPerPage( (int)$this->optionRepository->get('post_per_page') ?? 16 ); 
        $paginator->setPage($page); 
        
        $this->template->pages = $this->pageRepository->findAll($paginator->getLength() + 1, $paginator->getOffset(), $s, 0);
        $this->template->pagesFavorites = $this->pageRepository->findAll($paginator->getLength() + 1, $paginator->getOffset(), "", 1);
        $this->template->paginator = $paginator;
        $this->template->s = $s;
    }	
    
	/**
	 */
	public function renderEdit(): void
	{
		$this->setView('create');
	}
    
    /**
	 * @param int $id
	 * @throws BadRequestException
	 */
	public function actionEdit(int $id): void
	{
		try {
            $this->template->page = $this->page = $this->pageRepository->findOneById($id);
            $this->template->nextId = $id;
            
            $this->template->featureImageId = $this->page->getFeatureImage();
            $this->template->featureImageUrl = $this->uploadRepository->getMediaUrlById($this->page->getFeatureImage());
		} catch (RecordNotFoundException $e) {
			throw new BadRequestException('No service was found with provided ID.');
		}
	}
    
    /**
	 */
    public function actionCreate(): void
	{
	    $this->template->featureImageId = 0;
        $this->template->featureImageUrl = '';
        $this->template->nextId = $this->pageRepository->countRows() + 1;
	}
    
    /**
	 * @param int $id
	 * @throws AbortException
	 * @throws RecordNotFoundException
	 */
	public function handleRemove($pid): void
	{
	    if ($this->user->isAllowed("pages", "delete"))
        {
    	    $page = $this->pageRepository->findOneById((int)$pid);
    		$this->pageRepository->remove($page);
    
    		$this->flashMessage('Prvek byl úspěšně odstraněn.');
        }
        else
        {
            $this->flashMessage('Nemáte práva odstraňovat stránku.', 'error');
        }
        $this->redrawControl('pages');
	}
    
    /**
	 * @param int $id
	 * @throws RecordNotFoundException
	 */
	public function handleMoveUp(int $id): void
	{
		$this->pageRepository->decreaseOrderNumberById($id);
		$this->redrawControl('pages');
	}

	/**
	 * @param int $id
	 * @throws RecordNotFoundException
	 */
	public function handleMoveDown(int $id): void
	{
		$this->pageRepository->increaseOrderNumberById($id);
		$this->redrawControl('pages');
	}
    
    
    
    public function handleAddFavorite($id): void
    {
        $this->template->favorite = $this->pageRepository->changeFavoriteAdv($id, $this->user);
        $this->redrawControl('pages');
    }
    
    /**
	 * @return Form
	 */
	public function createComponentPageForm(): Form
	{
	    $form = $this->pageFormFactory->create();
        
        if ($this->page) {
            $array = $this->page->toArray();
			$form->setDefaults($array);
		}
        
		$form->onError[] = function(Form $form) {
			foreach ($form->getErrors() as $error) {
				$this->flashMessage($error, 'error');
			}
		};
        
        $form->onSuccess[] = function(Form $form, ArrayHash $values) {
			if ($this->page) 
            {
				$updated = $this->pageRepository->update($this->page, $values);
                if ($updated)
                {
                    $this->flashMessage('Page was successfully updated.', 'success');
                }
                else
                    $this->flashMessage('This page exists.', 'error');
			} 
            else 
            {
                $this->page = $this->pageRepository->create($values);
                if ( $this->page != null )
                {
                    $this->flashMessage('Page was successfully create.', 'success');
                }
                else
                {
                    $this->flashMessage('This page exists.', 'error');
                    $this->redirect(':create');
                }
			}
            
            $this->redirect(':edit', $this->page->getId());
		};
        
		return $form;
	}
}