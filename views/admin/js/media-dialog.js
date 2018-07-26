;(function($){
	var hasMediaData = false;
	var $mediaList   = $('#mediaDialogList');
	var $mediaSearchList = $('#mediaDialogSearchList').hide();
	var $mediaDialog = $('#mediaDialog').modal(
		{
			show : function(){
				if(!hasMediaData)
				{
					$.mediaDialog.load(function(html){
						$mediaList.html(html);
						$.mediaDialog._select("#mediaDialogList > div:first-child > div.dlg-media-item");
						// $('.dlg-media-item').addClass('current');
						hasMediaData=true;
					},"");
				}
			}
		});
	
	var $mediaDialog_BtnInsert = $('#mediaDialog_BtnInsert').disable();
	var currImgUrl, currImgAlt;
	var searchText ="";
	
	$('#mediaDialog_searchInput').on('change keyup',function()
	{
		if(this.value=="")
		{
			searchText ="";
			$mediaList.show();
			$mediaSearchList.hide().html("");
		}
	});
	
	$.mediaDialog = 
	{
		insertMode   : "html",
		forceFilename: "",
		show:function()
		{
			$mediaDialog.modal('show');
		},
		hide:function()
		{
			$mediaDialog.modal('hide');
		},
		selectedItem: {},
		_select:function(item)
		{
			var el   = $(item);
			var data = el.data('file');
			$('.current',$mediaList).removeClass('current');
			el.addClass('current');
			this.selectedItem     = data;
			
			if(data.extension=='jpg' || data.extension=='png')
			{
				$('#dlgParamImage').show();
			}else{
				$('#dlgParamImage').hide();
			}
			$('#mediaDialogParam').show();
			$('#dlgParamThumb').html( el.html() );
			
			$('#dlgParamName').text( data.filename);
			$('#dlgParamDate').text( data.datePosted );
			$('#dlgParamSize').text( (data.fileSize/1000) + " KB");
			
			$('#dlgParamAlt').val( data.title);
			$('#dlgParamCredit').val( data.metaData["credit"]?data.metaData["credit"]:"" );
			
			$mediaDialog_BtnInsert.disable(false);
		},
		getSelectedCredit:function () 
		{ 
			return $('#dlgParamCredit').val();
		
		},
		load: function(callback,q, page)
		{
			$mediaDialog.addClass('mediaDialog-loading');
			$.get(ADMIN_BASE_URL + '/media?mode=dialog_content&q='+ q + (page?'&p='+page :''),function(html)
			{
				$mediaDialog.removeClass('mediaDialog-loading');
				callback(html);
			});
		},
		_loadmore: function(elem, p)
		{
			this.load(function(html)
			{
				$mediaList.append(html);
				$(elem.parentNode).remove();
			}, searchText ,p);
			
		},
		_search : function()
		{
			var text = $('#mediaDialog_searchInput').val().trim();
			if(text)
			{
				searchText = text;
				this.load(function(html)
				{
					$mediaList.hide();
					$mediaSearchList.show().html(html);
				}, text);
			}
		},
		insert: function(){},
		_err_del: function(a)
		{
			$(a.parentNode.parentNode.parentNode).remove();
		}
	}
	$('#mediaDialog_BtnInsert').click(function()
	{
		$.mediaDialog.insert($.mediaDialog.selectedItem);
	});
	
	var upload_index,upload_files;
	var $mediaDialog_btnUploadInput=$('#mediaDialog_btnUploadInput');
	

	var fileHandler = new $.IO.FileHandler($mediaDialog_btnUploadInput,
	{
		fileTypes  :"jpg|png|gif|zip|rar|gz|pdf|doc|xls|ppt|pps|docx|xlsx|pptx",
		change    : function(files)
		{
			upload_index = 0;
			upload_files = files;
			next_upload();
		}
	});

	function next_upload()
	{
		var ulpoad_indx_sts = (upload_index+1) + " / " + upload_files.length;
		var fileToUpload    = upload_files[upload_index];
		$mediaList.prepend(
			'<div>\
				<div class="dlg-media-item">\
					<div>\
						<img class="media-thumb"  src="<?php echo $this->templateUrl ?>/img/media_thumb.png" />\
						<div class="media-item-title">.</div>\
						<div class="progressbar"><div class="progressbar-meter"></div></div>\
						<i onclick="$.mediaDialog._err_del(this)" class="media-item-del fa fa-close"></i>\
					</div>\
				</div>\
			</div>'
		);
		var $preloader   = $('#mediaDialogList>div:first-child');
		var $progressbar = $('.progressbar',$preloader);
		var $meter       = $('.progressbar-meter',$progressbar).css('width','1%');
	
		function checkNextUpload()
		{
			upload_index++;
			if(upload_index!=upload_files.length ){
				setTimeout(next_upload,300);
			}
		}
		var postdata ={"ref":"dialog"};
		if($.mediaDialog.forceFilename!="")
		{
			postdata.forceFilename = $.mediaDialog.forceFilename;
		}
		
		$.IO.upload(fileToUpload, ADMIN_BASE_URL+ '/media/upload',postdata , {
			complete:function(obj)
			{
				$preloader.remove();
				$mediaList.prepend(obj.html);
				checkNextUpload();
			},
			error:function(sts)
			{
				$preloader.addClass('error');
				$('.media-item-title',$preloader).html(sts);
				checkNextUpload();
			},
			progress:function(e)
			{
				$meter.css('width',e.percentLoaded +'%');
			},
			start:function(){
				
			}
		}, 'file');
	}
	
})(jQuery);

// 
// $(document).ready(function(){
// 	
// });
