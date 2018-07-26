<div class="margin-12"></div>

<div id="hero" class="static">
	<div class="item" style="background-image:url('<?php echo Request::$baseUrl.'/uploads/library/'.$this->pageAbout['heroImage']; ?>')">
		<div class="item-text">
			<h1 class="h3"><span><?php echo $this->pageAbout['heroTitle']; ?></span></h1>
		</div>
	</div>
</div>


<div id="about" class="page">
	
	<div class="container">
			<div class="margin-12"></div>
		<h1 class="title h3 text-center"><?php echo $this->pageAbout['titleBelowHero']; ?></h1>
		
		<div class="intro-section">
			
			<div>
				<img src="<?php echo Request::$baseUrl.'/uploads/library/'.$this->pageAbout['pictureBelowHeader']; ?>" alt="" />
			</div>
			<div>
				<?php echo $this->pageAbout['textBelowHero']; ?>
			</div>
					
			
		</div>
				
	</div>
		<div class="margin-12"></div>
	<div class="intro-about full-background" style="background-image:url('<?php echo Request::$baseUrl.'/uploads/library/'.$this->pageAbout['thirdSectionImage']; ?>')">
		<div class="container">
			<hr>
			<div>
				<?php echo $this->pageAbout['thirdSectionTitle']; ?>	
			</div>
			<hr>
		</div>
	</div>
	
	<div class="page dark-background">
		<div class="container">
				<div class="margin-12"></div>
			<h2 class="title h3 text-center"><?php echo $this->pageAbout['titleFourthSection']; ?>	 </h2>
			
			<div class="margin-12"></div>
			
			<div class="half-content">
			
				<div>
					<img src="<?php echo Request::$baseUrl.'/uploads/library/'.$this->pageAbout['firstRowImage']; ?>" alt="" />
				</div>
				<div class="text">
					<?php echo $this->pageAbout['firstRowText']; ?>
				</div>
				
			</div>
			
					<div class="margin-12"></div>
			<div class="half-content">
			
				<div class="text">
					<?php echo $this->pageAbout['secondRowText']; ?>
				</div>
				
				<div>
					<img src="<?php echo Request::$baseUrl.'/uploads/library/'.$this->pageAbout['secondRowImage']; ?>" alt="" />
				</div>
			</div>
				<div class="margin-12"></div>9
		</div>
	</div>
	
	
</div>


