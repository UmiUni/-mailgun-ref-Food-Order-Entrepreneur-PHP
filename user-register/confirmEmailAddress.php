<?php
require("Conn.php");
require("MySQLDao.php");
$dao = new MySQLDao();
$dao->openConnection();
$email_token = htmlentities($_GET["token"]);
$email = htmlentities($_GET["email"]);

if (empty($email_token)) {
	echo "Missing required parameter";
	return;
}
$ret = $dao->activateEmail($email, $email_token);
echo $ret;
$dao->closeConnection();
?>
