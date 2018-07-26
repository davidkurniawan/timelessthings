
/* -----------------------------------------------------------------------
 * jqarta.pager.js 
 * @version 1.0.0
 * @http://www.jqarta.com
 * @Copyright 2013 jQarta.com
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ----------------------------------------------------------------------- */
 
;(function ($) 
{
	var 
	 dialogid = 0
	, layer    = 0;

	
	$.Modal = function(element, options)
	{
		if(isElement(element))
		{
			
			this.$element = $(element);
			this.options  = $.extend({}, $.Modal.defaultOptions , options , this.$element.data());
		}else
		{
			if(isString(element))
			{
				this.options  = $.extend({}, $.Modal.defaultOptions , options);
				if(element.isUrl())
				{
					this.href = element;
				
				}else{
					this.$element = $(element);
				}
			}else{
				this.options  = $.extend({}, $.Modal.defaultOptions , element);
			}
		}
		//if( (this.$element || this.href) ){
		
			this.create();
		//}
	};
	
	$.Modal.defaultOptions = 
	{
		title: "",
		dropShadow      : true,
		width           : '100%',
		height          : '100%',
		closeButton     : true,
		classNames      : "",
		beforeShow      : function(){},
		result          : function(){},
		show            : function(){},
		close           : function(){}

	};
	$.Modal.prototype = $.extend({}, $.Component, 
	{
		create : function()
		{
			
			var that = this;
			this.id          = "modal_box_"+ (++dialogid);
			this.isShow      = false;
			$('body').append((
			['<div class="modal ', this.options.classNames ,'" id="',this.id,'">',
			'	<div class="modal-align-wrapper"></div><div ',
			'    class="modal-box showcaption">',
			'    	<div class="modal-caption">',
			'        	<span class="modal-text">', this.options.title ,'</span>',
			'            <a data-result="close" href="#close" class="modal-close-button">&times;</a>',
			'        </div>',
			'    </div>',
			'</div>']).join(""));
			

			this.$modal       = $('#'+this.id);
			this.$modalbox    = $('.modal-box',this.$modal).css({width:this.options.width, height:this.options.height});
			this.$captionText = $('.modal-text',this.$modal);
			//this.$closeButton = $('.modal-close-button',this.$modal).on('click',function(){ that.hide(); return false; });


			if(this.options.closeButton){
				this.$modalbox.addClass("modal-hascaption");
			}
			if(this.$element)
			{
				//alert(2);
				this.$element.removeClass('modal').addClass('modal-client')[0].removeAttribute('data-role');
				this.$modalbox.append(this.$element);
				var 
					$content  =  $('.modal-content',this.$modal),
					$footer  =  $('.modal-footer',this.$modal);
				if($content.length && $footer.length)
				{
					$content.css('bottom',$footer.outerHeight());
				}
			}else{
				this.$modalbox.append('<div class="modal-client"></div>');
				this.$element = $('.modal-client',this.$modal);
			}
			this.$modal.on('modal.show',function()
			{
				that.show();
			});
			this.$modal.on('modal.hide',function()
			{
				that.hide();
			});
			$('[data-result]',this.$modal).on('click',function()
			{
				this.result = that.options.result;
				var retval = this.result($(this).data('result'));
				if(retval!==false){
					that.hide(); 
				}
				return false;
			});
			
			this.$modal.hide();
		},
		hide:function()
		{
			if(this.isShow)
			{
				var that = this;
				this.$modal.fadeOut(200,function(){
					that.$modal.removeClass('modal-top-layer'); 
					if(this.dataUrl){
						this.$element.html("");
					}
					that.options.close(that);
				});
				this.isShow = false;
				layer--;
				$('body').css('overflow','auto');
			}
		},
		show:function()
		{
			this._show(null,null);
		},
		_show:function(url,op)
		{
			if(this.isShow){return;}
			layer++;
			this.$modal.css('z-index', (1000 + layer));
			if(layer>1){
				this.$modal.addClass('modal-top-layer'); 
			}
			var that     = this;
			this.isShow  = true;
			this.dataUrl = url;
			if(url)
			{
				this.isIframe = true;
				if(op)
				{
					
					
					if(op.title){
						this.$captionText.text( op.title);
					}
					if(op.modalWidth)
					{
						var l = parseFloat($('.modal-client',this.$modalbox).css('left'));
						this.$modalbox.css('width', parseFloat(op.modalWidth) + (l*2) +'px');
					}
					if(op.modalHeight)
					{
						var t = parseFloat($('.modal-client',this.$modalbox).css('top'));
						this.$modalbox.css('height', parseFloat(op.modalHeight) + (t+l)+'px');
					}
				}
				this.$element.html('<iframe  frameborder="0" framespacing="0" style="visibility:hidden;width:100%;height:100%" src="'+url+'"></iframe>');
				$('iframe',this.$element).load(function()
				{
					this.style.visibility="visible";
				});
			}
			$('body').css('overflow','hidden');
			that.options.beforeShow(that);
			this.$modal.fadeIn(200,function(){
				that.options.show(that);
			});
		}
	});
	
	
	$.fn.modal = function(options)
	{
		if(options == 'show')
		{
			this.trigger('modal.show');
		}
		else if(options == 'hide')
		{
			this.trigger('modal.hide');
		}
		else{
			return this.each(function()
			{
				var href= this.getAttribute('href');
				if(href)
				{
					var objmodal,
					$element =$(this);
					
					if(href.startWidth("#"))
					{
						objmodal =$(href);
						if(objmodal.length)
						{
							$element.on('click',function()
							{
								objmodal.modal('show');
								return false;
							});
						}
					}else
					{
						if(options)
						{
							objmodal = new $.Modal(href,
								$.extend({}, options , $element.data())
							);
							$element.on('click',function(){
								objmodal._show(href);
								return false;
							});
						}else
						{
							if(!$.Modal.iframeDefault)
							{
								$.Modal.iframeDefault = new $.Modal();
							}
							$element.on('click',function()
							{
								
								var op   = $element.data();
								op.title = this.title;
								var uri = $.parseUri(href);
								
								if(uri['host'].indexOf('youtube.com'))
								{
									
									if(uri.queryKey){
										if(uri.queryKey.v){
											href= "https://www.youtube.com/embed/" + uri.queryKey.v;
										}
									}
								}
								$.Modal.iframeDefault._show(href,op);
								return false;
							});
						}
					}
					
				}else
				{
					new $.Modal(this,options);
				}
			});
		}
	};

	$.autoCreateComponents.add( function(container)
	{
		$('[data-role*="modal"],[rel=modal]', container).modal();
	});
	
	
	
	
})(jQuery);



