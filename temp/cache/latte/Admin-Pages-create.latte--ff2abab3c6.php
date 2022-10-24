<?php

use Latte\Runtime as LR;

/** source: /var/www/html/app/Presenters/../../templates/Admin/Pages/create.latte */
final class Templateff2abab3c6 extends Latte\Runtime\Template
{
	protected const BLOCKS = [
		0 => ['content' => 'blockContent', 'modal-edit-class' => 'blockModal_edit_class', 'modal-edit-title' => 'blockModal_edit_title', 'modal-edit-body' => 'blockModal_edit_body', 'modal-edit-footer' => 'blockModal_edit_footer'],
		'snippet' => ['featureimage' => 'blockFeatureimage'],
	];


	public function main(): array
	{
		extract($this->params);
		if ($this->getParentName()) {
			return get_defined_vars();
		}
		$this->renderBlock('content', get_defined_vars()) /* line 1 */;
		return get_defined_vars();
	}


	public function prepare(): void
	{
		extract($this->params);
		Nette\Bridges\ApplicationLatte\UIRuntime::initialize($this, $this->parentName, $this->blocks);
		
	}


	/** {block content} on line 1 */
	public function blockContent(array $ʟ_args): void
	{
		extract($this->params);
		extract($ʟ_args);
		unset($ʟ_args);
		echo '
<div class="container-fluid">
	<h4 class="c-grey-900 mT-10 mB-20">
		';
		if ($this->global->uiPresenter->isLinkCurrent("Pages:create")) {
			echo 'Nová stránka';
		}
		echo '
		';
		if ($this->global->uiPresenter->isLinkCurrent("Pages:edit")) {
			echo 'Úprava stránky';
		}
		echo '
	</h4>
                    
    ';
		echo Nette\Bridges\FormsLatte\Runtime::renderFormBegin($form = $this->global->formsStack[] = $this->global->uiControl["pageForm"], []) /* line 9 */;
		echo '
	<div class="row">
		<div class="col-md-8">
			<div class="bgc-white p-20 bd">
				<div class="row mt-4">
					<div class="col-md-12">
						<div class="form-group">
							';
		if ($ʟ_label = end($this->global->formsStack)["title"]->getLabel()) echo $ʟ_label;
		echo '
							';
		echo end($this->global->formsStack)["title"]->getControl()->addAttributes(['class' => 'form-control']) /* line 17 */;
		echo '
						</div>
					</div>
				</div>
                <div class="row mt-4">
					<div class="col-md-12">
						<div class="form-group">
							';
		if ($ʟ_label = end($this->global->formsStack)["slug"]->getLabel()) echo $ʟ_label;
		echo '
							';
		echo end($this->global->formsStack)["slug"]->getControl()->addAttributes(['class' => 'form-control']) /* line 25 */;
		echo '
						</div>
					</div>
				</div>
                <div class="row mt-4">
                    <div class="col-md-12">
						<div class="form-group">
							';
		if ($ʟ_label = end($this->global->formsStack)["content"]->getLabel()) echo $ʟ_label;
		echo '
							';
		echo end($this->global->formsStack)["content"]->getControl()->addAttributes(['class' => 'form-control tinymce']) /* line 33 */;
		echo '
						</div>
                    </div>
                </div>
            </div>
		</div>
        <div class="col-md-4">
            <div class="form-group mt-2">
                <div class="p-2 bg-warning bg-opacity-25 rounded">
                    <a class="ajax" href="';
		echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("modal!", ['edit'])) /* line 42 */;
		echo '">Přídat obrázek</a>
<div id="';
		echo htmlspecialchars($this->global->snippetDriver->getHtmlId('featureimage'));
		echo '">';
		$this->renderBlock('featureimage', [], null, 'snippet') /* line 43 */;
		echo '</div>
                </div>    
                <input type="hidden" class="future-image-id" value="';
		echo LR\Filters::escapeHtmlAttr($featureImageId) /* line 55 */;
		echo '"';
		$ʟ_input = $_input = end($this->global->formsStack)["feature_image"];
		echo $ʟ_input->getControlPart()->addAttributes(['type' => null, 'class' => null, 'value' => null])->attributes() /* line 55 */;
		echo '>
			</div>
            
';
		if ($user->isInRole('superadmin')) /* line 58 */ {
			echo '            <div class="form-group mt-4">
                <div class="row mt-4">
					<div class="col-md-12">
						<div class="form-check form-switch">
                            <label class="form-check-label" for="flexSwitchActiveInactive"';
			$ʟ_input = $_input = end($this->global->formsStack)["activeinactive"];
			echo $ʟ_input->getLabelPart()->addAttributes(['class' => null, 'for' => null])->attributes() /* line 63 */;
			echo '>Označte tuto kategorie jako aktivní nebo neaktivní</label>
							<input class="form-check-input" type="checkbox" id="flexSwitchActiveInactive"';
			$ʟ_input = $_input = end($this->global->formsStack)["activeinactive"];
			echo $ʟ_input->getControlPart()->addAttributes(['class' => null, 'type' => null, 'id' => null])->attributes() /* line 64 */;
			echo '>
						</div>
					</div>
                </div>
                
                <div class="row mt-4">
					<div class="col-md-12">
						<div class="form-check form-switch">
                            <label class="form-check-label" for="flexSwitchSitemap"';
			$ʟ_input = $_input = end($this->global->formsStack)["sitemap"];
			echo $ʟ_input->getLabelPart()->addAttributes(['class' => null, 'for' => null])->attributes() /* line 72 */;
			echo '>Přídat do mapy webu</label>
							<input class="form-check-input" type="checkbox" id="flexSwitchSitemap"';
			$ʟ_input = $_input = end($this->global->formsStack)["sitemap"];
			echo $ʟ_input->getControlPart()->addAttributes(['class' => null, 'type' => null, 'id' => null])->attributes() /* line 73 */;
			echo '>
						</div>
					</div>
                </div>
			</div>	
';
		}
		echo '            
			<div class="form-group mt-2 d-flex justify-content-end">
                ';
		echo end($this->global->formsStack)["submit"]->getControl()->addAttributes(['class' => 'btn btn-primary']) /* line 81 */;
		echo '
			</div>
        
        </div>
	</div>
    ';
		echo Nette\Bridges\FormsLatte\Runtime::renderFormEnd(array_pop($this->global->formsStack));
		echo '
</div>





';
		
	}


	/** {define modal-edit-class} on line 89 */
	public function blockModal_edit_class(array $ʟ_args): void
	{
		echo '    modal-edit-class
';
	}


	/** {define modal-edit-title} on line 92 */
	public function blockModal_edit_title(array $ʟ_args): void
	{
		echo '	Media
';
	}


	/** {define modal-edit-body} on line 95 */
	public function blockModal_edit_body(array $ʟ_args): void
	{
		echo '	Libovolný obsah modal okna
';
	}


	/** {define modal-edit-footer} on line 98 */
	public function blockModal_edit_footer(array $ʟ_args): void
	{
		echo '	<button class="btn btn-primary media-close" data-dismiss="modal" aria-label="Close">OK</button>
';
	}


	/** {snippet featureimage} on line 43 */
	public function blockFeatureimage(array $ʟ_args): void
	{
		extract($this->params);
		extract($ʟ_args);
		unset($ʟ_args);
		$this->global->snippetDriver->enter("featureimage", 'static');
		try {
			echo '                        <div class="feature-image-wrapper">
                            <div class="feature-image">
                                <img src="';
			echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($featureImageUrl)) /* line 46 */;
			echo '" width="100%">
                            </div>
                        
                        </div>
';
			if ($featureImageUrl != '') /* line 50 */ {
				echo '                            <a class="ajax future-remove" data-id="';
				echo LR\Filters::escapeHtmlAttr($featureImageId) /* line 51 */;
				echo '" onclick="f_removeFeatureImage" href="';
				echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("removeFeatureImage!")) /* line 51 */;
				echo '">Smazat obrázek</a>
';
			}
		}
		finally {
			$this->global->snippetDriver->leave();
		}
		
	}

}
