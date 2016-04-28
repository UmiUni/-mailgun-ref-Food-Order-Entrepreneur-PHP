<?php
require("Conn.php");
require("MySQLDao.php");
$dao = new MySQLDao();
$dao->openConnection();
$email_token = htmlentities($_GET["token"]);
$email = htmlentities($_GET["email"]);

if (empty($email_token)) {
echo "<h1>Missing email token</h1>";
return;
}

if (empty($email)) {
echo "<h1>Missing email!</h1>";
return;
}

if($dao->emailMatchToken($email, $email_token)){
echo '
<html>
<head>
</head>
<body>
<h1>Change Password</h1>

<form method="post" action="/Food-Order-Entrepreneur-PHP/user-register/resetPasswordStep3.php">

<label for="email">Email: '.$email.'</label>
<input type="hidden" id="email" name="email" title="Email" value="'.$email.'" />
</br>

<label for="newPassword">New&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Password:</label> 
<input type="password" id="newPassword" name="newPassword" title="New password" />
</br>

<label for="confirmPassword">Retype Password:</label> 
<input type="password" id="confirmPassword" name="confirmPassword" title="Confirm new password" />
</br>

<input type="hidden" id="token" name="token" title="Password Token" value="'.$email_token.'"/>

<p class="form-actions">
<input type="submit" value="Change Password" title="Change password" />
</p>

</form>
</body>
</html>
';
} else {
 echo "<h1>Invalid Password Reset Link!</h1>";
}
$dao->closeConnection();
?>
