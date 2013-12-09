<?php defined('SYSPATH') OR die('No direct access allowed.');

/***

TODO
- go through spam assassin documentation and get the spam score as low as possible to ensure email's received

***/

class Emailer_Model extends Model {
	public function sendemail($to, $subject, $body, $from='info@10fintec.com')
	{
		include Kohana::find_file('vendor', 'phpmailer/class.phpmailer');

		$config = Kohana::config('email.options');

		$mail = new PHPMailer(); // defaults to using php "mail()"
		
		$mail->IsSMTP(); // telling the class to use SMTP
		//$mail->Host       = "mail.studionostalgia.ca"; // SMTP server
		$mail->Host       = $config['hostname'];
		$mail->SMTPDebug  = 1;					// enables SMTP debug information (for testing)
												// 1 = errors and messages
												// 2 = messages only
		$mail->SMTPAuth   = $config['authentication'];				// enable SMTP authentication
		$mail->SMTPSecure = $config['encryption'];
		$mail->Port       = $config['port'];
		$mail->Username   = $config['username'];
		$mail->Password   = $config['password'];

		//$mail->AddReplyTo('grad@studionostalgia.ca', 'Studio Nostalgia Graduation Photos');
		$mail->SetFrom('info@10fintec.com', '10fintec');

		$mail->AddAddress($to);
		$mail->Subject    = $subject;
		
		$mail->MsgHTML($body);

		if(!$mail->Send()) {
			//echo "Mailer Error: " . $mail->ErrorInfo;
			return true;
		} else {
			//echo "Message sent!";
			return false;
		}
	}
	
	public function showtemplate($content=null)
	{
		$view = View::factory('email/template');
		if($content)
			$view->content = $content;
		echo $view->render();
		
	}
}