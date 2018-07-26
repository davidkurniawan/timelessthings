<?php
/*/////////////////////////////////////////////////////////////////////////////////////////////////////////////
Author URI: http://shapetherapy.com/
Copyright 2008-2010 by wildan
*/
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { header("Status: 404 Not Found"); exit; }
///////////////////////////////////////////////////////////////////////////////////////////////////////////////


abstract class PostContentBase extends HtmlDocument
{
	protected 
		$items,
		$content,
		$category,
		$sortOrder = 'item.datePublished DESC',
		$contentsPerPage=10;
	
	protected function onPageStart()
	{
		
		if(isset($this->categoryName))
		{
			
			if(isset(app::$config->categoryParent[$this->categoryName]))
			{
				$this->parentCategory = new Object( app::$config->categoryParent[$this->categoryName]);
				//$content_type = $this->parentCategory->contentType;
				$this->parentCategory->url = empty($this->subCategoryName)? Request::$pathUrl : dirname(Request::$pathUrl);
			}
		}
		if(	!empty($this->contentName))
		{
			//$this->contentFilename =  $this->templatePath . '/'. $content_type . '-page.php';
			// echo $this->contentName;
			$this->onGetContent();
			
		}else
		{
			//if(isset($content_type)){
				//$this->contentFilename = $this->templatePath . '/'. $content_type . '-list.php';
			//}
			if( empty($this->pageIndex)){
				$this->pageIndex = 1;
			}
			
			$filter = '';
			$pathName = $this->categoryName;
			if($this->parentCategory)
			{
				if( !empty($this->subCategoryName))
				{
					$pathName .= "/" . $this->subCategoryName;
					$filter   = "term.pathName='$pathName'";
				}
				else
				{
						$filter = "term.parent=" .$this->parentCategory->id;
				}
			}else{
				$filter   = "term.pathName='$pathName'";
			}
			
			//echo $filter ;exit;
			$this->items = array();
			$this->dataview = new DataView();
			$this->dataview->pageIndex  = $this->pageIndex;
			$this->dataview->strOrderBy = $this->sortOrder;
			
			if($sql = $this->onDataViewSql($filter))
			{
				
				$this->dataview->queryPages( $sql,$this->contentsPerPage);
				while ($row =  $this->dataview->fetchAssoc())
				{
					if(!empty($row['pathName'])){
						$row['categoryUrl'] = Request::$baseUrl .'/' . $row['pathName'];
						$row['url'] = $row['categoryUrl'] .'/'. $row['name'];
					}
					
					$this->onDataViewFetchRow($row);
					$this->items[] = new Object($row);
				}
				
				if(isset($this->categoryName))
				{
					if( !empty($this->parentCategory))
					{
						if( $this->subCategoryName)
						{
							if($this->items)
							{
								$this->category = new stdClass();
								$this->category->title = $this->items[0]->categoryTitle;
								$this->category->id    = $this->items[0]->categoryId;
							}else
							{
								$this->category =  app::$database->getObject("SELECT id,title FROM #__terms WHERE pathName='$pathName'");
								echo $pathName;exit;
							}
							$this->title =   $this->parentCategory->title .' &#8250; ' . $this->category->title;
							$this->category->parentCategory = $this->parentCategory;
						}else{
							$this->category = $this->parentCategory;
							$this->title    = $this->category->title;
							$this->category->parentCategory=null;
						}
					}else
					{
						
						$this->category =  app::$database->getObject("SELECT id,title FROM #__terms WHERE pathName='$pathName'");
						$this->category->parentCategory=null;
						$this->title    = $this->category->title;
					}
					$this->category->url =  Request::$pathUrl;
				}
				
				

				//if($this->items)
				//{
					$this->onContents();
				//}
			}
		}
	}

	protected function onDataViewFetchRow(& $row)
	{
		
	}
	abstract protected function onDataViewSql($filter);
	
	protected function onContents(){}
	protected function onContent(){}
	
	protected function onContentSql(){}
	
	protected function onGetContent()
	{
		if($this->content = app::$database->getObject( $this->onContentSql() ))
		{
			$this->title = $this->content->title;
			$this->categoryUrl = dirname(Request::$url);
			$this->onContent();
		}
		else{
			Response::notFound();
		}
	}


}

?>