
console.log("brick")
var JSBrick = function (){
	var masonry;

	function myPlugin(t) {
		if (!(this instanceof myPlugin)) {
			return new myPlugin(t);
		}
		masonry = document.getElementById(t)
	}

	myPlugin.prototype.brick = function (options) {
		var settings = {
			thisClass:"item", // ???????? ????????
			classPadding: 10,
			col: 4,
			sizeWindow:"570, 880, 1180, 1440", // ???? ???????? ???????????? ????????? ??????? ? ? ???????? ??????? responsive, ?? ? ??????? ??????? ?? ?????? ??????????? ??????? ??? ???????????? ???????

			wrapPadding: 5, 
			wrapMargin: 10,
            border:"0px solid #777",
			showTime: 1000,
			effect: "slide", // Use "move", "fade", "slide"

			responsive:true,
			afterEvent:function(){return true;},
            afterLoad:function(){return true;} 
		}
		obj = function (a,b) { // ??'??????? ??'???? ?? ??????????? ?? ??'??? ??????? ??????????
			var c = {};
			for (var key in a) {
				if (a.hasOwnProperty(key)) {
					c[key] = key in b ? b[key] : a[key];
				}
			}
			return c;
		}
		var options = obj(settings,options) // ???????? ??'??? ??????? ?????

		var block = document.getElementsByClassName(options.thisClass); // Determine class of bricks
		
		var p = new Object();
		
		function init() {
			p = new parameters();
			setBlock();
			masonry.style.height = p.heightArray[p.determineMaxHeight(p.heightArray)] + "px"; //???????? ????????? ?????? ????????? ?????
		}

		
		function parameters(){
			var sizeWin;
			if (options.responsive){
				sizeWin = options.sizeWindow.split(",");
				this.col = options.col;
				for (var i = sizeWin.length; i > 0 ; i--){
					if(masonry.clientWidth < parseInt(sizeWin[i-1])) // Number of columns
						this.col = i; 	
				}
			}else{this.col = options.col}

            this.w = masonry.clientWidth / this.col - options.wrapMargin * (this.col - 1) / this.col;
			//this.w = (masonry.clientWidth  - options.wrapMargin * (this.col - 1)) / this.col; // Set bricks width
			this.heightArray = new Array(); 
			this.leftPosArray = new Array();

			for(i = 0; i < block.length; i++) {
				block[i].style.width = this.w - 2 * options.wrapPadding - parseInt(options.border) * 2 + "px";
                block[i].style.border = options.border;
				block[i].style.position = "absolute";
				block[i].style.padding = options.wrapPadding + "px";				
				block[i].style.overflow = "hidden";	
			}

			// set bricks on the first row 
			this.leftPosArray[0] = options.classPadding;
			for (var i = 1; i < this.col; i++) {
				this.leftPosArray.push( (this.w  + options.wrapMargin) * i + options.classPadding);
			}

			// these functions are determianting the minimum values height of columns
			this.determineMinHeight = function(array){
				var wIndex = 0;
				var wMin = array[0];
				for (var i = 0; i < array.length; i++) { 
					if (wMin > array[i]) {
						wMin = array[i]; 
						wIndex = i;
					}
				}
				return wIndex;	
			}
			// these functions are determianting the maximum values height of columns
			this.determineMaxHeight = function(array){
				var wIndex = 0;
				var wMax = array[0];
				for (var i = 0; i < array.length; i++) { 
					if (wMax < array[i]) {
						wMax = array[i]; 
						wIndex = i;
					}
				}
				return wIndex;
			}
		}

		// ??????? ????????, t - ???????,  f - ???????, ?? ??????????? ????? ?????????? ??????, v - ??????? ???????? (??'???)
		function animation(t, v, f){
			if (f == undefined) f = function(){return true}

			for (var key in v) // ??????????? ??????? ??'???
				if(t.style[key] == "") t.style[key] = 0; // ????????? ????? ??? ????????, ???? ???? ?????

			var delta; // ??????? ??? ???????????
			var start = Date.now(); 
			var timer = setInterval(function() {
				var timePassed = Date.now() - start;
				for (var key in v) {
					delta = parseInt(t.style[key]) + ( v[key] - parseInt(t.style[key]) ) * timePassed / options.showTime;
					t.style[key] = delta + "px";
				}

				if (timePassed >= options.showTime) {
					clearInterval(timer);
					f();
				}
			}, options.showTime / 25);
		}


		function setBlock(){
			for(i = 0; i < block.length; i++) {
				if (i < p.col){
					animation(block[i], {left:parseInt(p.leftPosArray[i]),top:options.classPadding});
					p.heightArray.push( block[i].offsetHeight + options.wrapMargin + options.classPadding);
				}else {
					var wIndex = p.determineMinHeight(p.heightArray);
					animation(block[i], {left:parseInt(p.leftPosArray[wIndex]), top:parseInt(p.heightArray[wIndex])});
					p.heightArray[wIndex] += block[i].offsetHeight + options.wrapMargin;
				}
                
                if (i == block.length - 1){
                    options.afterEvent();
                }
                
			}
		}

		
		init()
        setTimeout(function(){
			masonry.style.display = "block"
			init();
		},options.showTime) // ????????, ???? ???? ????????? ???????? ????????? ????? ???????? ????????
		
		var resEvent = true; // ????, ?? ????????? ?????????? ????????? ?????? ?? ?????????? ??????
		window.addEventListener("resize", function(event) {
			if (resEvent) {
				resEvent = false;
				for(i = 0; i < block.length; i++)
					block[i].style.height = "auto"

				setTimeout(function(){
					init();
					setTimeout(function(){ // ????????, ???? ???? ????????? ???????? ????????? ????? ???????? ????????
						init();
						resEvent = true;
                        
                        options.afterLoad();
					},options.showTime)
				},options.showTime)
			}
			
			return true;
		})

	}

	return myPlugin;
}()