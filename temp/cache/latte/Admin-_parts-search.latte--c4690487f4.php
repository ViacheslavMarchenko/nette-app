<?php

use Latte\Runtime as LR;

/** source: /var/www/html/templates/Admin/_parts/search.latte */
final class Templatec4690487f4 extends Latte\Runtime\Template
{

	public function main(): array
	{
		extract($this->params);
		echo '<div class="row">
	<div class="col-md-12">
		<div class="bgc-white p-20 bd">
			<div class="row justify-content-end">
				<div class="col-md-6">
                    ';
		echo Nette\Bridges\FormsLatte\Runtime::renderFormBegin($form = $this->global->formsStack[] = $this->global->uiControl["searchForm"], ['class' => 'form-inline justify-content-end']) /* line 6 */;
		echo '
                        <div class="form-group me-sm-3 mb-2">
                            <label for="inputSearch" class="sr-only"';
		$ʟ_input = $_input = end($this->global->formsStack)["s"];
		echo $ʟ_input->getLabelPart()->addAttributes(['for' => null, 'class' => null])->attributes() /* line 8 */;
		echo '></label>
                            <input type="text" class="form-control" id="inputSearch" value="';
		echo LR\Filters::escapeHtmlAttr($s) /* line 9 */;
		echo '" placeholder="Výhledavání"';
		$ʟ_input = $_input = end($this->global->formsStack)["s"];
		echo $ʟ_input->getControlPart()->addAttributes(['type' => null, 'class' => null, 'id' => null, 'value' => null, 'placeholder' => null])->attributes() /* line 9 */;
		echo '>
                        </div>
                        <button type="submit" class="btn btn-primary mb-2">Výhledat</button>
                        <a class="btn btn-primary mb-2 ms-2" href="';
		echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("default")) /* line 12 */;
		echo '"> <i class="fas fa-brush"></i></a>
                    ';
		echo Nette\Bridges\FormsLatte\Runtime::renderFormEnd(array_pop($this->global->formsStack));
		echo '
				</div>
			</div>
		</div>
	</div>
</div>';
		return get_defined_vars();
	}


	public function prepare(): void
	{
		extract($this->params);
		Nette\Bridges\ApplicationLatte\UIRuntime::initialize($this, $this->parentName, $this->blocks);
		
	}

}
