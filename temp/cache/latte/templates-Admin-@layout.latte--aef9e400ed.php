<?php

use Latte\Runtime as LR;

/** source: /var/www/html/app/Presenters/../../templates/Admin/@layout.latte */
final class Templateaef9e400ed extends Latte\Runtime\Template
{
	protected const BLOCKS = [
		0 => ['styles' => 'blockStyles', 'toolbar' => 'blockToolbar'],
		'snippet' => ['modal' => 'blockModal'],
	];


	public function main(): array
	{
		extract($this->params);
		echo '<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
	<title>Admin</title>
    
';
		if ($this->getParentName()) {
			return get_defined_vars();
		}
		$this->renderBlock('styles', get_defined_vars()) /* line 8 */;
		echo '
</head>

<body class="app ">
<div id="loader">
	<div class="spinner"></div>
</div>
<script>
    function loader() {
        const loader = document.getElementById(\'loader\');
        setTimeout(function () {
            loader.classList.add(\'fadeOut\');
            loader.style.background = \'transparent\';
        }, 100);
    }
    window.addEventListener(\'load\', function load() {
        loader();
    });
</script>
<div>
	<div class="sidebar">
		<div class="sidebar-inner bg-light">
			<div class="sidebar-logo px-3 py-1">
				<div class="">
					<div class="peer peer-greed">
						<a class="sidebar-link text-decoration-none" href="';
		echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Dashboard:")) /* line 108 */;
		echo '">
							<div class="peers ai-c fxw-nw">
								<div class="logo">
                                    <span>Administrace</span>
                                </div>
							</div>
						</a>
					</div>
					<div class="peer">
						<div class="mobile-toggle sidebar-toggle">
							<a href="" class="text-decoration-none"><i class="ti-arrow-circle-left"></i></a>
						</div>
					</div>
				</div>
			</div>
			<ul class="nav sidebar-menu scrollable">
';
		if (($user->isAllowed("full"))) /* line 124 */ {
			echo '                <li class="nav-item ';
			if ($this->global->uiPresenter->isLinkCurrent("Uploads:*")) {
				echo 'active';
			}
			echo '">
                    <a class="nav-link px-3 pt-3" href="';
			echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Uploads:")) /* line 126 */;
			echo '">
						<span class="icon-holder"><i class="fas fa-cloud-upload"></i></span>
						<span class="title">Soubory</span>
					</a>
                </li>
';
		}
		echo '                <li class="nav-item ';
		if ($this->global->uiPresenter->isLinkCurrent("Pages:*")) {
			echo 'active';
		}
		echo ' ">
                    <a class="nav-link px-3 pt-3" href="';
		echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Pages:")) /* line 133 */;
		echo '">
						<span class="icon-holder"><i class="fas fa-file-signature"></i></span>
						<span class="title">Stránky</span>
					</a>
                </li>
                <li class="nav-item ';
		if ($this->global->uiPresenter->isLinkCurrent("Users:*")) {
			echo 'active';
		}
		echo '">
                    <a class="nav-link px-3" href="';
		echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Users:")) /* line 139 */;
		echo '">
						<span class="icon-holder"><i class="fas fa-users"></i></span>
						<span class="title">Užívatele</span>
					</a>
                </li>
                <li class="nav-item ';
		if ($this->global->uiPresenter->isLinkCurrent("Options:*")) {
			echo 'active';
		}
		echo '">
';
		if (($user->isAllowed("full"))) /* line 145 */ {
			echo '                    <a class="nav-link px-3" href="';
			echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Options:")) /* line 146 */;
			echo '">
						<span class="icon-holder"><i class="fas fa-cog"></i></span>
						<span class="title">Nastavení</span>
';
		}
		echo '					</a>
				</li>
			</ul>
		</div>
	</div>
	<div class="page-container">
		<div class="header navbar">
			<div class="header-container">
                <nav class="navbar navbar-expand-lg navbar-light bg-light">

                    <div class="collapse navbar-collapse justify-content-between px-3">
                        <ul class="navbar-nav">
                            <li class="nav-item active me-3">
                                <a id="sidebar-toggle" class="sidebar-toggle" href="javascript:void(0);" onclick="f_MenuCollapse(false)"><i class="fas fa-bars"></i></a>
                            </li>
';
		if ($user->isInRole("superadmin")) /* line 165 */ {
			echo '                            <li class="nav-item px-4">
                                <a class=" text-decoration-none" target="_blank" href="';
			echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link(":Front:Homepage:")) /* line 167 */;
			echo '">
        							<i class="fas fa-desktop"></i> <span style="position: relative; top: -3px">Otevřít webové stránky</span>
        						</a>
                            </li>
';
		}
		echo '                            ';
		$this->renderBlock('toolbar', get_defined_vars()) /* line 172 */;
		echo '
                        </ul>
                        <ul class="navbar-nav align-items-center">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        							<span class="">';
		echo LR\Filters::escapeHtmlText($user->getIdentity()->name) /* line 177 */;
		echo '</span> <img class="w-25" src="';
		echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($baseUrl)) /* line 177 */;
		echo '/admin-static/assets/static/images/user.png" alt="">
        						</a>
        						<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <a class="dropdown-item" href="';
		echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link(":Admin:Users:edit", [$user->id])) /* line 180 */;
		echo '"><i class="fas fa-user-alt"></i> <span>Profil</span></a>
                                    <a class="dropdown-item" href="';
		echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("logout!")) /* line 181 */;
		echo '"><i class="fas fa-sign-out-alt"></i> <span>Odhlásit</span></a>
        						</div>
                            </li>
                        </ul>
                    </div>
                </nav>
			</div>
		</div>
		<main class="main-content bgc-grey-100">
			<div id="mainContent">
';
		$iterations = 0;
		foreach ($flashes as $flash) /* line 191 */ {
			echo '				<div';
			echo ($ʟ_tmp = array_filter(['alert', 'alert-' . ($flash->type === 'error' ? 'danger' : $flash->type)])) ? ' class="' . LR\Filters::escapeHtmlAttr(implode(" ", array_unique($ʟ_tmp))) . '"' : "" /* line 191 */;
			echo '>';
			echo LR\Filters::escapeHtmlText($flash->message) /* line 191 */;
			echo '</div>
';
			$iterations++;
		}
		$this->renderBlock('content', [], 'html') /* line 192 */;
		echo '			</div>
		</main>
		<footer class="bdT ta-c p-3 lh-0 fsz-sm bg-light"><span>Copyright © <a href="mailto:vsmarchenko@gmail.com">Five</a>, ';
		echo LR\Filters::escapeHtmlText(date('Y')) /* line 195 */;
		echo '. All rights reserved.</span></footer>
	</div>
</div>
<div class="modal fade" id="modal">
	<div class="modal-dialog">
		<div class="modal-content"';
		echo ' id="' . htmlspecialchars($this->global->snippetDriver->getHtmlId('modal')) . '"';
		echo '>
';
		$this->renderBlock('modal', [], null, 'snippet');
		echo '		</div>
	</div>
</div>

<script type="text/javascript" src="';
		echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($baseUrl)) /* line 232 */;
		echo '/assets/js/jquery.js"></script>
<script type="text/javascript" src="';
		echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($baseUrl)) /* line 233 */;
		echo '/assets/js/jquery-ui.js"></script>
<script type="text/javascript" src="';
		echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($baseUrl)) /* line 234 */;
		echo '/assets/js/bootstrap.js"></script>
<script type="text/javascript" src="';
		echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($baseUrl)) /* line 235 */;
		echo '/assets/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="';
		echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($baseUrl)) /* line 236 */;
		echo '/assets/js/awesome.js"></script>
<script type="text/javascript" src="';
		echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($baseUrl)) /* line 237 */;
		echo '/assets/js/nette.ajax.js"></script>
<script src="https://cdn.tiny.cloud/1/d2wy98hnrvg14fda939oemaw9owosh1wriq9e06hizhe3x3p/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

<script type="text/javascript">

</script>

';
		$this->createTemplate('_parts/script.latte', $this->params, 'include')->renderToContentType('html') /* line 244 */;
		echo '

</body>
</html>';
		return get_defined_vars();
	}


	public function prepare(): void
	{
		extract($this->params);
		if (!$this->getReferringTemplate() || $this->getReferenceType() === "extends") {
			foreach (array_intersect_key(['flash' => '191', 'item' => '211'], $this->params) as $ʟ_v => $ʟ_l) {
				trigger_error("Variable \$$ʟ_v overwritten in foreach on line $ʟ_l");
			}
		}
		Nette\Bridges\ApplicationLatte\UIRuntime::initialize($this, $this->parentName, $this->blocks);
		
	}


	/** {block styles} on line 8 */
	public function blockStyles(array $ʟ_args): void
	{
		extract($this->params);
		extract($ʟ_args);
		unset($ʟ_args);
		echo '	<style>
		#loader {
			transition: all .3s ease-in-out;
			opacity: 1;
			visibility: visible;
			position: fixed;
			height: 100vh;
			width: 100%;
			background: #fff;
			z-index: 90000
		}

		#loader.fadeOut {
			opacity: 0;
			visibility: hidden
		}

		.spinner {
			width: 40px;
			height: 40px;
			position: absolute;
			top: calc(50% - 20px);
			left: calc(50% - 20px);
			background-color: #333;
			border-radius: 100%;
			-webkit-animation: sk-scaleout 1s infinite ease-in-out;
			animation: sk-scaleout 1s infinite ease-in-out
		}

		@-webkit-keyframes sk-scaleout {
			0% {
				-webkit-transform: scale(0)
			}
			100% {
				-webkit-transform: scale(1);
				opacity: 0
			}
		}

		@keyframes sk-scaleout {
			0% {
				-webkit-transform: scale(0);
				transform: scale(0)
			}
			100% {
				-webkit-transform: scale(1);
				transform: scale(1);
				opacity: 0
			}
		}
		.form-errors ul {
			list-style: none;
			margin-top: 4px;
			padding-left: 0;
			font-size: 14px;
		}
		.form-checkboxes input {

			width: 26px;
			display: inline-block;
			vertical-align: middle;
			margin-bottom: 8px;
		}
		.form-checkboxes label {

			width: calc(100% - 26px);
			display: inline-block;
			vertical-align: middle;
			margin-bottom: 8px;
		}
	</style>
    <link href="';
		echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($baseUrl)) /* line 80 */;
		echo '/assets/css/awesome.css" type="text/css" rel="stylesheet">
    <link href="';
		echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($baseUrl)) /* line 81 */;
		echo '/assets/css/bootstrap.css" type="text/css" rel="stylesheet">   
	<link href="';
		echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($baseUrl)) /* line 82 */;
		echo '/admin-static/style.css" type="text/css" rel="stylesheet">
';
	}


	/** {block toolbar} on line 172 */
	public function blockToolbar(array $ʟ_args): void
	{
		
	}


	/** {snippet modal} on line 200 */
	public function blockModal(array $ʟ_args): void
	{
		extract($this->params);
		extract($ʟ_args);
		unset($ʟ_args);
		$this->global->snippetDriver->enter("modal", 'static');
		try {
			echo '			';
			if (isset($modal)) /* line 201 */ {
				echo '
				<div class="modal-header">
                    <button type="button" class="close btn-close" data-dismiss="modal" aria-label="Close"></button>
					<h4 class="modal-title">
						';
				if ($this->hasBlock("modal-$modal-title")) /* line 205 */ {
					$this->renderBlock("modal-$modal-title", [], 'html') /* line 205 */;
				}
				echo '
					</h4>
				</div>
				<div class="modal-body">
                    <div class="content">
    					<div class="row">
';
				$iterations = 0;
				foreach ($media as $item) /* line 211 */ {
					echo '                            <div class="col-md-2">
                                <div class="media-image">
                                    <img src="';
					echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($baseUrl)) /* line 214 */;
					echo '/';
					echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($item->getUrl())) /* line 214 */;
					echo '" width="100%" data-id=';
					echo LR\Filters::escapeHtmlAttrUnquoted($item->getId()) /* line 214 */;
					echo '>
                                </div>
                                <div class="media-title">
                                    ';
					echo LR\Filters::escapeHtmlText($item->getFilename()) /* line 217 */;
					echo '
                                </div>
                            </div>
';
					$iterations++;
				}
				echo '                        </div>
                    </div>
				</div>
				<div class=\'modal-footer ';
				$this->renderBlock("modal-$modal-class", [], 'htmlAttr') /* line 224 */;
				echo '\'>
';
				$this->renderBlock("modal-$modal-footer", [], 'html') /* line 225 */;
				echo '				</div>
';
			}
		}
		finally {
			$this->global->snippetDriver->leave();
		}
		
	}

}
