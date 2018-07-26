
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
 
var 
__scriptelems_   = document.getElementsByTagName("script"),
__scriptincludes = [];
$.jQartaBaseUrl  = __scriptelems_[__scriptelems_.length-1].src.match(/^(.*)\/([^\/]+)$/)[1] + '/';
$.include        = function(filename)
{
	if(jQuery.inArray(filename,__scriptincludes)==-1)
	{
		__scriptincludes.push(filename);
		if(!filename.isUrl()){
			if(filename.charAt(0)!='/')
				filename = $.jQartaBaseUrl + filename;
		}
		if(/\.css$/.test(filename))
		{
			document.write('<link rel="stylesheet" type="text/css" href="'+ filename  +'" />');
		}else{
			document.write('<script language="javascript" type="text/javascript" src="'+ filename  +'"></script>');
		}
	}
};

;(function ($)
{
	////////// UTILS ///////////////// 
	window.isObject = function(obj)
	{
		return Object.prototype.toString.call(obj) === "[object Object]";
	};
	window.isArray = function(obj)
	{
		return obj?obj.constructor == Array:false;
	};
	window.isFunction = function(obj)
	{
		return  typeof obj=="function";
	};
	window.isNull = function(obj)
	{
		return obj == null;
	};
	window.isEmpty = function(obj)
	{
		return !obj;
	};
	window.isString = function(obj)
	{
		return  typeof obj=="string";
	};
	window.isNumOrString = function(obj)
	{
		return  isNumeric(obj) || isString(obj);
	};
	window.isNumeric = function(obj) 
	{
		return (!isNaN(obj) && obj!='') ||  typeof obj=="number";
	};
	window.isBool = function(obj) {
		return  (obj===true || obj === false);
	};
	window.isElement = function(obj)
	{
		if(obj){
			return isString(obj.tagName);
		}
		return false;
	};
	window.isDate = function(obj)
	{
		return (isBool(obj) || isNumeric(obj) || isEmpty(obj) ) ? false: !/Invalid|NaN/.test(new Date(obj));
	};
	window.defined = function(obj){
		return obj!==undefined;
	};
	window.zeroPad = function(val, count, right) 
	{
		var str = String(val);
		count = count || 2;
		for (var l=str.length; l < count; l++) {
			str = (!right ? ('0' + str) : (str + '0'));
		}
		return str;
	};

	
/////////////////////////////////////////////////
///// Extended $.support  ///////////////////////
/////////////////////////////////////////////////
	//alert(navigator.userAgent);
	
	
	if(!$.browser)
	{
		$.browser = {}
	}
		$.browser = {
			msie    :(/msie/gi).test(navigator.userAgent),
			webkit  :(/webkit/gi).test(navigator.userAgent),
			safari  :(/safari/gi).test(navigator.userAgent),
			firefox :(/firefox/gi).test(navigator.userAgent),
			opera   :(/opera/gi).test(navigator.userAgent),
			isStandalone: function ()
			{
				if('standalone' in window.navigator )
				{
					return  window.navigator.standalone;
				}
				return false;
			}
		};
		//alert($.browser.msie);
	//}
	
	$.support = $.support || {};
	$.support.touch = 'ontouchstart' in window;
	$.browser.mozilla = $.browser.firefox;
	var 
	propPrefix = $.browser.webkit 
		?'webkit'
		: ($.browser.mozilla? '' : ('opera' in window ? 'O' : '')),
	
	cssPrefix  = propPrefix == ''?'' : '-'+   propPrefix.toLowerCase() +'-',
	style      = document.documentElement.style,
	cssSupport      =  {
		'transform'      :['Transform','transform'],
		'transition'     :['Transition','transition'],
		'animation'      :['Animation','animation']
	},
	cssSupportEvent =  {
		   'webkitTransition' : 'webkitTransitionEnd'
		,  'MozTransition'    : 'transitionend'
		,  'OTransition'      : 'oTransitionEnd otransitionend'
		,  'msTransition'     : 'msTransitionEnd'
		,  'transition'       : 'transitionend'
		,  'webkitAnimation'  : 'webkitAnimationEnd'
		,  'MozAnimation'     : 'animationend'
		,  'OAnimation'       : 'oAnimationEnd oanimationend'
		,  'animation'        : 'animationend'
	};
	$.prefixed = function(str){
		return propPrefix==''?str.toLowerCase(): propPrefix + str;
	}
	
		

	
	$.cssPrefixed = function(str){
		return cssPrefix + str;
	}
	for(var name in cssSupport)
	{
		var ar = cssSupport[name];
		$.support[name] = ($.prefixed(ar[0]) in style)
		? $.prefixed ( ar[0])
		: (name in style? ar[1] : false);
		
	}
	$.support.transitionend   = $.support.transition? cssSupportEvent[$.support.transition] :false;
	$.support.animationend    = $.support.animation ? cssSupportEvent[$.support.animation]:false;
	$.support.transform3d     = ($.prefixed('Perspective') in style) || ('perspective'in style);

	$.device={
		ipad       : (/ipad/gi).test(navigator.userAgent),
		iphone     : (/iphone/gi).test(navigator.userAgent),
		android    : (/android/gi).test(navigator.userAgent),
		ios        : (/ipad|iphone|ipod/gi).test(navigator.userAgent),
		windows    : (/windows/gi).test(navigator.userAgent),
		blackberry : (/blackberry/gi).test(navigator.userAgent)
	};
	$.device.desktop= !(/(android|iphone|blackberry|ipad)/gi).test(navigator.userAgent),

/////////////////////////////////////////////////
///// PROTOTYPE : Number ////////////////////////
/////////////////////////////////////////////////

	$.extend(Number.prototype,
	{
		toRad : function() 
		{
			return this * Math.PI / 180;
		},
		formatCurrency : function(useSymbol,precision)
		{
			if(precision==null)//isNull(precision))
				precision =Number.currency.decimals;
			
			var patern = Number.currency.paterns[(this<0?0:1)];
			var numStr = __format(Math.abs(this),precision, Number.currency);
			if(useSymbol){
				return patern.replace(/[\$n]/g, function ($0) {
					return $0=='$'? (useSymbol?Number.currency.symbol:""): numStr;
				});
			}
			return numStr;
		},
		formatNumber : function(precision)
		{
			var patern = Number.paterns[(this<0?0:1)];
			precision  =  precision || (this == parseFloat(this)?0:Number.decimals);
			
			var numStr = __format(Math.abs(this),precision, Number);
			return patern.replace(/n/g, numStr);
		},
		isKeyDelete : function()
		{
			return this== 46 || this== 110;
		},
		isKeyEnter : function()
		{
			return this== 13 || this== 108;
		}
	});
	
	function __format(number,precision,formatInfo)
	{
		var groupSizes = formatInfo.groupSizes,
			curSize = groupSizes[ 0 ],
			curGroupIndex = 1,
			factor = Math.pow( 10, precision ),
			rounded = Math.round( number * factor ) / factor;
			
		if ( !isFinite(rounded) ) {
			rounded = number;
		}
		number = rounded;
		var numberString = number+"",
			right = "",
			split = numberString.split(/e/i),
			exponent = split.length > 1 ? parseInt( split[ 1 ], 10 ) : 0;
		numberString = split[ 0 ];
		split = numberString.split( "." );
		numberString = split[ 0 ];
		right = split.length > 1 ? split[ 1 ] : "";
	
		var l;
		if ( exponent > 0 ) {
			right = zeroPad( right, exponent, true );
			numberString += right.slice( 0, exponent );
			right = right.substr( exponent );
		}
		else if ( exponent < 0 ) {
			exponent = -exponent;
			numberString = zeroPad( numberString, exponent + 1,false );
			right = numberString.slice( -exponent, numberString.length ) + right;
			numberString = numberString.slice( 0, -exponent );
		}
		if ( precision > 0 ) {
			right = formatInfo.separators[1] +
				((right.length > precision) ? right.slice( 0, precision ) : zeroPad( right, precision ,true));
		}
		else {
			right = "";
		}
		var stringIndex = numberString.length - 1,
			sep = formatInfo.separators[0],
			ret = "";
	
		while ( stringIndex >= 0 ) {
			if ( curSize === 0 || curSize > stringIndex ) {
				return numberString.slice( 0, stringIndex + 1 ) + ( ret.length ? ( sep + ret + right ) : right );
			}
			ret = numberString.slice( stringIndex - curSize + 1, stringIndex + 1 ) + ( ret.length ? ( sep + ret ) : "" );
	
			stringIndex -= curSize;
	
			if ( curGroupIndex < groupSizes.length ) {
				curSize = groupSizes[ curGroupIndex ];
				curGroupIndex++;
			}
		}
		//return numberString.slice( 0, stringIndex + 1 ) + sep + ret + right;
		var rtn = numberString.slice( 0, stringIndex + 1 ) + sep + ret + right;
		return rtn.trim();
	}
	
///// PROTOTYPE : Math ///////////////////////
////////////////////////////////////////////////

	Math.clamp = function(value,max,min)
	{
		return Math.max(min, Math.min( value , max));
	};
	
///// PROTOTYPE : String ///////////////////////
////////////////////////////////////////////////


	$.extend(String.prototype,
	{
		isUrl: function ()
		{
			return this.isFullUrl() || this.indexOf("/")>-1;
		},
		isFullUrl: function ()
		{
			var re = /^(http|https):\/\/[A-Za-z0-9\.-]{3,}/;
			return re.test(this);
		},
		isEmail : function ()
		{
			var re = /([A-Za-z0-9\.-_]+)@([A-Za-z0-9\.-_])/;
			return re.test(this);
		},
		isPhoneNumber: function(str)
		{
			return (/^\+([0-9]+)$/).test(str);
		},
		shuffle : function () 
		{
			if(this.length<=1) return this;
			var ar = (this.split('')).shuffle();
			return ar.join('');
		},
		multiply : function (len) 
		{
			if(len>0){
				var text = this;
				for(var i=0;i<len;i++){
					text += this;
				}
				return text;
			}
			return "";
		},
		padLeft : function (len,_char) 
		{
			_char = _char || " ";
			len = len || 1;
			val = this;
			while (val.length < len){ val =  _char + val;}
				return val;
		},
		padRight : function (len,_char) 
		{
			_char = _char || " ";
			len = len || 1;
			val = this;
			while (val.length < len) {val =  val + _char;}
				return val;
		},
		trim : function () 
		{
			return this.replace(/^\s+|\s+$/g, "" );
		},
		trimLeft : function () 
		{
			return this.replace(/^\s+/g, "" );
		},
		trimRight: function () 
		{
			return this.replace(/\s+$/g, "" );
		},
		repeat : function (n,separator) 
		{
			if (n > 0){
				separator = separator || "";
				var s = [this];
				for (var i = 1; i < n; i++){
					s.push(this);
				}
				return s.join(separator);
			}
			return this;
		},
		regSlashes : function () 
		{
			return this.addSlashes(/[\(\)\*\[\]\|\{\}\-\*\+\$\!\.\'\"\:\?\\]/g);
		},
		addSlashes : function (rg) 
		{
			if(rg=="")
				return "\\"+ (this.split("").join("\\"));
			else
			{
				rg =  rg ||  "\"\'\\\\";
				var re = typeof rg=='string'? new RegExp("(["+rg+"]+)","g"):rg;
				return this.replace(re, function ($0) 
				{
					return "\\"+ $0;
				});
			}
		},
		startWidth : function (str) 
		{
			return this.indexOf(str)==0;
		},
		endWidth : function (str) 
		{
			return this.lastIndexOf(str)==this.length-str.length;
		},
		capitalize : function()
		{
			return this.replace( /(^|\s)([a-z])/g , function(m,p1,p2){ return p1+p2.toUpperCase(); } );
		},
		format : function () 
		{
			var params = arguments;
			if ( params.length > 0 )
			{
				if (params.length==1 && isArray(params[0]))
					params =  isArray(params[0]) ? params[0] : [params[0]];
			}else
				return this;
			var i=-1;
			return this.replace(/\{([0-9]+)\}/g, function ($0) 
			{
				return  params[++i];
			});
		}
	});
	

///// PROTOTYPE : Date ///////////////////////
////////////////////////////////////////////////

	Date.isLeapYear = function (y)
	{
		return (y%4==0 && y%100!=0) || y%400==0;
	};
	Date.daysInYear = function (year)
	{
		return Date.isLeapYear(y)?367:365;
	};
	Date.fromString = function (str, patern)
	{
		var 
		  date =  new Date('January 1, 1970 00:00:00')
		, patr = Date._regFormat(patern)
		, re = new RegExp (patr[1],"i")
		, m  = str.match(re)
		, _h, _ampm, _date=
		{
			y:function(n){date.setYear(n)},
			M:function(n){date.setMonth(n)},
			d:function(n){date.setDate(n)},
			d:function(n){date.setDate(n)},
			MMM:function(n){date.setMonth(n)},
			H:function(n){date.setHours(n)},
			m:function(n){date.setMinutes(n)},
			s:function(n){date.setSeconds(n)},
			h:function(n){_h=n},
			mn:function(n){_ampm=n}
		};
		if(m){
			for(var i=1; i<m.length;i++)
			{
				var ref= patr[0][i];
				
				if(ref[0]=='num')
				{
					var n = parseFloat(m[i]);
					if( !(n>= ref[2] && n<=ref[3]) ){
						return false;
					}
					_date[ref[1]](n);
				}
				else if(ref[0]=='str')
				{
					var s = m[i].toLowerCase(), 
					found = false;
					for(var j=0;j<ref[2].length;j++)
					{
						if(s==ref[2][j].toLowerCase()){
							found=true;
							if(ref[1]){
								_date[ref[1]]((j));
							}
						}
					}
					if(!found){
						return false;
					}
				}
			}
			if(_h && _ampm){
				if(_ampm==1){_h +=12;}
				date.setHours(_h);
			}
			return date;
		}
		return false;
	};
	Date._regFormat = function (patern)
	{
		var token    = /d{1,4}|M{1,4}|y{1,4}|f{1,3}|([Hhmst])\1?|"[^"]*"|'[^']*'/g;
		var subname=[''];
		flags = {
			d:    ['num','d',1,31,1,2],
			dd:   ['num','d',1,31,2],
			ddd:  ['str','',Date.abbrDayNames],
			dddd: ['str','',Date.dayNames],
			M:    ['num','M',1,12,1,2],
			MM:   ['num','M',1,12,2],
			MMM:  ['str','MMM',Date.abbrMonthNames],
			MMMM: ['str','MMM',Date.monthNames],
			yyyy: ['num','y',1900,9999,4],
			h:    ['num','h',1,12,1,2],
			hh:   ['num','h',1,12,2],
			H:    ['num','H',0,23,1,2],
			HH:   ['num','H',0,23,2],
			m:    ['num','m',0,59,1,2],
			mm:   ['num','m',0,59,2],
			s:    ['num','s',0,59,1,2],
			ss:   ['num','s',0,59,2],
			f:    ['num','f',0,1000,3], 
			ff:   ['num','f',0,1000,3],
			fff:  ['num','f',0,1000,3],
			t:    ['str','mn'[Date.meridiemNames.am,Date.meridiemNames.pm]],
			tt:   ['str','mn',[Date.meridiemNames.AM,Date.meridiemNames.PM]]
		};
		function reg(args)
		{
			if(args[0]=='num'){	
				subname.push(['num',args[1],args[2],args[3]]);
				return '([0-9]{'+ args[4] + (args[5]?','+args[5]:'')+'})';
			}
			subname.push( ['str', args[1], args[2] ] );
			return '([A-Za-z]+)';
		}
		var reg_patern ='^' + patern.replace(token, function ($0){
			return $0 in flags ? reg(flags[$0]) : $0.slice(1, $0.length - 1);
		}) +'$';
		return  [subname, reg_patern];
	};
	
	$.extend(Date.prototype,
	{
	
		isWeekend: function (){
			return this.getDay()==0 || this.getDay()==6;
		},
		isWeekDay: function (){
			return !this.isWeekend();	
		},
		isLeapYear : function (){
			return Date.isLeapYear(this.getFullYear());
		},
		getDaysInMonth: function (){
			return [31,(this.isLeapYear() ? 29:28),31,30,31,30,31,31,30,31,30,31][this.getMonth()];
		},
		getDayName: function (abbreviated){
			return abbreviated ? Date.abbrDayNames[this.getDay()] : Date.dayNames[this.getDay()];
		},
		getMonthName: function (abbreviated){
			return abbreviated ? Date.abbrMonthNames[this.getMonth()] : Date.monthNames[this.getMonth()];
		},
		getDayOfYear: function (){
			var tmpdtm = new Date("1/1/" + this.getFullYear());
			return Math.floor((this.getTime() - tmpdtm.getTime()) / 86400000);
		},
		getWeekOfYear: function (){
			return Math.ceil(this.getDayOfYear() / 7);
		},
		getWeek : function()
		{
			//var jan = new Date(this.getFullYear(),0,1);
			//return Math.ceil((((this - jan) / 86400000) + jan.getDay()+1)/7);
			var d = new Date(this);
			var D = d.getDay();
			if(D == 0) D = 7;
			d.setDate(d.getDate() + (4 - D));
			var YN = d.getFullYear();
			var ZBDoCY = Math.floor((d.getTime() - new Date(YN, 0, 1, -6)) / 86400000);
			var WN = 1 + Math.floor(ZBDoCY / 7);
			return WN;
		},
		setDayOfYear: function (day){
			this.setMonth(0);
			this.setDate(day);
			return this;	
		},
		addYears: function (num){
			this.setFullYear(this.getFullYear() + num);
			return this;
		},
		addMonths: function (num){
			var tmpdtm = this.getDate();
			this.setMonth(this.getMonth() + num);
			if (tmpdtm > this.getDate())
				this.addDays(-this.getDate());
			
			return this;
		},
		addDays: function (num){
			this.setTime(this.getTime() + (num*86400000) );
			return this;	
		},
		addHours: function (num){
			this.setHours(this.getHours() + num);
			return this;
		},
		addMinutes: function (num){
			this.setMinutes(this.getMinutes() + num);
			return this;	
		},
		addSeconds: function (num){
			this.setSeconds(this.getSeconds() + num);
			return this;	
		},
		zeroTime: function (){
			this.setMilliseconds(0);
			this.setSeconds(0);
			this.setMinutes(0);
			this.setHours(0);
			return this;	
		},	
		format : function (patern)
		{
			patern =  Date.paterns[patern] || patern;
			var date = this,
			token    = /d{1,4}|M{1,4}|y{1,4}|f{1,3}|z{1,3}|([Hhmst])\1?|"[^"]*"|'[^']*'/g;
			var	d = date.getDate(),
			D = date.getDay(),
			M = date.getMonth(),
			y = date.getFullYear(),
			H = date.getHours(),
			m = date.getMinutes(),
			s = date.getSeconds(),
			L = date.getMilliseconds(),
			z = function(l){ hour = date.getTimezoneOffset() / 60; return (hour <= 0 ? '+' : '-') + zeroPad( Math.floor( Math.abs( hour ) ), l ); },
			Z = function(){ 
				hour = date.getTimezoneOffset() / 60;
				return ( (hour <= 0 ? '+' : '-') + zeroPad( Math.floor( Math.abs( hour ) ), 2 ) +
                    ":" + zeroPad( Math.abs( date.getTimezoneOffset() % 60 ), 2 ) );
			};
			flags = {
				d:    d,
				dd:   zeroPad(d),
				ddd:  Date.abbrDayNames[D],
				dddd: Date.dayNames[D],
				M:    M + 1,
				MM:   zeroPad(M + 1),
				MMM:  Date.abbrMonthNames[M],
				MMMM: Date.monthNames[M],
				y:    String(y).slice(3),
				yy:   String(y).slice(2),
				yyyy: y,
				h:    H % 12 || 12,
				hh:   zeroPad(H % 12 || 12),
				H:    H,
				HH:   zeroPad(H),
				m:    m,
				mm:   zeroPad(m),
				s:    s,
				ss:   zeroPad(s),
				f:    zeroPad(L, 3).substr( 0, 1 ), 
				ff:   zeroPad(L, 3).substr( 0, 2 ), 
				fff:  zeroPad(L, 3).substr( 0, 3 ), 
				t:    H < 12 ?Date.meridiemNames.am[0] : Date.meridiemNames.pm[0],
				tt:   H < 12 ? Date.meridiemNames.am[1] : Date.meridiemNames.pm[1],
				z :   z(1),
				zz :  z(2),
				zzz:  Z()
			};
			return patern.replace(token, function ($0) {
				return $0 in flags ? flags[$0] : $0.slice(1, $0.length - 1);
			});
		}
	
	});
	
////////////////////////////////////////////////
////////////////////////////////////////////////

	$.getMeta = function(name){
			var tags = document.getElementsByTagName('meta');
			name = name.toLowerCase();
			for(var i in tags){
				var m = tags[i];
				if( String(m['name']).toLowerCase() == name || String(m['httpEquiv']).toLowerCase() == name)
					return  m.content;
			}
			return null;
	};
	
	var langCurrent;
	var langs ={"en":{
		culture:
		{
			date:{
				dayNames:["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"],
				abbrDayNames:["Sun","Mon","Tue","Wed","Thu","Fri","Sat"],
				monthNames:["January","February","March","April","May","June","July","August","September","October","November","December"],
				abbrMonthNames:["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],
				firstDayOfWeek:0,
				meridiemNames:{"am":"am","AM":"AM","pm":"pm","PM":"PM"},
				paterns: {
					shortDate    : "MM\/d\/yyyy",
					longDate     : "dddd, MMMM dd, yyyy",
					shortTime    : "h:mm t",
					longTime     : "h:mm:ss t",
					shortDateTime: "MM\/d\/yyyy h:mm t",
					longDateTime : "dddd, MMMM dd, yyyy h:mm t",
					fullDateTime : "dddd, MMMM dd, yyyy h:mm:ss t",
					yearMonth    : "yyyy MMMM",
					monthDay     : "MMMM dd"
				}
			},
			number:{
				separators:[",","."],
				groupSizes:[3],
				decimals:2,
				paterns:["-n","n"],
				percent:{"separators":[",","."],"groupSizes":[3],"decimals":2,"paterns":["-n %","n %"],"symbol":"%"},
				currency:{"separators":[",","."],"groupSizes":[3],"decimals":2,"paterns":["($n)","$n"],"symbol":"$"}
			}
		}
	}};
	$.lang = 
	{
		setCulture : function(id,callback)
		{
			id = id.toLowerCase();
			if(id=="en-us"){
				id="en";
			}
			var loadnew = false;
			if(!defined( langs[id])){
				langs[id] = {};
			}
			if( !defined( langs[id].culture))
			{
				$.getJSON( $.jQartaBaseUrl + 'lang/'+ id +'.json', function( data ) 
				{
					if(data){
						langs[id].culture = data;
						langCurrent = langs[id];
					}
					if(isFunction(callback)){
						callback(defined(langs[id].culture));
					}
				});
			}else{
				langCurrent = langs[id];
				if(isFunction(callback)){
					callback(true);
				}
			}
			
		}
	};
	
	$.localize   = function(a,b, c)
	{
		var name,conversation, langid;
		if(isObject(b)){
			conversation = b;
			name = a;
			langid = c || 'en';
		}
		else if(isObject(a)){
			conversation = a;
			name = "global";
			langid = b || 'en';
		}
		if(name)
		{
			if(!defined( langs[langid])){
				langs[langid] = {};
			}
			if(!defined( langs[langid][name] )){
				langs[langid][name] = {};
			}
			if(!defined( $.lang[name] ))
			{
				$.lang[name] = function(text)
				{
					var str = langid!='en'
					? langCurrent[name][text] || langs["en"][text] || text
					:langCurrent[name][text] || text;
					if(arguments.length>1)
					{
						return str.format(arguments.shift());
					}
				};
			}
			$.extend(langs[langid][name], conversation, true);
		}
	};
	
	$.localize({});
	
	
	var html     = document.getElementsByTagName('html')[0];
	$.htmlAttr=function(name){
		return html.getAttribute(name);
	};
	
	var langname = ($.htmlAttr('lang') || "en").toLowerCase();
	
	
	
	$.lang.setCulture(langname);
	
	window.__ = $.lang.global;
	
	////////////////////////////////////////////////////
	
	$.rectangle     = function (a,b,c,d){
		var self=this;
		
		if(arguments.length <=2 && isObject(a))
		{
			if(a[0] == window)
			{
				this.update = function()
				{
					this.left   = a.scrollLeft();
					this.top    = a.scrollTop();
					this.width  = a.width();
					this.height = a.height();
				};
			}else{
				this.update = function()
				{
					
					var of      = a.offset();
					this.width  = a.outerWidth();
					this.height = a.outerHeight();
					
					if(!b)
					{
						var oparent = a.offsetParent();
						//document.title = a.offsetParent()[0].tagName;
						//var mleft = parseFloat(a.css('margin-left'));
						//mleft = isNaN(mleft)?0:mleft;
						//var mtop  = a.css('margin-top');
						
						if( (/relative|absolute/).test(oparent.css('position')) )
						{
							this.left = of.left;
							this.top = of.top;
							
						}else{
							var offsetParent =oparent.offset();
							this.left = of.left - offsetParent.left;
							this.top  = of.top - offsetParent.top;
						}
						
					}
					else
					{
						//document.title="3";
						var $parent = $(b);
						if( $parent[0].tagName!='BODY' ||
						    $parent[0].tagName!='HTML')
						{
							var offsetParent = $parent.offsetParent().offset();
							
							this.left = of.left - offsetParent.left;
							this.top  = of.top - offsetParent.top;
						}
					}
				};
			}
			this.update();
		}
		else
		{
			this.left   = a?a:0;
			this.top    = b?b:0;
			this.width  = c?c:0;
			this.height = d?d:0;
		}
		
		this.right  = function() {return this.width + this.left;};
		this.bottom = function() {return this.height + this.top;};

		this.pointInRect = function(x,y)
		{
			return (x>=this.left && x<= this.right()) && (y>=this.top && y<= this.bottom());
		};
		var obj  =this;
		function _inRect(rc)
		{
			return rc.pointInRect(obj.left,obj.top)
			+ rc.pointInRect(obj.right(),obj.top)
			+ rc.pointInRect(obj.left,obj.bottom())
			+ rc.pointInRect(obj.right(),obj.bottom()); 
		};
		this.inRect = function(a)
		{
			return  _inRect(a)==4;
		};
		this.intersectsWith = function(rc)
		{
			var p= _inRect(rc);
			return (p>0 && p<4);
		};
		this.clone = function()
		{
			return new $.rectangle(self.left,self.top,self.width,self.height);
		};
		this.offset = function(x,y)
		{
			this.left  += x;
			this.top   += y || 0;
		};
		this.toCenterOfRect = function(rectOuter)
		{
			this.left  = (rectOuter.width - this.width)/2;
			this.top   = (rectOuter.height - this.height)/2;
		};
		this.scale = function(scale,centerPivot)
		{
			var pivot = centerPivot==undefined? true : centerPivot;
			var r = new $.rectangle(self.left,self.top,
				self.width * (scale/100),
				self.height * (scale/100));
			if(centerPivot)
			{
				r.left = self.left -  ((r.width-self.width) /2);
				r.top  = self.top -  ((r.height-self.height) /2);
			}
			return r;
		};
		this.fitToRect = function(rect)
		{
			var wh = $.fitSizeToSize(rect.width,rect.height,this.width,this.height);
			return new $.rectangle((rect.width-rect.height.width)/2,(rh-wh.height)/2, wh.width,wh.height);
		};

	};
	$.fitSizeToSize = function(rw,rh,width,height)
	{
		var w=0,h=0;
		if(rw>rh)
		{
			if(width>height)
			{
				if( (width / height) > (rw / rh) )
				{
					w=rw;
				}else{
					h=rh;
				}
			}else
				h=rh;
		}else
		{
			if(height>width)
			{
				if( (height / width) > (rh / rw) )
				{
					h=rh;
				}else{
					w=rw;
				}
			}else
				w = rw;
		}
		if(h==0)
			h=  parseInt ((w / width ) * height);
		if(w==0)
			w=  parseInt ((h / height ) * width);
		return {width:w,height:h};
	};
	$.cookie = function(name, value, options) 
	{
		/*
		* Copyright (c) 2006 Klaus Hartl (stilbuero.de)
		* Dual licensed under the MIT and GPL licenses:
		* http://www.opensource.org/licenses/mit-license.php
		* http://www.gnu.org/licenses/gpl.html
		*/
		if (typeof value != 'undefined') { // name and value given, set cookie
			options = options || {};
			if (value === null) {
				value = '';
				options.expires = -1;
			}
			var expires = '';
			if (options.expires && (typeof options.expires == 'number' || options.expires.toUTCString)) {
				var date;
				if (typeof options.expires == 'number') {
					date = new Date();
					date.setTime(date.getTime() + (options.expires * 24 * 60 * 60 * 1000));
				} else {
					date = options.expires;
				}
				expires = '; expires=' + date.toUTCString(); // use expires attribute, max-age is not supported by IE
			}
			// CAUTION: Needed to parenthesize options.path and options.domain
			// in the following expressions, otherwise they evaluate to undefined
			// in the packed version for some reason...
			var path = options.path ? '; path=' + (options.path) : '';
			var domain = options.domain ? '; domain=' + (options.domain) : '';
			var secure = options.secure ? '; secure' : '';
			document.cookie = [name, '=', encodeURIComponent(value), expires, path, domain, secure].join('');
		} else { // only name given, get cookie
			var cookieValue = null;
			if (document.cookie && document.cookie != '') {
				var cookies = document.cookie.split(';');
				for (var i = 0; i < cookies.length; i++) {
					var cookie = $.trim(cookies[i]);
					// Does this cookie string begin with the name we want?
					if (cookie.substring(0, name.length + 1) == (name + '=')) {
						cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
						break;
					}
				}
			}
			return cookieValue;
		}
    };
	
	// parseUri 1.2.2
	// (c) Steven Levithan <stevenlevithan.com>
	// MIT License
	$.parseUri = function  (str) {
		var	o   = $.parseUri.options,
			m   = o.parser[o.strictMode ? "strict" : "loose"].exec(str),
			uri = {},
			i   = 14;
		while (i--) {uri[o.key[i]] = m[i] || "";}
		uri[o.q.name] = {};
		uri[o.key[12]].replace(o.q.parser, function ($0, $1, $2) {
			if ($1) uri[o.q.name][$1] = $2;
		});
		return uri;
	};
	$.parseUri.options = {
		strictMode: false,
		key: ["source","protocol","authority","userInfo","user","password","host","port","relative","path","directory","file","query","anchor"],
		q:   {
			name:   "queryKey",
			parser: /(?:^|&)([^&=]*)=?([^&]*)/g
		},
		parser: {
			strict: /^(?:([^:\/?#]+):)?(?:\/\/((?:(([^:@]*)(?::([^:@]*))?)?@)?([^:\/?#]*)(?::(\d*))?))?((((?:[^?#\/]*\/)*)([^?#]*))(?:\?([^#]*))?(?:#(.*))?)/,
			loose:  /^(?:(?![^:@]+:[^:@\/]*@)([^:\/?#.]+):)?(?:\/\/)?((?:(([^:@]*)(?::([^:@]*))?)?@)?([^:\/?#]*)(?::(\d*))?)(((\/(?:[^?#](?![^?#\/]*\.[^?#\/.]+(?:[?#]|$)))*\/?)?([^?#\/]*))(?:\?([^#]*))?(?:#(.*))?)/
		}
	};
	
	$.parseSize = function  (strSize, strDefault) 
	{
		if(!isNumOrString(strSize)) return null;
		var _match = function(str){
			return str.match(/([0-9\.]+)(([a-z\%]+)$|$)/);
		};
		var match = _match(strSize.toString());
		if(!match && strDefault)
		{
			strSize = strDefault;
			match = _match(strDefault);
		}
		if(match)
		{
			var unit = (match[2] || 'px');
			return {
			'unit'  : unit,
			'value' : match[1] + unit, 
			'number': parseFloat(match[1])
			};
		}
		return null;
	};
////////////////////////////////////////////////////
////////////////////////////////////////////////////

	
	

	
/////////////////////////////////
////////////////////////////////

	$.extend($.fn,
	{
		rectangle : function(offsetParent)
		{
			return new $.rectangle(this,offsetParent);
		},
		display : function(bool)
		{
			if(bool == undefined || bool)
			{
				return this.show();
			}else{
				return this.hide();
			}
		},
		visible : function(bool)
		{
			return this.css('visibility',(bool == undefined || bool)?'visible':'hidden');
		},
		disable : function(bool){
			if(bool == undefined || bool)
			{
				return this.attr("disabled","disabled");
			}else{
				return this.attr("disabled",false);
			}
		},
		outerHtml : function(){
		
			if(this[0].outerHTML)
			{
				return this[0].outerHTML;
			}else{
			
				var c = $(this[0]).clone();
				var p = c.wrap('<div>').parent();
				var retval = p.html();
				p.remove();
				return retval;
			}
		},
		findParent : function(selector)
		{
			var parents = this.parents(selector);
			if(parents.length>0){
				return parents[0];
			}
			return false;
		},
		formData: function()
		{
			var form   = this[0];
			var elems  = form.elements;
			var retval = {};
			if(elems.length){
				for(var i=0;i<elems.length;i++)
				{
					var el=elems[i];
					if(el.disabled || isEmpty(el.name))
						continue;
					if(el.type=="checkbox" || el.type=="radio"){
						if(el.checked)
							retval[el.name] = el.value;
					}
					else
					{
						retval[el.name] = el.value;
					}
				}
			}
			return retval;
		},
		transform :function(css)
		{
			this.each(function(){
				this.style[$.support.transform] = css;
			});
			//this.css('-moz-transform',css);
		},
		rotate :function(a,b)
		{
			if(a && b)
			{
				return this.transform('rotateX('+a+') rotateY('+b+')');
			}
			else if(a){
				return this.transform('rotate('+a+')');
			}
		},
		scale : function(a,b)
		{
			if(a && b){
				return this.transform( 'scaleX('+a+') scaleY('+b+')');
			}
			else if(a){
				return this.transform( 'scale('+a+')');
			}
		},
		translate :function(a,b)
		{
			if(a && b){
				return this.transform( 'translateX('+a+') translateY('+b+')');
			}
			else if(a){
				return this.transform( 'translateX('+a+')');
			}else if(b){
				return this.transform( 'translateY('+b+')');
			}
		},
		translate3d :function(a,b,c)
		{
			this.transform( 'translate3d('+a+','+b+','+c+')');
		}
	});

	
	if($.support.transitionend && !$.browser.mozilla)
	{
		/////////////////////////////////////////////////////////////////////////
		///// Hardware Accellarator Animation //////////////////////////////////
		///// BUG on FireFox: The transitionend event is not firing consistently
		
		$.animate = $.fn.animate; 
		$.fn.animate = function(properties, b, c, d)
		{
		
			if(isObject(b) || defined(properties.scrollTop) || defined(properties.scrollLeft) )
			{
				$.animate.apply(this,[properties, b,c,d]);
				//$.animate.apply(this,[b]);
			}else
			{
				var 
				duration = (b/1000) + "s",
				easing   = c || "",
				complete = d;
				if(isFunction(c)){
					easing = "";
					complete = c;
				}
				var that=this;
				var ar = [];
				for(var i in properties){
					ar.push(i + " "+ easing + " " + duration);
				}
				this.css($.support.transition, ar.join(",")); 
				function transitionend()
				{
					this.css($.support.transition,"");
					if(isFunction(complete) )
					{
						complete();
					}
				}
				this.one($.support.transitionend, transitionend);
				this.css(properties);
			}
		}
		var fadeTo = function(that, duration, opacity, complete)
		{
			duration = duration || 400;
			var ds = (duration/1000)+"s";
			that.css($.support.transition, "opacity "+ ds); 
			
			function _complete(){
				that.css($.support.transition, ""); 
				if(isFunction(complete) )
				{
					complete();
				}
			}
			that.one($.support.transitionend, _complete);
			that.css("opacity",opacity); 
		}
		
		$.jQueryfadein  = $.fn.fadeIn;
		$.jQueryfadeout = $.fn.fadeOut;
		
		$.extend($.fn,
		{
			fadeIn : function(a,b)
			{
				if(isObject(a))
				{
					$.jQueryfadein.apply(this,[a]);
				}else{
					if(this.css('display')=='none'){
						this.css('opacity',0).show();
						this.css('display');
						fadeTo(this,a,1,b);
					}else{
						fadeTo(this,a,1,b);
					}
				}
			},
			fadeOut : function(a,b)
			{
				
				if(isObject(a))
				{
					$.jQueryfadeout.apply(this,[a]);
				}else{
					var that = this;
					this.css('display');
					fadeTo(this,a,0,function()
					{
						that.hide();
						if(isFunction(b)){
							b();
						}
					});
				}
			},
			//fadeTo( duration, opacity [, easing ] [, complete ] )
			fadeTo : function(a,b,c,d)
			{
				if(c && d)
				{
					this.animate({opacity:b},a,c,d);
				}else
				{
					fadeTo(this,a,b,c);
				}
			}
		});

	}
///////////////////////////////////////////////////
///////////////////////////////////////////////////

	$.Component =
	{

		create:function(){},
		init:function(element,options, defaultOption)
		{
			this.$element = $(element);
			this.options  = $.extend({}, defaultOption , options , this.$element.data());
			this.create();
		}
	};
	
	$.autoCreateComponents = 
	{
		roles:[],
		add:function(a, b)
		{
			this.roles.push([a,b]);
		},
		init: function(container)
		{
			container = container || document;
			//alert(container);
			for(var i=0;i<this.roles.length;i++)
			{
				var role = this.roles[i];
				if(isFunction(role[0]))
				{
					role[0](container);
				}
				else{
				
					var rolename = role[1] || role[0];
				
					$('[data-role*="'+ rolename +'"]',container)[role[0]]();
					
				}
			}
		}
	};
	
	/////////////////////////////////////////
	/////////////////////////////////////////
	
	function setOptionText(lbl,elem)
	{
		var text = elem.options[elem.selectedIndex].text;
		lbl.html(text||"&nbsp;");
	}
	$.autoCreateComponents.add( function(container)
	{
		$('.alert.dismissible',container).each(function()
		{
			var $alert = $(this).prepend('<button class="close">&times;</button>');
			$('button.close',this).on('click',function()
			{
	
				$alert.css('opacity',0).one($.support.transitionend, function()
				{
					var h = $alert.outerHeight() + parseFloat($alert.css('margin-bottom'));
					$alert.css({
						'padding':0,
						'border':0,
						'margin':0,
						'height':h
					});
					setTimeout(function(){
						$alert.css('height',0)
						.one($.support.transitionend, function(){$alert.remove();});
					},50);
					
				});
			});
		});
		
	});
	$.autoCreateComponents.add( function(container)
	{
		container = container || document;		
		$('.radio-glyph  input',container).after('<i class="glyph glyph-radio"></i>');
		$('.checkbox-glyph  input',container).after('<i class="glyph glyph-checkbox"></i>');
		
		$('.form-element>select',container).each(function()
		{
			var parent = $(this.parentNode);
			$(this).after('<span></span><i class="glyph glyph-arrow-down"></i>');
			var lbl = $('span',parent);
			
			$(this).change(function()
			{
				setOptionText(lbl,this);
			}).focus(
				function(){
				parent.addClass("border-focus");
			}).blur(
				function(){
				parent.removeClass("border-focus");
			});
			setOptionText(lbl,this);
			if(!parent.hasClass('block'))
			{
				parent.width($(this).width());
			}
			parent.addClass('select-control');
		});
		

	
	});
	
	/////////////////////////////////////////
	/////////////////////////////////////////
	$(document).ready(function()
	{
		$.autoCreateComponents.init();
	});
	
	
	$.postCsrf = function(url,data,callback,datatype)
	{
		data = data || {};
		data.token = $.htmlAttr('token');
		return $.post(url,data,callback,datatype || 'text');
	};
	
})(jQuery);

