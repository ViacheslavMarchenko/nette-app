<?php

use Latte\Runtime as LR;

/** source: /var/www/html/templates/Admin/@auth.latte */
final class Template330599bbdd extends Latte\Runtime\Template
{
	protected const BLOCKS = [
		0 => ['scripts' => 'blockScripts'],
		'snippet' => ['authform' => 'blockAuthform'],
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
	<style>
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
	</style> 
    <link href="';
		echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($baseUrl)) /* line 58 */;
		echo '/assets/css/awesome.css" type="text/css" rel="stylesheet">
    <link href="';
		echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($baseUrl)) /* line 59 */;
		echo '/assets/css/bootstrap.css" type="text/css" rel="stylesheet">   
	<link href="';
		echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($baseUrl)) /* line 60 */;
		echo '/admin-static/style.css" type="text/css" rel="stylesheet">
</head>
<body class="app">
<div id="loader">
	<div class="spinner"></div>
</div>
<script>
    window.addEventListener(\'load\', function load() {
        const loader = document.getElementById(\'loader\');
        setTimeout(function () {
            loader.classList.add(\'fadeOut\');
        }, 100);
    });
</script>
<div class="container-fluid">
    <div class="vh-100 row">
        <div class="col-12 col-md-4 col-lg-3 bg-light v-100 scrollable pos-r p-4">
            <div class="bgc-black bdrs-50p pos-r">
    			<div class="logo">
                    <span>Administrace</span>
                </div>
    		</div>
';
		$iterations = 0;
		foreach ($flashes as $flash) /* line 82 */ {
			echo '    		<div';
			echo ($ʟ_tmp = array_filter(['alert-flash', 'alert', 'alert-' . ($flash->type === 'error' ? 'danger' : $flash->type)])) ? ' class="' . LR\Filters::escapeHtmlAttr(implode(" ", array_unique($ʟ_tmp))) . '"' : "" /* line 82 */;
			echo '>';
			echo LR\Filters::escapeHtmlText($flash->message) /* line 82 */;
			echo '</div>
';
			$iterations++;
		}
		echo '    		<div class=" mt-4"';
		echo ' id="' . htmlspecialchars($this->global->snippetDriver->getHtmlId('authform')) . '"';
		echo '>
';
		$this->renderBlock('authform', [], null, 'snippet');
		echo '    		</div>
    
    	</div>
        
    	<div class="col-12 col-md-8 col-lg-9 scrollable">
    		<div class="pos-a centerXY">
    			
    		</div>
    	</div>
    </div>
</div>

';
		$this->renderBlock('scripts', get_defined_vars()) /* line 133 */;
		echo '
</body>
</html>';
		return get_defined_vars();
	}


	public function prepare(): void
	{
		extract($this->params);
		if (!$this->getReferringTemplate() || $this->getReferenceType() === "extends") {
			foreach (array_intersect_key(['flash' => '82'], $this->params) as $ʟ_v => $ʟ_l) {
				trigger_error("Variable \$$ʟ_v overwritten in foreach on line $ʟ_l");
			}
		}
		Nette\Bridges\ApplicationLatte\UIRuntime::initialize($this, $this->parentName, $this->blocks);
		
	}


	/** {block scripts} on line 133 */
	public function blockScripts(array $ʟ_args): void
	{
		extract($this->params);
		extract($ʟ_args);
		unset($ʟ_args);
		echo '<script type="text/javascript" src="';
		echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($baseUrl)) /* line 134 */;
		echo '/assets/js/jquery.js"></script>
<script type="text/javascript" src="';
		echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($baseUrl)) /* line 135 */;
		echo '/assets/js/nette.ajax.js"></script>
<script type="text/javascript" src="';
		echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($baseUrl)) /* line 136 */;
		echo '/assets/js/netteForms.js"></script>
<script src="https://www.google.com/recaptcha/api.js?onload=g_onRecaptchaLoad&amp;render=explicit" async defer></script>

<script>
$(function () {
    $.nette.init();
    
    $.nette.ext(\'bs-modal\', {
        before: function (xhr, settings) {
            //document.getElementById(\'loader\').classList.remove(\'fadeOut\');
    	},
        
		init: function() {
			
		},
        
		success: function (jqXHR, status, settings) {
            if (typeof settings.responseJSON === \'undefined\')
                return;
                
			if (typeof settings.responseJSON.snippets != \'undefined\') {
				var $snippet_authform = settings.responseJSON.snippets[\'snippet--authform\'];
                
                if ($snippet_authform) {
                    $(".alert-flash").remove();
                    g_onRecaptchaLoad();
                }
			}
        }
    })
    
    var clientIDs = {};

	window[\'g_onRecaptchaLoad\'] = function () {
		$(\'.g-recaptcha\').each(function () {
			var el = $(this);

			clientIDs[this.id] = grecaptcha.render(this, {
				size: \'invisible\',
				badge: \'bottomleft\',
				callback: function (token) {
					el.closest(\'form.recaptcha\').off(\'submit\').trigger(\'submit\');
				}

			}, true);
		});

		$(function () {
			$(\'form.recaptcha\').on(\'submit\', function (event) {
				event.preventDefault();

				var form = $(this);
				if (Nette.validateForm(this, true)) {
					// execute only reCAPTCHAs in submitted form
					$(\'.g-recaptcha\', form).each(function () {
						grecaptcha.execute(clientIDs[this.id]);
					});
				}
			});
		});
	};
})
</script>
';
	}


	/** {snippet authform} on line 83 */
	public function blockAuthform(array $ʟ_args): void
	{
		extract($this->params);
		extract($ʟ_args);
		unset($ʟ_args);
		$this->global->snippetDriver->enter("authform", 'static');
		try {
			echo '                ';
			if ($signform) /* line 84 */ {
				echo '
        			';
				echo Nette\Bridges\FormsLatte\Runtime::renderFormBegin($form = $this->global->formsStack[] = $this->global->uiControl["signInForm"], []) /* line 85 */;
				echo '
        				<div class="form-group">
        					';
				if ($ʟ_label = end($this->global->formsStack)["email"]->getLabel()) echo $ʟ_label->addAttributes(['class' => 'text-normal text-dark required']);
				echo '
        					';
				echo end($this->global->formsStack)["email"]->getControl()->addAttributes(['class' => 'form-control']) /* line 88 */;
				echo '
        				</div>
        				<div class="form-group mt-4">
        					';
				if ($ʟ_label = end($this->global->formsStack)["password"]->getLabel()) echo $ʟ_label->addAttributes(['class' => 'text-normal text-dark required']);
				echo '
        					';
				echo end($this->global->formsStack)["password"]->getControl()->addAttributes(['class' => 'form-control']) /* line 92 */;
				echo '
        				</div>
';
				if ($this->hasBlock("recaptcha")) /* line 94 */ {
					echo '                        <div class="form-group mt-4">
                            ';
					echo end($this->global->formsStack)["recaptcha"]->getControl() /* line 96 */;
					echo '
                            <span style=\'color:red\'>';
					echo LR\Filters::escapeHtmlText($form['recaptcha']->getError()) /* line 97 */;
					echo '</span>
                        </div>
';
				}
				echo '        				<div class="form-group mt-4">
        					<div class="peers ai-c jc-sb fxw-nw mT-30 d-flex justify-content-between align-items-center">
    							';
				echo end($this->global->formsStack)["submit"]->getControl()->addAttributes(['class' => 'btn btn-primary']) /* line 102 */;
				echo '
                                <a class="ajax" href="';
				echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("resetpassword!")) /* line 103 */;
				echo '">Zapoměl jste heslo</a>
        					</div>
        				</div>
        			';
				echo Nette\Bridges\FormsLatte\Runtime::renderFormEnd(array_pop($this->global->formsStack));
				echo "\n";
			}
			else /* line 107 */ {
				echo '                    ';
				echo Nette\Bridges\FormsLatte\Runtime::renderFormBegin($form = $this->global->formsStack[] = $this->global->uiControl["resetPassForm"], []) /* line 108 */;
				echo '
        				<div class="form-group">
        					';
				if ($ʟ_label = end($this->global->formsStack)["email"]->getLabel()) echo $ʟ_label->addAttributes(['class' => 'text-normal text-dark required']);
				echo '
        					';
				echo end($this->global->formsStack)["email"]->getControl()->addAttributes(['class' => 'form-control']) /* line 111 */;
				echo '
        				</div>
        				<div class="form-group mt-4">
        					<div class="peers ai-c jc-sb fxw-nw mT-30 d-flex justify-content-between align-items-center">
        						';
				echo end($this->global->formsStack)["submit"]->getControl()->addAttributes(['class' => 'btn btn-primary']) /* line 115 */;
				echo '
                                <a class="ajax" href="';
				echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("loginform!")) /* line 116 */;
				echo '">Login</a>
        					</div>
        				</div>
        			';
				echo Nette\Bridges\FormsLatte\Runtime::renderFormEnd(array_pop($this->global->formsStack));
				echo "\n";
			}
		}
		finally {
			$this->global->snippetDriver->leave();
		}
		
	}

}
