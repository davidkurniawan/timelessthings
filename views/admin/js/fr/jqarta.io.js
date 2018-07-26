
;(function ($) 
{

	
	$.support.file         = 'File' in window;
	$.support.fileReader   = 'FileReader' in window;
	$.support.fileList     = 'FileList' in window;
	$.support.blob         = 'Blob' in window;
	
	
	$.IO = 
	{
		upload:function(file, posturl, postdata, callback, filepostname)
		{
			var formData = new FormData();
			var xhr      = new XMLHttpRequest();
			
			formData.append(filepostname || 'file', file);
			
			if( isObject(postdata) ){
				for(var n in postdata)
				{
					formData.append(n, postdata[n]);
				}
			}
			if(typeof callback == 'function')
			{
				xhr.upload.onerror = function(e)
				{
					callback(false, xhr.status);
				};
			}else
			{
				var obj = $.extend(
				{
					complete:function(){},
					error:function(){},
					progress:function(){},
					start:function(){}
					
				},callback);
				
				xhr.upload.onerror = function(e)
				{
					obj.error(xhr.status);
				};
				xhr.upload.onprogress = function(e)
				{
					//document.title=e.loaded;
					if (e.lengthComputable)
					{
						e.percentLoaded = ((e.loaded / e.total) * 100);
						obj.progress(e);	
					}
				};
			}

			xhr.onreadystatechange=function(e)
			{
				if(xhr.readyState==4)
				{
					if( xhr.status!=200)
					{
						if(typeof callback == 'function')
						{
							callback(false, xhr.status);
						}else{
							obj.error(xhr.status);
						}
					}else
					{
						//alert(xhr.responseText);
						var json;
						try{
							json = jQuery.parseJSON(xhr.responseText);
						}catch(e){}
						
						if(json)
						{
							if(json.err)
							{
								obj.error(json);
							}else{
								
								obj.complete(json);
							}
						}else
						{
							obj.complete(xhr.responseText);
						}
					}
				}
			};
			xhr.open("POST", posturl);
			xhr.send(formData);
		},
		readFile:function(file,callback,readmode)
		{
			readmode = readmode || 'dataurl';
			var reader = new FileReader();
			
			if(typeof callback == 'function')
			{
				reader.onload = function(e)
				{
					callback(true, e.target.result);
				};
				reader.onerror = function(e)
				{
					callback(false, e.target.error);
				};
				reader.onabort = function(e)
				{
					callback(false, null);
				};
			}else
			{
				var obj = $.extend(
				{
					result:function(){},
					error:function(){},
					progress:function(){},
					start:function(){},
					abort:function(){}
				},callback);
				
				reader.onload = function(e)
				{
					obj.result(e.target.result);
				};
				reader.onerror = function(e)
				{
					obj.error(e.target.error);
				};
				reader.onprogress = function(e)
				{
					obj.progress(e.loaded , e.total);
				};
				reader.onloadstart  = obj.start;
				reader.onabort      = obj.abort;
			}

			if(readmode ==  'text')
			{
				reader.readAsText(file);
			}
			else if(readmode ==  'binary')
			{
				reader.readAsBinaryString(file);
			}
			else if(readmode ==  'dataurl')
			{
				reader.readAsDataURL(file);
			}
			else
			{ //buffer
				reader.readAsArrayBuffer(file);
			}
		},
		readDataURL:function(file,callback)
		{
			this.readFile(file,callback,'dataurl');
		},
		readBinaryString:function(file,callback)
		{
			this.readFile(file,callback,'binary');
		},
		readText:function(file,callback)
		{
			this.readFile(file,callback,'text');
		},
		saveAs: function (filename, data,type)
		{
			var blobdata, downloadLink = document.createElement("a");
			
			if(typeof data =='string')
			{
				type = type ||  'text/plain';
				blobdata = new Blob([data], {"type":type});
			}else{
				if( data.constructor != Blob)
				{
					return false;
				}
				blobdata = data;
			}
			
			//////////////////////////////////////////////////////////////
			// http://thiscouldbebetter.wordpress.com/2012/12/18/loading-editing-and-saving-a-text-file-in-html5-using-javascrip/
			//////////////////////////////////////////////////////////////
			downloadLink.download = filename;
			downloadLink.innerHTML = "Download File";
			if (window.webkitURL != null)
			{
				// Chrome allows the link to be clicked
				// without actually adding it to the DOM.
				downloadLink.href = window.webkitURL.createObjectURL(blobdata);
			}
			else
			{
				// Firefox requires the link to be added to the DOM
				// before it can be clicked.
				downloadLink.href = window.URL.createObjectURL(blobdata);
				downloadLink.onclick = function (e){document.body.removeChild(e.target)};
				downloadLink.style.display = "none";
				document.body.appendChild(downloadLink);
			}
			downloadLink.click();
			return true;
		}
	};


	$.extend(window.File.prototype,
	{
		uload : function(posturl,postdata,callback , filepostname)
		{
			$.IO.upload(this, posturl, postdata, callback, filepostname);
		},
		readFile : function(callback)
		{
			$.IO.readFile(this,callback);
		},
		readText : function(callback)
		{//
			$.IO.readText(this,callback);
		},
		readDataURL : function(callback)
		{
			$.IO.readDataURL(this,callback);
		},
		readBinaryString : function(callback)
		{
			$.IO.readBinaryString(this,callback);
		}
	});
	
	$.IO.FileHandler = function(element, options)
	{
		var $element  = $(element);
		var op        = $.extend({}, $.IO.FileHandler.defaultOptions, options, $element.data());
		
		

		element = $element[0];
		element.__onfiles=function(files){
			return op.change(files);
		};
		element.__dragover=function(e){
			op.dragover(e);
		};
		element.__drop=function(e){
			op.drop(e);
		};
		element.__dragout=function(e){
			op.dragout(e);
		};
		function handleFileSelect(files) 
		{
			var _files,len;
			if(op.fileTypes)
			{
				_files =[];
				var rg = new RegExp("\.(" + op.fileTypes +")+$","i");
				for(var i=0;i<files.length; i++)
				{
					var f = files[i];
					if(rg.test(f.name))
					{
						_files.push(f);
					}
				}
			}else{
				_files = files;
			}
			len = _files.length;
			
			if(len)
			{
				var retval = element.__onfiles(_files);
				if(retval!==false)
				{
					if(typeof op.file == 'function')
					{
						for(var j=0;j<len; j++)
						{
							op.file({"file": _files[j],index:j,lastIndex:len-1});
						}
					}
				}
			}
		}
		var isDragFiles = false;
		if(element.tagName=='INPUT' && element.type=='file')
		{
			
			$element.on('change', function(e)
			{
				
				handleFileSelect(e.target.files);
			});
		}else
		{
			$element.on('dragover', function(e)
			{
				//var tx ="";
				isDragFiles = false;
				for(t in e.originalEvent.dataTransfer.types)
				{
				//	tx += e.originalEvent.dataTransfer.types[t] +"\n";
					if(e.originalEvent.dataTransfer.types[t]=='text/html'){
						return false;
					}
				}
				if(element.__dragover(e)!==false)
				{
					isDragFiles = true;
					e.stopPropagation();
					e.preventDefault();
					e.originalEvent.dataTransfer.dropEffect = 'copy';
				}
				
			})
			.on('drop', function(e)
			{
				if(e.originalEvent.dataTransfer.files && isDragFiles)
				{
					if(element.__drop(e)!==false)
					{
						e.stopPropagation();
						e.preventDefault();
						handleFileSelect(e.originalEvent.dataTransfer.files);
					}
				}
			})
			.on('dragleave dragend drop', function(e)
			{
				element.__dragout(e);
			})
		}
		
	};
	
	$.IO.FileHandler.defaultOptions = 
	{
		fileTypes       : null,
		change          : function(files){},
		//complete        : function(){},
		dragover        : function(e){},
		dragout         : function(e){},
		drop            : function(e){},
		file            : null
	};
	
	$.fn.fileHandler = function(options)
	{
		return this.each(function()
		{
			$.IO.FileHandler(this,options);
		});
	};
	
	
	
})(jQuery);









