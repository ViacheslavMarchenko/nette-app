<?php

use Latte\Runtime as LR;

/** source: /var/www/html/app/Presenters/../../templates/Admin/Users/default.latte */
final class Template2e50414814 extends Latte\Runtime\Template
{
	protected const BLOCKS = [
		0 => ['toolbar' => 'blockToolbar', 'content' => 'blockContent'],
		'snippet' => ['services' => 'blockServices'],
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
		$this->renderBlock('content', get_defined_vars()) /* line 12 */;
		return get_defined_vars();
	}


	public function prepare(): void
	{
		extract($this->params);
		if (!$this->getReferringTemplate() || $this->getReferenceType() === "extends") {
			foreach (array_intersect_key(['item' => '30'], $this->params) as $ʟ_v => $ʟ_l) {
				trigger_error("Variable \$$ʟ_v overwritten in foreach on line $ʟ_l");
			}
		}
		Nette\Bridges\ApplicationLatte\UIRuntime::initialize($this, $this->parentName, $this->blocks);
		
	}


	/** {block toolbar} on line 1 */
	public function blockToolbar(array $ʟ_args): void
	{
		extract($this->params);
		extract($ʟ_args);
		unset($ʟ_args);
		if ($user->isAllowed("users", "create")) /* line 2 */ {
			echo '	<li>
		<a class="bgcH-grey-100 c-grey-700" href="';
			echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Users:create")) /* line 4 */;
			echo '">
			<i class="ti-plus mR-10"></i>
			<span style="position: relative; top: -3px">Přídat užívatele</span>
		</a>
	</li>
';
		}
		
	}


	/** {block content} on line 12 */
	public function blockContent(array $ʟ_args): void
	{
		extract($this->params);
		extract($ʟ_args);
		unset($ʟ_args);
		echo '	<div class="container-fluid">
		<h4 class="c-grey-900 mT-10 mB-30">Příspěvky</h4>
        
';
		$this->createTemplate('../_parts/search.latte', $this->params, 'include')->renderToContentType('html') /* line 16 */;
		echo '        
		<div class="row">
			<div class="col-md-12">
				<table class="table bgc-white bd">
					<thead>
						<tr>
							<th scope="col">Jméno</th>
                            <th scope="col">E-mail</th>
							<th scope="col">Role</th>
                            <th scope="col" class="d-flex justify-content-end">Akce</th>
						</tr>
					</thead>
					<tbody';
		echo ' id="' . htmlspecialchars($this->global->snippetDriver->getHtmlId('services')) . '"';
		echo '>
';
		$this->renderBlock('services', [], null, 'snippet');
		echo '					</tbody>
                    <tfoot>
                        <tr>
                            <td>
                                <div class="pagination">
';
		if (!$paginator->isFirst()) /* line 46 */ {
			echo '                                		<a href="';
			echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("default", [1])) /* line 47 */;
			echo '">První</a>
                                		&nbsp;|&nbsp;
                                		<a href="';
			echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("default", [$paginator->page-1])) /* line 49 */;
			echo '">Předchozí</a>
                                		&nbsp;|&nbsp;
';
		}
		echo '                                
                                	Stránka ';
		echo LR\Filters::escapeHtmlText($paginator->getPage()) /* line 53 */;
		echo ' z ';
		echo LR\Filters::escapeHtmlText($paginator->getPageCount()) /* line 53 */;
		echo '
                                
';
		if (!$paginator->isLast()) /* line 55 */ {
			echo '                                		&nbsp;|&nbsp;
                                		<a href="';
			echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("default", [$paginator->getPage() + 1])) /* line 57 */;
			echo '">Další</a>
                                		&nbsp;|&nbsp;
                                		<a href="';
			echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("default", [$paginator->getPageCount()])) /* line 59 */;
			echo '">Poslední</a>
';
		}
		echo '                                </div>
                            </td>
                        </tr>
                    </tfoot>
				</table>
			</div>
		</div>
	</div>';
	}


	/** {snippet services} on line 29 */
	public function blockServices(array $ʟ_args): void
	{
		extract($this->params);
		extract($ʟ_args);
		unset($ʟ_args);
		$this->global->snippetDriver->enter("services", 'static');
		try {
			$iterations = 0;
			foreach ($users as $item) /* line 30 */ {
				echo '						<tr>
							<td><a href="';
				echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Users:edit", [$item->getId()])) /* line 31 */;
				echo '">';
				echo LR\Filters::escapeHtmlText($item->getName()) /* line 31 */;
				echo '</a></td>
                            <td><a href="mailto:';
				echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($item->getEmail())) /* line 32 */;
				echo '">';
				echo LR\Filters::escapeHtmlText($item->getEmail()) /* line 32 */;
				echo '</a></td>
							<td>';
				echo LR\Filters::escapeHtmlText($item->getRole()) /* line 33 */;
				echo '</td>
                            <td class="d-flex justify-content-end">
                                <a class="btn btn-sm btn-primary" href="';
				echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Users:edit", [$item->getId()])) /* line 35 */;
				echo '"><i class="fa fa-pencil fa-fw"></i> Upravit</a>
';
				if ($user->isAllowed("users", "create") && $user->id != $item->getId()) /* line 36 */ {
					echo '								<a href="#" data-id="';
					echo LR\Filters::escapeHtmlAttr($item->getId()) /* line 37 */;
					echo '" class="item-remove btn btn-sm btn-danger ms-2"><i class="fa fa-trash fa-fw"></i> Odstranit</a>
';
				}
				echo '							</td>
						</tr>
';
				$iterations++;
			}
		}
		finally {
			$this->global->snippetDriver->leave();
		}
		
	}

}
