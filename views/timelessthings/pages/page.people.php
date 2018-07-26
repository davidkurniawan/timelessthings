<div class="margin-12"></div>

<div id="people" class="page dark-background">
	
	<div class="container">
			<div class="margin-10"></div>
			<div class="text-center">
				<h3 class="title side-line head"><span><?php echo $this->settings['pagePeopleTitle']; ?></span></h3>
			</div>
			
			
			<div class="intro section text-center" style="max-width:640px; color:#FFF;">
					<p>
						<?php echo $this->settings['pagePeopleDesc']; ?>
					</p>
			</div>
		
		
		<div class="slideshow">
			<?php foreach($this->people as $people){ ?> 
	 		
			<div><img src="<?php echo Request::$baseUrl.'/uploads/library/'. $people->picture; ?>" /> </div>
	 	<?php } ?>
			
		
			
		</div>		
		<div class="margin-12"></div>
		
	</div>
		
		
	
</div>



	
</div>

<script>
	$(document).ready(function(){
		$(".slideshow").bxSlider({pager:false});
	});
</script>
