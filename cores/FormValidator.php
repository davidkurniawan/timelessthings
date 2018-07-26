<?php


class FormValidator
{
	private $formData;
	private $errFields = array();
	
	public  function __construct($formdata)
	{
		$type = gettype($formdata);
		//echo $type;exit;
		if($type =='object')
		{
			 $this->formData = (array) $formdata;
		}
		else if($type =='string')
		{
			 if(!($this->formData = @ json_encode($formdata,true)))
			 {
				 throw new Exception('Invalid JSON string.');
			 }
		}else if($type =='array')
		{
			$this->formData = $formdata;
		}
		else
		{
			 throw new Exception('Invalid form data.');
		}
	}

	private function notEmpty($postname)
	{
		if(isset($this->formData[$postname]) )
		{
			if($this->formData[$postname] == '')
			{
				$this->errFields[$postname] = '';
				return false;
			}
			return true;
		}
		return false;
	}
	
	public function setError($postname, $msg='')
	{
		$this->errFields[$postname] = $msg;
		//echo $this->errFields[$postname];exit;
	}
	
	public function getValue($postname, $defaultValue='')
	{
		if(isset($this->formData[$postname]) ){
			return  $this->formData[$postname];
		}
		return $defaultValue;
	}
	public function getNumber($postname, $defaultValue=0)
	{
		if(isset($this->formData[$postname]) ){
			return  intval($this->formData[$postname]);
		}
		return $defaultValue;
	}
	
	/////////////////////////////
	public function validateText($postname, $minlength=1, $maxlength = 2147483647)
	{
		if(!$this->errText($postname, $minlength, $maxlength)){
			return $this->formData[$postname];
		}
		return null;
	}
	public function validateEmail($postname,$defaultValue='')
	{
		if(!$this->errEmail($postname)){
			return  $this->formData[$postname];
		}
		return null;
	}
	public function validatePhoneBumber($postname,$defaultValue='')
	{
		if(!$this->errPhoneNumber($postname)){
			return  $this->formData[$postname];
		}
		return null;
	}
	
	public function validateNumber($postname,$defaultValue=0, $min=null, $max=null)
	{
		if(!$this->errNumber($postname,$min, $max)){
			return  $this->formData[$postname];
		}
		return null;
	}
	public function validateDateIso($postname,$defaultValue='')
	{
		if(!$this->errDateIso($postname)){
			return  $this->formData[$postname];
		}
		return null;
	}
	public function isValid($field=null)
	{
		if($field && gettype($field)=='string')
		{
			return !isset($this->errFields[$field]);
		} 
		return count($this->errFields)==0;
	}
	public function getInvalidFields()
	{
		return array_keys($this->errFields);
	}
	
	public function getInvalidMessage($field)
	{
		return !$this->isValid($field)? $this->errFields[$field]:'';
	}

/*
	public function release()
	{
		if($this->errFields)
		{
			if(!Request::isXmlHttpRequest())
			{
				app::$page->addScript('_INVALID_FIELDS = ' . json_encode($this->errFields) . ';');
			}
			return false;
		}
		return true;
	}
*/
	/////////////////////////////
	private function errText($postname, $minlength=1, $maxlength = 2147483647)
	{
		if($this->notEmpty($postname)){
			$this->formData[$postname] = trim($this->formData[$postname]);
			$len = strlen($this->formData[$postname]);
			if( !($len>= $minlength && $len<= $maxlength) )
			{
				$this->errFields[$postname] ='';
			}else
				return false;
		}
		return true;
	}
	private function errEmail($postname)
	{
		if($this->notEmpty($postname))
		{
			if(!Helper::isEmail($this->formData[$postname]))
			{
				$this->errFields[$postname] ='';
			}else
				return false;
		}
		return true;
	}
	private function errNumber($postname,$min=null, $max=null)
	{
		if($this->notEmpty($postname))
		{
			$num = $this->formData[$postname];
			if(!is_numeric($num))
			{
				$this->errFields[$postname] ='';
			}else{
				if(is_numeric($min)){
					if($num < $min){
						$this->errFields[$postname] ='';
						return true;
					}
				}
				if(is_numeric($max)){
					if($num > $max){
						$this->errFields[$postname] ='';
						return true;
					}
				}
				return false;
			}
		}
		return true;
	}
	private function errPhoneNumber($postname)
	{
		if($this->notEmpty($postname))
		{
			if( preg_match('#^((\+[1-9])|0+)([0-9]+)$#i',$this->formData[$postname]))
			{
				return false;
			}else{
				$this->errFields[$postname] ='';
				return true;
			}
		}
		return true;
	}
	private function errDateIso($postname)
	{
		if($this->notEmpty($postname))
		{
			if( preg_match('#^(?<y>[0-9]{4}+)-(?<m>[0-9]{2}+)-(?<d>[0-9]{2}+)$#i',$this->formData[$postname], $m))
			{
				if( !($m['y'] >1900  && (intval($m['m'])>0 &&  intval($m['m'])<=12) && (intval($m['d'])>0 &&  intval($m['d'])<=31)) ){
					$this->errFields[$postname] ='';
					return true;
				}
			}
			return false;
		}
		return true;
	}
	////////////////////
}
?>