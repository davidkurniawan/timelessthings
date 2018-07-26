	<?php 
	$isYt = true;
	$picture = "";
	if($this->content->id>0){
		$picture  = $this->content->picture;
		if($picture)
		{
			if($picture[0] ==":"){
				$picture = substr($picture,1 );
			}else{
				$isYt = false;
			}
		}else{
			$isYt = false;
		}
	}
	
	// var_dump($this->content);
	?>
	
<div class="grid-title grid cols-2">
	<div>
    	<h1><?php echo $this->title ?></h1>
    	
    	<div class="how_to" style="font-size:14px; color:#696666;">
    		<ol style="font-size:12px;">
    			<li>Masukkan Title, Deskripsi dan Save Maka Tombol Upload Gambar Akan Aktif</li>
    			<!-- <li></li> -->
    		</ol>
    	</div>
    	
    	
    </div>
    
    <div class="text-right">
		
	    	<?php 
		//if($this->isHaveCategories) { 
		?>
        
    	<div class="button-group" id="categoriesButton">
          <button class="button default" data-role="dropdown">Category: 
          <span id="category_title"><?php echo $this->content->categoryTitle ?></span> <span class="glyph glyph-arrow-down"></span></button>
          <ul class="popup">
            <?php
					foreach($this->categories as $term)
					{
						
						// if($term->parent!=0 )
						// {
							
						
				?>
                	<li class="category-item"><a data-name="<?php echo $term->pathName ?>" data-id="<?php echo $term->id ?>" href="javascript:;"><?php echo $term->title ?></a></li>
			<?php
						// }
					}
			?>
          </ul>
        </div>
        
        <?php // }  ?>
	
        <div class="button-group float-right">
          <?php 
		  $btnclass="success";
		  if ($this->content->status==0){ ?><button  id="btnSave" class="save_pub button success bold">Save and Publish</button><?php } ?>
          <?php if ($this->content->status==1){  ?><button  id="btnSave" class="save_changes button success">Save Changes</button><?php } ?>
           
          <button id="btnSaveDropdown" type="button" class="button success"  data-role="dropdown"><span class="glyph glyph-arrow-down"></span></button>
          <ul class="popup">
          	<li><a class="save_changes" href="javascript:;">Save Changes</a></li>
            <?php //if ($this->content->status==0){ ?>
            <li><a class="save_pub" href="javascript:;">Save and Publish</a></li>
            <?php //} ?>
            <?php //if ($this->content->status==1){ ?>
            <li><a class="save_pending" href="javascript:;">Save and Pending</a></li>
			<?php //} ?>
          </ul>
        </div>
		<?php if ($this->content->id>0 && $isYt!=true){ ?>
		<div id="btnAddFiles" type="button" style="margin-right:10px" class="button default float-right"><i class="icon icon-upload"></i>
        	<input id="inputFile" multiple="multiple" type="file">
        </div>
		<?php }else{ ?>
			<div id="btnAddFiles"  style=" background:#666666; margin-right:10px"  type="button" class="button default float-right"><i  style=" color:#F2F2F2;"  class="icon icon-upload"></i>
        	<input id="inputFile"multiple="multiple" type="file" disabled="disabled">
        </div>
		<?php } ?>
		
    </div>
</div>
<script language="javascript" src="<?php echo Request::$baseUrl . "/js/jqarta.io.js" ?>"></script>
<script type="text/javascript">
tinymce.init({
	selector: '#c_content',
	content_css: "/js/css/styles.css?v3",
	relative_urls: false,
    remove_script_host: false,
    plugins: [
        // "advlist autolink lists link image charmap anchor",
        // "searchreplace visualblocks code",
        // "insertdatetime paste"
    ],
    toolbar: " bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent "
	, setup: function(editor) {
		// editor.addButton('btn_media', {
           // // text: 'Image',
            // icon: 'image',
            // onclick: function() {
                // isAddFeaturedImg = false;
				// $.mediaDialog.show();
            // }
        // });
   }
});
</script>
<div style="position:relative;">
	<?php if($this->featuredImage)
	{
		
	?>
    <div id="featuredImg" class="form-element">
        <div style="background-image:url(/media/library/<?php echo $this->content->picture ?>)"> </div>
    </div>
    <div>
    	<?php }else{ ?>
    		
			<div>
    	<?php } ?>
    <table class="form block-md">
    <tr>
        <th><label>Title</label></th>
        <td>
            <input id="inputTitle" placeholder="Title" value="<?php echo htmlentities($this->content->title) ?>" class="form-element block bold" />
        </td>
    </tr>
    <?php 
        $inputName_attr ='disabled="disabled"';
        if($this->task=='edit'){
            $inputName_attr = 'id="inputName"';
        } 
    ?>
    <tr>
        <th><label>Permalink</label></th>
        <td>
             <div>
            <div class="input-group">
                <label class="text-gray"><?php echo Request::$baseUrl ?>/<span id="categoryPathName"><?php  echo $this->content->pathName ?></span>/</label>
                <input <?php echo $inputName_attr ?>  value="<?php echo $this->content->name ?>" placeholder="Path name of Permalink URL" class="form-element">
            </div>
         </div>
        </td>
    </tr>
	<?php 
	if($isYt){
	?>

    <tr>
        <th><label>Youtube URL/Video ID</label></th>
        <td>
            <input id="inputYt" placeholder="Kosongkan jika galeri foto" value="<?php echo htmlentities($picture) ?>" class="form-element block bold" />
        </td>
    </tr>
	<?php } ?>
     <!-- <tr>
        <th><label>Description</label></th>
        <td>
      <textarea class="form-element" id="c_content" name="content" style="height:150px; width:100%"><?php echo htmlentities($this->content->body) ?></textarea>
        </td>
    </tr>  -->
</table>
</div>
</div>
<br />
<br />

 <textarea class="form-element" id="c_content" name="content" style="height:150px; width:100%"><?php echo htmlentities($this->content->body) ?></textarea>
 
 <br />
 <br />
 
 
 <?php if($this->content->id>0){ ?>
 	
 	<div class="grid cols-4 spacing-15">
 		<div  class="input-group">
		 	<label>Price (IDR)</label>
		    <input  id="pricing" type="text" placeholder="Product Pricing" class="form-element questiondesc" value="<?php echo isset($this->content->metaData['price']) ? $this->content->metaData['price'] : ""; ?>" />
		  
		</div>	
 
 	</div>
 
 
 <br /><br />
 
<?php } ?>

<br /><br />




<?php  if($this->content->id>0 && $isYt!=true){ ?>
<table id="mediaTableData" class="datatable table border-outer border-cell-h">
<thead>
	<tr>
        <th colspan="3">Photos Product</th>
    </tr>
</thead>
<tbody>

<?php if($this->photos){
	foreach($this->photos as  $key=> $item ) { 

		
		$thumbnailUrl = ImageDocument::getImageUrl($item->name . ".". $item->extension,'gallery','t');
		$ext = $item->extension;
		$attr = '';
		$isImage = true;
		if($ext=='jpg' || $ext=='png'){
			$attr = 'class="media-thumb" style="background-image:url(' .  $thumbnailUrl . ')"';
		}else{
			$isImage=false;
			$attr = 'class="media-thumb ' . $item->extension . '"';
		}
		$status = $item->status!=1?'':' published';
?>
		
    <tr class="gallery-item" data-name="<?php echo $ext == 'jpg' ? $item->name.'.jpg' : $item->name.'.png'?> ">
    	<td>
    		
    		<!-- Set Default Picture -->
    		
    	</td>
        <td><img src="<?php echo $this->templateUrl ?>/img/media_thumb.png" <?php echo $attr ?> /></td>
        <td>
		<a data-status="<?php echo $item->status ?>" onclick="_status(this,<?php echo $item->id ?>)" 
        href="javascript:;" class="status icon icon-checkmark<?php echo $status ?>"></a>
		<span class="spacer"></span>
        <a title="Delete permanently" 
		onclick="_delete(this,<?php echo $item->id ?>)"
		 href="javascript:;" class="icon icon-cancel-circle"></a>
        </td>
       
        <td style="width:100%">
        <div class="input-group">
          <input placeholder="Caption" class="form-element chooseColor" value="<?php echo htmlentities($item->description) ?>" />
          <span class="input-group-button">
            <button onclick="media_save_desc(this,<?php echo $item->id ?>)" 
			type="button" class="button default"><i class="icon icon-floppy-o"></i></button>
          </span>
        </div>
        </td>
         <!-- <div id="colorpickerHolder"></div> -->
        
    </tr>
<?php }} ?>

</tbody>
</table>
<?php  }  ?>
<br />
<?php require $this->templatePath . "/inc.media-dialog.php"; ?>
<script language="javascript">

	var pathUrl = window.location.href.split('?')[0];
	var $postData = 
	{
		id      : <?php echo $this->content->id ?>, 
		title   : "<?php echo $this->content->title ?>", 
		picture : "<?php echo $this->content->picture ?>", 
		category: <?php echo $this->content->category ?> ,
		meta 	: {}
	};
	
	
$('.save_changes').on('click',function()
{
	update();
});
$('.save_pub').on('click',function()
{
	$postData.status =1; 
	update();
});
$('.save_pending').on('click',function()
{
	$postData.status =0; 
	update();
});


function update()
{
	$postData.title = $("#inputTitle").val().trim();
	if($postData.title=='')
	{
		alert("Title is required field");
		return false;
	}
	if($("#inputName").length)
	{
		$postData.name  = $("#inputName").val().trim();
	}
	
	
	$postData.body  =  tinymce.activeEditor.getContent();
	// console.log("auooo>>>>>" + $postData.body);
	if($postData.body=='')
	{
		alert("Description is required field");
	}
	
	$photos = $('.gallery-item .published');
	
	
	// if($("#inputYt").length)
	// {
		// var yt = $("#inputYt").val().trim();
		// if(yt){
			// $postData.picture  = ":"+ yt;
		// }else{
			// // $postData.picture="";
		// }
	// }else
	// {
// 	
		// if($photos.length){
// 			
			// $postData.meta = {"photos": $photos.length};
			// $postData.picture = $($photos[0]).data('name'); 
		// }else{
			// $postData.meta = {"photos": 0};	
			// $postData.status  = 0; 
		// }
	// }
	
	$('#btnSaveDropdown').disable();
	var $btnSave = $('#btnSave').disable();
	var prev =  $btnSave.html();
	$btnSave.html("Updating...");
	$postData.task='save';
	
	if($("#pricing").length)
	{
		$postData.meta['price'] = $("#pricing").val().trim();
	}
	
	if($("#customProduct").length)
	{
		$postData.meta['customImage']=$("#customProduct").val().trim();
	}
	if($("#customOverlayProduct").length)
	{
		$postData.meta['customOverlay']= $("#customOverlayProduct").val().trim();
	}
	if($("#guarantee").length)
	{
		$postData.meta['guaranteeDelivered']= $("#guarantee").val().trim();
	}
	$.post(pathUrl,$postData,function(ret){
		
		$('#btnSaveDropdown').disable(false);
		$btnSave.disable(false);
		if($postData.status ===0){
			$btnSave.html("Save and Publish");
			$btnSave.removeClass("save_pub save_changes").addClass("save_pub");
		}
		else
		{	
			$btnSave.html("Save Changes");
			$btnSave.removeClass("save_pub save_changes").addClass("save_changes");
		}
		if($postData.id==0 && ret)
		{
			if(ret.id){
				location.href = pathUrl.replace(/\/new$/,"") + '/edit?id='+ret.id;
			}
		}
	},"json");
}

var $featuredImg      = $('#featuredImg>div');

$categoriesButton = $('#categoriesButton'),
	$categoryItems    = $('.category-item a');
	$categoryItems.on('click',function()
	{
		var el = $(this);
		$postData.category = el.data('id');
		
		$('#categoryPathName').text(el.data('name'));
		$('#category_title').text(el.text());
	});

var galeryId = <?php echo $this->content->id ?>;
var $btnAddFiles    = $('#btnAddFiles');
var $btnInputFiles  = $('#btnAddFiles input');
var upload_index,upload_files;
var $mediaTableData =  $('#mediaTableData');
var fileHandler = new $.IO.FileHandler($btnInputFiles,
{
	fileTypes  :"jpg|png",
	change    : function(files)
	{
		upload_index = 0;
		upload_files = files;
		next_upload();
	}
});

function updatePhotoInfo()
{
	$.post(location.href,{"task":"numpics"},function(){});

}
function media_save_desc(a,id)
{
	media_save_data(a,id,"save_desc", function(){ updatePhotoInfo });
}
function _delete(a, id)
{
	data_table_row_delete(a, id, ADMIN_BASE_URL + '/media/upload',updatePhotoInfo);
	
}

function _status(a, id){
	var el = $(a);
	var s =  el.data('status');
	data_table_row_status(a, id,  ADMIN_BASE_URL + '/media/upload', s, function(obj)
	{
		if(s==1){
			el.data('status',0);
			el.removeClass('published');
		}else{
			el.data('status',1);
			el.addClass('published');
		}
		updatePhotoInfo();
	});
}
function next_upload()
{
	var ulpoad_indx_sts = (upload_index+1) + " / " + upload_files.length;
	var fileToUpload   = upload_files[upload_index];
	$('tbody', $mediaTableData).prepend(
	'<tr>\
		<td colspan="3" style="padding:20px">\
			<div class="progressbar"><div class="progressbar-meter"></div></div>\
			<div>Uploading file '+ ulpoad_indx_sts +' ( '+ fileToUpload.name +')</div>\
		</td>\
	</tr>'
	);
	var $tr = $('tbody>tr:first-child',$mediaTableData);
	var $progressbar = $('.progressbar',$tr);
	var $meter       = $('.progressbar-meter',$progressbar).css('width','1%');

	function checkNextUpload()
	{
		upload_index++;
		if(upload_index!=upload_files.length )
		{
			setTimeout(next_upload,300);
			
		}else{
			updatePhotoInfo();
			location.reload();
		}
	}
	$.IO.upload(fileToUpload,ADMIN_BASE_URL+ '/media/upload', {"status":0,"mtype":"gallery","owner": galeryId }, {
		
		complete:function(obj)
		{
			
			// window.location.reload();
		// console.log(obj.fileTypes);
	$tr.after('<tr class="gallery-item new"  data-name="'+ obj.dataFile.name+'.jpg">\
	<td><img src="/themes/sa/img/media_thumb.png" class="media-thumb" style="background-image:url(/media/gallery/t/'+ obj.dataFile.name+'.jpg)"></td>\
        <td><a data-status="0" onclick="_status(this,'+ obj.dataFile.id+')" href="javascript:;" class="status icon icon-checkmark"></a>\
        </td>\
        <td style="width:100%">\
        <div class="input-group">\
          <input placeholder="Caption" class="form-element chooseColor" value="">\
          <span class="input-group-button">\
            <button onclick="media_save_title(this,'+ obj.dataFile.id+')" type="button" class="button default"><i class="icon icon-floppy-o"></i></button>\
          </span>\
        </div>\
        </td>\
    </tr>');
	
			//$('input',$tr.next()).val(obj.dataFile.description);
			$tr.remove();
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
var isAddFeaturedImg, isAddOverlayImg = false;
	$.mediaDialog.insert = function(item)
	{
		if(item.extension =='jpg' || item.extension =='png' || item.extension =='gif')
		{
			var mediumUrl = '/media/library/h/'+  item.filename;
			var thumbUrl  = '/media/library/t/'+  item.filename;
			if((isAddFeaturedImg || $postData.picture=='') && $featuredImg.length)
			{
				$postData.picture = mediumUrl;
				$featuredImg.css('background-image','url('+ thumbUrl +')');
			}else if(isAddOverlayImg)
			{
				$("#customOverlayProduct").val(item.filename);
			}
			
			
			else{
				
				// var credit = $.mediaDialog.getSelectedCredit();
				// if(credit){
					// tinymce.activeEditor.insertContent('<div class="image-caption float-left">\
					// <img alt="'+ item.title +'" src="'+ mediumUrl +'" />\
					// <p class="image-caption-text">Foto: '+ credit +'</p>\
					// </div>');
				// }else{
					// tinymce.activeEditor.insertContent('<img class="float-left" alt="'+ item.title +'" src="'+ mediumUrl +'" />'); 
				// }
				
				$("#customProduct").val(item.filename);
				
			}
		}else{
			var seltext = tinymce.activeEditor.selection.getContent({format: 'text'});
			tinymce.activeEditor.insertContent('<a href="/media/library/'+ item.filename +'" title="'+ item.title +'">'+ (seltext || item.title) +'</a>'); 
		}
		$.mediaDialog.hide();
	};
	
	$("#insertCustomOverlayImage").click(function(){
		
		
			isAddOverlayImg = true;
		$.mediaDialog.show();
	});
	
	$('#insertCustomImage').click(function(){
		
		isAddFeaturedImg = false;
			isAddOverlayImg = false;
		$.mediaDialog.show();
			
	
	});
	

	
$('#btnAddMedia').click(function()
	{
		isAddFeaturedImg = false;
		isAddOverlayImg = false;
		$.mediaDialog.show();
	});
	
	$('#featuredImg').click(function()
	{
		// console.log("auooo");
		isAddFeaturedImg = true;
		$.mediaDialog.show();
		
	});
	
	// colorPick();
	colorPick();
	function colorPick()
	{
			
		$(".chooseColor").each(function(){
			var that = this;
			$(this).ColorPicker({
				color : '#0000ff',
				onShow : function(colpkr) {
					$(colpkr).fadeIn(100);
					return false;
				},
				onHide : function(colpkr) {
					$(colpkr).fadeOut(100);
					return false;
				},
				onChange : function(hsb, hex, rgb,el) {
					
					// var currentColor = activeObj.getFill();
					//Editor.changeColor("#"+hex);
					
					$(that).val("#"+hex);
					
					//$('#colorSelector div').css('backgroundColor', '#' + hex);
				}
				
			}); 
		
		});
		
		
	}
	

</script>









