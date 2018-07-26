<?php
if (preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { header("Status: 404 Not Found");
	exit ;
}

class Contact extends HtmlDocument {
	
	
	// $scripts = array ('jquery.inputmask.js');
	protected $msgEr, $status;
	public $bodyClass ="single";
	public $script = "";
	
	protected $settings, $queries;
	
	protected function onPageStart() {
		$this -> contentFilename = $this -> templatePath . '/contact.php';
		
		
		if (Request::isPost()) {

			$this->queries = Request::isPost() ? $_POST : $_GET;
			// var_dump($this->queries);
			$this -> sendContact($this->queries);

		}
		
		$this->settings = Settings::getSettings();
		
		

	}

	private function sendContact($queries) {

		// $to = Homepage::getEmailContact();
		$to = $this->settings['contactMail'];
		
		if (!empty($queries)) {

			$subject = '[Contact] '. $this->queries['subject'];
			
			$name = $this->queries['name'];
			$email = $this->queries['email'];
				
			$messages  =  "<ul>";
			$messages .= "<li> Name : ". $name ."</li>";
			$messages .= "<li> Email : ". $email ."</li>";
			$messages .= "<li> Surename : ". @$_POST['surname'] ."</li>";
			$messages .= "<li> Message : ". $this->queries['subject'] ."</li>";
					
			$messages .= "</ul>";	
				
			$sendmail = Helper::sendMail($to, $subject, $messages, $email, 1);

			if ($sendmail) {
					$this->status = "success";	
				$this->msgEr = "Thank You For Contact Us";
			}else{
				$this->status = "danger";
				$this->msgEr = "Please Try Again";
			}
			
		}

	}

}


