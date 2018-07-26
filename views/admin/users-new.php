

<h2><?php echo $this->title ?></h2>

	<div class="panel">
		<form class="form" method="post" data-role="validate">
		        <fieldset>
		        
		        <label>Name</label>
		        <div>
		            <input name="name" data-rule="text" class="form-element block"  value="<?php echo $this->user->name ?>" />
		        </div>
		        
		        <label>Email Address</label>
		        <div>
		            <input name="email" data-rule="email"  class="form-element block"  value="<?php echo $this->user->email ?>" />
		        </div>
		        
		        
		        	<label>Role</label>
		        <div>
				
		            <div class="select block">
		                <select name="role" id="role" class="form-element">
		                	<?php foreach($this->roles as $role){ ?>
		                    <option value="<?php echo $role->id ?>"><?php echo $role->title ?></option>
		                    <?php } ?>
		                </select>
		                <div class="button-caret">
		                	<i class="caret"></i>
		                </div>
		            </div>
		        </div>
		        <div id="branchwrap">
		        <label>Cabang</label>
		        
		        	
		            <div class="select block">
		                <select name="branch" id="branch" class="form-element">
		                	<option value="0">-- Pilih Cabang --</option>
		                	<?php foreach(Adm_Branch::getBranch() as $branch){ ?>
		                    <option value="<?php echo $branch->id ?>"><?php echo $branch->title ?></option>
		                    <?php } ?>
		                </select>
		                <div class="button-caret">
		                	<i class="caret"></i>
		                </div>
		            </div>
		        </div>
		        
			</fieldset>
		    
		    <fieldset>
		        <div  class="form">
		            <label>
		                Password
		            </label>
		            <div>
		                <input data-rule="text" 
		                data-minlength="6"
		                autocomplete="off" 
		                name="password" class="form-element block" type="password" />
		            </div>
		            <label>
		                Confirm Password
		            </label>
		            <div>
		                <input 
		                data-rule="text" 
		                data-equalto="password"
		                data-minlength="6" 
		                autocomplete="off" name="password_confirm"
		                class="form-element block" type="password" />
		            </div>
		            
		            <button class="button success"> Save New </button>
		        </div>
		        
		    </fieldset>
		    
		    
		</form>
	</div>
	

	<script>
		$(document).ready(function(){
			if($("#role").val() == 5 || $("#role").val() == 6)
			{
				$("#branchwrap").show();
			}else{
				$("#branchwrap").hide();
			}
		});
	
		$("#role").on("change", function(){
			
			if($(this).val() == 5|| $(this).val() == 6)
			{
				$("#branchwrap").show();
			}else{
				$("#branchwrap").hide();
			}
			
			
		});
	</script>
