
<?php
require("Conn.php");
require("MySQLDao.php");
require("EmailConfirmation.php");
$dao = new MySQLDao();
$dao->openConnection();
$email = htmlentities($_POST["email"]);
$returnValue = array();

if (empty($email)) {
$returnValue["status"] = "Error";
$returnValue["message"] = "Missing required field: Email!";
echo json_encode($returnValue);
return;
}

$emailTokenFromDatabase = $dao->getEmailToken($email);

if(strcmp($emailTokenFromDatabase, "") === 0) {
$returnValue["status"] = "Error";
$returnValue["message"] = "Email not exists!";
echo json_encode($returnValue);
return;
}

if($dao->emailMatchToken($email, $emailTokenFromDatabase)) {
// Send out this email message to user
$emailConfirmation = new EmailConfirmation();
$emailConfirmation->sendEmailPasswordReset($email, $emailToken);

$returnValue["status"] = "Success";
$returnValue["message"] = "Reset email has been sent, please check your inbox or spambox!";
echo json_encode($returnValue);
return;
} else {
$returnValue["status"] = "Error";
$returnValue["message"] = "Email exists but reset email has not been sent, please contact food@jogchat.com";
echo json_encode($returnValue);
return;
}
$dao->closeConnection();
?>
