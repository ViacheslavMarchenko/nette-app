<?php

declare(strict_types=1);

namespace App\Presenters\Front;

use Nette;
use Nette\Application\UI\Form;
use Nette\Utils\ArrayHash;
use Nette\Security\AuthenticationException;
use App\Forms\SignInFormFactory;
use App\Presenters\AbstractPresenter;
use App\Model\Page;
use App\Repository\PageRepository;
use App\Repository\OptionRepository;
use App\Mail\MailFactory;

final class PagePresenter extends AbstractPresenter
{
    use BasicPresenter;
    
    /**
	 * @var PageRepository @inject
	 */
	public $pageRepository;
    
    /**
	 * @var OptionRepository @inject
	 */
	public $optionRepository;
    
    /**
	 * @var Page
	 */
    private $page;
    
	public function renderDefault($slug): void
    {
         switch ($slug)
         {
            default:
                $this->template->page = $this->page = $this->pageRepository->findOneBySlug($slug);
            break;
         }
    }
    
    public function processContactForm(Form $form)
	{
		$values = $form->getValues(true);

        $message = "Jméno: " . $values['name'] . "<br>";
        $message .= "E-mail: " . $values['email'] . "<br>";
        $message .= "Typ produktu: " . $values['product'] . "<br>";
        $message .= "Počet produktů: " . $values['count'] . "<br>";
        $message .= "Zpráva: " . $values['message'] . "<br>";
        
        $this->mailFactory::mailRequest('FivePhotos - kontaktní formulář', $message);
        
		$this->template->emailSuccessMessage = 'Zpráva byla odeslána. Budeme Vás kontaktovat do 24 hodin.';
        $this->redrawControl('success');
	}
}