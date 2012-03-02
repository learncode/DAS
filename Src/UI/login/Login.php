<?php
include_once 'UserCRUD.php';

if(isset($_POST['submit']))
{
	
	$id = $_POST['userid'];
	$password = $_POST["password"];
	if(!empty($id) && !empty($password))
	{
		validateUser($id, $password);
	}
	else 
	{
		$_SESSION['message'] = 'Please enter the valid credentials to login';
	}
}

if(isset($_SESSION['message']))
{
	echo $_SESSION['message'];
}

?>
<html>
<head>

</head>
<body>
<form name="login" method="post" id="login" enctype="application/x-www-form-urlencoded" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
<div><label for="userid">Username</label>
<input name="userid" id="userid" size="10" type="text"></div>
<div><label for="password">Password</label>
<input name="password" id="password" type="password"></div>
<input name="action" id="action" value="login" type="hidden">
<div>
<input name="submit" id="submit" value="Login" type="submit"></div>
</form>
</body>
</html>