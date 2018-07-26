<div class="margin-12"></div>



<div id="about" class="page">
	
		
	<?php
	$productsEx = array(
				array(
					"title" => "TABLES",
					"file" => "tables.jpg",
					"description" => "	<p>
							A stunning slab of petrified wood will make a dramatic statement 
							in your dining room when it’s polished and transformed into a table – stylish, 
							functional and simply spectacular.

						</p>
						<p>
							
							The most basic type of petrified wood table is simply a trunk that’s 
							large enough seat two couples. After the trunk is extracted from below ground, 
							it’s polished down to create a smooth, glossy surface, leaving the natural shape 
							of the tree ring as the rim of the masterpiece.

							
						</p>
						<p>
							At the Timeliness Things Company, we design tables which can be made 
							entirely of petrified wood or just the table top. However you like it, 
							the shimmering colors of the minerals creates a sculptured icon that’s 
							guaranteed to make a memorable impact, whatever the setting.
						</p>"
				),
				array(
					"title" => "SINKS",
					"file" => "sinks.jpg",
					"description" => "	<p>
						Nothing is more natural than a stone sink made of petrified wood. 
						Quarried to our workshop, every single wood log is hand selected based on its color,
						 hardness and size.
						</p>
						<p>
						Before crafting, each log is meticulously examined to determine 
						the best way to cut to optimize its pattern and form. 
						With so many combinations of color, shape and sizes, no two sinks are ever alike. 
						From simple round cross-cuts to extreme organic shapes, our hand-crafted petrified 
						wood sinks are truly one-of-a-kind.
						</p>
					"
				),
				array(
					"title" => "MANTLE PIECES",
					"file" => "mantlepieces.jpg",
					"description" => "	<p>
							Intriguing and rare, petrified wood has the qualities of stone. 
							To create a perfect mantle piece, the first cut is from the center of a petrified tree,
							 before our craftsmen sculpt the stone into a large, rectangular-shaped mantle piece.
							  We make sure the rings will be clearly visible.
						</p>"
				),
				array(
					"title" => "DECORATIVE COLUMNS",
					"file" => "decorativecolumns.jpg",
					"description" => "	<p>
							Nature can’t be beaten when it comes to creating stunning shapes and colors.
							 This certainly counts for our sculptures of petrified wood. Awe-inspiring and artistic, 
							 a column of petrified wood is extracted, hand cut and polished for 
							 a museum-quality piece of art. These decorative columns pieces offer 
							 a striking focal point in any living room, office or garden.
						</p>"
				),
				array(
					"title" => "MOSAICS",
					"file" => "mosaicts.jpg",
					"description" => "	<p>
							Our craftsmen know how to rejuvenate the left-over pieces, 
							shaping them into colored patterns. Assembling these blocks into a collage of shades,
							 a gorgeous mosaic design is created, ideal as a wall panel or a sturdy floor tile.
						</p>"
				),
				array(
					"title" => "STOOLS",
					"file" => "stools.jpg",
					"description" => "	<p>
							Whether for the piano, the bar, or everything in-between, 
							a stool crafted from petrified wood will amaze and delight for every occasion. 
							Three-legged or four-legged, our stools come in a variety of shapes and sizes.
						</p>"
				),
				array(
					"title" => "SLABS",
					"file" => "slabs.jpg",
					"description" => "	<p>
							Each slab is thickly cut and is more than strong enough to be 
							used as a table top. They are ready to be used as a coffee table or table top, 
							or displayed on an easel or as a wall piece. Polished to a mirror finish, each 
							of our petrified wood plates is flat and buffed to produce a gorgeous piece of natural art.
						</p>"
				),
				array(
					"title" => "KITCHEN TOOLS",
					"file" => "kitchentools.jpg",
					"description" => "
						<p>
							From the best looking bits, we create smaller, more elaborated objects such as candle holders, 
							trays and bowls. Although the grains of the stone will vary, 
							the colors are mostly earth tones, making them suitable for virtually any interior.
						</p>"
				),
			);
	 ?>
	<div class="page light-background">
		<div class="container">
			<?php foreach($this->products as $index => $item) { ?> 
			<div class="item-product">
				<div class="margin-12"></div>
				<div class="container text-center" style="overflow:hidden;">
					<h3 class="side-line"><span><?php echo $item->title; ?></span></h3>
				</div>
				<div class="margin-10"></div>
				 <div class="half-content">
				  	<div>
						<img src="<?php echo Request::$baseUrl.'/uploads/library/'.$item->picture; ?>" alt="" />
					</div>
					<div class="text">
						<?php echo $item->body; ?>
					</div>				
				</div>
			</div>
			<?php } ?>
			<div class="margin-12"></div>
		</div>
	</div>
	
	
</div>


