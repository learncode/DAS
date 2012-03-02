<?php
include_once '../../Lib/DBWrapper.php';
include_once '../../Lib/CustomErrorHandler.php';
include_once '../../Core/ACMKnowledgeArea.php';

session_start();

function throwError()
{
	$message = "Please use the Knowledge Area Screen to select the option";
	$_SESSION["message"] = $message;
}

if(isset($_GET["id"]))
{
	if(is_numeric($_GET["id"]))
	{
		$message = "";
		$id = $_GET["id"];
		$instance = DBWrapper::getInstance();
		$area = new ACMKnowledgeArea($instance);
		if($area->selectAreaById($id))
		{
			$area->state = false;
			$rowCount = $area->updateArea();
			
			if($rowCount == 1)
			{
				$message .= "Knowledge Area deleted.";
			}
			else
			{
				$message .= "Knowledge Area could not deleted.";
			}
		}
		else
		{
			throwError();
		}
	}
	else
	{
		throwError();
	}
}
else 
{
	throwError();
}

header("Location: KnowledgeArea.php");