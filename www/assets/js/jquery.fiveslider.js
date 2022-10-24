/**
   // jquery.jscarousel.js v 3.03
   // Copyright (c) 2017-2021, Viacheslav Marchenko
   // vsmarchenko@gmail.com
	
   // Permission is hereby granted, free of charge, to any person obtaining a copy
   // of this software and associated documentation files (the "Software"), 
   // to deal in the Software to use only.
	
	-----------------------------------------------------------------------------------------
   
   ********     ******          ******
   *     **   **              **
         **   **              **           *     ****    ****   *    *   ****   *****  *
         **    *******    **  **          * *    *   *  *    *  *    *  *       *      *
         **          **       **         *   *   ****   *    *  *    *   ****   ***    *
       ****          **       **         *****   * *    *    *  *    *       *  *      *
   ******      ******           ******  *     *  *  **   ****    ****    ****   *****  *****
   
   -----------------------------------------------------------------------------------------
   
   // The above copyright notice and this permission notice shall be included in
   // all copies or substantial portions of the Software.

   // THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
   // IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
   // FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
   // AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
   // LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
   // OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
   // THE SOFTWARE.
**/


function Fiveslider(container, config, run = true) {
	this.options = $.extend({
        slider: "slider",
        
        // Вмиканная стрілок
		arrows: true,
        prev: "prev-js",
		next: "next-js",
        
        slideAlign: false,
        autoHeight: false,
        overflow: true,
        
		// Параметри слайдера
		orientation: "horizontal", // horizontal / vertical / none
        number: 1, // Кількість кадрів на слайдері в видимій частині
        period: 1,
        margin:5, // Відстань між слайдами
        index: 1, // Номер кадра, який буде показаний перший після загрузки сайта (не для опції fade)
        
        limit: -1,
        
        slideHeight:"auto", // число або "auto" 
        slideWidth:"auto", // число або "auto"
        
        animateTime: 1000, // Час анімації слайдів
        showNumberSlide:false,
        numberSlideSeparate: " / ",            
		bgImage:false, // Якщо є фонові зображення, то встановити true (функція центрує зображення для всіх браузерів).
        easing: "swing",
		
        sizeImage: "cover", 
        
		// Вмикати, якщо використовуєтсья лише як слайдер картинок (перше зображення центрується автоматично). Картинки завантажуються по мірі прокрутки слайдера
		image:false,
        preloader:true, // Прелоадер картинок або слайдера
		preloaderImage:"Loading...", // Текст або адреса картинки прелодера, наприклад, images/preloader.gif
		preloadClass: "jspreload",

		// Вмиканная булетів й їхня позиція
		bullets: true,
        bulletsClass: "bullets",
		bulletsPos: "bottom", // Вибір між users / left / top / right / bottom
        
		carousel: true,
        fade: false,
        fadeShift: 10,
        
		// Перемикання слайдів колесиком миші
		mouse: false,
        
		auto: true, // Deprecated
        autorun: true,
        autoTimer: 7000,
        direction: "right", // left/top або right/bottom
        
        //Стоп анімація при наїзді мишкою
        mouseOver:false,
        
        border: 0,
                    
		// Ручне перемикання слайдів 
		hand: false, // Переміщення слайдів мишкою
        handOffset: 100, // Величини, при зміщенні на яку йде переміщення
        
        visualLoader: true,
        
        beforeLoad:function(){return true;},
        afterResize:function(){return},
        afterLoad:function(){return true;},
        beforeScroll:function(){return true;},
        afterScroll:function(){return true;},
        afterClick:function(){return true;},
        sliderClick:function(){return true;},
    }, config);

    var self = this;
    this.container = container;
    
    this.setRun = function(r) {
        run = r;
    }
    
    this.setHeightSlide = function() {
        var maxHeight = 0;
        $(self.slider+" > li").each(function(){
            var thisH = $(self.container).height() + _pdng * 2;
            if (thisH > maxHeight) { maxHeight = thisH; }
        });
        
        return maxHeight;
    }

    this.setWidthSlide = function() {
        if (self.options.number == _countSlides || self.options.number == 1) {   
            return (($(self.container).width()) / self.options.number - self.borderWidth);
        } else {
            //return (($(self.container).width()) / self.options.number - _mrgn / (self.options.number-1) - self.borderWidth - _pdng * 2);
            return ( $(self.container).width() - _mrgn * (self.options.number -  1) ) / self.options.number  - self.borderWidth - _pdng * 2;
        }
    }
    
    this.setSliderClass = function() {
        var classes = "." + $(self.container).find(" ." + self.options.slider).attr("class").split(" ");
        
        try {
            return classes.join(".");
        } catch {
            return classes;
        }
    }
    
    this.slider = self.options.slider;
    this.borderWidth = parseInt($(self.slider+" > li").css("border-width")) * 2;
    this.prevBtn = "." + self.options.prev;
    this.nextBtn = "." + self.options.next;
    
    var _countSlides;
	var _mrgn;
    var _pdng;
    var _slideH;
    var _slideW;
    
	var _count;
    var _c = 0;
    var _checkScrool = true;
    var _arrFadeIndex = new Array();
    var _autosrollStop;
    var _beforeSlideNumber = 0;
    var _currentSlideNumber = 0;
    var _preloadClass;
    var _img = new image();
    
    this.properties = function() {
        _countSlides = (self.options.limit <= 0 ? $(self.slider+" > li").length : self.options.limit); // Кількість слайдів в слайдері
    	_mrgn = self.options.margin; //(self.options.number == 1 ? 0 : self.options.margin);
        _pdng = parseInt($(self.container).find("li").css("padding-left"));
        _slideH = (self.options.slideHeight == "auto") ? self.setHeightSlide() : self.options.slideHeight;
        _slideW = (self.options.slideWidth == "auto") ? self.setWidthSlide() : self.options.slideWidth / self.options.number;
        
    	_count = self.options.index; // Змінна, яка показує на яку скільки слайдів перемикається слайдер
        _c = 0; // Тимчасова змінна, яка показує номер поточного кадру
        _checkScrool = true;	 // Ключ, що запобігає зпрацюванню функції виконання під час переміщення кадрів
        _arrFadeIndex = new Array(); // Массив для зберігання zIndex елементів при увімкненій опції fade
        _beforeSlideNumber = 0;
        _currentSlideNumber = 0;
        _preloadClass = "."+self.options.preloadClass;
        _img = new image();
    }
    
    this.getCurrentSlideNumber = function() {
        if ( _c == _countSlides - 1)
            _currentSlideNumber = _countSlides - 1;
        else
            _currentSlideNumber = _c + _countSlides;
        
        return _currentSlideNumber;
    }
    
    this.getBeforeSlideNumber = function() {
        return _beforeSlideNumber;
    }
    
    /* BULLETS */
    this._buttonSlide;
    
    this.changeColorButton = function(_c){ // зміна кольору булетів
        $(self._buttonSlide).find("li").removeClass("active");
        
        var pos = (_c < 0) ? _countSlides : (_c + 1);
        
        if (_c >= Math.ceil(_countSlides /  self.options.index)) pos = 1;
        
        $(self._buttonSlide).find("li:nth-child("+pos+")").addClass("active")
    }
    
    this.displayBullets = function(){
        if (typeof self._buttonSlide === "undefined" ) {
            var bulletsWrapper = $("<div />")
                .addClass("bullets")
                .addClass(self.options.bulletsClass)
                .css({position:"absolute", zIndex:(_countSlides * 2), margin:0, padding:0});
            
            var bulletsUL = $("<ul />")
                .css({margin:0, padding:0})
                .appendTo(bulletsWrapper);
                
            for (var i = 0; i < Math.ceil(_countSlides / self.options.index); i++){
                $('<li></li>').appendTo(bulletsUL);
            }
			
            if (self.options.bulletsPos == "top") {
                $(self.container).prepend(bulletsWrapper);
            } else {
                $(self.container).append(bulletsWrapper);
            }
            
            self._buttonSlide = $(self.container).find(" ." + self.options.bulletsClass);
        }   
    }
    
    this.positionBullets = function() {	
		var bulletMarginLeft = parseInt($(self._buttonSlide).find("li").css("margin-left"));
        var bulletPaddingLeft = parseInt($(self._buttonSlide).find("li").css("padding-left"));
        var bulletMarginBottom = 0; //parseInt($(buttonSlide+">ul >li").css("margin-bottom"));
		var heightButton = ( $(self._buttonSlide).find("li").height() + bulletMarginBottom ) * _countSlides;
		var widthButton = ( $(self._buttonSlide).find("li").width() + (bulletMarginLeft + bulletPaddingLeft) * 2 ) * _countSlides;
        
        switch (self.options.bulletsPos){
			case "left": $(self._buttonSlide).css({left:"20px",top:"50%",marginTop:-heightButton+"px"});
			break;
				
			case "right": $(self._buttonSlide).css({right:"20px",top:"50%",marginTop:-heightButton+"px"});
			break;
				
			case "top":  
                $(self._buttonSlide).find("li").css({position:"relative","float":"left"}); 
                $(self._buttonSlide).css({left:"50%",transform:"translateX(-50%)"});
            break;
            
			case "bottom":
			    $(self._buttonSlide).find("li").css({position:"relative","float":"left"}); 
                $(self._buttonSlide).css({left:"calc(50% - " + widthButton/2 + "px)", bottom:0});
			break;
				
			case "users": "";
			break;
		}
	}
    
	this.changeSlideByClickBullet = function() {
		var checkBoolets = function() {
			var p = 0; // Аргумент, що передається функціям

			this.checkBooletsVertical = function(){
				$(self._buttonSlide).find("li").each(function(i){
					$(this).on("mousedown touchstart",function(){
						
						if (_checkScrool == false) {return false;} // Ключ, який заборняє будь-які дії під час переміщення кадрів
						
                        checkBoolets.p = Math.abs(_c - i);
						if ((_c - i) > 0){
							_c = i;
							_count = i + 2;
							self.scrollUp(checkBoolets.p);
							self.changeColorButton(_c);
						}else if ((_c - i) < 0){
							_c = i;
							_count = i;
							self.scrollDown(checkBoolets.p);

							self.changeColorButton(_c);
						}
						arrowsHideShow();
					})
				})

			},

			this.checkBooletsHorizontl = function (){
				$(self._buttonSlide).find("li").each(function(i){
					$(this).on("click mouseover",function(){
						
						if (_checkScrool == false) {return false;} // Ключ, який заборняє будь-які дії під час переміщення кадрів

						self.changeColorButton(i)
            
                        checkBoolets.p = Math.abs(_c - i);
            			if ((_c - i) > 0){
							_count = i + 2;
							_c = i;
							self.scrollLeft(checkBoolets.p * self.options.index);
						}else if ((_c - i) < 0){
							_count = i - _c;
							_c = i
							self.scrollRight(checkBoolets.p * self.options.index);
						}
						arrowsHideShow()
					})
				})
			},

			this.checkBooletsFade = function (){
				$(self._buttonSlide).find("li").each(function(i){
					$(this).on("mouseover", function(){
					    if (_c - i == 0) {return;}
                        
						if (self.options.auto){
							clearInterval(_autosrollStop);
							self.startPlay();
						}
						
						if (_checkScrool == false) {return false;} // Ключ, який заборняє будь-які дії під час переміщення кадрів

						self.changeColorButton(i);
						_count = i;
						_c = i;                                            
						self.scrollFade();
						arrowsHideShow();
					})
				})
			}
		}
		
		var check = new checkBoolets();
        self.positionBullets();
        
        switch (self.options.orientation) {
            case "horizontal": check.checkBooletsHorizontl();
            break;
            
            case "vertical": check.checkBooletsVertical();
            break;
            
            default: check.checkBooletsFade();
            break;
        }
    }
    /* BULLETS (end)) */
    
    var valueSlides = { // Функція формування кількості кадрів в видимій частині лайдера
        valueVertical: function(){
            $(self.slider+" > li").height(_slideH);
        },
        
        valueHorizontal: function(){
            if (self.options.slideHeight != "auto")
                $(self.slider+" > li").height(_slideH);
                
            $(self.slider+" > li").css({"float":"left",marginRight:_mrgn})
            $(self.slider+" > li").width(_slideW);
        }
    };
	
	var shapeNumberDiv = { // Додавання лічильника кадрів
        shapeDiv: $(self.container).append("<div class='number-of-slide' style='position:absolute;z-index:"+(_countSlides * 3)+"'></div>"),
        
        showNumberOfSlide:function (i){
            if (i == 0) i = _countSlides;
            $(self.container).find(".number-of-slide").html("<span>" + i + "</span><span>" + self.options.numberSlideSeparate + "</span><span>" +_countSlides + "</span>");
        }
    }
    
    // Контроль мобільності дотиком до екрану
    this.mobile = function(event){
	    return ((event.type === "touchstart" || event.type === "touchmove")) ? true : false;
	}
	
    this.alignHightSlide = function() {
        if ( $(window).width() < 560 ) { return; }
    
        var block_height = 0;
        
        $(self.slider+" > li").height("auto")
        $(self.slider+" > li").each(function() {
            var this_height = $(this).outerHeight();
            
            if (this_height > block_height) {
                block_height = this_height;
            }
        })
        
        $(self.slider+" > li").each(function() {
            $(this).outerHeight(block_height)
        })
    }
    
    this.destroy = function() {
        $(self.container).off();
        $(self.container).unbind();
        clearInterval(_autosrollStop);
    }
    
    this.init = function (){
        if (!run) {
            //self.resizeWindow();
            return;
        }
        
        this.destroy();
        
        if (self.options.limit > 0) {
            for (var i = $(self.slider+" > li").length; i >= self.options.limit; i--) {
                $(self.slider+" > li").eq(i).remove();
            }
        }
        
        self.options.beforeLoad();
        self.resizeWindow();
        self.properties();
        
        if(self.options.image){
			_img = new image();
			if (self.options.preloader) {_img.preloaderToSlide()};
			_img.lazyLoad();
		}
        
        if (_countSlides <= self.options.number) {
            self.options.afterLoad();
            self.shapingSliderCarousel(false);
			return;
		} // Якщо <= {number} кадрів, то плагін припиняє роботу
        
        if(self.options.image){ self.options.number = 1 } // В каруселі з картинок завжди лише один кадр
		
        if(self.options.showNumberSlide){
            shapeNumberDiv.shapeDiv;
            shapeNumberDiv.showNumberOfSlide(_c+1);
        }
        
        if (self.options.fade) {
            shapingSliderFade(); 
            self.options.orientation = "none";
            //self.options.carousel = true; 
			self.options.number = 1
        } else {
            self.shapingSliderCarousel();
        }
		
		if(self.options.bgImage){
            $(self.slider+" > li").each(function(){
                $(this).css({backgroundSize:self.options.sizeImage, 'background-repeat': 'no-repeat', 'background-position':'center'})
                var bg = $(this).css('background-image');
                bg = bg.replace('url(','').replace(')','').replace(/\"/gi, "");
                $(this).css({"filter":"progid:DXImageTransform.Microsoft.AlphaImageLoader(src='"+bg+"', sizingMethod='scale')"})
            })
        }  
        
        if(!self.options.carousel) {$(self.slider).find(self.prevBtn).hide(); self.options.auto = false} // Якщо карусель вимкнення, то автопрогравання вимкнене
		if(self.options.hand && !self.options.fade){motionAction();} // Якщо увімкнене ручне керування кадрів, то автопрогравання вимкнене
        if(!self.options.auto) { 
            self.options.mouseOver = false;
        } 
        
        if (self.options.autorun) { 
            self.startPlay();
        } else {
            $(self.slider).hide();
        }
        
        if(self.options.mouse && !self.options.fade){mouseScroll();} // Перемикання слайдера колесиком миші
        
        if(self.options.arrows){
            if ($(self.container).find(".five-arrows").length == 0) {
                var arrows = $("<div class='five-arrows'></div>").appendTo($(self.container));
                $("<div class='" + self.options.prev + "'></div>").appendTo(arrows);
                $("<div class='" + self.options.next + "'></div>").appendTo(arrows);
                self.actionChangeSlideByClickArrows();
                arrowsHideShow();
            }
        } 
        
        if (self.options.mouseOver) {
            $(self.slider).parent().parent().on("mouseover", function(){
                $(self.slider).clearQueue().stop();
                clearInterval(_autosrollStop);
            }).on("mouseout", function(){
                _checkScrool = true
                self.startPlay();
            })
        }

        if (self.options.slideAlign) {
            self.alignHightSlide();
        }
        
        if (self.options.orientation == "horizontal") {
            //$(self.selector).width(_slideW * self.options.number)
        } else {    
            //$(self.selector).height(_slideH);
        }
        
        if (self.options.autoHeight) self.heightSliderBySlide(0);
        
        self.options.afterLoad();
        
        if(self.options.bullets) { // Перемикання слайдів кліками на булети
            self.changeColorButton(_c);
            self.changeSlideByClickBullet();
        }; 
    } 
    
    this.resizeWindow = function() {
        var windowWidth = $(window).width();
        
        $(window).resize(function () {
            if (!run) {
                return;
            }
            
            if ($(window).width() == windowWidth) {
                windowWidth = $(window).width();
                return;
            }
            
            self.options.beforeLoad();
            self.options.afterResize();
            
            _c = 0;
            
            _slideH = (self.options.slideHeight == "auto") ? self.setHeightSlide() : self.options.slideHeight;
            _slideW = (self.options.slideWidth == "auto") ? self.setWidthSlide() : self.options.slideWidth / self.options.number;
            
            if (self.options.orientation != "none") {
                $(self.slider).css({left:(-(_slideW + self.borderWidth + _mrgn + _pdng * 2) * _countSlides)+"px"});
                $(self.slider).width((_slideW + self.borderWidth + _mrgn + _pdng * 2) * _countSlides * _countSlides * _countSlides); // Додавання копій слайдів зправа й зліва
            }
                        
            $(self.slider+" > li").width(_slideW);
            
            if(self.options.bullets) { 
                self.changeColorButton(_c);
                self.changeSlideByClickBullet();
            }
            if (self.options.autoHeight) self.heightSliderBySlide(0);
                
            windowWidth = $(window).width();
        })  
    }
    
    this.visualLoader = function() {
        console.log(1)
        if (self.options.visualLoader) {
            /*$(self.slider).parent().find(".five-slide-loader").remove();
        
            $("<div class='five-slide-loader'></div>").insertAfter(self.slider);
            $(self.slider).parent().find(".five-slide-loader").addClass("active");
            */
        }
    }
    // UPDATE wp_options SET option_value = REPLACE(option_value, 'http://test.startmedia.cz/subdom/test', 'https://www.heyduk.cz')
    this.heightSliderBySlide = function(_c) {
        var h = 0;
        var index = (_c == _countSlides-1 ? -1 : _c);
        
        for (var i = 0; i < self.options.number; i++) {
            var curH = 0;
            
            if (!self.options.autoHeight) {
                curH = $(self.slider+" > li").eq( _countSlides + index + i).height() + _pdng * 2;
            } else {
                curH = $(self.slider+" > li").eq(_c + i).height() + _pdng * 2
            }
            
            if (h < curH) {
                h = curH;
            }
        }
        
        $(self.slider).animate({height: h}, 300);
    }
	
    this.shapingSliderCarousel = function(carousel) { // Формування слайдера
        if (typeof carousel === "undefined") {
            carousel = true;
        }
        
        if (carousel) {
            $(self.slider+" > li").clone().slice(0, _countSlides).appendTo($(self.slider));
            $(self.slider+" > li").clone().slice(0, _countSlides).appendTo($(self.slider));
    
            if(self.options.orientation == "vertical"){
                valueSlides.valueVertical();
                console.log(_slideH +" "+ self.borderWidth+" "+_mrgn + " " +_pdng)
    			$(self.slider).css({top:(-(_slideH + self.borderWidth + _mrgn + (_pdng * 2)) * _countSlides) + "px"}); 
            } else if(self.options.orientation == "horizontal"){
                valueSlides.valueHorizontal();
                $(self.slider).css({left:(-(_slideW + self.borderWidth + _mrgn + (_pdng * 2)) * _countSlides) + "px"});
                $(self.slider).width((_slideW + _pdng) * _countSlides * _countSlides * _countSlides); 
            }
    
            if (self.options.bullets) { 
                self.displayBullets();
                self.positionBullets();
            };
        } else {
            valueSlides.valueHorizontal();
            $(self.slider).css({left:0});
            $(self.slider).width((_slideW + self.borderWidth + _mrgn + _pdng * 2) * _countSlides);
        }
    }
    
    function shapingSliderFade(){ // Формування слайдера при увікненій опції fade
        self.options.number = 1;
        
        $(self.slider+" > li").each(function(i){
            $(this).css({position:"absolute",opacity:1,top:0,left:0,zIndex:(_countSlides - i)})
            _arrFadeIndex[i] = _countSlides - i;
        })
        if (self.options.bullets) { self.displayBullets() }; 
    }

    function motionAction() {
        self.evt = false;
        motion();
    }
			
    function motion(){
        var pos = new Object;
        var f = false;
        var g = false; // Змінна для відслідковування як кнопка миши натиснута
        
        $(self.slider).css({cursor:"pointer"});
                    
        if (self.options.orientation == "horizontal"){
            motionHorizontal();
        } else if (self.options.orientation == "vertical"){
            motionVertical();
        }
        
        $(self.slider).on("mousedown touchstart", function(event){ //Запам'ятаюємо початкові дані
            if ( !_checkScrool ) return; // Ключ, що вимикає роботу слайдера при пролистуванні в данний момент часу
        	_checkScrool = false;
        	
            if(event.which == 3) {g = true; return;} // Забороняємо роботу скрипта при натиснутій правій кнопці
            if(event.which == 1 && g) {g = false; ;return;} // Забороняємо роботу скрипта при переході з правої на ліву кнопку
            
            pos.xStart = $(this).offset().left; // Права точка слайдеру
            pos.xThis = event.offsetX; // Координата Х відносно поточного слайду
            
            pos.yStart = $(this).offset().top; // Верхня точка слайдеру
            pos.yThis = event.offsetY; // Координата Y відносно поточного слайду
            
            if (self.mobile(event)){
				pos.xThis = event.originalEvent.changedTouches[0].clientX;
				pos.yThis = event.originalEvent.changedTouches[0].clientY;
			}

            if (self.options.orientation == "horizontal") {
                if (((pos.yThis - pos.yStart) <= 10 || (pos.yThis - pos.yStart) >= 10) && 
                    (pos.xThis - pos.xStart) == 0 ) return;
            }
            f = true;
            pos.t = 0;
            
            $(this).attr('unselectable','on').css('MozUserSelect','none');
            $(this).css({"user-select": "none"});
			
            return;
        })
        
        function motionHorizontal() {
            $(self.slider).on("mousemove touchmove", function(event){
                if (!f || (pos.xThis - event.offsetX) == 0) {return}; 
                
                var t = $(this).offset().left - (pos.xThis - event.offsetX); // Точка в яку передвинувся кадр
                
                if (self.mobile(event)){
                    t = $(this).offset().left - (pos.xThis - event.originalEvent.changedTouches[0].clientX);
                    pos.xThis = event.originalEvent.changedTouches[0].clientX;
				}
                	
				if (!self.options.carousel){ // відключення прокрутки першого й останнього слайдів при вимкненій каруселі
                    if ((_count == 1 && pos.t < 0) || (_count == _countSlides && pos.t > 0)){
                        t = pos.xStart;
                        f = false;
                    }
                }
                pos.t = pos.xStart - t; // Величина, на яку передвинувся кадр
				$(this).offset({left:t});
			})
            .on("mouseup touchend", function(e){
                if (!f) {return;}
                
                _checkScrool = true;
                
                /*if (pos.t === 0) {
                    self.options.sliderClick();
                    //return;
                }*/
            
                if (pos.t < 0){
                    if (Math.abs(pos.t) < self.options.handOffset){
                        _count--;
                        self.scrollRight(1,Math.abs(pos.t + _slideW + self.borderWidth + _mrgn + _pdng * 2),true);
                    } else {
                        _c = _countSlides - Math.abs(_c) - 1;
						self.scrollLeft(0,Math.abs(pos.t + _slideW + _mrgn + _pdng * 2));
                        _c = _count - 1;
                        self.changeColorButton(_c);
                    }
                }
                if (pos.t > 0){
                    if (Math.abs(pos.t) > self.options.handOffset){
                        _c = _c + 1;
                        
						self.scrollRight(1,Math.abs(pos.t));
                        _c = _count - 1;
                        self.changeColorButton(_c);
                    }else{
						_count++;
                        self.scrollLeft(0,Math.abs(pos.t - self.borderWidth),true);
                    }
                }
                
                f = false;
                arrowsHideShow();
                
				return;
            })
            
        }
        
        function motionVertical() {
            $(self.slider).on("mousemove touchmove", function(event){
                if (!f || (pos.yThis - event.offsetY) == 0) {return false} 
                
                var t = $(this).offset().top - (pos.yThis - event.offsetY); // Точка в яку передвинувся кадр
                if (self.mobile(event)){
                    t = $(this).offset().top - (pos.yThis - event.originalEvent.changedTouches[0].clientY);
                    pos.yThis = event.originalEvent.changedTouches[0].clientY;
				}
                
                if (!self.options.carousel){ // відключення прокрутки першого й останнього слайдів при вимкненій каруселі
                    if ((_count <= 1 && pos.t < 0) || (_count >= _countSlides && pos.t > 0)){
                        t = pos.yStart;
                        f = false
                    }
                }
                pos.t = pos.yStart - t; // Величина, на яку передвинувся кадр
                $(this).offset({top:t})
            })
            $(self.container).on("mouseup mouseleave touchend", function(e){
                _checkScrool = true;
                if (!f || pos.t === 0) {f = false; return false}
                
                if (pos.t < 0){
                    if (Math.abs(pos.t) > self.options.handOffset){
						if (_c == 0) _c = _countSlides - 1;
						else _c = _c - 1;
                        self.changeColorButton(_c);
						self.scrollUp(1,Math.abs(pos.t));
                    }else{
                        _count--;
                        self.scrollDown(0,Math.abs(pos.t),true);
                    }
                }
                if (pos.t > 0){
                    if (Math.abs(pos.t) < self.options.handOffset){
                        _count++;
                        self.scrollUp(1,Math.abs(pos.t - _slideH),true);
                    }else{
                        _c = _c + 1;
                        self.scrollDown(0,Math.abs(pos.t - _slideH));
						self.changeColorButton(_c);
                    }
                }
                f = false;
                arrowsHideShow()
            })
        }
    }
    
    function mouseScroll(){
        $(self.container).on('DOMMouseScroll mousewheel wheel', function(event){
            if (_checkScrool == false) {return false;} // Ключ, що вимикає роботу слайдера при пролистуванні в данний момент часу

            if(self.options.orientation == "horizontal"){
                if(event.originalEvent.deltaY > 0) {
					_c = _c + 1;
					self.scrollRight()
				}else {
					_c = _countSlides - Math.abs(_c) - 1;
					self.scrollLeft()
				}
                _c = _count - 1;
            }else if(self.options.orientation == "vertical"){
                if(event.originalEvent.deltaY > 0) {
					_c = _c + 1;
					self.scrollDown()
				}else {
					_c = _countSlides - Math.abs(_c) - 1;
					self.scrollUp()
				}
				_c = _count - 1;
            }
            self.changeColorButton(_c)
            arrowsHideShow();
            
            return false;
        });
    }

    this.startPlay = function(manual = false) {
		if (_checkScrool == false) {return false;}

        if (!self.options.autorun) {
            self.init();
            $(self.slider).show();
            if (self.options.autoHeight) self.heightSliderBySlide(0);
            self.visualLoader();
        }
        
        if (self.options.auto) {    
            _autosrollStop = setInterval(function(){
    			if (!_checkScrool) {clearInterval(this); return false;} // Ключ, що вимикає роботу слайдера при пролистуванні в данний момент часу
    			
                
                if (!self.options.auto && _c == (Math.ceil(_countSlides / self.options.index) - 1)) {
                    clearInterval(_autosrollStop);
                    return;
                }
                
                if (self.options.orientation == "horizontal") {
                    if (self.options.direction == "top" || self.options.direction == "left") {
                        _c = (_c == 0) ? (Math.ceil(_countSlides / self.options.index) - 1) : _c - 1; 
                        self.scrollLeft();
                    }
                    if (self.options.direction == "bottom" || self.options.direction == "right") {
                        _c = (_c == (Math.ceil(_countSlides / self.options.index) - 1)) ? 0 : _c + 1; 
                        self.scrollRight();
                    }                 
                } else if (self.options.orientation == "vertical") {
    				if (self.options.direction == "top" || self.options.direction == "left"){_c = (_c == 0) ? (Math.ceil(_countSlides / self.options.index) - 1) : _c - 1;  self.scrollUp()}
                    if (self.options.direction == "bottom" || self.options.direction == "right"){_c = (_c == (Math.ceil(_countSlides / self.options.index) - 1)) ? 0 : _c + 1; self.scrollDown()}
                } else if (self.options.orientation == "none") {
                    _c = _count; self.scrollFade(); 
                }
                
                self.changeColorButton(_c);
            }, self.options.autoTimer)
        }
    }
    
    function autoStop() {
        if (self.options.auto){
            clearInterval(_autosrollStop);
            self.startPlay();
        }
    }
    
    this.manualStart = function() {
        
    } 
	
    this.checkInParam = function(n, move, mouse){ // Перевірка вхідних даних
		self.n = (typeof n === "undefined") ? self.options.index : n;
		self.move = (typeof move === "undefined") ? 0 : move;
		self.mouse = (typeof mouse === "undefined") ? false : true;
	}
	
    // TO DO	
	this.scrollDown = function (n, move, mouse){
		self.checkInParam(n, move, mouse)
		if (_checkScrool){
			if (self.options.mouseOver) autoStop();
			_checkScrool = false;
			
            if (_count == _countSlides && !self.options.carousel){_checkScrool = true; return false}
			if (_count == (_countSlides + 1)) {_count = 1} //
			
            if (self.options.image) {_img.lazyLoad(_c+1)}
			
			$(self.slider).animate({top:"-="+((_slideH + self.borderWidth + _mrgn + _pdng * 2) * self.n + self.move)+"px"}, self.options.animateTime, self.options.easing, function () {
				_checkScrool = true;
				if(!self.mouse && _count == _countSlides && self.options.carousel){
					$(self.slider+" li").slice(0, _countSlides).appendTo($(self.slider))
					$(self.slider).css({top:"+="+((_slideH + self.borderWidth + _mrgn + _pdng * 2) * _countSlides) +"px"})
					_count = 0;
                    self.options.afterClick()
				}
				self.move = 0;
                
                if (self.options.showNumberSlide) {shapeNumberDiv.showNumberOfSlide(_c+1)}
                
                $(self.slider).off();
                
                if (self.options.hand) motionAction();
                
                self.options.afterScroll();
			})
			_count++;  
		}
	}
		
    // TO DO
	this.scrollUp = function (n, move, mouse){
		self.checkInParam(n, move, mouse)

		if (_checkScrool){
			if (self.options.mouseOver) autoStop();
			_checkScrool = false;

			if (_count == 1 && !self.options.carousel){_checkScrool = true; return false}
			if (_count == 0) { _count = _countSlides } //
			
			if (self.options.image) {_img.lazyLoad(_c+1)} // Загрузка картинки якщо дощволено користувачем
			
			$(self.slider).animate({top:"+="+((_slideH + self.borderWidth + _mrgn + _pdng * 2) * self.n - self.move)+"px"}, self.options.animateTime, self.options.easing, function () {
				_checkScrool = true;
				if(!self.mouse && _count == (_countSlides - 1) && self.options.carousel ){
				    $(self.slider+" > li").slice(_countSlides, (_countSlides*2)).prependTo($(self.slider))
					$(self.slider).css({top:"-="+((_slideH + self.borderWidth + _mrgn + _pdng * 2) * _countSlides)+"px"})
					_count = _countSlides - self.n;
                    self.options.afterClick();	
				}
				self.move = 0;
                
                if(self.options.showNumberSlide) {shapeNumberDiv.showNumberOfSlide(_c+1)}
                
                $(self.slider).off();
                
                if (self.options.hand) motionAction();
                
                self.options.afterScroll();
			})
			_count--;
		}
	}
		
    this.scrollRight = function (n, move, mouse){
		self.checkInParam(n, move, mouse);
        
        if (_checkScrool){
            if (self.options.mouseOver) autoStop();
			_checkScrool = false;
            
            if (_count == Math.ceil(_countSlides /  self.options.index) && !self.options.carousel){_checkScrool = true; return false}
            if (_count >= Math.ceil(_countSlides /  self.options.index)) { _count = self.options.period - 1 } //
			
			if (self.options.image) {_img.lazyLoad(_c+1)} // Загрузка картинки якщо дозволено користувачем
            
            var index = (_c == _count - 1 ? -1 : _c);
            _beforeSlideNumber = _count + 1;
            
            self.options.beforeScroll();
            
            $(self.slider).animate({left:"-="+((_slideW + self.borderWidth + _mrgn + _pdng * 2) * self.n * self.options.period - self.move)+"px"}, self.options.animateTime, self.options.easing, function () {
                _checkScrool = true;
                if(!self.mouse && _count >= Math.ceil(_countSlides /  self.options.index) && self.options.carousel ){
                    $(self.slider+" > li").slice(_countSlides, (_countSlides * 2)).prependTo($(self.slider))
                    $(self.slider).css({left:"+="+((_slideW + self.borderWidth + _mrgn + _pdng * 2) * _countSlides)+"px"});
                    self.options.afterClick();
                }
                self.move = 0;
                if (self.options.showNumberSlide) shapeNumberDiv.showNumberOfSlide(_c+1);
                if (self.options.autoHeight) self.heightSliderBySlide(_c);
                
                $(self.slider).off();
                
                if (self.options.hand) motionAction();
                
                self.options.afterScroll();
            })
            
            _count = _count + self.options.period;
        }
    }
        
    this.scrollLeft = function (n, move, mouse){
        self.checkInParam(n, move, mouse);

        if (_checkScrool){
            if (self.options.mouseOver) autoStop();
			_checkScrool = false;
            
            if (_count == 1 && !self.options.carousel){_checkScrool = true; return false} // Ключ 
            if (_count == 1) { _count = Math.ceil(_countSlides /  self.options.index) + 1 } //
			
			if (self.options.image) {_img.lazyLoad(_c+1)} // Загрузка картинки якщо дозволено користувачем
			
            var index = (_c == _count - 1 ? -1 : _c);
            _beforeSlideNumber = _count - 1;
            
            self.options.beforeScroll();
            
            $(self.slider).animate({left:"+="+((_slideW + self.borderWidth + _mrgn + _pdng * 2) * self.n * self.options.period + self.move )+"px"}, self.options.animateTime, self.options.easing, function () {
                _checkScrool = true;
                
                if(!self.mouse && _count == self.options.number && self.options.carousel ){
                    $(self.slider+" > li").slice(0, _countSlides * 2).prependTo($(self.slider));
                    $(self.slider).css({left:"-="+((_slideW + self.borderWidth + _mrgn + _pdng * 2) * _countSlides)+"px"});
                    self.options.afterClick();
                }
                self.move = 0;
                if (self.options.showNumberSlide) shapeNumberDiv.showNumberOfSlide(_c+1);
                if (self.options.autoHeight) self.heightSliderBySlide(_c);
                
                $(self.slider).off();
                
                if (self.options.hand) motionAction();
                
                self.options.afterScroll();
            })
            
            _count = _count - self.options.period;
        }
    }
        
    this.scrollFade = function(){
        if (_checkScrool){
            if (!self.options.mouseOver) autoStop();
		
            _checkScrool = false;
            var index = 0;
            var index_highest = 0;   

            $(self.slider + " > li").each(function(i) {
                var index_current = parseInt($(this).css("zIndex"), 10);

                if(index_current > index_highest) {
                    index_highest = index_current;
                    index = i;
                }
            });

            var max = $(self.slider + " li:nth-child("+(index + 1)+")");
            
            if (_count == _countSlides) { _count = 0; _c = 0; }
            
			if (self.options.image) {_img.lazyLoad(_c+1)} // Загрузка картинки якщо дощволено користувачем
			
            var th = $(self.slider + " > li:nth-child(" + (_c + 1) + ")");
            th.css({zIndex:_countSlides});
            max.css({zIndex:(_countSlides + 1)});
            max.animate({opacity:0,left: self.options.fadeShift}, self.options.animateTime,self.options.easing,function(){
                _checkScrool = true;
                self.options.afterLoad();
                
                var j = 0;
                for (var i = _c; i > (_c - _countSlides); i--){
                    if (i <= 0) {
                        _arrFadeIndex[j++] = _countSlides - Math.abs(i);
                    }else{ _arrFadeIndex[j++] = i}
                    
                }
                $(self.slider+" > li").each(function(i){
                    if (i == _c) {
                        $(this).css({zIndex:_arrFadeIndex[i],opacity:1,left:0});
                    } else {
                        $(this).css({zIndex:_arrFadeIndex[i],opacity:0,left:0});
                    }
                })
                th.css({zIndex:(_countSlides + 1)});
                
                if (self.options.showNumberSlide) {shapeNumberDiv.showNumberOfSlide(_c+1)}
                if (self.options.autoHeight) self.heightSliderBySlide(_c);
                
                $(self.slider).off();
                
                if (self.options.hand) motionAction();
                
                self.options.afterScroll();
                self.visualLoader();                
            });
            
            _count++;
        }
    }
    
    this.actionNextSlide = function(checkArrows) {
        clearInterval(_autosrollStop);

        if (_checkScrool == false) {return false;} // Ключ, який заборняє будь-які дії під час переміщення кадрів     
                           
        if (self.options.auto && !self.options.mouseOver){
			self.startPlay();
		}

        if (checkArrows) {
            checkArrows = false;
            if (_c >= (_countSlides - 1) && self.options.carousel) {
                _c = 0;
                self.changeColorButton(_c)
            }else if (_c >= (_countSlides - 2) && !self.options.carousel) {
                _c = _countSlides - 1;
                arrowsHideShow()
                self.changeColorButton(_c)
            }else { 
                self.changeColorButton(++_c)
                arrowsHideShow()
            };
            
            switch (self.options.orientation){
                case "horizontal": self.scrollRight();
                break;
                
                case "vertical": self.scrollDown();
                break;
                
                case "none": self.scrollFade();
                break;
            }
            setTimeout(function(){checkArrows = true}, self.options.animateTime); // Вимикаємо роботу стрілок під час руху кадру
        }
        return false;
    }
    
    this.actionPrevSlide = function(checkArrows) {
        clearInterval(_autosrollStop);

        if (_checkScrool == false) {return false;} // Ключ, який заборняє будь-які дії під час переміщення кадрів
        if (self.options.auto && !self.options.mouseOver){
            self.startPlay();
		}
		
        if(checkArrows){
            checkArrows = false;
            if (_c <= 0 && self.options.carousel) {
                _c = _countSlides - 1;
                self.changeColorButton(_c)
            }else if (_c <= 1 && !self.options.carousel) {
                _c = _c - 1;
                arrowsHideShow()
                self.changeColorButton(_c)
            }else {
                _c = _c - 1;
                self.changeColorButton(_c);
                arrowsHideShow() 
            };
            
            switch (self.options.orientation){
                case "horizontal": self.scrollLeft();
                break;
                
                case "vertical": self.scrollUp();
                break;
                
                case "none": {_count = _c; self.scrollFade()};
                break;
            }
            setTimeout(function(){checkArrows = true}, self.options.animateTime); // Вимикаємо роботу стрілок під час руху кадру
        }  
        return false;
    }
    
	this.actionChangeSlideByClickArrows = function(){
		var checkArrows = true; // Запобігає зпрацюванню функції під час переміщення кадрів
        
        $(self.nextBtn).on("mousedown touchstart", function(e){
            self.actionNextSlide(checkArrows);
            return false;
        })
        
        $(self.prevBtn).on("mousedown touchstart", function(){
			self.actionPrevSlide(checkArrows);
            return false;
        })
    }
    
    function arrowsHideShow(){ // Функція, що прибирає ліву чи праву стрілки крайніх слайдів при відсутності каруселі
        if (self.options.carousel){return false;}
        
        if (_c == 0) { 
            $(self.slider).find(self.prevBtn).hide();
            $(self.slider).find(self.nextBtn).show() 
        }else if ( _c == (_countSlides - 1)) {
            $(self.slider).find(self.prevBtn).show();
            $(self.slider).find(self.nextBtn).hide()
        }
        else {
            $(self.slider).find(self.prevBtn).show();
            $(self.slider).find(self.nextBtn).show()
        }  
    }  
   
    function image() {
        var preloader = function() {
			var preText;
			if( self.options.preloaderImage.match(/(png|jpg|gif|svg)/ig) != null){
				preText = "<img src='"+options.preloaderImage+"'/>"
				
			}else{preText = self.options.preloaderImage}
			return "<div class='"+_preloadClass.slice(1)+"'>"+preText+"</div>";	
		}
        
        var preloadSetClass = function(){ // Р’РёР·РЅР°С‡Р°С”РјРѕ СЃС‚РёР»С– РґР»СЏ РїСЂРµР»РѕР°РґРµСЂР°
			var img = new Image();
			var preH;
		
			if( self.options.preloaderImage.match(/(png|jpg|gif|svg)/ig) != null){
				img.onload = function() {
					preH = this.height;
					$(_preloadClass).css({position:"relative",height:preH+"px",marginTop:(-preH/2)+"px",textAlign:"center",top:_slideH/2+"px"})
				};
				img.src = self.options.preloaderImage;
			}else {
				preH = $(_preloadClass).height()
				$(_preloadClass).css({position:"relative",height:preH+"px",marginTop:(-preH/2)+"px",textAlign:"center",top:_slideH/2+"px"})
			};
        }
		
		this.preloaderToSlide = function(){ // Р¤СѓРЅРєС†С–СЏ РІРёРІРѕРґРёС‚СЊ РїСЂРµР»РѕР°РґРµСЂ С‚Р° РЅР°Р·РЅР°С‡Р°С” СЃС‚РёР»С–
			$(self.slider+" li").append(preloader); // Р’РёР·РёРІР°С”РјРѕ РїСЂРµР»РѕР°РґРµСЂ
            preloadSetClass();  // Р’РёР·РЅР°С‡Р°С”РјРѕ СЃС‚РёР»С– РґР»СЏ РїСЂРµР»РѕР°РґРµСЂР°
		}
            
		this.lazyLoad = function(im){
			im = (im == undefined) ? 1 : im;
			im = (im == 0) ? _countSlides : Math.abs(im);// РџРѕС‚РѕС‡РЅРёР№ РЅРѕРјРµСЂ РєР°РґСЂСѓ
			
			$(self.slider+" li").css({overflow:"hidden"})
			var path = $(self.slider+" li:nth-child("+Number(im)+") img").attr("src"); // РћС‚СЂРёРјСѓС”РјРѕ Р°С‚СЂРёР±СѓС‚ src
            			
            var imageContainers = $(self.slider+" li:nth-child("+_countSlides+"n"+"+"+Number(im)+") img"); // РћС‚СЂРёРјСѓС”РјРѕ СѓСЃС– СЃРµР»РµРєС‚РѕСЂРё img
			var allConatiner = $(self.slider+" li:nth-child("+_countSlides+"n"+"+"+Number(im)+")");
			if (path != "") {imgPosition(imageContainers); return false;} // РЇРєС‰Рѕ Р°С‚СЂСѓР±СѓС‚ src РЅРµ РїСѓСЃС‚РёР№, С‚Рѕ РІРёРєРѕРЅСѓС”С‚СЊСЃСЏ Р»РёС€Рµ С„СѓРЅРєС†С–СЏ РІРёСЂС–РІРЅСЋРІР°РЅРЅСЏ	
            
			var srcImg = imageContainers.attr("data-path"); // РћС‚СЂРёРјСѓС”РјРѕ Р°С‚СЂРёР±СѓС‚ path
            
			imageContainers.attr("src",srcImg).hide()
            
            var img = new Image();
            img.onload = function() {
				setTimeout(function(){imgPosition(imageContainers); $(self.slider+" li:nth-child("+_countSlides+"n"+"+"+Number(im)+") ._preloadClass").hide();},1000);
			};
			img.src = srcImg;
		}
		
		var imgPosition = function(size){ // Р¤СѓРЅРєС†С–СЏ РІРёСЂС–РІРЅСЋРІР°РЅРЅСЏ Р·РѕР±СЂР°Р¶РµРЅРЅСЏ
			var v = $(size).width();
			var h = $(size).height();
			var k = (v / _slideW < h / _slideH) ? v / _slideW : h / _slideH; // РљРѕРµС„С–С†С–С”РЅС‚ РІС–РґРЅРѕС€РµРЅРЅСЏ СЃС‚РѕСЂС–РЅ
            var fTime = (self.options.fade) ? anTime : 500;
            
			$(size).width(v / k)
			$(size).height(h / k)
            
			$(size).css({marginTop:( (_slideH - h / k)/2 )+"px", marginLeft:( (_slideW - v / k)/2 )+"px"}).fadeIn(fTime)

		}
	}
    
    self.init();
};
