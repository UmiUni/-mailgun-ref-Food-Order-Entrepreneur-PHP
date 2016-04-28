<?php
class MySQLDao {
var $dbhost = null;
var $dbuser = null;
var $dbpass = null;
var $conn = null;
var $dbname = null;
var $result = null;

function __construct() {
$this->dbhost = Conn::$dbhost;
$this->dbuser = Conn::$dbuser;
$this->dbpass = Conn::$dbpass;
$this->dbname = Conn::$dbname;
}

public function openConnection() {
$this->conn = new mysqli($this->dbhost, $this->dbuser, $this->dbpass, $this->dbname);
if (mysqli_connect_errno())
echo new Exception("Could not establish connection with database");
}

public function getConnection() {
return $this->conn;
}

public function closeConnection() {
if ($this->conn != null)
$this->conn->close();
}

public function getUserDetails($email)
{
$returnValue = array();
$sql = "select * from users where user_email='" . $email . "'";

$result = $this->conn->query($sql);
if ($result != null && (mysqli_num_rows($result) >= 1)) {
$row = $result->fetch_array(MYSQLI_ASSOC);
if (!empty($row)) {
$returnValue = $row;
}
}
return $returnValue;
}

public function getUserDetailsWithPassword($email, $userPassword)
{
$returnValue = array();
$sql = "select user_email from users where user_email='" . $email . "' and user_password='" .$userPassword . "'";

$result = $this->conn->query($sql);
if ($result != null && (mysqli_num_rows($result) >= 1)) {
$row = $result->fetch_array(MYSQLI_ASSOC);
if (!empty($row)) {
$returnValue = $row;
}
}
return $returnValue;
}

public function registerUser($email, $password)
{
$sql = "INSERT INTO users SET user_email=?, user_password=?";
$statement = $this->conn->prepare($sql);

if (!$statement)
throw new Exception($statement->error);

$statement->bind_param("ss", $email, $password);
$returnValue = $statement->execute();

return $returnValue;
}

public function storeEmailToken($email, $email_token)
{
$sql = "UPDATE users SET email_token=? where user_email=?";
$statement = $this->conn->prepare($sql);

if (!$statement)
throw new Exception($statement->error);

$statement->bind_param("ss", $email_token, $email);
$returnValue = $statement->execute();

return $returnValue;
}

public function getEmailToken($email) {
$emailToken = '';
$sql = "SELECT email_token FROM users WHERE user_email=?";
$statement = $this->conn->prepare($sql);
#if (!$statement) throw new Exception($statement->error);
if (!$statement) return $emailToken;
$statement->bind_param("s", $email);
$returnValue = $statement->execute();
$statement->bind_result($emailToken);
While($statement->fetch()){
}
return $emailToken; 
}

public function emailMatchToken($email, $email_token) {
	$emailTokenFromDatabase = getEmailToken($email);
	if (strcmp($emailTokenFromDatabase, $email_token) == 0) {
		return true;
	}
	return false;
}


public function activateEmail($email, $email_token){
$ret = emailMatchToken($email,$email_token);
if($ret === true){
	$num = 1;	
	$sql = "UPDATE users SET isEmailConfirmed=? WHERE user_email=?";
	$statement = $this->conn->prepare($sql);

	if (!$statement)
	throw new Exception($statement->error);

	$statement->bind_param("is",$num, $email);
	$returnValue = $statement->execute();
	return '<h1>Account is activated!</h1>';
} else {
	return '<h1>Account activation failed!</h1><h1>Please send email to food@jogchat.com for help.</h1>';
}
}

}
?>
