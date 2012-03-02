<?php
include_once 'KnowledgeUnitCRUD.php';

$message = "";
session_start();
if(isset($_GET["id"]))
{
	if(is_numeric($_GET["id"]) )
	{
		$unitId = $_GET["id"];
		$unitArray = getKnowledgeUnitById($unitId);
		if(!empty($unitArray))
		{
			$unitArray["state"] = false;
			$count = updateKnowledgeUnit($unitArray);
			if($count == -1)
			{
				$message .= 'Knowledge Unit <b>'.$unitArray["name"].'</b> doesn\'t exist to delete.';
			}
			elseif($count == 0)
			{
				$message .= 'Knowledge Unit <b>'.$unitArray["name"].'</b> could not be deleted.';
			}
			else 
			{
				$message .= 'Knowledge Unit <b>'.$unitArray["name"].'</b> deleted.';
			}
		}
		else 
		{
			$message .= "Use the Knowledge Unit screen to perform operations";
		}
	}
	else 
	{
		$message .= "Use the Knowledge Unit screen to perform operations";
	}
}
$_SESSION["message"] = $message;
header("Location: KnowledgeUnit.php");