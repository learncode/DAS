<?php
include_once '../Lib/DBWrapper.php';
include_once '../Lib/CustomErrorHandler.php';
include_once '../Core/ACMKnowledgeArea.php';

session_start();

if(isset($_SESSION["message"]))
{
	echo "<h3>".$_SESSION["message"]."</h3><br/>";
}

function insertArea(array $options)
{
	$instance = DBWrapper::getInstance();
	$area = new ACMKnowledgeArea($instance);
	
	if(!$area->selectAreaByCode($options[0]) && !$area->selectAreaByName($options[1]))
	{	
		$area->code = $options[0];
		$area->name = $options[1];
		$area->description = $options[2];
		$area->coreHours = $options[3];
		$area->state = true;
		return $area->insertArea();
	}
	else 
	{
		return 2;
	}
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
		$rowCount = insertArea($options);
		if($rowCount == 1)
		{
			$message .= "Knowledge Area inserted in the database.";
		}
		elseif($rowCount == 2)
		{
			$message .= "Knowledge Area already exists.";
		}
		else
		{
			$message .= "Knowledge Area could not be inserted.";
		}
	}
	else 
	{
		$message .= "To insert a Knowledge Area all fileds are required to be filled.";
	}
	$_SESSION["message"] = $message;
}
?>
<a href="KnowledgeArea.php">View all ACM Knowledge Areas</a>
<form action="<?php $_SERVER['PHP_SELF'];?>" method="post">
<fieldset>
    <legend>Add ACM Knowledge Area:</legend>
    <p>
      <b>Code:</b>
      <input type="text" name="code" size="30" maxlength="30" value="" id="code"/>
    </p>
    <p>
      <b>Name:</b>
      <input type="text" name="name" size="30" maxlength="80" value="" id="name"/>
    </p>
    <p>
      <b>Description:</b> 
      <textarea name="description" rows="3" cols="40" id="description"></textarea>
    </p>
    <p>
      <b>Core Hours:</b>
      <input type="text" name="hours" size="30" maxlength="5" value="" id="hours"/>
    </p>
    <p>
      <input type="submit" name="submit" value="submit" id="publish"/>
    </p>
</fieldset>
</form>