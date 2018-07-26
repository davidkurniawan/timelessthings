<?php

if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { header("Status: 404 Not Found"); exit; }
///////////////////////////////////////////////////////////////////////////////////////////////////////////////


class Adm_Users extends Adm_DataEntries
{
	
	protected $user,$roles;
	protected function onPageStart()
	{
		$this->title = "Users";
		parent::onPageStart();
		
		
	}
	protected function onPostData($posttask)
	{
		if($posttask)
		{
			$id = @ $_POST['id'];
			if($posttask=='status')
			{
				$status = $_POST['status']==1?0:1;
				app::$database->updateRows("#__users",array("status"=>$status),"id=$id");
				echo "{}";
			}
			else if($posttask=='delete')
			{
				app::$database->deleteRows("#__users","id=$id");
				echo "{}";
			}
			exit;
		}
	}
	protected function onDataview($statusFilter)
	{
		 if(!$this->isAdmin){Response::unauthorized();}
		 
		 $this->contentFilename = $this->templatePath  . '/users.php';
		 return "SELECT item.*, role.title as roleTitle 
		 FROM #__users as item 
		 inner join #__roles as role on role.id = item.role";
	}
	
	protected function onDataviewAssoc(& $row){}
	
	protected function onEdit()
	{
		
		$this->contentFilename = $this->templatePath  . '/users-edit.php';
		$this->id = @ $_REQUEST['id'];
		if($this->id)
		{
			
			if(!$this->isAdmin){
				if($this->currentUser->id != $this->id)
					Response::unauthorized();
			}
			
			
			
			if(!($this->user = app::$database->getObject
			( (
					"SELECT user.*, role.title as roleTitle 
					FROM #__users as user 
					INNER JOIN #__roles as role on role.id = user.role
					WHERE user.id=" . $this->id
				)
			)))
			{
				Response::badRequest();
			}

			if(Request::isPost())
			{
				$postData = array( "name" => $_POST['name'],"email"=> $_POST['email']);
				
				if(!empty($_POST['role'])){
					$postData['role'] = $_POST['role'];
				}
				if(!empty($_POST['password']) && !empty($_POST['password_confirm']) )
				{
					
					if(getHash($_POST['current_password']) != $this->user->password)
					{
						$this->alert("Your current password is not correct", 'danger');
						return;
					}
					$postData['password'] = getHash($_POST['password']);
				}
				app::$database->updateRows("#__users", $postData,"id=".$this->id);
				Response::redirect(Request::$url);
				
			}
			
		}else{
			Response::badRequest();
		}
		$this->roles = app::$database->getObjects("SELECT role.* FROM #__roles as role WHERE role.group=2");
		$this->user->metaData  = empty($this->content->metaData)?array(): json_decode($this->user->metaData);
					
	}
	protected function onNew()
	{
		
		if(!$this->isAdmin){
			Response::unauthorized();
		}
		$this->contentFilename = $this->templatePath  . '/users-new.php';
		$this->roles = app::$database->getObjects("SELECT role.* FROM #__roles as role WHERE role.group=2");
		
		if(Request::isPost())
		{
			$ar = new ActiveRecord("#__users",null,'id');
			$ar->name   = trim($_POST['name']);
			$ar->email  = trim($_POST['email']);
			$ar->role   = $_POST['role'];
			
			$ar->password   = getHash($_POST['password']);
			
			$ar->status   = 1;
			$ar->dateRegistered   = $ar->dateActivated   = Helper::ymdHis();
			$ar->save();
			Response::redirect(dirname(Request::$url));
			
		}
		else
		{
			$this->user = new stdClass();
			$this->user->name  = "";
			$this->user->email = "";
			$this->user->role  = 4;
			$this->user->id    = 0;
			

		}
		
	}
	
	
	
	
	
	
	
	
	
	
	
	
}


















?>