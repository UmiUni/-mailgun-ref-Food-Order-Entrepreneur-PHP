<?php
require("Conn.php");
require("MySQLDao.php");
$dao = new MySQLDao();
$dao->openConnection();
$email_token = htmlentities($_POST["token"]);
$email = htmlentities($_POST["email"]);
$newPassword = htmlentities($_POST["newPassword"]);
$confirmPassword = htmlentities($_POST["confirmPassword"]);
if(empty($newPassword) || empty($confirmPassword)){
echo '<h1>Password cannot be empty!</h1>';
header('Refresh: 1; url = '. $_SERVER['HTTP_REFERER']);
} else {
if(strcmp($newPassword,$confirmPassword) !== 0){
echo '<h1>Password mismatch!</h1>';
header('Refresh: 1; url = '. $_SERVER['HTTP_REFERER']);
} else {
$secure_password = md5($newPassword);
$ret = $dao->resetPassword($email, $email_token, $secure_password);
echo $ret;
}
}
?>
