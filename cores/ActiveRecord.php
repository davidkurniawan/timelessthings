<?php

class ActiveRecord
{
	protected 
		$table,
		$connection=null,
		$columns=null,
		$primaryKey;
	public $datarow = array();
	public function __construct($table, $datarow=null, $primary_key = null, $connection=null)
	{
		
		$this->connection = is_null($connection)? App::$database: $connection;
		$this->table      = $table;
		
		$this->primaryKey = is_null($primary_key)?$this->connection->getPrimaryKey($table):$primary_key;
	
		if(is_array($datarow)) 
			$this->datarow = $datarow;
	}	
	
	public function save($_datarow=null)
	{
		if(is_null($_datarow))
		{
			if(is_null($this->columns))
			{
				$_columns = App::$database->getDataRows("SHOW COLUMNS FROM " . $this->table);
				$this->columns = array();
				foreach($_columns as  $value)
					$this->columns[] = $value['Field'];
			}
			$datarow = array();
			foreach($this->datarow as $key => $value)
			{
				if (in_array($key, $this->columns)) 
				{
					$datarow[$key]=$value;
				}
			}
		}else
		$datarow = $_datarow;

		if(is_null($this->primaryKey))
		{
			if ($this->connection->insertRow ($this->table, $datarow))
			{
				return true;
			}
			return false;
		}
		if(empty($this->datarow[$this->primaryKey]))
		{
			
			if ($this->connection->insertRow ($this->table, $datarow))
			{
				return $this->datarow[$this->primaryKey] = $this->connection->insertId();
			}
		}else
		{
			if(is_null($this->primaryKey))
			{
				trigger_error("Can not save ActiveRecord when primarykey is not set on table '{$this->table}'", E_USER_ERROR);
			}
			$id   = $this->datarow[$this->primaryKey];
			$retval = $this->connection->updateRows($this->table, $datarow, $this->primaryKey . '='. $id);
			return $retval;
		}
	}
	public function delete()
	{
		if(!empty($this->datarow[$this->primaryKey]))
		{
			if($this->connection->deleteRows($this->table, $this->primaryKey . '='. $this->datarow[$this->primaryKey]))
			{
				unset($this->datarow[$this->primaryKey]);
				return true;
			}
		}
		return false;
	}
    public function __get($prop)
    {
		return $this->getProperty($prop);
    }
	public function getProperty($name)
    {
		if (array_key_exists($name,$this->datarow)) 
		{
			return  $this->datarow[$name];
		}
		return null;
    }
    public function __set($prop, $value)
    {
		$this->datarow[$prop] = $value;
    }
	public function __isset($name) 
	{
        return isset($this->datarow[$name]);
    }
    public function __unset($name) 
	{
        unset($this->datarow[$name]);
    }
}
?>