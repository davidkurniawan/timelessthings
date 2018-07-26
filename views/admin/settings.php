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
		<legend>General Settings</legend>
		<div>
			<div>
				<label>
					Contact Mail <sup style="color:red">*</sup>
					<input type="text" name="contactMail" class="form-element block" id="contactMail" data-rule="email" value="<?php echo $this->settingValue["contactMail"]; ?>" />
				</label>
			</div>
		
			<br />
			<div>
				<label>
					Contact Address <sup style="color:red">*</sup>
					<textarea id="contactAddress" data-rule="text" rows="10" class="form-element c_content block v-resize" name="contactAddress"><?php echo $this->settingValue["contactAddress"]; ?></textarea>
				</label>
			</div>
			<br />
			<div>
				<label>
					Instagram 
					<input type="text" name="instagram" class="form-element block" id="instagram"  value="<?php echo $this->settingValue["instagram"]; ?>" />
				</label>
			</div>			
			<br />		
			
			<div>
				<label>
					Facebook 
					<input type="text" name="facebook" class="form-element block" id="facebook"  value="<?php echo $this->settingValue["facebook"]; ?>" />
				</label>
			</div>			
			<br />		
			
			<div>
				<label>
					Twitter 
					<input type="text" name="twitter" class="form-element block" id="twitter"  value="<?php echo $this->settingValue["twitter"]; ?>" />
				</label>
			</div>			
			
		
		</div>	
		
	</fieldset>

		<legend><h3>HOMEPAGE</h3></legend>
		
		
	<fieldset>
		<div>
			
			<div>
				<h4>Home Section Below Slider </h4>
				<br>
				<label>
				
					<input type="text" name="homeSection1" id="homeSection1" class="form-element block"  value="<?php echo $this->settingValue["homeSection1"]; ?>"/>
				
				</label>
			</div>
			<br>
			<hr>
			
			<div>
				<h4>Home Section About</h4>
				<br>
				<div class="grid cols-3 spacing-15">
					
					<div>
						
						<div id="featuredImg" class="form-element" style="height:150px; width:100%; position:relative;">
							<div style="background-image:url(/uploads/library/<?php echo $this->settingValue["pictureAbout"]; ?>)"> </div>
							<input type="hidden" name="pictureAbout" id="pictureAbout" value="<?php echo $this->settingValue["pictureAbout"]; ?>" >
						</div>
					</div>
					
					<div class="colspan-2">
						<label>
							
							<textarea placeholder="About Text  *" id="aboutText" data-rule="text" rows="7" class="form-element block v-resize" name="aboutText"><?php echo $this->settingValue["aboutText"]; ?></textarea>
						</label>
					</div>
				</div>
				
			
			</div>
			<br>
			<hr>
			<div>
				<h4>Home Section Philoshophy</h4>
				<br>
				<div class="grid cols-3 spacing-15">
					<div>
			
						<div id="featuredPhilosophy" class="gale form-element" style="height:150px; width:100%; position:relative;">
							<div style="background-image:url(/uploads/library/<?php echo $this->settingValue["picturePhilosophy"]; ?>)"> </div>
							<input type="hidden" name="picturePhilosophy" id="picturePhilosophy" value="<?php echo $this->settingValue["picturePhilosophy"]; ?>" >
						</div>
					</div>
					<div class="colspan-2">						
						<div>
							<label>
								Title 
								<input type="text" name="titlePhilosophy" id="titlePhilosophy" class="form-element block"  value="<?php echo $this->settingValue["titlePhilosophy"]; ?>"/>
							
								<br>
								Description
								<textarea name="textPhilosophy" id="textPhilosophy" class="form-element block" cols="10" rows="10"><?php echo $this->settingValue["textPhilosophy"]; ?></textarea>
								
								
							</label>
						</div>
						
					</div>
				</div>
			
			</div>
		</div>
		
		</fieldset>
		<hr>
		<br />
		<div class="grid cols-2 spacing-15">
			<div>
				<h4>Home Section Process</h4>
				<div>
					
					<div id="featuredProcess" class="gale form-element" style="height:150px; width:100%; position:relative;">
						<div style="background-image:url(/uploads/library/<?php echo $this->settingValue["pictureProcess"]; ?>)"> </div>
						<input type="hidden" name="pictureProcess" id="pictureProcess" value="<?php echo $this->settingValue["pictureProcess"]; ?>" >
					</div>
				</div>
				<label>
					Title 
					<input type="text" name="titleProcess" id="titleProcess" class="form-element block"  value="<?php echo $this->settingValue["titleProcess"]; ?>"/>
				</label>			
				
				
			</div>
			<div>
				<h4>Home Section People</h4>
				<div>
					
					<div id="featuredPeople" class="gale form-element" style="height:150px; width:100%; position:relative;">
						<div style="background-image:url(/uploads/library/<?php echo $this->settingValue["picturePeople"]; ?>)"> </div>
						<input type="hidden" name="picturePeople" id="picturePeople" value="<?php echo $this->settingValue["picturePeople"]; ?>" >
					</div>
				</div>
				<label>
					Title 
					<input type="text" name="titlePeople" id="titlePeople" class="form-element block"  value="<?php echo $this->settingValue["titlePeople"]; ?>"/>
				</label>			
				
			</div>
		</div>
		<hr>
		<legend><h3>PAGE PEOPLE</h3></legend>
		<div>
			<label>
				Text
				<textarea name="pagePeopleTitle" id="pagePeopleTitle" class="c_content form-element block" cols="10" rows="1"><?php echo $this->settingValue["pagePeopleTitle"]; ?></textarea>
						
			</label>			
				
		</div>
		
		<div>
			<label>
				Description
				<input type="text" name="pagePeopleDesc" id="pagePeopleDesc" class="form-element block"  value="<?php echo $this->settingValue["pagePeopleDesc"]; ?>"/>
				
			</label>			
				
		</div>
		
		<button type="submit" class="button success">Save Changes</button>

</form>

<?php require $this->templatePath . "/inc.media-dialog.php"; ?>
<script>
var $featuredImg    	= $('#featuredImg > div'),	
	$featuredPhilosophy = $("#featuredPhilosophy > div"),
	$featuredProcess	= $("#featuredProcess > div"),
	$featuredPeople	= $("#featuredPeople > div");
	
var $pictureAbout 		= $("#pictureAbout"),
	$picturePhilosophy	= $("#picturePhilosophy"),
	$pictureProcess		= $("#pictureProcess");
	$picturePeople		= $("#picturePeople");
	
var isAddPhil, isAddProcess, isAddPeople;


$.mediaDialog.insert = function(item)
	{
		if(item.extension =='jpg' || item.extension =='png' || item.extension =='gif')
		{
			var mediumUrl = '/uploads/library/h/'+  item.filename;
			var thumbUrl  = '/uploads/library/t/'+  item.filename;
			
			if(isAddPhil){
				$picturePhilosophy.val(item.filename);
				// // $postData.picture = mediumUrl;
				$featuredPhilosophy.css('background-image','url('+ thumbUrl +')');
			
			}else if(isAddProcess){
				$pictureProcess.val(item.filename);
				// // $postData.picture = mediumUrl;
				$featuredProcess.css('background-image','url('+ thumbUrl +')');
			
			}else if(isAddPeople){
				$picturePeople.val(item.filename);
				// // $postData.picture = mediumUrl;
				$featuredPeople.css('background-image','url('+ thumbUrl +')');
			
			}else{
				$pictureAbout.val(item.filename);
				// $postData.picture = mediumUrl;
				$featuredImg.css('background-image','url('+ thumbUrl +')');
			}
				
			
	
		}
		$.mediaDialog.hide();
	};
$('#featuredPeople').click(function()
	{
		isAddProcess = false;
		isAddPhil = false;
		isAddPeople = true;
		$.mediaDialog.show();
		
	});
	
$('#featuredProcess').click(function()
	{
		isAddProcess = true;
		isAddPhil = false;
		isAddPeople = false;
		
		$.mediaDialog.show();
		
	});
	
$('#featuredPhilosophy').click(function()
	{
		isAddProcess = false;
		isAddPhil = true;
		isAddPeople = false;
		
		$.mediaDialog.show();
		
	});
$('#featuredImg').click(function()
	{
		isAddProcess = false;
		isAddPhil = false;
		isAddPeople = false;
		
		$.mediaDialog.show();
		
	});
</script>