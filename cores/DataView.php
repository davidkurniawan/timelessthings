<?php
class DataView
{
	protected $db;
	private 
		$sql,
		$num_display = 0,
		$page_index  = 0,
		$view_result;
	public  
		$pageIndex  = 1,
		$pageLength = 0,
		$totalRows  = 0,
		$firstIndex = 0,
		$numDisplay = 0,
		$pagination,
		$querySelectCount,
		$strOrderBy='';
		
	
	
	public function __construct( $db = null)
	{
		$this->db = is_null($db)?App::$database:$db;
	}
	
	public function queryPages($sql, $num_display = null)
	{ 
		if(isset($this->querySelectCount)){
			$result           = $this->db->query($this->querySelectCount); 
		}else{
			$sql_count        =  preg_replace('/(\s|^)SELECT(.*)FROM/si', 'SELECT count(*) FROM',$sql);
			$result           = $this->db->query($sql_count); 
		}
		$this->totalRows  = $this->db->fetchResult($result);
		$this->sql        = $sql;
		
		if($this->totalRows==0) return;
		
		$this->num_display = is_null($num_display)? $this->numDisplay:$num_display;
		$this->num_display = $this->num_display<= 0? $this->totalRows: $this->num_display;
		$this->numDisplay  = $this->num_display;
		$this->pageLength  = ceil($this->totalRows / $this->num_display);
		
		$this->page_index  = ($this->pageIndex -1);
		$this->page_index  = ($this->page_index<0)? 0 : ($this->page_index> $this->pageLength-1 ? $this->pageLength-1 : $this->page_index);
		$this->firstIndex  = $this->page_index * $this->num_display;

		$this->view_result = $this->db->query($this->sql  .  (empty($this->strOrderBy)?'': ' Order By '. $this->strOrderBy )   . ($this->num_display>0?' LIMIT '. $this->firstIndex .','.$this->num_display:'') ) or $this->db->error( __FILE__, __LINE__); 
		$this->pagination = new Pagination($this->page_index, $this->pageLength);
	}
	
	public function query($sql )
	{ 
		$this->view_result = $this->db->query
		(
			$sql
		) or $this->db->error( __FILE__, __LINE__); 
		
		$this->totalRows= $this->db->numRows($this->view_result);
	}
	
	public function fetchAssoc()
	{ 
		return $this->db->fetchAssoc($this->view_result);
	}


}
	
?>