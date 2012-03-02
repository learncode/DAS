<?php
include_once '../Lib/DBWrapper.php';
include_once '../Lib/CustomErrorHandler.php';
include_once '../Core/ACMKnowledgeArea.php';

session_start();
function throwError()
{
	$message = "Please use the Knowledge Area Screen to select the option";
	$_SESSION["message"] = $message;
	header("Location: KnowledgeArea.php");
}

if(isset($_GET["id"]))
{
	if(is_numeric($_GET["id"]))
	{
		$id = $_GET["id"];
		if(isset($_SESSION["areas"]))
		{
			$areas = $_SESSION["areas"];
			if($id > 0 && $id < count($areas))
			{
?>
<a href="KnowledgeArea.php">View all ACM Knowledge Areas</a>
<form action="<?php $_SERVER['PHP_SELF'];?>" method="post">
<fieldset>
    <legend>Add ACM Knowledge Area:</legend>
    <p>
      <b>Code:</b>
      <input type="text" name="code" size="30" maxlength="30" readonly="readonly" value="<?php echo $areas[$id-1][1];?>" id="code"/>
    </p>
    <p>
      <b>Name:</b>
      <input type="text" name="name" size="30" maxlength="80" value="<?php echo $areas[$id-1][2];?>" id="name"/>
    </p>
    <p>
      <b>Description:</b> 
      <textarea name="description" rows="3" cols="40" id="description"><?php echo $areas[$id-1][3];?></textarea>
    </p>
    <p>
      <b>Core Hours:</b>
      <input type="text" name="hours" size="30" maxlength="5" value="<?php echo $areas[$id-1][4];?>" id="hours"/>
    </p>
    <p>
      <input type="submit" name="submit" value="submit" id="publish"/>
    </p>
</fieldset>
</form>
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

if(isset($_POST["submit"]))
{
	$message = "";
	if(!empty($_POST["code"]) && !empty($_POST["name"]) && !empty($_POST["description"]) && !empty($_POST["hours"]))
	{
		$options[0] = $_POST["code"];
		$options[1] = $_POST["name"];
		$options[2] = $_POST["description"];
		$options[3] = $_POST["hours"];
		echo "Before calling update <br/>";
		$rowCount = updateArea($options);
		if($rowCount == 1)
		{
			$message .= "Knowledge Area updated in the database.";
		}
		elseif($rowCount == 2)
		{
			$message .= "Knowledge Area content not changed.";
		}
		
		else
		{
			$message .= "Knowledge Area could not updated.";
		}
	}
	else 
	{
		$message .= "To update a Knowledge Area all fileds are required to be filled.";
	}
	
	$_SESSION["message"] = $message;
	echo $_SESSION["message"];
	header("Location: KnowledgeArea.php");	
}

function updateArea(array $options)
{
	$instance = DBWrapper::getInstance();
	$area = new ACMKnowledgeArea($instance);
	
	if($area->selectAreaByCode($options[0]))
	{
		$area->code = $options[0];
		$area->name = $options[1];
		$area->description = $options[2];
		$area->coreHours = $options[3];
		$area->state = true;
		return $area->updateArea();
	}
	else 
	{
		return 2;
	}
}