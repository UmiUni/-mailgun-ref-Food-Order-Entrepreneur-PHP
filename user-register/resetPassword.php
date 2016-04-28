
<?php
require("Conn.php");
require("MySQLDao.php");
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
$ret = $dao->resetPassword($email, $emailTokenFromDatabase);
echo $ret;
$dao->closeConnection();
?>
