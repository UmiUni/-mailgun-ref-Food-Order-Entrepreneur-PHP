<?php
require("Conn.php");
require("MySQLDao.php");
$email = htmlentities($_POST["email"]);
$password = htmlentities($_POST["password"]);
$returnValue = array();

if(empty($email) || empty($password))
{
$returnValue["status"] = "error";
$returnValue["message"] = "Missing required field";
echo json_encode($returnValue);
return;
}

$secure_password = md5($password);

$dao = new MySQLDao();
$dao->openConnection();
$userDetails = $dao->getUserDetailsWithPassword($email,$secure_password);

if(!empty($userDetails))
{
$returnValue["status"] = "Success";
$returnValue["message"] = "Logged in successfully!";
echo json_encode($returnValue);
} else {
$returnValue["status"] = "Error";
$returnValue["message"] = "Email is not found or password is incorrect!";
echo json_encode($returnValue);
}

$dao->closeConnection();

?>
