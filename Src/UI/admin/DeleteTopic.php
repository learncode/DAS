<?php
include_once 'TopicCRUD.php';

$message = "";
session_start();
if(isset($_GET["id"]))
{
	if(is_numeric($_GET["id"]) )
	{
		$topicId = $_GET["id"];
		$topicArray = getTopicById($topicId);
		if(!empty($topicArray))
		{
			$topicArray["state"] = false;
			$count = updateTopic($topicArray);
			if($count == -1)
			{
				$message .= 'Learning Objective <b>'.$topicArray["description"].'</b> doesn\'t exist to delete.';
			}
			elseif($count == 0)
			{
				$message .= 'Learning Objective <b>'.$topicArray["description"].'</b> could not be deleted.';
			}
			else 
			{
				$message .= 'Learning Objective <b>'.$topicArray["description"].'</b> deleted.';
			}
		}
		else 
		{
			$message .= "Use the Learning Objective screen to perform operations";
		}
	}
	else 
	{
		$message .= "Use the Learning Objective screen to perform operations";
	}
}
$_SESSION["message"] = $message;
header("Location: Topic.php");