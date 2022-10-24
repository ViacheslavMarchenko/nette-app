<?php

use Latte\Runtime as LR;

/** source: /var/www/html/app/Presenters/../../templates/Admin/Auth/default.latte */
final class Template149e0063c9 extends Latte\Runtime\Template
{
	protected const BLOCKS = [
		['content' => 'blockContent'],
	];


	public function main(): array
	{
		extract($this->params);
		echo "\n";
		if ($this->getParentName()) {
			return get_defined_vars();
		}
		$this->renderBlock('content', get_defined_vars()) /* line 3 */;
		return get_defined_vars();
	}


	public function prepare(): void
	{
		extract($this->params);
		$this->parentName = '../@auth.latte';
		Nette\Bridges\ApplicationLatte\UIRuntime::initialize($this, $this->parentName, $this->blocks);
		
	}


	/** {block content} on line 3 */
	public function blockContent(array $ʟ_args): void
	{
		
	}

}
