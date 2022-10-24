<?php

declare(strict_types=1);

namespace App\Presenters\Admin;

use Nette\Application\UI\Form;
use Nette\Application\AbortException;
use App\Presenters\AbstractPresenter;
use App\Repository\OptionRepository;
use App\Forms\Admin\SearchFormFactory;
use Nette\Utils\ArrayHash;

/**
 * Class BasicPresenter
 */
trait BasicPresenter
{    
    /**
	 * @var OptionRepository @inject
	 */
	public $optionRepository;
    
    /**
	 * @var SearchFormFactory @inject
	 */
	public $searchFormFactory;
    
    
    public function handlePwdreload($count)
    {
        $data = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz![]{}()%&*$#^<>~@|';
        
        $this->template->newpassword = substr(str_shuffle($data), 0, (int)$count);
        $this->redrawControl('pwdreload');
    }
    
    /**
     */
    public function handleRemove($id) 
    {
        
    }
    
    /**
	 * @return Form
	 */
	public function createComponentSearchForm(): Form
	{
	    $form = $this->searchFormFactory->create();
        $form->onSuccess[] = function(Form $form, ArrayHash $values) {
			$this->redirect(':default', 1, $values['s']);
		};
		return $form;
	}
    
	/**
     */
    public function handleModal($modalId)
	{
	    $paginator = new \Nette\Utils\Paginator;
        $paginator->setItemCount(1);
		
        $this->template->media = $this->uploadRepository->findAll();
        $this->template->modal = $modalId;
        
		$this->redrawControl('modal');
	}
    
    /**
     */
    public function handleAddFeatureImage($id, $src) 
    {
        $this->template->featureImageUrl = $src;
        $this->template->featureImageId = $id;
        
        $this->redrawControl('featureimage');
    }
    
    /**
     */
    public function handleRemoveFeatureImage() 
    {
        $this->template->featureImageUrl = '';
        $this->template->featureImageId = 0;
        
        $this->redrawControl('featureimage');
    }
    
    /**
     * Admin panel collapsed
     */
    public function handlePanelCollapsed($collapsed)
    {
        if ((int)$collapsed == 2)
        {   
            echo (isset($_SESSION['admin_panel_collapsed']) ? $_SESSION['admin_panel_collapsed'] : "0");
        }
        else
        {
            $_SESSION['admin_panel_collapsed'] = $collapsed;
            echo $collapsed;
        }
        
        die();
    }
    
    /**
     * 
     */
    public function handleMediaFileRename($uid, $value)
    {
        $media = $this->uploadRepository->findOneById((int)$uid);
        if ($this->uploadRepository->countByNameAndPath((int)$uid, $value, $media->getFilepath()) == 0) 
        {
            $result = $this->uploadRepository->uploadService->updateFileName($media->getFilepath(), $media->getFilename(), $value);
            
            if ($result)
            {
                $this->uploadRepository->updateFilename($media, $value);
                echo json_encode(['error'=>false]);
            }
            else 
            {
                echo json_encode(['error'=>true, 'message'=>'Chyba přejmenování. Obraťte se na spravce webu.']);
            }
        }
        else 
        {
            echo json_encode(['error'=>true, 'message'=>'Soubor ze stejným jménem již existuje.']);
        }
        
        die();
    }
}