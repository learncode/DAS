<?php
include_once 'KnowledgeUnitCRUD.php';

session_start();
$message = "";

function addKnowledgeUnit($unitArray)
{
	$rowCount = -1;
	$tempArray = getKnowledgeUnitByName($unitArray["name"]);
	if(empty($tempArray))
	{
		$rowCount = insertKnowledgeUnit($unitArray);
	}
	return $rowCount;
}

if(isset($_POST["submit"]))
{
	if(!empty($_POST["name"]) && !empty($_POST["knowledgeArea"]) && !empty($_POST["coverageHours"]) && !empty($_POST["core"]))
	{
		$unitArray["name"] = $_POST["name"];
		$unitArray["knowledgeAreaId"] = $_POST["knowledgeArea"];
		$unitArray["coverageHours"] = $_POST["coverageHours"];
		$isCore = $_POST["core"];
		$unitArray["isCore"] = ($isCore == "Yes") ? true : false;
		$unitArray["state"] = true;
		$count = addKnowledgeUnit($unitArray);
		if($count == -1)
		{
			$message .= 'Knowledge Unit <b>'.$unitArray["name"].'</b> exists.';
		}
		elseif($count == 0)
		{
			$message .= 'Knowledge Unit <b>'.$unitArray["name"].'</b> could not be entered.';
		}
		else 
		{
			$message .= 'Knowledge Unit <b>'.$unitArray["name"].'</b> entered.';
		}
	}
	else 
	{
		$message .= "All fields have to be entered.";
	}
	$_SESSION["message"] = $message;
	header("Location: KnowledgeUnit.php");
}
?>

<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
<fieldset id="" class="">
    <legend>ACM Knowledge Unit:</legend>
    <p>
	    <b>Knowledge Unit Name:</b>
	    <input type="text" name="name" size="30" maxlength="80" value="" id="name"/>
    </p>
    <p>
    	<b>Knowledge Area: </b>
    	<select name="knowledgeArea">
    	<?php 
    		$knowledgeArea = getAllKnowledgeAreas();
    		foreach($knowledgeArea as $key=>$value)
    		{
    	?>
    	<option value="<?php echo $value["id"];?>">
    	<?php echo $value["name"];?>
    	</option>
    	<?php 
    		}
    	?>
    	</select>
    </p>
    <p>
    	<b>Coverage Hours:</b>
    	<input type="text" name="coverageHours" size="30" maxlength="80" value="" id="coverageHours"/>
    </p>
    <p>
    	<b>Core:</b>
    	<input type="radio" name="core" value="Yes" checked="checked">Yes
    	<input type="radio" name="core" value="No">No
    </p>
    <p>
    	<input type="submit" name="submit" value="submit" id="publish"/>
    </p>
</fieldset>
</form>