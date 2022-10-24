<?php

use Latte\Runtime as LR;

/** source: /var/www/html/app/Presenters/../../templates/Admin/Uploads/default.latte */
final class Template12a411154f extends Latte\Runtime\Template
{
	protected const BLOCKS = [
		0 => ['toolbar' => 'blockToolbar', 'content' => 'blockContent'],
		'snippet' => ['uploads' => 'blockUploads'],
	];


	public function main(): array
	{
		extract($this->params);
		if ($this->getParentName()) {
			return get_defined_vars();
		}
		$this->renderBlock('toolbar', get_defined_vars()) /* line 1 */;
		echo '

';
		$this->renderBlock('content', get_defined_vars()) /* line 5 */;
		return get_defined_vars();
	}


	public function prepare(): void
	{
		extract($this->params);
		if (!$this->getReferringTemplate() || $this->getReferenceType() === "extends") {
			foreach (array_intersect_key(['item' => '12'], $this->params) as $ʟ_v => $ʟ_l) {
				trigger_error("Variable \$$ʟ_v overwritten in foreach on line $ʟ_l");
			}
		}
		Nette\Bridges\ApplicationLatte\UIRuntime::initialize($this, $this->parentName, $this->blocks);
		
	}


	/** {block toolbar} on line 1 */
	public function blockToolbar(array $ʟ_args): void
	{
		echo '	
';
	}


	/** {block content} on line 5 */
	public function blockContent(array $ʟ_args): void
	{
		extract($this->params);
		extract($ʟ_args);
		unset($ʟ_args);
		echo '	<div class="container-fluid">
		<h4 class="c-grey-900 mT-10 mB-30">Soubory</h4>
    </div>
    
    <div class="container-fluid">
	   <div class="row media"';
		echo ' id="' . htmlspecialchars($this->global->snippetDriver->getHtmlId('uploads')) . '"';
		echo '>
';
		$this->renderBlock('uploads', [], null, 'snippet');
		echo '		</div>
	</div>';
	}


	/** {snippet uploads} on line 11 */
	public function blockUploads(array $ʟ_args): void
	{
		extract($this->params);
		extract($ʟ_args);
		unset($ʟ_args);
		$this->global->snippetDriver->enter("uploads", 'static');
		try {
			$iterations = 0;
			foreach ($iterator = $ʟ_it = new LR\CachingIterator($uploads, $ʟ_it ?? null) as $item) /* line 12 */ {
				echo '			<div class="col-md-3">
                <div>
					<div class="col-auto" style="margin-bottom: 10px;">
						<span><div style="height: 80px; width: 80px;     
                                    background-size: contain;
                                    background-position: center;
                                    background-repeat: no-repeat; 
                                    background-image: url(';
				echo LR\Filters::escapeHtmlAttr(LR\Filters::escapeCss($baseUrl)) /* line 19 */;
				echo '/';
				echo LR\Filters::escapeHtmlAttr(LR\Filters::escapeCss($item->getFilepath())) /* line 19 */;
				echo '/';
				echo LR\Filters::escapeHtmlAttr(LR\Filters::escapeCss($item->getFilename())) /* line 19 */;
				echo ')"></div></span>
					</div>
					<div class="col">
						<strong class="media-name" data-id="';
				echo LR\Filters::escapeHtmlAttr($item->getId()) /* line 22 */;
				echo '"><span>';
				echo LR\Filters::escapeHtmlText($item->getFilename()) /* line 22 */;
				echo '</span></strong>
						<p>
                            <a href="';
				echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($baseUrl)) /* line 24 */;
				echo '/';
				echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($item->getFilepath())) /* line 24 */;
				echo '/';
				echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($item->getFilename())) /* line 24 */;
				echo '" class="text-info merge-tag" title="Ziskat Merge Tag">Zkopírovat do schránky</a>
                            <br>
							Velikost: ';
				echo LR\Filters::escapeHtmlText(($this->filters->bytes)($item->getFilesizeInMb())) /* line 26 */;
				echo '
							<br>
							<a data-id="';
				echo LR\Filters::escapeHtmlAttr($item->getId()) /* line 28 */;
				echo '" class=" item-remove text-danger" href="';
				echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link(":remove!", [$item->getId()])) /* line 28 */;
				echo '">Odstranit</a>
                            <br>
';
				if (!$iterator->first) /* line 30 */ {
					echo '                                <a class="ajax btn btn-sm btn-light" href="';
					echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("movePrev!", [$item->getId()])) /* line 31 */;
					echo '"><i class="fa fa-arrow-left fa-fw"></i></a>
';
				}
				echo '							';
				if (!$iterator->first & !$iterator->last) /* line 33 */ {
					echo ' | ';
				}
				echo "\n";
				if (!$iterator->last) /* line 34 */ {
					echo '                                <a class="ajax btn btn-sm btn-light" href="';
					echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("moveNext!", [$item->getId()])) /* line 35 */;
					echo '"><i class="fa fa-arrow-right fa-fw"></i></a>
';
				}
				echo '						</p>
					</div>
				</div>
            </div>
';
				$iterations++;
			}
			$iterator = $ʟ_it = $ʟ_it->getParent();
			echo '            
            <div class="col-md-12">
                <hr>
                <div class="mt-2">
					';
			echo Nette\Bridges\FormsLatte\Runtime::renderFormBegin($form = $this->global->formsStack[] = $this->global->uiControl["uploadForm"], []) /* line 45 */;
			echo '
                    <div class="input-group">
						<div class="form-group">
							';
			if ($ʟ_label = end($this->global->formsStack)["files"]->getLabel()) echo $ʟ_label;
			echo '
							<br>
							';
			echo end($this->global->formsStack)["files"]->getControl() /* line 50 */;
			echo '
						</div>
                    </div>
					<div class="form-group mt-4">
						';
			echo end($this->global->formsStack)["submit"]->getControl()->addAttributes(['class' => 'btn btn-primary']) /* line 54 */;
			echo '
					</div>
					';
			echo Nette\Bridges\FormsLatte\Runtime::renderFormEnd(array_pop($this->global->formsStack));
			echo '
				</div>
                <hr>
            </div>
            <table class="mt-3">
                <tr>
                    <td>
                        <div class="pagination">
';
			if (!$paginator->isFirst()) /* line 64 */ {
				echo '                        		<a href="';
				echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("default", [1])) /* line 65 */;
				echo '">První</a>
                        		&nbsp;|&nbsp;
                        		<a href="';
				echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("default", [$paginator->page-1])) /* line 67 */;
				echo '">Předchozí</a>
                        		&nbsp;|&nbsp;
';
			}
			echo '                        
                        	Stránka ';
			echo LR\Filters::escapeHtmlText($paginator->getPage()) /* line 71 */;
			echo ' z ';
			echo LR\Filters::escapeHtmlText($paginator->getPageCount()) /* line 71 */;
			echo '
                        
';
			if (!$paginator->isLast()) /* line 73 */ {
				echo '                        		&nbsp;|&nbsp;
                        		<a href="';
				echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("default", [$paginator->getPage() + 1])) /* line 75 */;
				echo '">Další</a>
                        		&nbsp;|&nbsp;
                        		<a href="';
				echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("default", [$paginator->getPageCount()])) /* line 77 */;
				echo '">Poslední</a>
';
			}
			echo '                        </div>
                    </td>
                </tr>
            </table>
';
		}
		finally {
			$this->global->snippetDriver->leave();
		}
		
	}

}
