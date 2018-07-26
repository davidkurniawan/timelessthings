
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
	cursorInPopup  = false, 
	currPopup,
	currMnu,
	timer,
	$tooltipTextWrapper,
	currTooltip;

	$.popup = 
	{
		getDisplayRect : function ($popup, a,b,margin)
		{
			var 
			rtarget,dock,
			rpopup    = $popup.rectangle(),
			rect      = new $.rectangle(0, 0, rpopup.width,rpopup.height),
			rwnd      = $(window).rectangle(),
			margin    = !isNumeric(margin)? 0: margin,
			setMargin = function(dock) 
			{
				if(dock =='bl' || dock=='b'  || dock=='br')
					rect.top += margin;
				else if(dock=='t' || dock=='tl' || dock=='tr')
				{
					rect.top -= margin;
					
				}
				else if(dock=='r' || dock=='rt' || dock=='rb')
					rect.left += margin;
				else if(dock=='l' || dock=='lt' || dock=='lb')
					rect.left -= margin;
			},
			rectPos   = function(x,y) 
			{
				rect.left = x;
				rect.top  = y;
				if( margin>0 )
				{
					setMargin(dock);
				}
			};
			dock = rect.dock  = b || 'bl';
			if(isObject(a))
			{
				if(a.x && a.y)
				{
					rtarget = new $.rectangle(a.x,a.y,0,0);
				}else
				{
					if(a.offsetParent()[0] != $popup.offsetParent()[0])
					{
						rtarget = a.rectangle(true);
					}else{
						rtarget = a.rectangle();
					}
				}
			}
			var fl = function(flip)
			{
				if(rect.left< rwnd.left)
				{
					if(flip)
					{
						var xr = rtarget.right();
						if( xr + rect.width<= rwnd.right())
						{
							rect.left = xr;
							return true;
						}
					}else
						rect.left = rwnd.left;
				}
			};
			var fr = function(flip)
			{
				if(rect.right()> rwnd.right())
				{
					if(flip)
					{
						var xr = rtarget.left-rect.width;
						if(xr >= rwnd.left)
						{
							rect.left = xr;
							return true;
						}
					}else
						rect.left = rwnd.right()-rect.width;
				}
			};
			var ft = function(noflip){
				if(rect.top < rwnd.top)
				{
					if(noflip)
						rect.top = rwnd.top;
					else{
						if((rtarget.bottom() + rect.height) <= rwnd.bottom())
						{
							rect.top = rtarget.bottom();
							return true;
						}
					}
				}
			};
			var fb = function(noflip){
				if(rect.bottom() > rwnd.bottom())
				{
					if(noflip)
					{
						rect.top = rwnd.bottom() - rect.height;
					}else{
						if(rtarget.top- rect.height >= rwnd.top)
						{
							rect.top = rtarget.top - rect.height;
							return true;
						}
					}
				}
			};
			
			switch (dock)
			{
				case "br": 
					rectPos( rtarget.right() - rpopup.width,rtarget.bottom()); 
					fl(); rect.dock= fb()?'tr':'br';
					break;
				case "tr": 
					rectPos( rtarget.right() - rpopup.width, rtarget.top - rpopup.height);
					fr(); rect.dock= ft()?'br':'tr';
					break;	
				case "tl":
					rectPos( rtarget.left ,rtarget.top - rpopup.height); 
					fr(); rect.dock= ft()?'bl':'tl';
					break;
				case "lt": 
					rectPos( rtarget.left-rpopup.width ,rtarget.top); 
					fb(true); rect.dock= fl(true)?'rt':'lt';
					break;
				case "lb": 
					rectPos( rtarget.left-rpopup.width ,rtarget.bottom()-rpopup.height); 
					ft(true); rect.dock = fl(true)?'rb':'lb';
					break;	
				case "rt": 
					rectPos( rtarget.right() ,rtarget.top); 
					fb(true); rect.dock= fr(true)?'lt':'rt';
					break;
				case "rb": 
					rectPos( rtarget.right() , rtarget.bottom()-rpopup.height); 
					ft(true); rect.dock = fr(true)?'lb':'rb';
					break;
				case "r" :
				case "l" : 
					rectPos( dock=='r'? rtarget.right(): rtarget.left - rpopup.width , 
					rtarget.top  - ((rpopup.height/2) - (rtarget.height/2)) ); 
					if(dock=='r')
					{
					
						fb(true);rect.dock= fr(true)?'l':'r';
					}else{
						fb(true);rect.dock= fl(true)?'r':'l';
					}
					break;
				case "b" : 
				case "t" : 
					
					rectPos( rtarget.left  - ((rpopup.width/2) - (rtarget.width/2)),
					dock=='t'?rtarget.top - rpopup.height:
					rtarget.bottom()); 

					if(dock=='t'){
						rect.dock= ft()?'b':'t';
						fl();fr();
					}else{
						rect.dock= fb()?'t':'b';
						fl();fr();
					}
					
					break;
				default  : 
					rectPos(rtarget.left,rtarget.bottom()); 
					fr(); rect.dock= fb()?'tl':'bl';
			}

			var t = rect.top;
			if( margin>0 && rect.dock != dock)
			{
				setMargin(rect.dock);
			}
			rect.getStemLocation = function (rstemp)
			{
				var padding=4;
				var x = 0
				, y= 0
				, cx=(rstemp.width/2)
				, cy=(rstemp.height/2);
				
				var pw = rect.width;
				var ph = rect.height;
				var tCenterX,tCenterY;
				
				tCenterX = rtarget.width>0?rtarget.left + (rtarget.width/2): rtarget.left;
				if(rtarget.width>rect.width){
					//tCenterY = rtarget.top + (rect.height/2);
				}else{
					tCenterY = rtarget.height>0?rtarget.top + (rtarget.height/2): rtarget.top;
				}
				var dockChar0 = rect.dock.charAt(0);
				switch (dockChar0)
				{
					case "l":
					case "r":
						y = (tCenterY - rect.offset.y)-cy;
						if(y<=0) 
						{
							y = padding;
							rect.top -= padding+rstemp.height
						}
						if(y>=(ph-rstemp.width) ) 
						{
							y = ph- ((rstemp.height*2));
							rect.top += ((rstemp.height  ))
						}
						x = (dockChar0=="l") ? rect.width-2: - (rstemp.width);
						
						break;
					case "t":
					case "b":
						x = (tCenterX - rect.offset.x)-cx;
						y = (dockChar0=="t") ? rect.height-2  : -(rstemp.height);
						
						if(x<=0){ 
							x = padding;
							if(rect.dock!='bl') 
							rect.left -= padding+rstemp.width
						}
						if(x >=(pw-rstemp.width) ) 
						{
							x = pw - ((rstemp.width*2) + padding);
							rect.left += ((rstemp.width + padding ))
						}
						
						break;
				}
				return point(x,y);
			};
			rect.offset =  {x : rect.left,y : rect.top };
			return rect;
		},
		hide : function(asTooltip)
		{
			if(asTooltip){
				hideTooltip();
			}
			else
			{
				if(currPopup ){
					hidePopup(currPopup,currMnu);
					currPopup=null;
				}
				$.hasActivePopup=false;
			}
		},
		show : function($button, $popup, op, points)
		{
			if(!op.tooltip)
			{
				$.popup.hide(true);
				makeClickEvent($popup);
				if($button.hasClass('active'))
				{
					hidePopup();
					return;
				}
				if(!cursorInPopup)
				{
					hidePopup();
					currMnu   = $button.addClass('active');
					currPopup = $popup._popupShow(op.fade);
				}
			}else{
				if(op.mousetrack){
					currTooltip = $popup;
				}else{
					currTooltip = $popup._popupShow(op.fade);
				}
				
			}
			
			var  pos, _this = $button[0];
			if(op.stem)
			{
				if(!$popup[0].stem)
				{
					$popup.prepend('<div class="popupstem"></div>');
					$popup[0].stem = $('.popupstem',$popup).addClass(op.dock);
				}
			}
			if(points){
				
				this.setPosition($popup, points ,   op);
			}else{
				this.setPosition($popup, $button,  op);
			}
			
			if(!op.tooltip){
				$.hasActivePopup=true;
			}
			if( op.tooltip){
				$popup._popupShow(op.fade);
			}
		},
		setPosition: function($popup, a, op)
		{
			if(op.stem)
			{
				var stem = $popup[0].stem;
				stem[0].className = "popupstem "+op.dock[0];
				var sw=
				stem.outerWidth(),
				sh=stem.outerHeight();
				
				var margin = Math.min(stem.outerHeight(), $popup[0].stem.outerWidth());
				pos = $.popup.getDisplayRect($popup, a, op.dock, margin  +(op.mousetrack?15:0));
				stem[0].className = "popupstem "+ pos.dock[0];
				
				var r = new $.rectangle(0,0,sw,sh);
				var spos    = pos.getStemLocation(r);
				$popup[0].stem.css(
				{
					'left':spos.x+'px',
					'top' :spos.y +'px'
				});
			}else
			{
				pos = $.popup.getDisplayRect($popup, a, op.dock, 0);
			}
			
			if(op.isRelative==undefined)
			{
				op.offsetParent = $($popup[0].parentNode);
				op.isRelative = op.offsetParent.css('position')!='static';
			}
			if(op.isRelative)
			{
				var of2 = op.offsetParent.offset();
				pos.left -= of2.left;
				pos.top  -=  of2.top;
			}
			$popup.css({'left':pos.left+'px','top':pos.top +'px'});
		}
	};

	function hideTooltip()
	{
		if(currTooltip){
			currTooltip._popupHide();
			currTooltip=null;
		}
	}
	function hidePopup(currpopup,currmnu)
	{
		if(currpopup && currmnu)
		{
			clearTimeout(timer);
			currmnu.removeClass('active');
			currpopup._popupHide();
		}else{
			if(cursorInPopup==false){
				$.popup.hide();
			}
		}
	};	
	function makeClickEvent($popup)
	{
		$('a',$popup).each(function()
		{
			if(!this.hasClickEvent)
			{
				this.hasClickEvent = true;
				if(this.getAttribute('href')!='#'){
					$(this).click(function(e){
						//alert(1);
						$.popup.hide();	
					});
				}
			}
		});
	}
	function fadeEnd($popup)
	{
		if($popup.css('opacity')==0){
			$popup.css({'left':'-10000px','top':'-10000px',});
		}
	}
	
	function point(x,y)
	{
		return {"x":x,"y":y};
	}
	
	
	
	$.extend($.fn,
	{
		_popupShow : function(fade)
		{
			return fade?this.addClass('in'):this.show();
		},
		_popupHide : function()
		{
			return this.hasClass('fade')?this.removeClass('in'):this.hide();
		},
		dropdown : function(popup, options)
		{
			var op =  $.extend( {}, $.fn.dropdown.defaultOptions, options);
			if(arguments.length==0)
			{
				return createPopup(this, null,op);
			}
			return createPopup(this, popup, op);
		},
		tooltip : function(options)
		{
			var $popup = $('#_popupTooltip');
			var op =  $.extend({}, $.fn.tooltip.defaultOptions, options);
			if($popup.length==0)
			{
				$('body').append('<div id="_popupTooltip" class="tooltip '+op.theme+'"><span></span></div>');
				$popup              = $('#_popupTooltip');
				$tooltipTextWrapper =  $('span',$popup);
			}
			op.stem    =  'small';
			op.tooltip =  true;
			op.trigger = 'mouseover';
			return createPopup(this,$popup, op);
		}
	});
	
	$.fn.dropdown.defaultOptions=
	{
		stem          : 'large',
		beforeShow    : function(){},
		show          : function(){},
		trigger       : 'click',
		showDelay     : 300,
		hideDelay     : 400,
		toggle        : true,
		dock          : "bl"
	};
	$.fn.tooltip.defaultOptions=
	{
		beforeShow    : function(){},
		show          : function(){},
		showDelay     : 100,
		hideDelay     : 0,
		fade          : true,
		mousetrack    : false,
		dock          : "t"
	};
	
	function createPopup($this, popup, options)
	{
		
		return $this.each
		(
			function()
			{
				
				if(options.tooltip){
					if(this.title)
					{
						this.tooltip = this.title;
						this.title='';
					}else
					{
						return;
					}
				}
				var  
				elem  = this, 
				$elem = $(this);
				
				var op =  $.extend( {}, options, $elem.data());
				var $popup = isEmpty(popup)
				? $elem.next().css('min-width',$elem.outerWidth())
				: $(popup);
				op.fade = $.support.transition && op.tooltip ?op.fade:false;
				
				if(op.stem){
					 $popup.addClass(op.stem+'-stem');
				}
				if(!$popup.hasClass('popup')){
					$popup.addClass('popup');
				}
				if(!$popup.hasClass('has-popup'))
				{
					$popup.addClass('has-popup' + (op.fade? ' fade':''))
					.mouseover(function()
					{
						if(!op.tooltip)
							cursorInPopup=$popup;
					})
					.mouseout(function()
					{
						cursorInPopup=false;
					});
					if(!op.tooltip)
					{
						if($popup[0].tagName == 'UL'){
							$popup.addClass('popupmenu');
						}
						$popup.find('li>ul,li>div').each(function()
						{
							$(this.parentNode).addClass('menu-item-parent');
							var $subPopup = $(this)
							.addClass( 'popup' + (this.tagName=='UL'?' popupmenu':''));	
						});
					}
					if(op.fade){
						fadeEnd($popup);
						$popup.bind($.support.transitionend,function(){fadeEnd($popup);});
					}
				}
				
				
				if(op.trigger=='mouseover')
				{
					$popup.mouseout(function()
					{
						clearTimeout(timer);
						timer = setTimeout(function(){
							$.popup.hide(op.tooltip);	
						}, op.hideDelay);
					})
					.mouseover(function()
					{
						clearTimeout(timer);
					});
					$elem.mouseout(function()
					{
						clearTimeout(timer);
						timer = setTimeout(function(){
							$.popup.hide(op.tooltip);				
						}, op.hideDelay);
					})
					.mouseover(function(e)
					{
						clearTimeout(timer);
						if($elem.hasClass('active'))
							return;
							
						timer = setTimeout(function()
						{
							if(op.tooltip)
							{
								$tooltipTextWrapper.html(elem.tooltip);
							}
							op.beforeShow($elem,$popup);
							if(op.mousetrack && op.tooltip)
							{
								$.popup.show($elem, $popup,op, point(e.pageX,e.pageY));
							}else{
								$.popup.show($elem,$popup,op);
							}
							op.show($elem,$popup);
						}, op.showDelay);
						
					});
					if(op.mousetrack && op.tooltip)
					{
						$elem.mousemove(function(e)
						{
							if(currTooltip){
								$.popup.setPosition(currTooltip ,  point(e.pageX,e.pageY),op);
							}
						});
					}
				}else{
					
					$elem.on('click',function()
					{
						if(op.toggleShowHide || (currPopup!= $popup && !op.toggleShowHide)){
							var retval = op.beforeShow($elem,$popup);
							if(retval!==false)
							{
								$.popup.show($elem,$popup,op);
								op.show($elem,$popup);
							}
						}
						return false;
					});
				}
			}
		);
	}
	
	$(document).on('click',function()
	{
		hidePopup();
		hideTooltip();
	});

	$.autoCreateComponents.add( 'tooltip');
	$.autoCreateComponents.add( 'dropdown');
	$.autoCreateComponents.add( function(container)
	{
		$('.popup li>*+ul, .popup li>*+div',container).each(function(){
			var a = $(this).prev();
			//a.addClass('submenu-parent')
			//.prepend('<i class="glyph glyph-arrow-right"></i>');
		});
		
	});
	
	
})(jQuery);
