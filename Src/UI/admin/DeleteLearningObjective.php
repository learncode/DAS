<?php
include_once 'LearningObjectiveCRUD.php';

$message = "";
session_start();
if(isset($_GET["id"]))
{
	if(is_numeric($_GET["id"]) )
	{
		$objectiveId = $_GET["id"];
		$objectiveArray = getLearningObjectiveById($objectiveId);
		if(!empty($objectiveArray))
		{
			$objectiveArray["state"] = false;
			$count = updateLearningObjective($objectiveArray);
			if($count == -1)
			{
				$message .= 'Learning Objective <b>'.$objectiveArray["description"].'</b> doesn\'t exist to delete.';
			}
			elseif($count == 0)
			{
				$message .= 'Learning Objective <b>'.$objectiveArray["description"].'</b> could not be deleted.';
			}
			else 
			{
				$message .= 'Learning Objective <b>'.$objectiveArray["description"].'</b> deleted.';
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
header("Location: LearningObjective.php");