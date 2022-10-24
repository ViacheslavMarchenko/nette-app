<?php

use Latte\Runtime as LR;

/** source: /var/www/html/templates/Front/_parts/scripts.latte */
final class Template57023807d8 extends Latte\Runtime\Template
{

	public function main(): array
	{
		extract($this->params);
		echo '<script type="text/javascript">
$(document).ready(function () {
    var h = $("header").height() + parseInt($("header").css("padding-top")) * 2 + $("footer").height() + parseInt($("footer").css("padding-top")) * 2;
    $("#content").css("min-height", "calc(100vh - " + h + "px)");
    
    f_marginPageRight();
    f_Page_carousel();
    f_Portfolio_image();
    f_Portfolio_blocks();
    
    if ($(".circle").length > 0)
        $(".circle").lettering();
    
    $( window ).resize(function() {
        f_marginPageRight();
    });
})

function f_Portfolio_image() {
    $(".portfolio-item").each(function(){
        var w = $(this).find("img").width();
        var h = $(this).find("img").height();
    
        if (w > h)
            $(this).addClass("m-100")
        else
            $(this).addClass("m-50")
    })
}

function f_Portfolio_blocks() {
    if ($("#portfolio").length > 0) {
        var sizeWindowArray = [780,1200,1900,2600];
        var sizeWindow = [];
        var col = 2;
        
';
		if (isset($column)) /* line 37 */ {
			echo '            col = parseInt(';
			echo LR\Filters::escapeJs($column) /* line 38 */;
			echo ');
';
		}
		echo '        
        for (var i = 0; i < col; i++) {
            sizeWindow.push(sizeWindowArray[i]);
        }
        
        JSBrick(\'portfolio\').brick({
    		col:col,
            sizeWindow:sizeWindow.join(","),
            classPadding:0,
    		wrapMargin:30,
    		wrapPadding:0,
    		showTime:1000,
            thisClass: "item",
            afterLoad: function() {
                $(".portfolio-item").css({"opacity": 0}).each(function() {
                    var self = this;
                    var countBlockTop = $(this).offset().top;
                    var windowHeight = window.innerHeight;
                    var show = true;
                
                    if(show && (countBlockTop < $(window).scrollTop() + windowHeight)){ 
                        $(self).animate({"opacity": 1}, 1000)
                    }
                
                    $(window).scroll( function (){
                        if(show && (countBlockTop < $(window).scrollTop() + windowHeight)){ 
                            setTimeout(function(){
                                $(self).animate({"opacity": 1}, 1000)
                            },500)
                        }
                    })
                })
            }
    	})
     }
}

function f_marginPageRight() {
    var width = $("header .container").css("margin-right");
    console.log(width)
    $(".page-right > div").css("margin-right", width);
}

function f_Page_carousel() {
    //if ( $(window).width() < 576 ) {
        if ($(".media-carousel-wrapper").length > 0) {
            
            new Fiveslider(".media-carousel-wrapper", {
                slider:\'.media-items\',
                animateTime: 1000,
                autoTimer: 15000,
                bullets: false,
                border: 0,
                arrows: true,
                auto: true,
                number: 1,
                carousel: true,
                bulletsClass: "media-carousel-bullets",
            })
        }
    //}
}

$(function () {
    $.nette.init();

    $.nette.ext(\'bs-modal\', {
        before: function (xhr, settings) {
            //document.getElementById(\'loader\').classList.remove(\'fadeOut\');
    	},
        
		init: function() {
			// if the modal has some content, show it when page is loaded
			var $modal = $(\'#modal\');
			if ($modal.find(\'.modal-content\').html().trim().length !== 0) {
				$modal.modal(\'show\');
			}
		},
        
		success: function (jqXHR, status, settings) {
		    if (typeof settings.responseJSON === \'undefined\') {
		      return;
		    }
			if (typeof settings.responseJSON.snippets != \'undefined\') {
				var $snippet_modal = settings.responseJSON.snippets[\'snippet--modal\'];
			}
            
            if ($snippet_modal) {
    			var $modal = $(\'#modal\');
                
    			if ($modal.find(\'.modal-content\').html().trim().length !== 0) {
    				$modal.modal({
                        \'backdrop\': \'static\',
                        \'keyboard\': false,
                        \'show\': true
                    });
    			} else {
    				$modal.modal(\'hide\');
    			}
                
                $(".modal-edit-class .media-close").click(function() {
                    
                })
            }
            
            loader();
		}
	});
});

</script>';
		return get_defined_vars();
	}


	public function prepare(): void
	{
		extract($this->params);
		Nette\Bridges\ApplicationLatte\UIRuntime::initialize($this, $this->parentName, $this->blocks);
		
	}

}
