<?php
require("Conn.php");
eequire("MySQLDao.php");
$dao = new MySQLDao();
$dao->openConnection();
$email_token = htmlentities($_GET["token"]);
$email = htmlentities($_GET["email"]);

if (empty($email_token)) {
echo "Missing required parameter";
return;
}

if($dao->emailMatchToken($email, $email_token)){
echo '
<html>
<head>
</head>
<body>
<h1>Change Password</h1>

<form method="post" action="">

<label for="email">Email:</label>
<input type="text" id="email" name="email" title="Email" value="'.$email.'" readonly/>

<label for="newPassword">New Password:</label> 
<input type="password" id="newPassword" name="newPassword" title="New password" />

<label for="confirmPassword">Confirm Password:</label> 
<input type="password" id="confirmPassword" name="confirmPassword" title="Confirm new password" />

<input type="hidden" id="token" name="token" title="Password Token" value="'.$email_token.'"/>

<p class="form-actions">
<input type="submit" value="Change Password" title="Change password" />
</p>

</form>
</body>
</html>
';
} else {
 echo "<h1>Invalid Link!</h1>";
}
$dao->closeConnection();
?>
