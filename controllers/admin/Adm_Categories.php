<?php

if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { header("Status: 404 Not Found"); exit; }
///////////////////////////////////////////////////////////////////////////////////////////////////////////////


class Adm_Categories extends Adm_Base
{
	protected $terms;
	
	protected function onPageStart()
	{
		parent::onPageStart();
		
		$this->title='Categories';
		$this->terms = Taxonomy::getCategoriesByContentType('menu',false);
		$this->contentFilename = $this->templatePath  . '/categories.php';
	}
	protected function isTitleExists($title)
	{
		if(app::$database->getResult("SELECT * FROM #__terms WHERE title ='". app::$database->escape($title) . "'"))
		{
			return true;
		}
		return false;
	}
	
	protected function onPostData($task)
	{
			
		if($task=='status')
		{
			$id = @ $_POST['id'];
			$status = $_POST['status']==1?0:1;
			app::$database->updateRows("#__terms",array("status"=>$status),"id=$id");
			Cache::delete(Cache::CACHE_NAME_CONFIG);
			echo "{}";
		}
		else if($task == 'update_ordering'){
			
			foreach($_POST['ordering'] as $key => $value)
			{
				app::$database->updateRows("#__terms", array("ordering"=> intval($value)), "id=$key");
			}
			
			Response::redirect(Request::$url);
		}		
		else if($task == 'add_new'){
			
			$title = trim($_POST['title']);
			$parent = trim($_POST['parentId']);
			if(!empty($title ))
			{
				
				if($this->isTitleExists($title))
				{
					$this->alert("Duplicate category found for \"$title\"");
				}
				else
				{
					$numor = app::$database->getResult("SELECT ordering FROM #__terms WHERE contentType='product' ORDER BY ordering DESC limit 0,1");
					app::$database->insertRow("#__terms", 
					array(
					"title"        => $title,
					"parent"	   => 7,
					"pathName"     => 'projects/'.Helper::safeUrlText($title),
					"contentType"  => 'portfolio',
					"status"       => 1,
					"ordering"     => ($numor+1)
					));
					
					Cache::delete(Cache::CACHE_NAME_CONFIG);
					Response::redirect(Request::$url);
				}
			}
		}
		else if($task == 'update_title')
		{
			$id = @ $_REQUEST['id'];
			$title = trim($_POST['value']);
			if(!empty($title ) && $id)
			{
				if($this->isTitleExists($title))
				{
					echo '';
				}
				else
				{
					$pathName= Helper::safeUrlText($title);
					app::$database->updateRows("#__terms", array(
					"title"    => $title,
					"pathName" => "projects/".$pathName,
					), "id=$id");
					Cache::delete(Cache::CACHE_NAME_CONFIG);
					echo $pathName;
				}
			}
			exit;
		}else if($task == 'delete')
		{
			
			if(Request::isXmlHttpRequest())
			{
				$parent = @$_POST['parent'];
				$termId = @$_POST['id'];
				
			
					if(app::$database->deleteRows("#__terms", "id=".$termId))
					{
						$contents = app::$database->getObjects('SELECT * FROM #__contents WHERE category='.$termId);
						$results = $this->getContentsResult($termId);
						// if()
// 						
						// if($res > 0)
						// {
							// app::$database->updateRows("#__contents", $contents, 'category='.$parent);
						// }
						
						echo json_encode("success");
						exit;
					}else{
						echo json_encode("failed");
						exit;
					}
				
					
			}
			
			
		}
		
		
	}

}

?>