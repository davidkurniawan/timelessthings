<?php

if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { header("Status: 404 Not Found"); exit; }
///////////////////////////////////////////////////////////////////////////////////////////////////////////////


class Adm_DataEntries extends Adm_Base
{
	protected 
		$items,
		$itemPerPage = 15,
		$statusTitles,
		$statusView = null,
		
		$countPublishItems=0,
		$countDeleteItems =0,
		$countDrafItems   =0,
		
		$sortOrder ="id DESC";
	
	protected function onPageStart()
	{
		parent::onPageStart();
		
		$this->statusTitles = array(
			0 => 'Draf',
			1 => 'Published',
			2 => 'Trash'
		);
		
		if(empty($this->task))
		{
			$this->pageIndex = intval(@ $_GET['p'] );
			if($this->pageIndex <1) $this->pageIndex  =1;
	
			$this->items = array();
			$this->dataview = new DataView();
			$this->dataview->pageIndex  = $this->pageIndex;
			$this->dataview->strOrderBy = $this->sortOrder;

			$this->isTrashCan  = isset($_REQUEST['trashcan']);
			
			$statusFilter ="item.status<>2";
			if($this->statusTitles)
			{
				if(isset($_REQUEST['status']))
				{
					$status   = intval($_REQUEST['status']);
					if(isset($status ))
					{
						$subtitle =  $this->statusTitles[$status];
						$statusFilter = "item.status=$status";
						$this->statusView = $status;
					}else{
						Response::badRequest();
					}
				}
			}

			$totalRows = app::$database->getResult(
				preg_replace('/(\s|^)SELECT(.*)FROM/si', 'SELECT count(*) FROM',$this->onDataview(""))
			);
			if($totalRows)
			{
				$this->countPublishItems = app::$database->getResult(
					preg_replace('/(\s|^)SELECT(.*)FROM/si', 'SELECT count(*) FROM', $this->onDataview("item.status=1"))
				);
				$this->countDrafItems = app::$database->getResult(
				preg_replace('/(\s|^)SELECT(.*)FROM/si', 'SELECT count(*) FROM', $this->onDataview("item.status=0"))
				);
				
				$this->countAllItems    = ($this->countPublishItems+$this->countDrafItems);
				$this->countDeleteItems  = $totalRows - ($this->countPublishItems + $this->countDrafItems);
				
				$sql = $this->onDataview($statusFilter);
				$this->dataview->queryPages( $sql ,$this->itemPerPage);
			}

			
			while ($row =  $this->dataview->fetchAssoc())
			{
				$this->onDataviewAssoc($row);
				$this->items[] = new Object($row);
			}
			if(isset($subtitle)){
				$this->title .=  " / $subtitle";
			}
			
		}else
		{
			if($this->task=='edit')
			{
				 $this->onEdit();
				 $this->title .=  " / Edit";
			}
			else if($this->task=='new')
			{
				$this->onNew();
				$this->title .=  " / New";
			}
		}
	}
	protected function onDataview($statusFilter){}
	protected function onDataviewAssoc(& $row){}
	protected function onEdit(){}
	protected function onNew(){}
}

?>