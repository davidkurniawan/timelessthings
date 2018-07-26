<?php
/*/////////////////////////////////////////////////////////////////////////////////////////////////////////////
Copyright 2012 by wildan
shapetherapy@gmail.com
*/
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { header("Status: 404 Not Found"); exit; }
///////////////////////////////////////////////////////////////////////////////////////////////////////////////



class Mysql extends DataProvider
{
	protected function get__providerName()
	{
		return 'MySql';
	}
	protected function onOpen($persistent=false)
	{	
		if($persistent)
			return  @mysql_pconnect($this->_host, $this->_user,$this->_password);
		else
			return @mysql_connect($this->_host, $this->_user,$this->_password,true);
	}	

	
	protected function onClose()
	{
		@mysql_free_result($this->_result);
		return @mysql_close($this->_handle);
	}
	protected function onSelectDb()
	{
		return @mysql_select_db($this->_database, $this->_handle);
	}
	public function escape($str)
	{
		if (function_exists('mysql_real_escape_string'))
			$str = @mysql_real_escape_string($str, $this->_handle);
		else
			$str = mysql_escape_string($str);
		return $str;
	}
	public function onQuery($sql)
	{
		return mysql_query($sql, $this->_handle);
	}
	
	public function beginTrans()
	{
		$this->query('SET AUTOCOMMIT=0');
		$this->query('BEGIN');
	}
	public function commitTrans()
	{
		$this->query('COMMIT');
		$this->query('SET AUTOCOMMIT=1');
	}
	public function rollBackTrans()
	{
		$this->query('ROLLBACK');
		$this->query('SET AUTOCOMMIT=1');
	}
	public function numRows($result=null)
	{
		$result=is_null($result)?$this->_result:$result;
		return intval( @mysql_num_rows($result));
	}
	public function fetchResult($result=null,$row=0,$field=0)
	{
		$result = is_null($result)?$this->_result:$result;
		return ($result) ? @mysql_result($result,$row,$field) : false;
	}
	public function fetchAssoc($result=null)
	{
		$result = is_null($result)?$this->_result:$result;
		return ($result) ? @mysql_fetch_assoc($result) : false;
	}
	public function fetchRow($result=null)
	{
		$result = is_null($result)?$this->_result:$result;
		return ($result) ? @mysql_fetch_row($result) : false;
	}
	public function seek($index,$result=null)
	{
		$result = is_null($result)?$this->_result:$result;
		return @mysql_data_seek($result, $index);
	}
	public function insertId($link_id=null)
	{
		if(is_null($link_id))
			return @mysql_insert_id($this->_handle);
		else
			return @mysql_insert_id($link_id);
	}
	public function affectedRows($link_id=null)
	{
		if(is_null($link_id))
			return mysql_affected_rows();
		else
			return @mysql_affected_rows($this->_handle);
	}
	public function errorDescription()
	{
		return 	($this->_handle)?@mysql_error($this->_handle):mysql_error();
	}	

}

?>