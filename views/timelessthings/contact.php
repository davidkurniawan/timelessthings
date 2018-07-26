
<div class="margin-12"></div>
<div id="contact" class="page dark-background" style="background-color:#534e4b;">
	
	<div class="container" style="overflow:hidden;">
			<div class="text-center">
				<h3 class="title side-line head"><span>CONTACT</span></h3>
			</div>
			<div class="margin-10"></div>			
			
	</div>
	
	<div class="container contact-form">
		
		<div class="col-md-8" style="border-right:1px solid #968363;">
			<form class="form" method="post" action="">
				 <div class="row">
			        <div class="col-xs-6 form-group">
			           	<label>NAME<sup>*</sup></label>
						<input type="text" class="form-control" name="name" id="name" />
			        </div>
			        <div class="col-xs-6 form-group">
			            <label>SURNAME<sup>*</sup></label>
						<input type="text" class="form-control" name="surname" id="surname" />
			        </div>
			         <div class="col-xs-6 form-group">
			           	<label>EMAIL<sup>*</sup></label>
						<input type="text" class="form-control" name="email" id="email" />
			        </div>
			        <div class="col-xs-6 form-group">
			            <label>PHONE</label>
						<input type="text" class="form-control" name="phoneNumber" id="phoneNumber" />
			        </div>
			         <div class="col-xs-6 form-group">
			           	<label>CITY</label>
						<input type="text" class="form-control" name="city" id="city" />
			        </div>
			        <div class="col-xs-6 form-group">
			            <label>COUNTRY</label>
						<select class="form-control" name="country" id="country">
							<option>- PLEASE SELECT -</option>
						</select>
			        </div>
			  		
			  		 <div class="col-xs-6 form-group">
			            <label>YOUR ROLE<sup>*</sup></label>
						<select class="form-control" name="role" id="role">
							<option>- PLEASE SELECT -</option>
						</select>
			        </div>
			        
			         <div class="col-xs-6 form-group">
			            <label>HOW DID YOU KNOW ABOUT US?<sup>*</sup></label>
						<select class="form-control" name="know" id="know">
							<option>- PLEASE SELECT -</option>
						</select>
			        </div>
			        
			  		<div class="col-xs-12 form-group">
			  			  <label>MESSAGE<sup>*</sup></label>
			  			  <textarea class="form-control" rows="10" name="message" id="message"></textarea>
			  		</div>
			  		
			    </div>
				
				<div class="row">
					<div class="input-group" style="margin-left:0; padding-left:15px;  font-size:12px;">
						<label style="font-weight:100;">
							<input type="checkbox" name="privacy" id="privacy" />
							ACCEPT <a href="#" style="color:#968362; text-decoration: underline;">PRIVACY POLICY<sup>*</sup></a>
						</label>
					</div>
					<div class="col-xs-12">
						<input type="submit" value="SEND" class="btn-send-contact" />
					</div>
					
				</div>
				
				
				
			
				
			</form>
			
			
			
		</div>
		<div class="col-md-4">
			
			<div class="address">
				<h3 class="h5" >TIMELESS THINGS COMPANY</h3>
				<br>
				<?php echo $this->settings['contactAddress']; ?>
				<!-- <h5 style="font-weight:200;">LOS ANGELES</h5>
				<p>
					5404 Alton Parkway, Suite 771
					<br>Irvine, CA 92604
					<br>T. (+1) 949 6169675
				</p>
				<br>
				<h5 style="font-weight:200;">BALI</h5>
				<p>
					
					Regus Benoa Square
					<br>Jl. Bypass Ngurah Rai No.21A
					<br>T. (+62) 361 2003275
					<br>www.timelessthingsco.com
				</p> -->
			
			</div>
			
			
		</div>
	</div>
</div>

