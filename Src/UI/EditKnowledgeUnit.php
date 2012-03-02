<?php
include_once 'KnowledgeUnitCRUD.php';

session_start();
$message = "";

function editKnowledgeUnit($unitArray)
{
	$rowCount = -1;
	$tempArray = getKnowledgeUnitByName($unitArray["name"]);
	if(!empty($tempArray))
	{
		$rowCount = updateKnowledgeUnit($unitArray);
	}
	return $rowCount;
}

function throwError()
{
	$message = "Please use the Knowledge Unit Screen to select the option";
	$_SESSION["message"] = $message;
	header("Location: KnowledgeUnit.php");
}

function dropdown( $name, array $options, $selected=null )
{
    $dropdown = '<select name="'.$name.'" id="'.$name.'">'."\n";
    $selected = $selected;
    if(!empty($options))
    {
	    foreach( $options as $key=>$value )
	    {
	    	$select = $selected==$value["id"] ? ' selected' : null;
	        $dropdown .= '<option value="'.$value["id"].'"'.$select.'>'.$value["name"].'</option>'."\n";
	    }
    }
    else 
    {
    	$dropdown .= '<option value=\"\" disabled=\"disabled\">No Knowledge Areas Available</option>'."\n";
    }
    $dropdown .= '</select>'."\n";
    return $dropdown;
}

if(isset($_GET["id"]))
{
	if(is_numeric($_GET["id"]) )
	{
		$unitId = $_GET["id"];
		$unitArray = getKnowledgeUnitById($unitId);		
		if(!empty($unitArray))
		{
?>
<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
<fieldset id="" class="">
    <legend>ACM Knowledge Unit:</legend>
    <p>
	    <b>Knowledge Unit Name:</b>
	    <input type="hidden" name="id" value="<?php echo $unitId;?>" />
	    <input type="text" name="name" size="30" maxlength="80" readonly="readonly" value="<?php echo $unitArray["name"];?>" id="name"/>
    </p>
    <p>
    	<b>Knowledge Area: </b>
    	<?php 
    		$knowledgeArea = getAllKnowledgeAreas();
    		echo dropdown('knowledgeArea', $knowledgeArea, $unitArray["knowledgeAreaId"]);
    	?>
    </p>
    <p>
    	<b>Coverage Hours:</b>
    	<input type="text" name="coverageHours" size="30" maxlength="80" value="<?php echo $unitArray["coverageHours"];?>" id="coverageHours"/>
    </p>
    <p>
    	<b>Core:</b>
    	<?php 
    		if($unitArray["isCore"] == 1)
    		{
    	?>
    	<input type="radio" name="core" value="Yes" checked="checked">Yes
    	<input type="radio" name="core" value="No">No
    	<?php 
    		}
    		else 
    		{
    	?>
    	<input type="radio" name="core" value="Yes">Yes
    	<input type="radio" name="core" value="No" checked="checked">No
    	<?php 
    		}
    	?>
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


if(isset($_POST["submit"]))
{
	if(!empty($_POST["name"]) && !empty($_POST["knowledgeArea"]) && !empty($_POST["coverageHours"]) && !empty($_POST["core"]))
	{
		$unitArray["id"] = $_POST["id"];
		$unitArray["name"] = $_POST["name"];
		$unitArray["knowledgeAreaId"] = $_POST["knowledgeArea"];
		$unitArray["coverageHours"] = $_POST["coverageHours"];
		$isCore = $_POST["core"];
		$unitArray["isCore"] = ($isCore == "Yes") ? true : false;
		$unitArray["state"] = true;
		$count = editKnowledgeUnit($unitArray);
		if($count == -1)
		{
			$message .= 'Knowledge Unit <b>'.$unitArray["name"].'</b> doesn\'t exist to update.';
		}
		elseif($count == 0)
		{
			$message .= 'Knowledge Unit <b>'.$unitArray["name"].'</b> could not be updated.';
		}
		else 
		{
			$message .= 'Knowledge Unit <b>'.$unitArray["name"].'</b> updated.';
		}
	}
	else 
	{
		$message .= "All fields have to be entered.";
	}
	$_SESSION["message"] = $message;
	header("Location: KnowledgeUnit.php");
}