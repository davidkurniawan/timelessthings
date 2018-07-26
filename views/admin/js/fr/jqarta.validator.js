
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
	$.validator = 
	{
		Form : function (element,options)
		{
			var $element = $(element);
			var that = this;
			this.fields =[];
			var $elements = $('*[data-rule],*[data-alert]',element).each(function()
			{
				if(this.name)
				{
					var f = new $.validator.Field( this ,options);
					that.fields.push( f);
				}
			});
			$element.on('submit validate',function(e)
			{
				var valid = true;
				$(that.fields).each(function(i,field)
				{
					var err = field.validate();
					if(err){
						valid = false;
					}
				});
				if(e.type=='submit')
				{
					if(options.submit(valid)===false)
					{
						return false;
					}
				}
				
				return valid;
			})
			.on('reset',function(e)
			{
				options.reset();
				$elements.removeClass(options.invalidClass);
				$('em.'+options.invalidClass,element).hide();
			});
		},
		Field : function (element,options)
		{
			var that = this;
			var $element  = $(element);
			var rule = $.extend(
			{
				equalto   :'',
				maxlength :2147483647,
				minlength :1,
				allowEmpty:false,
				decimals  :0,
				min       :null,
				max       :null
			},$element.data());
			rule.type = $element.data('rule');
			
			$element.on('keyup paste change blur input',function(e)
			{
				that.validate(e.type);
			});
			
			if($element.data('alert'))
			{
				$.validator.errResult(element, $element.data('alert'),options,'blur');
			}
			
			this.validate = function(evt_type)
			{
				
				var err = false;
				
					if(rule.type=='checked')
					{
						err =  element.checked!==true?'checked':false;
					}
					else
					{
						if(!element.value.match (/\S/))
						{
							if(rule.type=='text')
							{
								if( !rule.allowEmpty)
								{
									if(rule.minlength>0){
										err=  'required';
									}
								}
							}
							else if(rule.type=='number' || rule.type=='phonenumber')
							{
								if( !rule.allowEmpty)
									err=  'required';
							}
							else
								err=  'required';
						}
					}
				
				//
				
				if(!err){
					err = $.validator.errors[rule.type](element.value,rule);
				}
				
				if(!err)
				{
					$.validator.errResult(element, null,options,evt_type);
					//alert(element.name + "="+element.disabled);
					//if(element.disabled) {return true;}
					if(element.disabled) {return false;}
					return false;
				}else
				{
					
					if($element.data('msg'))
					{
						$.validator.errResult(element, $element.data('msg'),options,evt_type);
						
					}else
					{
						if(isArray(err))
						{
							var errname = err[0];
							err.shift();
							$.validator.errResult(element, options.messages[errname].format(err),options,evt_type);
						}else{
							$.validator.errResult(element, options.messages[err],options,evt_type);
						}
					}
					
					//alert(element.name + ":"+element.disabled);
					if(element.disabled) {return false;}
					return true;
				}
				
				//return true;
			}
		},
		errResult:function(elem,msg, options,evt_type)
		{
			var $elem, $parentNode = $(elem.parentNode);
			//if($parentNode.hasClass('select')){
			//	$elem = $parentNode;
			//	elem  = $parentNode[0];
		//	}else{
				$elem = $(elem);
		//	}
			
			var hasInvalid = $elem.hasClass('invalid');
			
			if(msg){
				if(elem.disabled)
				{
					$elem.removeClass('invalid');
					if(elem.errElem)
						elem.errElem.hide();
					return;
				}else
					$elem.addClass('invalid');
			}else{
				$elem.removeClass('invalid');
			}

			
			var errorDisplay =  $elem.data('errorDisplay') || options.errorDisplay;
			if(errorDisplay)
			{
				if(!elem.errElem)
				{
					if(errorDisplay=='before' || errorDisplay=='after')
					{
						if(errorDisplay == 'before'){
							if($parentNode.hasClass('select'))
							{
								$parentNode.before('<em class="small"></em>');
								elem.errElem = $parentNode.prev().addClass(options.invalidClass).hide();
							}else{
								$elem.before('<em class="small"></em>');
								elem.errElem = $elem.prev().addClass(options.invalidClass).hide();
							}
						}else{
							if($parentNode.hasClass('select'))
							{
								$parentNode.after('<em class="small"></em>');
								elem.errElem = $parentNode.next().addClass(options.invalidClass).hide();
							}else{
								$elem.after('<em class="small"></em>');
								elem.errElem = $elem.next().addClass(options.invalidClass).hide();
							}
						}
					}else
					{
						$errdis = $(errorDisplay);
						if($errdis.length)
						{
							//if(elem.disabled) return;
							elem.errElem = $errdis.addClass(options.invalidClass).hide();
						}
					}
				}
				if(msg){
					//if(elem.disabled) return;
					elem.errElem.text(msg).show();
				}else{
					elem.errElem.hide();
				}
			}
		},
		errors:
		{
			"equalto" : function(value,equalto,allowEmpty)
			{
				if( !(allowEmpty && value.trim()==''))
				{
					var equalto = $('*[name='+equalto+']');
					if(equalto.length){
						if(equalto.val() != value){
							return "equalto";
						}
					}
				}
				return false;
			},
			"text": function(value,rule)
			{
				var err = false;
				if( !(rule.allowEmpty && value.trim()==''))
				{
					if(value.length > rule.maxlength)
						err = ['maxlength',rule.maxlength];
					else if(value.length < rule.minlength)
						err = ['minlength',rule.minlength];
				}
				if(!err && rule.equalto){
					err = this.equalto(value,rule.equalto,rule.allowEmpty);
				}
				return err;
			},
			"email": function(value,rule)
			{
				var reg = /^[0-9a-zA-Z\_\-\.]+@[0-9a-zA-Z]+[\.]{1}[0-9a-zA-Z]+[\.]?[0-9a-zA-Z]+$/ ;
				var err  = reg.test(value)?false:'email'; 
				if(!err && rule.equalto){
					err = this.equalto(value,rule.equalto,rule.allowEmpty);
				}
				return err;
			},
			"phonenumber": function(value,rule)
			{
				//var reg = /^(0|\+)[1-9]+$/ ;
				
				//var reg = /^(0[1-9]+$)|(\+[1-9][0-9 ]+$)/ ;
				var reg = /^(0[1-9]([0-9]+)$)|(\+[1-9][0-9 ]+$)/ ;
				//var reg = /^0[0-9]([0-9]+)$/ ;
				return reg.test(value)?false:'phonenumber'; 
				
			},
			"number": function(value,rule)
			{
				if( !(rule.allowEmpty && value.trim()==''))
				{
					if(isNaN(value))
						return 'nan';
					else{
						if( rule.min!=null){
							if(value < rule.min){
								return ['min',rule.min];
							}
						}
						if( rule.max!=null){
							if(value > rule.max)
								return ['max',rule.max];
						}
					}
				}
				return false;
			},
			"currency": function(value,rule)
			{
				return this["number"](currencyToNum(value) ,rule);
			},
			"date": function(value,rule)
			{
				if(!rule.format){
					return  /Invalid|NaN/.test(new Date(value))?'date':false;
				}else{
					return  Date.fromString(value,rule.format)?false:'date';
				}
			}
		}
	}
	

	
	$.fn.validate = function(options)
	{
		if(options=='validate')
		{
			var evt    =  jQuery.Event("validate");
			this.trigger(evt);
			return evt.result;
		}
		else
		{
			var op = $.extend({},$.fn.validate.defaultOptions, options);
			return this.each(function()
			{
				new $.validator.Form(this, $.extend({},op, $(this).data()));
			});
		}
	}
	$.fn.validate.defaultOptions = 
	{
		//resultContainer  : '.class',
		errorDisplay  : 'after',
		invalidClass  : 'invalid',
		submit        : function(valid){},
		reset         : function(){},
		messages      :{
			required    : "This field is required.",
			email       : "Please enter a valid email address.",
			phonenumber : "Please enter a valid phone number",
			url         : "Please enter a valid URL.",
			date        : "Please enter a valid date.",
			number      : "Please enter a valid number.",
			currency    : "Please enter a valid value.",
			equalto     : "Please enter the same value again.",
			maxlength   : "Please enter no more than {0} characters.",
			minlength   : "Please enter at least {0} characters.",
			nan         : "Please enter a number",
			max         : "Please enter a value less than or equal to {0}.",
			min         : "Please enter a value greater than or equal to {0}."
		}
	};
	
	$.autoCreateComponents.add('validate');

	
	
})(jQuery);

	