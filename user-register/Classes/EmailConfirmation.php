<?php
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

	function sendEmailConfirmation($messageDetails) {
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		$headers .= "From: " . $messageDetails["from_name"] . " <". $messageDetails["from_email"]. ">" . "\r\n";
		$returnValue = mail($messageDetails["to_email"], $messageDetails["message_subject"], $messageDetails["message_body"], $headers);
	}
	
	function loadEmailMessage() {
		$myfile = fopen("../inc/emailMessage.html","r");
		$returnValue = fread($myfile, filesize("../inc/emailMessage.html"));
		fclose($myfile);
		return $returnValue;
	}
}
?>

