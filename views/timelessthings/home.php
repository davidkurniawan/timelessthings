<div class="margin-12"></div>
<div id="hero" class="slider">
		<?php foreach($this->slider as $slide){ ?> 
	 			<div class="item" style="background-image:url('<?php echo Request::$baseUrl.'/uploads/library/'. $slide->picture; ?>')">
					<div class="item-text">
						<h1 class="h3"><span><?php echo $slide->body; ?></span></h1>
					</div>
			</div>	
	 				
	 	<?php } ?>
	 			
	
</div>
<div class="intro section">
	<div class="container">
		
		<p>
			<?php echo $this->settings['homeSection1']; ?>
		</p>
	</div>
</div>

<div class="intro-about full-background" style="background-image:url('<?php echo Request::$baseUrl.'/uploads/library/'.$this->settings['pictureAbout']; ?>')">
	<div class="container">
		<hr class="hide-sm">
		<div>
			<p>
			<?php echo $this->settings['aboutText']; ?>
			</p>		
		</div>
		
		<div class="more">
			<a href="/page/about-us" class="more-btn">
				READ MORE
			</a>
		</div>
	</div>
</div>

<div class="intro-philosophy section">
	<div class="container">
		<div style="background-image:url(<?php echo Request::$baseUrl.'/uploads/library/'.$this->settings['picturePhilosophy']; ?>)">
			<div class="text-center">
				<h3><span><?php echo $this->settings['titlePhilosophy']; ?></span></h3>
				<div>
					<?php echo $this->settings['textPhilosophy']; ?>
				</div>
				<div class="more">
					<a href="/page/philosophy" >LEARN MORE</a>
				</div>
			</div>
		</div>	
	</div>
</div>


<div class="home-products section">
	<div class="container">
		<h3 class="text-center"><span>Products</span></h3>
		<div class="product-wrapper">
			
			<?php 
			
			$productsEx = array(
				array(
					"title" => "TABLES",
					"file" => "tables.jpg"
				),
				array(
					"title" => "SINKS",
					"file" => "sinks.jpg"
				),
				array(
					"title" => "MANTLE PIECES",
					"file" => "mantlepieces.jpg"
				),
				array(
					"title" => "DECORATIVE COLUMNS",
					"file" => "decorativecolumns.jpg"
				),
				array(
					"title" => "MOSAICS",
					"file" => "mosaics.jpg"
				),
				array(
					"title" => "STOOLS",
					"file" => "stools.jpg"
				),
				array(
					"title" => "SLABS",
					"file" => "slabs.jpg"
				),
				array(
					"title" => "KITCHEN TOOLS",
					"file" => "kitchentools.jpg"
				),
			);
			
			foreach ($this->products as $item){ ?> 
			
			<div class="col-md-6">
				<a href="#" class="product-item" style="background-image:url(<?php echo Request::$baseUrl.'/uploads/library/'.$item->picture; ?>); ">
					<div class="title">
						<h4><span class="more"><?php echo $item->title; ?></span></h4>
					</div>
				</a>
			</div>
			
			<?php } ?>
		</div>
	</div>
</div> 




<div id="pageintro" class="section">
	<div style="background-image:url(<?php echo Request::$baseUrl.'/uploads/library/'.$this->settings['pictureProcess']; ?>)">
		<div>
			<a href="/page/process"><?php echo $this->settings['titleProcess']; ?></a>
		</div>
	</div>
	<div style="background-image:url(<?php echo Request::$baseUrl.'/uploads/library/'.$this->settings['picturePeople']; ?>)">
		<div>
			<a href="/page/people"><?php  echo $this->settings['titlePeople'];  ?></a>
		</div>
	</div>
</div>

<script>
	$(document).ready(function(){
		$(".slider").bxSlider({controls:false});
	});
</script>