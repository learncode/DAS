<?php
include_once '../../Lib/DBWrapper.php';
include_once '../../Core/User.php';


$instance = DBWrapper::getInstance();
$user = new user($instance);

function validateUser($id, $password)
{
	global $user;
	if($user->login($id, $password))
	{
		if($_SESSION['userTypeId'] == 1)
		{
			header("Location: ../../UI/admin/ViewKnowledgeArea.php");
		}
		else 
		{
			header("Location: ../../UI/public/MyCourses.php");
		}
	}
	else 
	{
		$_SESSION['message'] = 'Invalid login credentials';
	}
}