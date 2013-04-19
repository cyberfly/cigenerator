<?php defined('BASEPATH') OR exit('No direct script access allowed');

/** Use this class for Email and SMS notification */
class Notification {
	private $_ci;

	function __construct()
	{
		$this->_ci = &get_instance();
	}
	
	public function send_mail($to, $subject, $message, $headers){
		$to = 'charles.ling@uvsms.com';
		mail($to, $subject, $message, $headers);
	}
	
	public function email_notification_generic($arrData){
		$to = 'charles.ling@uvsms.com';
		$to      = $arrData['email_recipient'];
		$subject = $arrData['email_subject'];
		$message = $arrData['email_message'];
		$headers  = 'MIME-Version: 1.0' ."\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' ."\r\n";
		// Additional headers
		$headers .= 'From: enquiry@waterlesscarwash.com.my' . "\r\n";
		$this->send_mail($to, $subject, $message, $headers);
	}
}