<?php

use Latte\Runtime as LR;

/** source: /var/www/html/app/Presenters/../../templates/Admin/Pages/default.latte */
final class Templateaf479419cc extends Latte\Runtime\Template
{
	protected const BLOCKS = [
		0 => ['toolbar' => 'blockToolbar', 'content' => 'blockContent'],
		'snippet' => ['pages' => 'blockPages'],
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
		$this->renderBlock('content', get_defined_vars()) /* line 10 */;
		return get_defined_vars();
	}


	public function prepare(): void
	{
		extract($this->params);
		if (!$this->getReferringTemplate() || $this->getReferenceType() === "extends") {
			foreach (array_intersect_key(['item' => '29, 62'], $this->params) as $ʟ_v => $ʟ_l) {
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
		echo '	<li>
		<a class="bgcH-grey-100 c-grey-700" href="';
		echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Pages:create")) /* line 3 */;
		echo '">
			<i class="ti-plus mR-10"></i>
			<span style="position: relative; top: -3px">Přidat stránku</span>
		</a>
	</li>
';
	}


	/** {block content} on line 10 */
	public function blockContent(array $ʟ_args): void
	{
		extract($this->params);
		extract($ʟ_args);
		unset($ʟ_args);
		echo '	<div class="container-fluid">
		<h4 class="c-grey-900 mT-10 mB-30">Stránky</h4>
        
';
		$this->createTemplate('../_parts/search.latte', $this->params, 'include')->renderToContentType('html') /* line 14 */;
		echo '        
		<div class="row">
			<div class="col-md-12"';
		echo ' id="' . htmlspecialchars($this->global->snippetDriver->getHtmlId('pages')) . '"';
		echo '>
';
		$this->renderBlock('pages', [], null, 'snippet');
		echo '			</div>
		</div>
        
	</div>';
	}


	/** {snippet pages} on line 17 */
	public function blockPages(array $ʟ_args): void
	{
		extract($this->params);
		extract($ʟ_args);
		unset($ʟ_args);
		$this->global->snippetDriver->enter("pages", 'static');
		try {
			echo '                ';
			if (($this->filters->length)($pagesFavorites) > 0) /* line 18 */ {
				echo '
                <table class="table bgc-white bd">
                    <thead>
						<tr>
							<th scope="col">Název</th>
							<th scope="col">Poslední zmena</th>
                            <th></th>
                            <th scope="col" class="d-flex justify-content-end">Akce</th>
						</tr>
					</thead>
					<tbody>
';
				$iterations = 0;
				foreach ($pagesFavorites as $item) /* line 29 */ {
					echo '                        <tr>
							<td><a href="';
					echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Pages:edit", [$item->getId()])) /* line 30 */;
					echo '">';
					echo LR\Filters::escapeHtmlText($item->getTitle()) /* line 30 */;
					echo '</a></td>
							<td>';
					echo LR\Filters::escapeHtmlText($item->getModifydate()->format('j. n. Y - H:i')) /* line 31 */;
					echo '</td>
                            <td>
                                <a class="ajax" href="';
					echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("addFavorite!", [$item->getId()])) /* line 33 */;
					echo '">
                                    ';
					if ($item->isFavorite($user)) /* line 34 */ {
						echo '<i class="fas fa-star"></i>
                                    ';
					}
					else /* line 35 */ {
						echo '<i class="far fa-star"></i>
';
					}
					echo '                                </a>
                            </td>
                            <td class="d-flex justify-content-end">
								<a class="btn btn-sm btn-primary me-2" href="';
					echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Pages:edit", [$item->getId()])) /* line 40 */;
					echo '"><i class="fa fa-pencil fa-fw"></i> Upravit</a>
';
					if ($user->isAllowed("pages", "create")) /* line 41 */ {
						echo '								<a href="#" data-id="';
						echo LR\Filters::escapeHtmlAttr($item->getId()) /* line 42 */;
						echo '" class="item-remove btn btn-sm btn-danger ms-2"><i class="fa fa-trash fa-fw"></i> Odstranit</a>
                                
';
					}
					echo '							</td>
						</tr>
';
					$iterations++;
				}
				echo '                    </tbody>
                    <tfoot><tr><td><div class="mt-5"></div></td></tr></tfoot>
                </table>
';
			}
			if (($this->filters->length)($pages) > 0) /* line 51 */ {
				echo '                <table class="table bgc-white bd">
                    <thead>
						<tr>
							<th scope="col">Název</th>
							<th scope="col">Poslední zmena</th>
                            <th></th>
                            <th scope="col" class="d-flex justify-content-end">Akce</th>
						</tr>
					</thead>
					<tbody>
';
				$iterations = 0;
				foreach ($iterator = $ʟ_it = new LR\CachingIterator($pages, $ʟ_it ?? null) as $item) /* line 62 */ {
					echo '						<tr>
							<td><a href="';
					echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Pages:edit", [$item->getId()])) /* line 63 */;
					echo '">';
					echo LR\Filters::escapeHtmlText($item->getTitle()) /* line 63 */;
					echo '</a></td>
							<td>';
					echo LR\Filters::escapeHtmlText($item->getModifydate()->format('j. n. Y - H:i')) /* line 64 */;
					echo '</td>
                            <td>
                                <a class="ajax" href="';
					echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("addFavorite!", [$item->getId()])) /* line 66 */;
					echo '">
                                    ';
					if ($item->isFavorite($user)) /* line 67 */ {
						echo '<i class="fas fa-star"></i>
                                    ';
					}
					else /* line 68 */ {
						echo '<i class="far fa-star"></i>
';
					}
					echo '                                </a>
                            </td>
                            <td class="d-flex justify-content-end">
								<a class="btn btn-sm btn-primary me-2" href="';
					echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Pages:edit", [$item->getId()])) /* line 73 */;
					echo '"><i class="fa fa-pencil fa-fw"></i> Upravit</a>
';
					if ($user->isAllowed("pages", "create")) /* line 74 */ {
						echo '								<a href="#" data-id="';
						echo LR\Filters::escapeHtmlAttr($item->getId()) /* line 75 */;
						echo '" class="item-remove btn btn-sm btn-danger ms-2"><i class="fa fa-trash fa-fw"></i> Odstranit</a>
                                
                                
';
						if ($s == '') /* line 78 */ {
							echo '                                <a class="btn btn-sm btn-light ajax';
							if ($iterator->isFirst()) /* line 79 */ {
								echo ' disabled';
							}
							echo ' me-2" href="';
							echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("moveUp!", [$item->getId()])) /* line 79 */;
							echo '"><i class="fa fa-arrow-up fa-fw"></i></a>
								<a class="btn btn-sm btn-light ajax';
							if ($iterator->isLast()) /* line 80 */ {
								echo ' disabled';
							}
							echo '" href="';
							echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("moveDown!", [$item->getId()])) /* line 80 */;
							echo '"><i class="fa fa-arrow-down fa-fw"></i></a>
';
						}
					}
					echo '							</td>
						</tr>
';
					$iterations++;
				}
				$iterator = $ʟ_it = $ʟ_it->getParent();
				echo '					</tbody>
                    <tfoot>
                        <tr>
                            <td>
                                <div class="pagination">
';
				if (!$paginator->isFirst()) /* line 90 */ {
					echo '                                		<a href="';
					echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("default", [1])) /* line 91 */;
					echo '">První</a>
                                		&nbsp;|&nbsp;
                                		<a href="';
					echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("default", [$paginator->page-1])) /* line 93 */;
					echo '">Předchozí</a>
                                		&nbsp;|&nbsp;
';
				}
				echo '                                
                                	Stránka ';
				echo LR\Filters::escapeHtmlText($paginator->getPage()) /* line 97 */;
				echo ' z ';
				echo LR\Filters::escapeHtmlText($paginator->getPageCount()) /* line 97 */;
				echo '
                                
';
				if (!$paginator->isLast()) /* line 99 */ {
					echo '                                		&nbsp;|&nbsp;
                                		<a href="';
					echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("default", [$paginator->getPage() + 1])) /* line 101 */;
					echo '">Další</a>
                                		&nbsp;|&nbsp;
                                		<a href="';
					echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("default", [$paginator->getPageCount()])) /* line 103 */;
					echo '">Poslední</a>
';
				}
				echo '                                </div>
                            </td>
                        </tr>
                    </tfoot>
';
			}
			echo '				</table>
';
		}
		finally {
			$this->global->snippetDriver->leave();
		}
		
	}

}
