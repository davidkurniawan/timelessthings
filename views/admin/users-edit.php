

<h1><?php echo $this->title ?></h1>
<?php $this->pageMessage() ?>

<form class="form" id="fromEditUser" data-role="validate" method="post">
    
    <!--
    <fieldset class="collapsible collapse"> 
        <legend>Registration Informations</legend>
        <div  class="form">
            <label>Date Registered</label>
            <div>
                <div class="form-element">29 Dec 2014 17:35 from IP 186.88.98.123</div>
            </div>
            <label>Date Activated</label>
            <div>
                <div class="form-element">29 Dec 2014 17:35 from IP 186.88.98.123</div>
            </div> 
        </div>
    </fieldset>
    -->
    <br />
    <fieldset>

        <label>Name</label>
        <div>
            <input  data-rule="text" name="name" class="form-element block"  value="<?php echo $this->user->name ?>" />
        </div>
        
        <label>Email Address</label>
        <div>
            <input  data-rule="email" name="email" class="form-element block"  value="<?php echo $this->user->email ?>" />
        </div>
        
        <label>Role</label>
        <div>

            <div class="select block">
            	<?php 
				if( $this->currentUser->role==3 || $this->currentUser->role ==2  ){
					// if($this->isAdmin || $this->isRoot){
						?>
                        <select class="form-element" name="role">
						<?php foreach($this->roles as $role){ ?>
							
							<?php if($role->id == $this->user->role){  ?> 
							
                        	<option selected="" value="<?php echo $role->id ?>"><?php echo $role->title ?></option>
                        	
                        	<?php }else{ ?>
                        		
                        	<option value="<?php echo $role->id ?>"><?php echo $role->title ?></option>
                        	
                        	<?php } ?>
						<?php } ?>
                        </select>
						<?php
					// }else{
						?>
						
						<!-- <select class="form-element"><option><?php echo $this->currentUser->roleTitle ?></option></select> -->
						
						<?php
					// }
				}else{
				?><select class="form-element">
                	<option><?php echo $this->currentUser->roleTitle ?></option>
                </select><?php
				}
				?>
                <div class="button-caret">
                	<i class="caret"></i>
                </div>
            </div>
        </div>

    </fieldset>
    <?php if( ($this->user->id == $this->currentUser->id) ){ ?>
    <fieldset>

        <div  class="form">
            <label>
                Current Password
            </label>
            <div>
                <input id="acc_current_password" autocomplete="off" name="current_password" class="form-element block" type="password">
                <div class="field-info">If you would like to change, enter the current password then type a new one. Otherwise leave this blank. </div>
            </div>
            <label>
                Password
            </label>
            <div>
                <input data-rule="text" id="acc_password" data-minlength="6" disabled="disabled" autocomplete="off" name="password" class="form-element block" type="password">
            </div>
            <label>
                Confirm Password
            </label>
            <div>
                <input data-rule="text" id="acc_password_confirm" 
                data-minlength="6" disabled="disabled" autocomplete="off" name="password_confirm" data-equalto="password" 
                class="form-element block" type="password">
            </div>
            
        </div>
        
    </fieldset>
    <?php } ?>
    <button class="button success" type="submit"> Save Changes </button>
</form>

<script>

$('#acc_current_password')
.on('keyup paste change blur input',
	function(e)
	{
		if(this.value.trim()!="")
		{
			$('#acc_password, #acc_password_confirm').disable(false);
		}else{
			$('#acc_password, #acc_password_confirm').disable().val("");
			$('#fromEditUser').validate('validate');
		}
	}
);

</script>