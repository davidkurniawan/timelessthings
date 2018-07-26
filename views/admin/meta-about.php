<h1><?php echo $this->title ?></h1>
<script type="text/javascript">

tinymce.init({
	selector: '.c_content',
	content_css: "<?php echo $this->templateUrl; ?>/js//css/styles.css?v3",
	relative_urls: false,
    remove_script_host: false,
    plugins: [
	
        // "advlist autolink lists link image charmap anchor",
         "searchreplace visualblocks code"
        // "insertdatetime paste"
    ],
    toolbar: " bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent "
	, setup: function(editor) {
   }
});
</script>


<form action="" method="post" class="form" data-role="validate">
	
	
	<!-- HOMEPAGE SETTINGS -->
	
		
	<fieldset>
		<div>
			
			<div>
				<h4>Page Background Header - Heading Title</h4>
				<br>
				<div class="grid cols-3 spacing-15">
					
					<div>
						
						<div id="featuredImg" class="form-element" style="height:150px; width:100%; position:relative;">
							<div style="background-image:url(/uploads/library/<?php echo $this->settingValue["heroImage"]; ?>)"> </div>
							<input type="hidden" name="heroImage" id="heroImage" value="<?php echo $this->settingValue["heroImage"]; ?>" >
						</div>
					</div>
					
					<div class="colspan-2">
						<label>
							<textarea placeholder="Title" id="heroTitle" data-rule="text" rows="3" class="c_content form-element block v-resize" name="heroTitle"><?php echo $this->settingValue["heroTitle"]; ?></textarea>
						</label>
					</div>
				</div>
				
			
			</div>
			<br>
			<hr>
			<div>
				<h4>Section Below Header</h4>
				<br>
				<div class="grid cols-3 spacing-15">
					<div>
			
						<div id="featuredBelowHero" class="gale form-element" style="height:150px; width:100%; position:relative;">
							<div style="background-image:url(/uploads/library/<?php echo $this->settingValue["pictureBelowHeader"]; ?>)"> </div>
							<input type="hidden" name="pictureBelowHeader" id="pictureBelowHeader" value="<?php echo $this->settingValue["pictureBelowHeader"]; ?>" >
						</div>
					</div>
					<div class="colspan-2">						
						<div>
							<label>
								Title 
								<input type="text" name="titleBelowHero" id="titleBelowHero" class="form-element block"  value="<?php echo $this->settingValue["titleBelowHero"]; ?>"/>
								
								<br>
								Description
								<textarea name="textBelowHero" id="textBelowHero" class="c_content form-element block" cols="10" rows="10"><?php echo $this->settingValue["textBelowHero"]; ?></textarea>
								
								
							</label>
						</div>
						
					</div>
				</div>
			
			</div>
			<br>
			<hr>
			<div>
				<h4>Third Section</h4>
				<br>
				<div class="grid cols-3 spacing-15">
					
					<div>
						
						<div id="featuredThirdSection" class="gale form-element" style="height:150px; width:100%; position:relative;">
							<div style="background-image:url(/uploads/library/<?php echo $this->settingValue["thirdSectionImage"]; ?>)"> </div>
							<input type="hidden" name="thirdSectionImage" id="thirdSectionImage" value="<?php echo $this->settingValue["thirdSectionImage"]; ?>" >
						</div>
					</div>
					
					<div class="colspan-2">
						<label>
							<textarea placeholder="Title" id="thirdSectionTitle" data-rule="text" rows="3" class="c_content form-element block v-resize" name="thirdSectionTitle"><?php echo $this->settingValue["thirdSectionTitle"]; ?></textarea>
						</label>
					</div>
				</div>
				
			
			</div>
			
			<br>
			<hr>
			<div>
				<h4>Fourth Section</h4>
				<div>
					<label>
						Title 
						<input type="text" name="titleFourthSection" id="titleFourthSection" class="form-element block"  value="<?php echo $this->settingValue["titleFourthSection"]; ?>"/>
					</label>
				</div>
				<br>
				<h5>First Row</h5>
				<div class="grid cols-3 spacing-15">
					
					<div>
						
						<div id="featuredFourthSection1" class="gale form-element" style="height:150px; width:100%; position:relative;">
							<div style="background-image:url(/uploads/library/<?php echo $this->settingValue["firstRowImage"]; ?>)"> </div>
							<input type="hidden" name="firstRowImage" id="firstRowImage" value="<?php echo $this->settingValue["firstRowImage"]; ?>" >
						</div>
					</div>
					
					<div class="colspan-2">
						<label>
							<textarea placeholder="Description" id="firstRowText" rows="7" class="c_content form-element block v-resize" name="firstRowText"><?php echo $this->settingValue["firstRowText"]; ?></textarea>
						</label>
					</div>
				</div>
				<h5>Second Row</h5>
				<div class="grid cols-3 spacing-15">
					
					<div>
						
						<div id="featuredFourthSection2" class="gale form-element" style="height:150px; width:100%; position:relative;">
							<div style="background-image:url(/uploads/library/<?php echo $this->settingValue["secondRowImage"]; ?>)"> </div>
							<input type="hidden" name="secondRowImage" id="secondRowImage" value="<?php echo $this->settingValue["secondRowImage"]; ?>" >
						</div>
					</div>
					
					<div class="colspan-2">
						<label>
							<textarea placeholder="Description" id="secondRowText"  rows="3" class="c_content form-element block v-resize" name="secondRowText"><?php echo $this->settingValue["secondRowText"]; ?></textarea>
						</label>
					</div>
				</div>
				
			</div>
			
			
			
		</div>
		
		</fieldset>
		
		
		<button type="submit" class="button success">Save Changes</button>

</form>

<?php require $this->templatePath . "/inc.media-dialog.php"; ?>
<script>
var $featuredImg    		= $('#featuredImg > div'),
	$featuredBelowHero 		= $("#featuredBelowHero > div"),
	$featuredThirdSection	= $("#featuredThirdSection > div"),
	$featuredFourthSection1	= $("#featuredFourthSection1 > div"),
	$featuredFourthSection2 = $("#featuredFourthSection2 > div");
	
	
var $heroImage 			= $("#heroImage"),
	$pictureBelowHeader	= $("#pictureBelowHeader"),
	$thirdSectionImage	= $("#thirdSectionImage"),
	$firstRowImage		= $("#firstRowImage"),
	$secondRowImage		= $("#secondRowImage");


var isAddPicBelowHeader,
	isAddThirdSection,
	isAddFirstRow,
	isAddSecondRow;

$.mediaDialog.insert = function(item)
	{
		if(item.extension =='jpg' || item.extension =='png' || item.extension =='gif')
		{
			var mediumUrl = '/uploads/library/h/'+  item.filename;
			var thumbUrl  = '/uploads/library/t/'+  item.filename;
			
			
			if(isAddPicBelowHeader){
				$pictureBelowHeader.val(item.filename);
				$featuredBelowHero.css('background-image','url('+ thumbUrl +')');
				
			}else if(isAddThirdSection){
				
				$thirdSectionImage.val(item.filename);
				$featuredThirdSection.css('background-image','url('+ thumbUrl +')');
				
			}else if(isAddFirstRow){
				
				$firstRowImage.val(item.filename);
				$featuredFourthSection1.css('background-image','url('+ thumbUrl +')');
				
			}else if(isAddSecondRow){
				
				$secondRowImage.val(item.filename);
				$featuredFourthSection2.css('background-image','url('+ thumbUrl +')');
				
			}
			else{
				$heroImage.val(item.filename);
				$featuredImg.css('background-image','url('+ thumbUrl +')');
			}
			
			
				
			
				
			
	
		}
		$.mediaDialog.hide();
	};
	
$('#featuredFourthSection2').click(function()
	{
		isAddPicBelowHeader = false;
		isAddThirdSection = false;
		isAddFirstRow = false;
		isAddSecondRow = true;
		
		$.mediaDialog.show();
		
	});
$('#featuredFourthSection1').click(function()
	{
		isAddPicBelowHeader = false;
		isAddThirdSection = false;
		isAddFirstRow = true;
		isAddSecondRow = false;
		
		$.mediaDialog.show();
		
	});

$('#featuredThirdSection').click(function()
	{
		isAddPicBelowHeader = false;
		isAddThirdSection = true;
		isAddFirstRow = false;
		isAddSecondRow = false;
		
		$.mediaDialog.show();
		
	});
	
	
$('#featuredBelowHero').click(function()
	{
		isAddPicBelowHeader = true;
		isAddThirdSection = false;
		isAddFirstRow = false;
		isAddSecondRow = false;
		
		$.mediaDialog.show();
		
	});


$('#featuredImg').click(function()
	{
		isAddPicBelowHeader = false;
		isAddThirdSection = false;
		isAddFirstRow = false;
		isAddSecondRow = false;
		
		$.mediaDialog.show();
		
	});
</script>