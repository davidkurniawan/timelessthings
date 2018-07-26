<?php
class Pagination
{
	private
	$pageLength
	,$basePath,
	$queries_str;
	public function __construct( $currentPageIndex,$pageLength)
	{

		$this->pageLength = $pageLength;
		$this->currPageIndex = $currentPageIndex;
		$this->queries_str =  parse_url(Request::$url, PHP_URL_QUERY);

	}
	private function pageLink($pageIndex,$qname)
	{
		if( $qname){
			$href = Helper::buildUrl(Request::$url,$qname . '=' .$pageIndex);
		}else{
			$href = Request::$basePathUrl . '/' . $pageIndex;
			if($this->queries_str){
				$href = Helper::buildUrl( $href,$this->queries_str );
			}
		}
		return "<li" . ($pageIndex-1 != $this->currPageIndex ? "" : ' class="current" ') . "><a href=\"" . $href . "\">" . $pageIndex .  "</a></li>";
	}
	public function getHtml($mumPadding=6,  $pageIndexQueryName=null)
	{
		if($this->pageLength==1)
		{
			return "";
		}
		$numLinks = $mumPadding;
		if ($numLinks > $this->pageLength)
			$numLinks = $this->pageLength;

		$n_index = $this->currPageIndex + 1;
		$n_sideLinks = intval(($numLinks - 1) / 2);

		if ($n_index + $n_sideLinks >= $this->pageLength)
		{
			$n_firstLink = $this->pageLength - $numLinks + 1;
			$n_lastLink = $this->pageLength;
		}
		else if ($n_index - $n_sideLinks <= 0)
		{
			$n_firstLink = 1;
			$n_lastLink = $numLinks;
		}
		else
		{
			$n_firstLink = $n_index - $n_sideLinks;
			$n_lastLink = $n_firstLink + $numLinks - 1;
		}
		$sb = array();
		 if ($n_firstLink != 1)
		 {
			 $ln = 1;
			 $sb[] =$this->pageLink(1, $pageIndexQueryName);
			 if ($n_firstLink != 2)
			 {
				 $sb[] =$this->pageLink(2, $pageIndexQueryName);
				 $ln = 2;
			 }
			 if ($ln != $n_firstLink - 1)
				 $sb[] ="<li><span>&#8230;</span></li>";
		 }

		for ($i = $n_firstLink; $i <= $n_lastLink; $i++)
		{
			$sb[] = $this->pageLink($i, $pageIndexQueryName);
		}

		if ($n_lastLink != $this->pageLength)
		{
			$ln = 0;
			if ($n_lastLink != $this->pageLength - 1)
			{
				$ln = 1;
			}
			if ($n_lastLink + 1 != $this->pageLength - $ln)
				$sb[] ="<li><span>&#8230;</span></li>";

			if ($ln == 1)
				$sb[] =$this->pageLink($this->pageLength - 1, $pageIndexQueryName);

			$sb[] = $this->pageLink($this->pageLength, $pageIndexQueryName);
		}

		return implode('',$sb);
	}
}
?>