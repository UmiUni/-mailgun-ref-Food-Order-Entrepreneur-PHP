<?php
require_once "Mail.php";
require_once "Mail/mime.php";
require 'mailgun-php/vendor/autoload.php';
use Mailgun\Mailgun;
class EmailConfirmation {
	function generateUniqueToken($tokenLength) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i <$tokenLength; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}


	/*Likely goes to spam box*/
        function sendEmailByOwnServer($messageDetails) {	
		$from = $messageDetails["from_name"] . " <". $messageDetails["from_email"]. ">" . "\r\n";
		$to = $messageDetails["to_email"];
		$subject = $messageDetails["message_subject"];
		$body = $messageDetails["message_body"];
 		$headers = array ('From' => $from, 'To' => $to, 'Subject' => $subject);
	
		$host = "smtp.gmail.com";
		$username = "food@jogchat.com";
		$password = "8515111q";

	
		$crlf = "\n";
		$mime = new Mail_mime(array('eol' => $crlf));
		//$mime->setTXTBody('Please click following link to activate your account: '.$tokenLink);
		$mime->setHTMLBody($body);
		$headers = $mime->headers($headers);
		$body = $mime->get();

		//$smtp = Mail::factory('smtp', array ('host' => $host, 'auth' => true, 'username' => $username, 'password' => $password));
		//$mail = $smtp->send($to, $headers, $body);
		$mail = Mail::factory('mail');
		$mail->send($to, $headers, $body);
		/*		
		$headers = array ('From' => $from, 'To' => $to, 'Subject' => $subject);
		$smtp = Mail::factory('smtp', array ('host' => $host, 'auth' => true, 'username' => $username, 'password' => $password));
		$mail = $smtp->send($to, $headers, $body);
		*/	
		/*
		$headers = "From: food@jogchat.com\r\n";
		$headers .= "Reply-To: ". $from;
		$headers .= "Return-Path: ". $from;
    		$headers .= "X-Mailer: PHP/" . phpversion()."\r\n";
    		$headers .= "MIME-Version: 1.0\r\n";
    		$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";  
		$returnValue = mail($to, $subject, $messageDetails["message_body"], $headers);
		*/	
	}
	
	function sendEmailByMailGun($messageDetails) {

	# Instantiate the client.
	$mgClient = new Mailgun('key-f44fa8c4e93f293b34bffd8df6269870');
	$domain = "jogchat.com";

	# Make the call to the client.
	$result = $mgClient->sendMessage($domain, array(
    	'from'       => 'Food Jogchat <food@jogchat.com>',
    	'to'         => $messageDetails['to_email'],
    	'subject'    => $messageDetails["message_subject"],
    	'html'       => $messageDetails["message_body"],
    	'o:tracking' => true 
	));
	}

	function sendEmailConfirmation($email, $emailToken) {

		$randomAdd = '';
		$num = rand(5, 20);
		for ($x = 0; $x <= $num; $x++) {
		 $randomAdd = $randomAdd.'*';
		}

		$messageDetails = array();
		$messageDetails["message_subject"] = $randomAdd."Activate Your Jogchat Account".$randomAdd;
		$messageDetails["to_email"] = $email;
		$messageDetails["from_name"] = "Food Jogchat";
		$messageDetails["from_email"] = "food@jogchat.com";

		$tokenLink = 'http://www.jogchat.com/Food-Order-Entrepreneur-PHP/user-register/confirmEmailAddress.php?token='.
				$emailToken.'&email='.$messageDetails["to_email"];
		$messageDetails["message_body"] =' 
		<html>
		  <body>
		    <h1>'.$randomAdd.' Welcome to Jogchat.com '.$randomAdd.'</h1>
		    <h1>Please click on the following link to activate your account: </h1>
		    <h1>'.$randomAdd.'<a href ="'.$tokenLink.'">link</a>'.$randomAdd.'</h1>
		  </body>
		</html>
		';
		//self::sendEmailByOwnServer($messageDetails);
		self::sendEmailByMailGun($messageDetails);
	 }

	 function sendEmailPasswordReset($email,$emailToken) {
		$randomAdd = ''; 
                $num = rand(5, 20);
                for ($x = 0; $x <= $num; $x++) {
                 $randomAdd = $randomAdd.'*';
                }   

                $messageDetails = array();
                $messageDetails["message_subject"] = $randomAdd."Reset Your Jogchat Account Password".$randomAdd;
                $messageDetails["to_email"] = $email;
                $messageDetails["from_name"] = "Food Jogchat";
                $messageDetails["from_email"] = "food@jogchat.com";

                $resetLink = 'http://www.jogchat.com/Food-Order-Entrepreneur-PHP/user-register/resetPasswordStep2.php?token='.$emailToken.'&email='.$email;
                $messageDetails["message_body"] ='  
                <html>
                  <body>
                    <h1>'.$randomAdd.' Welcome to Jogchat.com '.$randomAdd.'</h1>
                    <h1>Please click on the following link to reset your password: </h1>
                    <h1>'.$randomAdd.'<a href ="'.$resetLink.'">link</a>'.$randomAdd.'</h1>
                  </body>
                </html>
                ';
                //self::sendEmailByOwnServer($messageDetails);		
                self::sendEmailByMailGun($messageDetails);		
	 }

}
?>

