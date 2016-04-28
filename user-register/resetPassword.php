
<?php
require("Conn.php");
require("MySQLDao.php");
require("EmailConfirmation.php");
$dao = new MySQLDao();
$dao->openConnection();
$email = htmlentities($_POST["email"]);
$returnValue = array();
$returnValue["status"] = "error";
$returnValue["message"] = "Missing required field";
if (empty($email_token)) {
	return $returnValue;
}
$emailTokenFromDatabase = getEmailToken($email);
if($emailTokenFromDatabase === '') return "Email not exists!";
if($dao->emailMatchToken($email, $emailTokenFromDatabase)) {
// Send out this email message to user
$emailConfirmation = new EmailConfirmation();
$emailConfirmation->sendEmailPasswordReset($email, $emailToken);
}
$dao->closeConnection();
?>
