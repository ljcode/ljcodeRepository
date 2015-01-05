/* 
 * easyDialog v1.5
 * Url : http://stylechen.com/easydialog.html
 * Author : chenmnkken@gmail.com
 * Date : 2011-04-15
 */
(function(){

var	doc = window.document,
	docElem = doc.documentElement;

var easyDialog = function(){

var	body = doc.body,
	isIE = !-[1,],	// 全世界最短的IE判定
	isIE6 = navigator.userAgent.toLowerCase().indexOf('msie 6.0') !== -1,
	options = {},	// 合并后的参数 
	elem,	    // 弹出层内容 
	timer;      // 定时器

var Dialog = function(){

	// 默认参数
	this.defaults = {
		container:   null,			// string   弹处层内容的id
		isOverlay:   true,			// boolean  是否添加遮罩层
		fixed: 	     true,			// boolean   是否静止定位
		follow:      null,			// string/object   是否跟随自定义元素来定位
		followX:     0,				// number    相对于自定义元素的X坐标的偏移
		followY:     0,				// number    相对于自定义元素的Y坐标的偏移
		autoClose:   0,				// number    自动关闭弹出层的时间
		callback:    null			// function    关闭弹出层执行的回调函数
	};
	
};

Dialog.prototype = {
	// 合并参数
	getOptions : function(arg){
		var temp = {}, i;
		for(i in this.defaults){
			temp[i] = arg[i] !== undefined ? arg[i] : this.defaults[i];
		}
		return temp;
	},
	
	// 防止IE6模拟fixed时出现抖动
	setBodyBg : function(){
		if(body.currentStyle.backgroundAttachment !== 'fixed'){
			body.style.backgroundImage = 'url(about:blank)';
			body.style.backgroundAttachment = 'fixed';
		}
	},
	
	// 防止IE6的select穿透
	appendIframe : function(elem){
		elem.innerHTML = '<iframe style="position:absolute;left:0;top:0;width:100%;height:100%;z-index:-1;border:0 none;filter:alpha(opacity=0)"></iframe>';
	},
	
	// 删除元素
	removeNode : isIE ? (function(){
		var div;
		// 防止IE内存泄露
		return function(elem){
			div = div || doc.createElement('div');
			div.appendChild(elem);
			div.innerHTML = '';
			}
		})() : function(elem){
			elem.parentNode.removeChild(elem);
	},
	
	// 获取元素在页面中的位置
	getOffset : function(elem){
		var	top = isIE ? elem.getBoundingClientRect().top + docElem.scrollTop : elem.offsetTop,
			left = isIE ? elem.getBoundingClientRect().left + docElem.scrollLeft : elem.offsetLeft;
			
		return { top: top, left: left };
	},
	
	// 遮罩层
	overlay : function(){
		var overlay;
		return (function(){
			overlay = overlay || doc.createElement('div');
			overlay.style.cssText = 'margin:0;padding:0;border:none;width:100%;height:100%;background:#333;opacity:0.6;filter:alpha(opacity=60);z-index:1000;position:fixed;top:0;left:0;';
			
			// IE6模拟fixed
			if(isIE6){
				body.style.height = '100%';
				overlay.style.position = 'absolute';
				overlay.style.setExpression('top','fuckIE6=document.documentElement.scrollTop+"px"');
			}
			
			overlay.id = 'overlay';
			return overlay;
		})();
	},
	
	// 弹出层
	dialogBox : function(){
		var dialogBox,
			self = this;
		return (function(){
			dialogBox = dialogBox || doc.createElement('div');	
			dialogBox.style.cssText = 'margin:0;padding:0;border:none;z-index:1001;';
			// 设置弹出层跟随某元素进行定位
			var setFollow = function(elem){
				dialogBox.style.top = (self.getOffset(elem).top + options.followY) + 'px';
				dialogBox.style.left = (self.getOffset(elem).left + options.followX) + 'px';
				options.fixed = false;
				options.isOverlay = false;
			};
			
			if(typeof options.follow === 'string'){
				setFollow(doc.getElementById(options.follow));
			}
			else if(options.follow && typeof options.follow === 'object'){
				setFollow(options.follow);
			}
			else{
				dialogBox.style.top = dialogBox.style.left = '50%';
			}
			
			if(options.fixed){
				if(isIE6){
					dialogBox.style.position = 'absolute';
					dialogBox.style.setExpression('top','fuckIE6=document.documentElement.scrollTop+document.documentElement.clientHeight/2+"px"');
				}else{
					dialogBox.style.position = 'fixed';
				}
			}else{
				dialogBox.style.position = 'absolute';
				if(options.follow === null){
					dialogBox.style.top = (docElem.clientHeight/2 + Math.max(docElem.scrollTop,body.scrollTop)) + 'px';
					dialogBox.style.left = (docElem.clientWidth/2 + Math.max(docElem.scrollLeft,body.scrollLeft)) + 'px';
					window.onresize = function(){
						dialogBox.style.top = (docElem.clientHeight/2 + Math.max(docElem.scrollTop,body.scrollTop)) + 'px';
						dialogBox.style.left = (docElem.clientWidth/2 + Math.max(docElem.scrollLeft,body.scrollLeft)) + 'px';
					};
				}
			}
			
			dialogBox.id = 'dialog_box';
			return dialogBox;
		})();
	}
	
};

var $ = new Dialog();

var base = {
	open : function(){
		var self = this;
		// 防止重复弹出
		if(doc.getElementById('dialog_box')){
			self.close();
		}
		
		if(timer){
			clearTimeout(timer);
		}
		
		// 将自定义的参数与默认参数进行合并
		options = $.getOptions(arguments[0]);
				
		var box = $.dialogBox();
		
		if(options.isOverlay){
			var layer = $.overlay();
			body.appendChild(layer);
			if(isIE6){
				$.appendIframe(layer);
			}
		}
		
		if(isIE6){
			$.setBodyBg();
		}
		
		body.appendChild(box);
		
		if(typeof options.container === 'string'){
			elem = doc.getElementById(options.container);			
			
			if(isIE6 && !options.isOverlay){
				$.appendIframe(box);
			}
			
			box.appendChild(elem);
			elem.style.display = 'block';
			var eWidth = elem.offsetWidth,
			    eHeight = elem.offsetHeight;
			
			// 强制去掉弹出层内容的margin
			elem.style.marginTop = elem.style.marginRight = elem.style.marginBottom = elem.style.marginLeft = '0px';
			
			// 居中定位
			if(!options.follow){
				box.style.marginLeft = '-' + eWidth/2 + 'px';
				box.style.marginTop = '-' + eHeight/2 + 'px';
			}
			
			// 防止select穿透固定宽度和高度
			if(isIE6 && !options.isOverlay){
				box.style.width = eWidth + 'px';
				box.style.height = eHeight + 'px';
			}
		}
		
		// 自动关闭弹出层
		if(options.autoClose && typeof options.autoClose === 'number'){
			timer = setTimeout(function(){
				self.close();
			},options.autoClose);
		}
		
		// ESC键关闭弹出层
		doc.onkeyup = function(e){
			e = e || window.event;
			if(e.keyCode === 27) self.close();
		};
	},
	
	close : function(){
		if(timer){
			clearTimeout(timer);
		}
		doc.onkeyup = null;
		if(document.getElementById('overlay')){
			$.removeNode(doc.getElementById('overlay'));
		}
		elem.style.display = 'none';
		body.appendChild(elem);
		$.removeNode(doc.getElementById('dialog_box'));
		
		// 执行callback
		if(typeof options.callback === 'function'){
			options.callback();
		}
	}
};

return base;

};

var loaded = function(){
		window.easyDialog = easyDialog();
	},
	
	doScrollCheck = function(){
		if ( doc.body ) {
			return;
		}

		try {
			docElem.doScroll("left");
		} catch(e) {
			setTimeout( doScrollCheck, 1 );
			return;
		}

		loaded();
	};

(function(){
	if( doc.body ){
		loaded();
	}
	else{
		if( doc.addEventListener ){
			doc.addEventListener( 'DOMContentLoaded', function(){
				doc.removeEventListener( 'DOMContentLoaded', arguments.callee, false );
				loaded();
			}, false );
			window.addEventListener( 'load', loaded, false );
		}
		else if( doc.attachEvent ){
			doc.attachEvent( 'onreadystatechange', function(){
				if( doc.readyState === 'complete' ){
					doc.detachEvent( 'onreadystatechange', arguments.callee );
					loaded();
				}
			});
			window.attachEvent( 'onload', loaded );
			
			var toplevel = false;

			try {
				toplevel = window.frameElement == null;
			} catch(e) {}

			if ( docElem.doScroll && toplevel ) {
				doScrollCheck();
			}
		}
	}
})();

})();