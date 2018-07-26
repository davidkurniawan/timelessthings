
<div class="grid-title grid cols-2">
	<div>
    	<h1><?php echo $this->title ?></h1>
    </div>
    <div class="text-right">


    	<?php
		if($this->isHaveCategories) {
		?>

    	<div class="button-group" id="categoriesButton">
          <button class="button default" data-role="dropdown">Category:
          <span id="category_title"><?php echo $this->content->categoryTitle ?></span> <span class="glyph glyph-arrow-down"></span></button>
          <ul class="popup">
            <?php
					foreach($this->categories as $term)
					{
				?>
                	<li class="category-item"><a data-name="<?php echo $term->pathName ?>" data-id="<?php echo $term->id ?>" href="javascript:;"><?php echo $term->title ?></a></li>
			<?php
					}
			?>
          </ul>
        </div>

        <?php }  ?>

        <div class="button-group">
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
    </div>
</div>
<script language="javascript" src="<?php echo $this->templateUrl . "/js/fr/jqarta.io.js" ?>"></script>
<script type="text/javascript">
tinymce.init({
	selector: '#c_content',
	content_css: "/themes/admin/css/framework/styles.css?v3 ",
	relative_urls: false,
    remove_script_host: false,
    plugins: [
        "advlist autolink lists link image charmap anchor",
        "searchreplace visualblocks code",
        "insertdatetime paste"
    ],
    toolbar: "btn_save | btn_media | insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link"
	, setup: function(editor) {
		editor.addButton('btn_media', {
           // text: 'Image',
            icon: 'image',
            onclick: function() {
                isAddFeaturedImg = false;
				$.mediaDialog.show();
            }
        });
   }
});
</script>

<div style="position:relative">
	<?php if($this->featuredImage)
	{

	?>
    <div id="featuredImg" class="form-element" style="float:left;">
        <div style="background-image:url(/uploads/library/<?php echo $this->content->picture ?>)"> </div>
    </div>

    <div>
    <table class="form block-md">
    <?php }else { ?>
    <div>
    <table class="form block-md">
    <?php } ?>

<?php if($this->upperHead){ ?>
<tr>
    <th><label>Upper head</label></th>
    <td>
        <input id="inputUpperHead" placeholder="Upper head" value="<?php echo htmlentities( @ $this->content->metaData['upperHead']) ?>" class="form-element block" />
    </td>
</tr>
<?php } ?>
<tr>
    <th><label>Title</label></th>
    <td>
        <input id="inputTitle" placeholder="Title" value="<?php echo htmlentities($this->content->title) ?>" class="form-element block bold" />
    </td>
</tr>
<?php
	$inputName_attr ='disabled="disabled"';
	if($this->task=='edit')
	{
		$inputName_attr = 'id="inputName"';
	}
?>
<tr>
    <th><label>Permalink</label></th>
    <td>
	 <?php  if($this->contentType!='page'){ ?>
         <div>
            <div class="input-group">
                <label class="text-gray"><?php echo Request::$baseUrl ?>/<span id="categoryPathName"><?php  echo $this->content->pathName ?></span>/</label>
                <input <?php echo $inputName_attr ?>  value="<?php echo $this->content->name ?>" placeholder="Path name of Permalink URL" class="form-element">
            </div>
         </div>
         <?php } else {?>
         <div>
            <div class="input-group">
                <label class="text-gray"><?php echo Request::$baseUrl ?>/page</label>
                <input <?php echo $inputName_attr ?>  value="<?php echo $this->content->name ?>" placeholder="Path name of Permalink URL" class="form-element">
            </div>
         </div>
    <?php } ?>
    </td>
</tr>

<?php  if($this->contentType=='event'){ ?>
<tr>
    <th><label>Date of Event</label></th>
    <td>
        <div style="margin-bottom:15px">
            <div class="input-group">
                <label class="text-gray"><div style="width:100px">Date Start</div></label>
                <input id="inputDate" placeholder="yyyy-mm-dd" value="" class="form-element" />
            </div>
        </div>
        <div>
            <div class="input-group">
                <label class="text-gray"><div style="width:100px">Date End</div></label>
                <input id="inputDate" placeholder="yyyy-mm-dd" value="" class="form-element" />
            </div>
        </div>
    </td>
</tr>
<?php } ?>

</table>

</div>
</div>
<br />
<br />

<br />
<br />
<br />
<br />
<div class="overflow:hidden;">
	<textarea id="c_content" name="content" style="height:380px; width:100%"><?php echo htmlentities($this->content->body) ?></textarea>
</div>	
	<br />

	<?php if ($this->contentType == "management")
	{
		?>

		 <div class="input-group">
                <label class="text-gray"><div style="width:100px">Linkedin Profile</div></label>
                <input id="linkedinprofile" placeholder="http://linkedin/user" value="<?php echo isset($this->content->metaData['linkedin']) ?  $this->content->metaData['linkedin'] : "" ; ?>" class="form-element" />
            </div>
		<?php
	}
	?>
	<!-- Meta Key -->



<?php
 require $this->templatePath . "/inc.media-dialog.php";
?>

<script language="javascript">
	var pathUrl = window.location.href.split('?')[0];
	var $postData =
	{
		id:<?php echo $this->content->id ?>,
		picture:"<?php echo $this->content->picture ?>",
		category:<?php echo $this->content->category ?> ,
		meta:{}
	};

	var
	$featuredImg      = $('#featuredImg>div'),
	$categoriesButton = $('#categoriesButton'),
	$categoryItems    = $('.category-item a');
	$categoryItems.on('click',function()
	{
		var el = $(this);
		$postData.category = el.data('id');

		$('#categoryPathName').text(el.data('name'));
		$('#category_title').text(el.text());
	});

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

		if($("#inputUpperHead").length){
			$postData.meta['upperHead'] = $("#inputUpperHead").val().trim();
		}else{
			$postData.meta['upperHead'] = "";
		}
		$postData.title = $("#inputTitle").val().trim();

		if($("#linkedinprofile").length)
		{
			$postData.meta['linkedin'] = $("#linkedinprofile").val().trim();
		}

		if($postData.title=='')
		{
			alert("Title is required field");
			return false;
		}
		if($("#inputName").length)
		{
			$postData.name  = $("#inputName").val().trim();
		}
		if($postData.category==0 && $categoriesButton.length)
		{
			alert("Please select category");
			return false;
		}

		$postData.body  = tinymce.activeEditor.getContent();
		var img = tinymce.activeEditor.dom.select('img');
		if($postData.picture =='' && $featuredImg.length && $postData.status==1)
		{
			alert("The content can not be save without featured image. Please insert one then continue saving");
			$postData.status= undefined;
			return false;

		}
		else
		{
			$('#btnSaveDropdown').disable();
			var $btnSave = $('#btnSave').disable();
			var prev =  $btnSave.html();

			$btnSave.html("Updating...");
			$postData.task='save';

			$.post(pathUrl,$postData,function(ret)
			{
				//alert(ret);
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
	}

	var isAddFeaturedImg;
	$.mediaDialog.insert = function(item)
	{
	    console.log(item);
		if(item.extension =='jpg' || item.extension =='png' || item.extension =='gif')
		{
			var fullUrl = '/uploads/library/'+  item.filename;
			var mediumUrl = '/uploads/library/h/'+  item.filename;
			var thumbUrl  = '/uploads/library/t/'+  item.filename;
			if((isAddFeaturedImg || $postData.picture=='') && $featuredImg.length)
			{
				$postData.picture = mediumUrl;
				$featuredImg.css('background-image','url('+ thumbUrl +')');
			}else{

				var credit = $.mediaDialog.getSelectedCredit();
				if(credit){
					tinymce.activeEditor.insertContent('<div class="image-caption float-left">\
					<img alt="'+ item.title +'" src="'+ mediumUrl +'" />\
					<p class="image-caption-text">Foto: '+ credit +'</p>\
					</div>');
				}else{
					tinymce.activeEditor.insertContent('<img alt="'+ item.title +'" src="'+ fullUrl +'" />');
				}
			}
		}else{
			var seltext = tinymce.activeEditor.selection.getContent({format: 'text'});
			tinymce.activeEditor.insertContent('<a href="/media/library/'+ item.filename +'" title="'+ item.title +'">'+ (seltext || item.title) +'</a>');
		}
		$.mediaDialog.hide();
	};

	$('#btnAddMedia').click(function()
	{
		isAddFeaturedImg = false;
		$.mediaDialog.show();
	});

	$('#featuredImg').click(function()
	{
		isAddFeaturedImg = true;
		$.mediaDialog.show();

	});
</script>









