<?php

use Latte\Runtime as LR;

/** source: /var/www/html/app/Presenters/../../templates/Front/Homepage/default.latte */
final class Template33a01171b9 extends Latte\Runtime\Template
{
	protected const BLOCKS = [
		['content' => 'blockContent', 'fbmeta' => 'blockFbmeta'],
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
		echo "\n";
		$this->renderBlock('fbmeta', get_defined_vars()) /* line 3 */;
		echo '

<div class="carusel container-carusel container-fluid p-0">
     <div class="row m-0">
        <div class="col-12 p-0">
        ';
		echo LR\Filters::escapeHtmlText($page->getContent()) /* line 12 */;
		echo '
        </div>
    </div>
</div>';
	}


	/** {block fbmeta} on line 3 */
	public function blockFbmeta(array $ʟ_args): void
	{
		extract($this->params);
		extract($ʟ_args);
		unset($ʟ_args);
		echo '    <meta property="og:title" content="';
		echo LR\Filters::escapeHtmlAttr($page->getTitle()) /* line 4 */;
		echo '">
    <meta property="og:description" content=\'';
		echo LR\Filters::escapeHtmlAttr(($this->filters->replace)(($this->filters->striphtml)(($this->filters->slice)($page->getContent(), 0, 200)), '\n\r', ' ')) /* line 5 */;
		echo '\'>
    <meta property="og:image" content="';
		echo LR\Filters::escapeHtmlAttr($baseUrl) /* line 6 */;
		echo LR\Filters::escapeHtmlAttr($page->FeatureImage('thumb-2x1')) /* line 6 */;
		echo '">
';
	}

}
