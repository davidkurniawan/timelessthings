<?php

if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { header("Status: 404 Not Found"); exit; }
///////////////////////////////////////////////////////////////////////////////////////////////////////////////


class PostContent extends PostContentBase
{
	private $isSearch;
	protected $contentType = true;
	
	protected function onPageStart()
	{
		// include 'gen-content.php';
		
		if($this->isSearch = (isset($_GET['q']) && Request::$pathInfo =='/search'))
		{
			$this->pageIndex = intval(@ $_GET['p'] );
			if($this->pageIndex <1) $this->pageIndex  =1;
		}

		$this->contentsPerPage=8;
		parent::onPageStart();
        
        // var_dump($this->contentName);
		if(	!empty($this->contentName))
		{
			$this->contentFilename =  $this->templatePath . '/article.php';
			
		}else{
			
			$this->contentFilename = $this->templatePath . '/articles.php';
			
		}
	}
	
	private static $dataViewSql = "SELECT item.*, term.pathName, term.title as categoryTitle , term.id as categoryId
		FROM #__contents as item 
		INNER JOIN #__terms as term ON item.category = term.id WHERE item.status=1 AND item.contentType='article'";
		
	public static function getCoverPicture($item)
	{
		if(empty($item->picture))
		{
			if($pic = app::$database->getObject("select name FROM #__media where owner={$item->id} and mediaType='gallery' order by ordering ASC,id DESC"))
			{
				$item->picture = $pic->name .".jpg";
				app::$database->updateRows("#__contents", array("picture"=>$item->picture ),"id=" . $item->id);
			}
		}
		return ImageDocument::getThumbnailUrl($item->picture, 'gallery');
	}	
		
		
	protected function onDataViewSql($filter)
	{
		if($this->isSearch)
		{
			$this->contentFilename =  $this->templatePath . '/search.php';
			$words = Helper::searchWords($_REQUEST['q']);
			if(count($words)>0)
			{
				foreach($words as $value){
					//$wheres[] = "keywords like '%".App::$database->escape($value)."%'";
					$wheres[] = "body like '%".App::$database->escape($value)."%'";
				}
				return PostContent::$dataViewSql . " AND "  .  implode(' AND ', $wheres);
			}
			return null;
		}else{
			return PostContent::$dataViewSql . " AND $filter";
		}
	}
	protected function onDataViewFetchRow(& $row)
	{
		PostContent::parseMeta($row);
	}

	protected function onContentSql()
	{
		$status = 'c.status=1 AND';
		return "SELECT 
			c.*, t.pathName as categoryName, t.title as categoryTitle, u.name as authorName
			FROM #__contents as c 
			LEFT JOIN #__users as u ON u.id = c.authorId
			LEFT JOIN #__terms as t ON t.id = c.category
			where $status c.name='" . app::$database->escape($this->contentName) . "'";
	}
	
	protected function onContent(){
		
		$arr = empty($this->content->metaData)? array(): unserialize($this->content->metaData);
		
		$this->content->metaData = new Object($arr);
		$this->content->upperHead = $this->content->metaData->upperHead;
		
		//$this->content->views += Pagelog::update($this->content->id, $this->content->contentType,1);
		if($this->content->contentType=='article')
		{
			//$this->content->views += Pagelog::update($this->content->id, 'article',Pagelog::LOG_TYPE_MOST_VIEWED,'#__contents','#__mostview' );
		}

	}


	//////////////////////////////////
	///////////////////////////////////


	//////////////////////////////////
	///////////////////////////////////
	
	public static function parseMeta(& $row)
	{
		$arr= empty($row['metaData'])? array(): unserialize($row['metaData']);
		$row['metaData'] = new Object($arr);
		$row['upperHead'] = $row['metaData']->upperHead;
	}
	
	public static function excerpt2($body,$maxlen = 100)
	{

		 if($text  = Helper::htmlToPlainText($body,true))
		 {
			 $strip = strpos($text, ' - ');
			 $start = 0;
			 
			 if($strip>0 && $strip<50)
			 {
				 $start = $strip+3;
				 $maxlen += $strip+3;
			 }
			 
			 $splitIndex = strpos($text, '.',$start);
			 $isForceSplit=true;
			 if(strlen($text)<$maxlen)
			 {
				
				// $dotIndex = strpos($text, ' ',$maxlen,$start);
				// if($dotIndex!==false){
				//	 $text = substr($text,$start,$dotIndex) . "...";
				// }
			 }
			 else{
				 if($splitIndex!==false)
				 {
					 if($splitIndex>$maxlen)
					 {
						 //$text= substr($text,$start,$maxlen) . "...";
						 
					 }else{
						 
						 if($splitIndex>$maxlen-40){
							 $text = substr($text,$start,$splitIndex);
						 	$isForceSplit=false;
						 }
					 }
				 }else{
					// $text= substr($text,$start,$maxlen) . "...";
				 }
			 }
		 }
			if( $isForceSplit)
			{
				$spaceIndex = strpos($text, ' ',$maxlen);
				if($spaceIndex!==false)
				{
					$text = substr($text,$start,$spaceIndex) . "...";
				}
			}
		 return $text ;
	}


	public static function excerpt($body,$maxlen = 100)
	{

		 if($text  = Helper::htmlToPlainText($body,true))
		 {
			 $strip = strpos($text, ' - ');
			 $start = 0;
			 
			 if($strip>0 && $strip<50)
			 {
				 $start = $strip+3;
				 $maxlen += $strip+3;
			 }
			 if(strlen($text)-$start > $maxlen)
			 {
			 	$spaceIndex = strpos($text, ' ',$maxlen);
				 if($spaceIndex!==false)
				 {
					 $text = substr($text,$start,$spaceIndex) . "...";
				 }
			 }
		 }
		 return  $text ;
	}



	public static function getHilightPosts($contentType, $len= 10, $category=0,  $orderby = 'datePublished DESC')
	{
		$items = array();
		$filter = "";
		if( $category >0 ){
			$filter =  "item.category=$category AND ";
		}
		if($result = app::$database->query(  
		PostContent::$dataViewSql . " AND $filter item.contentType='$contentType'  AND featured=1 ORDER BY item.$orderby LIMIT 0,$len"))
		{
			while ($row =  app::$database->fetchAssoc($result)){
				$row['categoryUrl'] = Request::$baseUrl .'/' . $row['pathName'];
				$row['url'] = $row['categoryUrl'] .'/'. $row['name'];
				PostContent::parseMeta($row);
				$items[] = new Object($row);
			}
		}
		return $items;
	}
	
	public static function getPosts($contentType, $len= 10,$category=0,  $orderby = 'datePublished DESC')
	{
		$items = array();
		$filter = array();
		if( $category >0 ){
			$filter[] =  "item.category=$category";
		}
		if( $contentType !== null ){
			$filter[] =  "item.contentType='$contentType'";
		}
		
		$queryAll =  app::$database->query(  PostContent::$dataViewSql );
		
		// $items['pageIndex'] = count($queryAll);
		
		if($result = app::$database->query(  
		PostContent::$dataViewSql .  (empty($filter)?"": " AND " . implode(" AND ",$filter)) . " ORDER BY item.$orderby LIMIT 0,$len"))
		{
			while ($row =  app::$database->fetchAssoc($result))
			{
				$row['categoryUrl'] = Request::$baseUrl .'/' . $row['pathName'];
				$row['url'] = $row['categoryUrl'] .'/'. $row['name'];
				PostContent::parseMeta($row);
				$items[] = new Object($row);
			}
		}
		return $items;
	}
	
	public static function getLatestPosts($contentType, $len=10, $category=0)
	{
		return self::getPosts($contentType, $len,$category);
	}

	public static function getMostPopularPosts($contentType, $len=10, $category=0)
	{
		return self::getPosts($contentType, $len,$category,'views DESC');
	}
	
	
	// get nex/prev post
	public static function getPost($contentType, $id)
	{
		$items = array();
		$filter = array();
		if( $contentType !== null ){
			$filter[] =  "item.contentType='$contentType'";
		}
		
		$queryAll =  app::$database->query(  PostContent::$dataViewSql );
		
		// $items['pageIndex'] = count($queryAll);
		
		if($result = app::$database->query("SELECT item.*, term.pathName, term.title as categoryTitle , term.id as categoryId
		FROM #__contents as item 
		INNER JOIN #__terms as term ON item.category = term.id WHERE item.status=1 AND item.contentType = 'article' AND item.id  $id LIMIT 0,1"))
		//PostContent::$dataViewSql .  (empty($filter)?"": " AND " . implode(" AND ",$filter)) . " ORDER BY item.$orderby LIMIT 0,$len"))
		{
			while ($row =  app::$database->fetchAssoc($result))
			{
				$row['categoryUrl'] = Request::$baseUrl .'/' . $row['pathName'];
				$row['url'] = $row['categoryUrl'] .'/'. $row['name'];
				PostContent::parseMeta($row);
				$items[] = new Object($row);
			}
		}
		return $items;
	}
}

?>