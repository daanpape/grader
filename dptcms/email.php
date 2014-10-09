<?php

/*
 * DPTechnics CMS
 * Email module
 * Author: Daan Pape
 * Date: 04-09-2014
 */

// Load required files
require_once('config.php');
require_once('database.php');
require_once('lib/swift_required.php');

class Email {
	
	/*
	 * Send multipart email 
	 */
	public static function sendMail($destination, $sender, $subject, $replyto, $html, $plain)
	{
		// Create the mail transport configuration
		$transport = Swift_MailTransport::newInstance();
		
		// Create the message
		$message = Swift_Message::newInstance();
		
		// Fill in the message headers
		$message->setTo(array($destination));
		$message->setSubject($subject);
		$message->setFrom($sender);
		$message->setReplyTo(array($replyto));
		
		// Fill in the message body
		$message->setBody($plain, 'text/plain');
		$message->addPart($html, 'text/html');
		
		echo $plain;
		
		// Send the email message
		$mailer = Swift_Mailer::newInstance($transport);
		return $mailer->send($message);
	}
	
	/*
	 * Fills in an email template. $email is the email 
	 * template containing subject, plain and html text
	 * where ':xxxx' parameters will be parsed. $data is 
	 * an array with 'key=>value' pairs that will be searched.
	 */
	public static function parseTemplate($email, $data)
	{
		// Parse the email
		foreach($data as $param => $value) {
			$email->subject = str_replace('{'.$param.'}', $value, $email->subject);
			$email->plain = str_replace('{'.$param.'}', $value, $email->plain);
			$email->html = str_replace('{'.$param.'}', $value, $email->html);
		}
		
		// Return it
		return $email;
	}
	
	/*
	 * Send a registration mail to the user
	 */
	public static function sendActivationMail($lang, $destination, $firstname, $lastname, $username, $token)
	{
		// Generate activation link
		$link = Config::$siteURL.'/activate/'.$token;
		
		// Fetch the emailtemplate from the database
		$template = EmailDAO::getEmail('activation', $lang);
		
		// Check if a template could be found
		if($template == null) {
			return null;
		}
		
		// Parse the template
		$email = self::parseTemplate($template, array(
			'firstname' => $firstname,
			'lastname' => $lastname,
			'username' => $username,
			'link' => $link,
			));
			
		// Send the multipart email
		return self::sendMail($destination, $email->sender, $email->subject, $email->replyto, $email->html, $email->plain);
	}
}
?>