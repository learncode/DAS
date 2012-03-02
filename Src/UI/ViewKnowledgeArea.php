<?php
session_start();

if(isset($_GET["id"]))
{
	if(is_numeric($_GET["id"]))
	{
		$id = $_GET["id"];
		if(isset($_SESSION["areas"]))
		{
			$areas = $_SESSION["areas"];
			if($id > 0 && $id <= count($areas))
			{
?>
<h3>View Knowledge Area</h3>
<b>Code:</b> <?php echo $areas[$id-1][1]; ?><br/>
<b>Name:</b> <?php echo $areas[$id-1][2]; ?><br/>
<b>Description:</b> <p><?php echo $areas[$id-1][3]; ?></p><br/>
<b>Total Hours:</b> <?php echo $areas[$id-1][4]; ?><br/>
<?php 
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
}
else 
{
	throwError();
}

function throwError()
{
	$message = "Please use the Knowledge Area Screen to select the option";
	$_SESSION["message"] = $message;
	header("Location: KnowledgeArea.php");
}