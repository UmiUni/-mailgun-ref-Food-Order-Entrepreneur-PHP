<?php

require("Conn.php");
require("MySQLDao.php");
require("Classes/EmailConfirmation.php");

$email = htmlentities($_POST["email"]);
$password = htmlentities($_POST["password"]);

$returnValue = array();


if(empty($email) || empty($password)){
$returnValue["status"] = "error";
$returnValue["message"] = "Missing required field";
echo json_encode($returnValue);
return;
}

$dao = new MySQLDao();
$dao->openConnection();
$userDetails = $dao->getUserDetails($email);

if(!empty($userDetails))
{
$returnValue["status"] = "error";
$returnValue["message"] = "User already exists";
echo json_encode($returnValue);
return;
}

$secure_password = md5($password); // I do this, so that user password cannot be read even by me

$result = $dao->registerUser($email,$secure_password);

if($result)
{
$returnValue["status"] = "Success";
$returnValue["message"] = "User is registered";
echo json_encode($returnValue);

// Generate a unique email confirmation token
$emailConfirmation = new EmailConfirmation();
$emailToken = $emailConfirmation->generateUniqueToken(16);

// Store this token in our database table
$dao->storeEmailToken($_POST["email"], $emailToken);

// Prepare email message parameters like Subject, Message, From, To and etc.
$messageDetails = array();
$messageDetails["message_subject"] = "Please confirm your email address";
$messageDetails["to_email"] = $_POST["email"];
$messageDetails["from_name"] = "Chaoran Wang";
$messageDetails["from_email"] = "superchaoran@gmail.com";

// Load up email message from an email template
$emailMessage = $emailConfirmation->loadEmailMessage();
$emailMessage = str_replace("{token}", $emailToken, $emailMessage);
$messageDetails["message_body"] = $emailMessage;

// Send out this email message to user
$emailConfirmation->sendEmailConfirmation($messageDetails);

return;

} else {
	$returnValue["status"] = "400";
	$returnValue["message"] = "Could not register user with provided information";
}

$dao->closeConnection();

?>

