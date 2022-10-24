<?php

use Latte\Runtime as LR;

/** source: /var/www/html/app/Presenters/../../templates/Front/Homepage/signin.latte */
final class Template0079fa3e00 extends Latte\Runtime\Template
{
	protected const BLOCKS = [
		['content' => 'blockContent'],
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
		if (!$this->getReferringTemplate() || $this->getReferenceType() === "extends") {
			foreach (array_intersect_key(['flash' => '5'], $this->params) as $ʟ_v => $ʟ_l) {
				trigger_error("Variable \$$ʟ_v overwritten in foreach on line $ʟ_l");
			}
		}
		Nette\Bridges\ApplicationLatte\UIRuntime::initialize($this, $this->parentName, $this->blocks);
		
	}


	/** {block content} on line 1 */
	public function blockContent(array $ʟ_args): void
	{
		extract($this->params);
		extract($ʟ_args);
		unset($ʟ_args);
		echo '
<div class="row mb-4 mx-0">

';
		$iterations = 0;
		foreach ($flashes as $flash) /* line 5 */ {
			echo '    <div';
			echo ($ʟ_tmp = array_filter(['alert', 'alert-' . ($flash->type === 'error' ? 'danger' : $flash->type)])) ? ' class="' . LR\Filters::escapeHtmlAttr(implode(" ", array_unique($ʟ_tmp))) . '"' : "" /* line 5 */;
			echo '>';
			echo LR\Filters::escapeHtmlText($flash->message) /* line 5 */;
			echo '</div>
';
			$iterations++;
		}
		echo '	<div class="signin mt-4 col-12 col-sm-8 offset-2 col-md-4 offset-md-4">
		';
		echo Nette\Bridges\FormsLatte\Runtime::renderFormBegin($form = $this->global->formsStack[] = $this->global->uiControl["signInForm"], []) /* line 7 */;
		echo '
            <div class="form-group">
				';
		if ($ʟ_label = end($this->global->formsStack)["email"]->getLabel()) echo $ʟ_label->addAttributes(['class' => 'text-normal text-dark required']);
		echo '
				';
		echo end($this->global->formsStack)["email"]->getControl()->addAttributes(['class' => 'form-control']) /* line 10 */;
		echo '
			</div>
			<div class="form-group mt-4">
				';
		if ($ʟ_label = end($this->global->formsStack)["password"]->getLabel()) echo $ʟ_label->addAttributes(['class' => 'text-normal text-dark required']);
		echo '
				';
		echo end($this->global->formsStack)["password"]->getControl()->addAttributes(['class' => 'form-control']) /* line 14 */;
		echo '
			</div>
';
		if ($this->hasBlock("recaptcha")) /* line 16 */ {
			echo '            <div class="form-group mt-4">
                ';
			echo end($this->global->formsStack)["recaptcha"]->getControl() /* line 18 */;
			echo '
                <span style=\'color:red\'>';
			echo LR\Filters::escapeHtmlText($form['recaptcha']->getError()) /* line 19 */;
			echo '</span>
            </div>
';
		}
		echo '			<div class="form-group mt-4">
				<div class="peers ai-c jc-sb fxw-nw mT-30 d-flex justify-content-between align-items-center">
					';
		echo end($this->global->formsStack)["submit"]->getControl()->addAttributes(['class' => 'btn btn-primary']) /* line 24 */;
		echo '
                    <a class="ajax" href="';
		echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link(":Admin:Auth:")) /* line 25 */;
		echo '">Zapoměl jste heslo</a>
				</div>
			</div>
		';
		echo Nette\Bridges\FormsLatte\Runtime::renderFormEnd(array_pop($this->global->formsStack));
		echo '
	</div>
</div>
';
	}

}
