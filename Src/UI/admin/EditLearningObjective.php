<?php
include_once 'LearningObjectiveCRUD.php';
echo beginHtml("ACM Learning Objective");
echo headerbar();
echo adminmenu();
echo acmcolumn();
echo startcolumn2();
session_start();
$message = "";

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
    	$dropdown .= '<option value=\"\" disabled=\"disabled\">No Knowledge Units Available</option>'."\n";
    }
    $dropdown .= '</select>'."\n";
    return $dropdown;
}

function throwError()
{
	$message = "Please use the Learning Objective Screen to select the option";
	$_SESSION["message"] = $message;
	header("Location: LearningObjective.php");
}

function editLearningObjective($objectiveArray)
{
	$rowCount = -1;
	$rowCount = updateLearningObjective($objectiveArray);
	return $rowCount;
}

if(isset($_GET["id"]))
{
	if(is_numeric($_GET["id"]))
	{
		$objectiveId = $_GET["id"];
		$objectiveArray = getLearningObjectiveById($objectiveId);		
		if(!empty($objectiveArray))
		{
?>
<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
<fieldset id="" class="">
    <legend>ACM Learning Objective:</legend>
    <input type="hidden" name="id" value="<?php echo $objectiveId;?>" />
    <p>
	    <b>Learning Objective Description:</b>
	    <textarea name="description" rows="3" cols="40" id="description"><?php echo $objectiveArray["description"];?></textarea>
    </p>
    <p>
    	<b>Knowledge Unit: </b>
    	
    	<?php 
    		$knowledgeUnit = getAllKnowledgeUnits();
    		echo dropdown("knowledgeUnit", $knowledgeUnit, $objectiveArray["knowledgeUnitId"] );
    	?>
    	
    </p>
    <p>
    	<b>ACM Objective:</b>
    	<?php 
    		if($objectiveArray["isACMObjective"] == 1)
    		{
    	?>
    	<input type="radio" name="ACMObjective" value="Yes" checked="checked">Yes
    	<input type="radio" name="ACMObjective" value="No">No
    	<?php 
    		}
    		else 
    		{
    	?>
    	<input type="radio" name="ACMObjective" value="Yes">Yes
    	<input type="radio" name="ACMObjective" value="No" checked="checked">No
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
	if(!empty($_POST["description"]) && !empty($_POST["knowledgeUnit"]) && !empty($_POST["ACMObjective"]))
	{
		$objectiveArray["id"] = $_POST["id"];
		$objectiveArray["description"] = $_POST["description"];
		$objectiveArray["knowledgeUnitId"] = $_POST["knowledgeUnit"];
		$isCore = $_POST["ACMObjective"];
		$objectiveArray["isACMObjective"] = ($isCore == "Yes") ? true : false;
		$objectiveArray["state"] = true;
		$count = editLearningObjective($objectiveArray);
		if($count == 0)
		{
			$message .= 'Learning Objective <b>'.$objectiveArray["description"].'</b> could not be entered.';
		}
		else 
		{
			$message .= 'Learning Objective <b>'.$objectiveArray["description"].'</b> entered.';
		}
	}
	else 
	{
		$message .= "All fields have to be entered.";
	}
	$_SESSION["message"] = $message;
	header("Location: LearningObjective.php");
}
echo endcolumn2();
echo footer();
echo endHtml();
?>