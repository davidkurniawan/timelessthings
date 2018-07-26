<?php
/*/////////////////////////////////////////////////////////////////////////////////////////////////////////////
Author URI: http://shapetherapy.com/
Copyright 2008-2010 by wildan
*/
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { header("Status: 404 Not Found"); exit; }
///////////////////////////////////////////////////////////////////////////////////////////////////////////////


class PostedFile extends Object
{
	private $base_mime,$destination;
	public function __construct($userfile)
	{
		if(isset($_FILES[$userfile]))
		{
			$this->properties = $_FILES[$userfile];
			
			$pf = pathinfo($this->name);
			$this->extension = '';
			$this->basename  = $this->name;
			if(!empty($pf['extension']))
			{
				if(strlen($pf['extension'])<=32)
				{
					$this->basename     = basename($this->name, '.'. $pf['extension']);
					$this->extension    = strtolower($pf['extension']);
					if($this->extension == 'jpeg')
						$this->extension = 'jpg';
				}
			}
		
			$this->uniqueName = rand(1,9) . uniqid();			
			$base_mime = explode('/',$this->type);
			$this->baseMime = $base_mime[0];
			
		}else
			$this->error = UPLOAD_ERR_NO_FILE;
	}

	public function move($destination)
	{
		return move_uploaded_file ($this->tmp_name, $destination);
	}

}
?>