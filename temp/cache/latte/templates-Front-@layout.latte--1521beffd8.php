<?php

use Latte\Runtime as LR;

/** source: /var/www/html/app/Presenters/../../templates/Front/@layout.latte */
final class Template1521beffd8 extends Latte\Runtime\Template
{
	protected const BLOCKS = [
		['webtitle' => 'blockWebtitle'],
	];


	public function main(): array
	{
		extract($this->params);
		echo '<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    
    <meta property="og:type" content="service">
    <meta property="og:locale" content="cs_CZ">
    <meta property="og:site_name" content="Five-photos">
';
		if ($this->hasBlock("fbmeta")) /* line 10 */ {
			$this->renderBlock('fbmeta', [], 'html') /* line 11 */;
		}
		else /* line 12 */ {
			echo '    <meta property="og:title" content="Nubium Test">
';
		}
		echo '    
    <link rel="stylesheet" type="text/css" href="';
		echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($baseUrl)) /* line 16 */;
		echo '/assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="';
		echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($baseUrl)) /* line 17 */;
		echo '/assets/css/awesome.css">
    <link rel="stylesheet" type="text/css" href="';
		echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($baseUrl)) /* line 18 */;
		echo '/assets/css/styles.css?v=';
		echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl(rand())) /* line 18 */;
		echo '">
    <link rel="stylesheet" type="text/css" href="';
		echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($baseUrl)) /* line 19 */;
		echo '/assets/css/mediaq.css?v=';
		echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl(rand())) /* line 19 */;
		echo '">
    
    <script type="text/javascript" src="';
		echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($baseUrl)) /* line 21 */;
		echo '/assets/js/jquery.js"></script>

    <link rel="icon" type="image/x-icon" href="';
		echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($baseUrl)) /* line 23 */;
		echo '/assets/img/favicon.ico">
    <title>Nubium Test | ';
		if ($this->getParentName()) {
			return get_defined_vars();
		}
		$this->renderBlock('webtitle', get_defined_vars()) /* line 24 */;
		echo '</title>
    
    <style>
        .loader {
            background: #ffffff;
            position: fixed;
            width: 100%;
            height: 100%;
            z-index: 99999;
            opacity: 1;
            visibility: visible;
            
            -webkit-transition: all 0.5s ease-in-out;
            transition: all 0.5s ease-in-out;
        }
        .loader.loaded {
            opacity: 0;
            visibility: hidden;
        }
        .loader.loaded1 {
            opacity: 1;
            visibility: visible;
            background: transparent;;
        }
		@keyframes ldio-xn75l8zffj {
            0% { transform: translate(-50%,-50%) rotate(0deg); }
            100% { transform: translate(-50%,-50%) rotate(360deg); }
        }

        .ldio-xn75l8zffj div {
            position: absolute;
            width: 60%;
            height: 60%;
            border: 10px solid var(--bs-primary);
            border-top-color: #fff;
            border-radius: 50%;
        }

        .ldio-xn75l8zffj div {
            animation: ldio-xn75l8zffj 1s linear infinite;
            top: 70px;
            left: 70px;
        }

        .loadingio-spinner-rolling {
            width: 140px;
            height: 140px;
            position: fixed;
            transform: translate(-70px, -70px);
            top: 50%;
            left: 50%;
            opacity: 0;
            visibility: hidden;

            -webkit-transition: opacity visibility 0.5s ease-in-out;
            transition: opacity visibility 0.5s ease-in-out;
        }

        .loadingio-spinner-rolling.active {
            opacity: 1;
            visibility: visible;
            z-index: 99999;
        }

        .ldio-xn75l8zffj {
            width: 100%;
            height: 100%;
            position: relative;
            backface-visibility: hidden;
            
            transform: translateZ(0) scale(1);
            transform-origin: 0 0;
        }

        .ldio-xn75l8zffj div { 
            box-sizing: content-box; 
        }
	</style>
</head>

<body>
<div class="loader">
    <div class="loadingio-spinner-rolling">
        <div class="ldio-xn75l8zffj"><div></div></div>
    </div>
</div>
<script>
    FIVEP = new fivePreloader();
    function fivePreloader() {
        var self = this;
        var _back = false;
        
        this.showPrloader = function($back = false) {
            _back = $back;
            jQuery(".loadingio-spinner-rolling").addClass("active");
            if ($back) {
                jQuery(".loader").addClass("loaded1")
            }
        }

        this.stopPrloader = function() {
            jQuery(".loadingio-spinner-rolling").removeClass("active");
            if (_back) {
                jQuery(".loader").removeClass("loaded1")
            }
        }
    }
    
    function loader(isBackTransparent = true) {
        setTimeout(function () {
            FIVEP.stopPrloader();
            
            if (isBackTransparent)
                jQuery(".loader").addClass(\'loaded\');
        }, 500);
    }
    window.addEventListener(\'load\', function load() {
        FIVEP.showPrloader();
        loader();
    });
</script>
<div id="page" class="hfeed site">
    <header class="page">
        <div class="py-3 subheader">
            <div class="container p-0">
                <div class="top d-flex py-0 py-sm-3 px-2 px-md-0 align-items-center justify-content-center">
                    <a href="/" class="d-flex align-items-center mb-0 mb-sm-2 text-decoration-none logo">
                        <span>Nubium-Test</span>
                    </a>
                    
                    <div class="navbar header-menu col-12 col-sm-auto mb-3 mb-sm-0">
                        <ul class="nav navbar-nav navbar-middle navbar-flex header-menu menu-btn-wrapper opened"> 
                           
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div id="content" class="site-content" tabindex="-1">
';
		$this->renderBlock('content', [], 'html') /* line 165 */;
		echo '    </div>

    <footer class="py-2">
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="block col-12">
                    <div class="d-flex flex-wrap py-3 align-items-center justify-content-center">
                        <a href="/" class="d-flex align-items-center mb-2 mb-sm-0 text-decoration-none">
                            Nubium-Test
                        </a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="block col-12 bottom text-center">
                    ©2022
                </div>
            </div>
        </div>
    </footer>	
</div>


<script type="text/javascript" src="';
		echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($baseUrl)) /* line 189 */;
		echo '/assets/js/jquery-ui.js"></script>
<script type="text/javascript" src="';
		echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($baseUrl)) /* line 190 */;
		echo '/assets/js/bootstrap.js"></script>
<script type="text/javascript" src="';
		echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($baseUrl)) /* line 191 */;
		echo '/assets/js/awesome.js"></script>
<script type="text/javascript" src="';
		echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($baseUrl)) /* line 192 */;
		echo '/bower_components/nette.ajax.js/nette.ajax.js"></script>
<script type="text/javascript" src="';
		echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($baseUrl)) /* line 193 */;
		echo '/assets/js/five-burger-menu.js"></script>
<script type="text/javascript" src="';
		echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($baseUrl)) /* line 194 */;
		echo '/admin-static/slimselect.js"></script>
<script type="text/javascript" src="';
		echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($baseUrl)) /* line 195 */;
		echo '/assets/js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="';
		echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($baseUrl)) /* line 196 */;
		echo '/assets/js/jquery.datetimepicker.js"></script>
<script type="text/javascript" src="';
		echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($baseUrl)) /* line 197 */;
		echo '/assets/js/jquery.fiveslider.js"></script>
<script type="text/javascript" src="';
		echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($baseUrl)) /* line 198 */;
		echo '/assets/js/jquery.fivebricks.js"></script>
<script type="text/javascript" src="';
		echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($baseUrl)) /* line 199 */;
		echo '/assets/js/jquery.lettering.js"></script>

';
		$this->createTemplate('_parts/scripts.latte', $this->params, 'include')->renderToContentType('html') /* line 201 */;
		echo '
</body>
</html>
';
		return get_defined_vars();
	}


	public function prepare(): void
	{
		extract($this->params);
		Nette\Bridges\ApplicationLatte\UIRuntime::initialize($this, $this->parentName, $this->blocks);
		
	}


	/** {block webtitle} on line 24 */
	public function blockWebtitle(array $ʟ_args): void
	{
		echo 'Praha';
	}

}
