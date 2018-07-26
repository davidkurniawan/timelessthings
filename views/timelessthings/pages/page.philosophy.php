<div class="margin-12"></div>

<div id="hero" class="static">
	<div class="item" style="background-image:url('<?php echo Request::$baseUrl.'/uploads/library/'.$this->pagePhilosophy['heroImage']; ?>')">
		<div class="item-text">
			<h1 class="h3"><span><?php echo $this->pagePhilosophy['heroTitle']; ?></span></h1>
		</div>
	</div>
</div>


<div id="philosophy" class="page">
	
	<div class="container">
		<div class="margin-12"></div>
		<h1 class="title h3 text-center"><?php echo $this->pagePhilosophy['titleBelowHero']; ?></h1>
						<div class="margin-10"></div>
			<img src="<?php echo Request::$baseUrl.'/uploads/library/'.$this->pagePhilosophy['pictureBelowHeader']; ?>" class="img-responsive" />
			
			<div class="intro section text-center" style="max-width:640px;">
					<?php echo $this->pagePhilosophy['textBelowHero']; ?>
			</div>
		</div>

	<div id="hero" class="static quotes">
	<div class="item" style="background-image:url('<?php echo Request::$baseUrl.'/uploads/library/'.$this->pagePhilosophy['thirdSectionImage']; ?>')">
		<div class="item-text">
			<h2 class="h3 title text-center"><?php echo $this->pagePhilosophy['thirdSectionTitle']; ?></h2>
			<h1 class="h3" style="max-width:720px; left:0; right:0; margin-left:auto; margin-right:auto;">
				
				<span style="position:relative;"><i class="openquote"></i>
					<?php echo $this->pagePhilosophy['thirdSectionDesc']; ?>
					<i class="closequote"></i>
					</span></h1>
		</div>
	</div>
</div>

	<div class="container">
		<div class="intro section text-center" style="max-width:640px;">
				<p>
					<?php echo $this->pagePhilosophy['thirdSectionDesc1']; ?>
				</p>
		</div>
			
			<div class="slide-philosophy">
			<?php foreach($this->philosophy as $philosophy){ ?> 
				<div><img src="<?php echo Request::$baseUrl.'/uploads/library/'. $philosophy->picture; ?>" /> </div>
		 	<?php } ?>
			</div>
			
			<div class="text-center">
				<h3 class="side-line"><span><?php echo $this->pagePhilosophy['titleFourthSection']; ?></span></h3>
			</div>
			
			<div class="intro section text-center" style="max-width:640px;">
					<p>
						<?php echo $this->pagePhilosophy['textFourthSection']; ?>
					</p>
			</div>
		
		
		
	</div>
	
</div>
<script>
	$(document).ready(function(){
		$(".slide-philosophy").bxSlider({pager:false});
	});
</script>

