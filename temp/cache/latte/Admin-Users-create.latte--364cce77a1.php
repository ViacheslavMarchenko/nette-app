<?php

use Latte\Runtime as LR;

/** source: /var/www/html/app/Presenters/../../templates/Admin/Users/create.latte */
final class Template364cce77a1 extends Latte\Runtime\Template
{
	protected const BLOCKS = [
		0 => ['content' => 'blockContent'],
		'snippet' => ['pwdreload' => 'blockPwdreload'],
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
		if ($this->global->uiPresenter->isLinkCurrent("Users:create")) {
			echo 'Nový užívatel';
		}
		echo '
		';
		if ($this->global->uiPresenter->isLinkCurrent("Users:edit")) {
			echo 'Úprava užívatele';
		}
		echo '
	</h4>
                    
    ';
		echo Nette\Bridges\FormsLatte\Runtime::renderFormBegin($form = $this->global->formsStack[] = $this->global->uiControl["userForm"], []) /* line 9 */;
		echo '
	<div class="row">
		<div class="col-md-8">
			
			<div class="bgc-white p-20 bd">
				<div class="row mt-4">
					<div class="col-md-12">
						<div class="form-group">
							';
		if ($ʟ_label = end($this->global->formsStack)["name"]->getLabel()) echo $ʟ_label;
		echo '
							';
		echo end($this->global->formsStack)["name"]->getControl()->addAttributes(['class' => 'form-control']) /* line 18 */;
		echo '
						</div>
					</div>
				</div>
                <div class="row mt-4">
					<div class="col-md-12">
						<div class="form-group">
							';
		if ($ʟ_label = end($this->global->formsStack)["email"]->getLabel()) echo $ʟ_label;
		echo '
							';
		echo end($this->global->formsStack)["email"]->getControl()->addAttributes(['class' => 'form-control']) /* line 26 */;
		echo '
						</div>
					</div>
				</div>
                <div class="row mt-4">
					<div class="col-md-12">
						<div class="form-group">
							';
		if ($ʟ_label = end($this->global->formsStack)["role"]->getLabel()) echo $ʟ_label;
		echo '
							';
		echo end($this->global->formsStack)["role"]->getControl()->addAttributes(['class' => 'form-control']) /* line 35 */;
		echo '
						</div>
					</div>
				</div>
                <div class="row mt-4">
					<div class="col-md-12">
						<div class="form-group">
							';
		if ($ʟ_label = end($this->global->formsStack)["password"]->getLabel()) echo $ʟ_label;
		echo '
                            <div id="';
		echo htmlspecialchars($this->global->snippetDriver->getHtmlId('pwdreload'));
		echo '">';
		$this->renderBlock('pwdreload', [], null, 'snippet') /* line 44 */;
		echo '</div>
                            <div class="input-group">
                                <input type="text" required="" class="form-control" value="" ';
		if ($this->global->uiPresenter->isLinkCurrent("Users:create")) {
			echo 'required';
		}
		$ʟ_input = $_input = end($this->global->formsStack)["password"];
		echo $ʟ_input->getControlPart()->addAttributes(['type' => null, 'required' => null, 'class' => null, 'value' => null])->attributes() /* line 46 */;
		echo '>
                                <div class="input-group-append">
                                    <a href="#" class="btn btn-secondary pwdreload" data-char="12" type="button"><i class="fas fa-sync"></i></a>
                                </div>
                            </div>
						</div>
					</div>
				</div>
            </div>
            
			
		</div>
        <div class="col-md-4">
';
		if ($user->isInRole('superadmin')) /* line 59 */ {
			echo '            <div class="form-group mt-4">
                <div class="row mt-4">
					<div class="col-md-12">
						<div class="form-check form-switch">
                            <label class="form-check-label" for="flexSwitchActiveInactive"';
			$ʟ_input = $_input = end($this->global->formsStack)["activeinactive"];
			echo $ʟ_input->getLabelPart()->addAttributes(['class' => null, 'for' => null])->attributes() /* line 64 */;
			echo '>Označte tuto kategorie jako aktivní nebo neaktivní</label>
							<input class="form-check-input" type="checkbox" id="flexSwitchActiveInactive"';
			$ʟ_input = $_input = end($this->global->formsStack)["activeinactive"];
			echo $ʟ_input->getControlPart()->addAttributes(['class' => null, 'type' => null, 'id' => null])->attributes() /* line 65 */;
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
		echo end($this->global->formsStack)["submit"]->getControl()->addAttributes(['class' => 'btn btn-primary']) /* line 73 */;
		echo '
			</div>
        
        </div>
	</div>
    ';
		echo Nette\Bridges\FormsLatte\Runtime::renderFormEnd(array_pop($this->global->formsStack));
		echo '
</div>';
	}


	/** {snippet pwdreload} on line 44 */
	public function blockPwdreload(array $ʟ_args): void
	{
		extract($this->params);
		extract($ʟ_args);
		unset($ʟ_args);
		$this->global->snippetDriver->enter("pwdreload", 'static');
		try {
			echo '<div class="d-none newpwdreloadede">';
			if (isset($newpassword)) /* line 44 */ {
				echo LR\Filters::escapeHtmlText($newpassword) /* line 44 */;
			}
			echo '</div>';
		}
		finally {
			$this->global->snippetDriver->leave();
		}
		
	}

}
