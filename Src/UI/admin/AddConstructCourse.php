<?php
session_start();
if(isset($_POST['name']))
{
	$_SESSION['courseId'] = $_POST['name'];
}