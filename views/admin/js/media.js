var $btnAddFiles    = $('#btnAddFiles');
var $btnInputFiles  = $('#btnAddFiles input');
var upload_index,upload_files;
var $mediaTableData =  $('#mediaTableData');
var fileHandler = new $.IO.FileHandler($btnInputFiles,
{
	fileTypes  :"jpg|png|pdf|doc|xls|ppt|pps|docx|xlsx|pptx",
	change    : function(files)
	{
		upload_index = 0;
		upload_files = files;
		next_upload();
		
	}
});

function _delete(a, id){
	data_table_row_delete(a, id, ADMIN_BASE_URL + '/media/upload');
}

function next_upload()
{
	var ulpoad_indx_sts = (upload_index+1) + " / " + upload_files.length;
	var fileToUpload   = upload_files[upload_index];
	$('tbody', $mediaTableData).prepend(
	'<tr>\
		<td><div class="thumb spinner"></div></td>\
		<td class="td_title bold">\
			<div class="progressbar"><div class="progressbar-meter"></div></div>\
			<div>Uploading file '+ ulpoad_indx_sts +' ( '+ fileToUpload.name +')</div>\
		</td>\
		<td class="td_act"></td>\
		<td class="td_type"></td><td class="td_poster"></td><td class="td_date"></td>\
	</tr>'
	);
	var $tr = $('tbody>tr:first-child');
	var $progressbar = $('.progressbar',$tr);
	var $meter       = $('.progressbar-meter',$progressbar).css('width','1%');


	function checkNextUpload()
	{
		upload_index++;
		if(upload_index!=upload_files.length )
		{
			setTimeout(next_upload,300);
		}
	}
	$.IO.upload(fileToUpload,ADMIN_BASE_URL+ '/media/upload', null, {
		
		complete:function(obj)
		{
			
			$tr.addClass('new');
			$('.thumb',$tr).removeClass("spinner").css('background-image','url('+obj.thumbnailUrl+')'); 
			$('.td_title',$tr).html(obj.dataFile.title);
			$('.td_type',$tr).html(obj.dataFile.extension.toUpperCase() + " File");
			$('.td_poster',$tr).html(obj.dataFile.realname);
			$('.td_date',$tr).html(obj.dataFile.datePosted);
			$('.td_act',$tr).html('<a onclick="_delete(this,'+obj.dataFile.id+')" href="javascript:;" class="fa fa-close"></a>');
			
			checkNextUpload();
		},
		error:function(sts)
		{
			$tr.addClass('error');
			$('.td_title',$tr).html(sts);
			checkNextUpload();
		},
		progress:function(e){
			$meter.css('width',e.percentLoaded +'%');
		},
		start:function(){
			
		}
	}, 'file');
}