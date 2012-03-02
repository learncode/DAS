<?php
include_once 'LearningObjectiveCRUD.php';
echo beginHtml("ACM Learning Objective");
echo headerbar();
echo adminmenu();
echo acmcolumn();
echo startcolumn2();
session_start();
$message = "";

function addLearningObjective($objectiveArray)
{
	$rowCount = -1;
	$tempArray = getLearningObjectiveByDescription($objectiveArray["description"]);
	if(empty($tempArray))
	{
		$rowCount = insertLearningObjective($objectiveArray);
	}
	return $rowCount;
}

if(isset($_POST["submit"]))
{
	if(!empty($_POST["description"]) && !empty($_POST["knowledgeUnit"]) && !empty($_POST["ACMObjective"]))
	{
		$objectiveArray["description"] = $_POST["description"];
		$objectiveArray["knowledgeUnitId"] = $_POST["knowledgeUnit"];
		$isCore = $_POST["ACMObjective"];
		$objectiveArray["isACMObjective"] = ($isCore == "Yes") ? true : false;
		$objectiveArray["state"] = true;
		$count = addLearningObjective($objectiveArray);
		if($count == -1)
		{
			$message .= 'Learning Objective <b>'.$objectiveArray["description"].'</b> exists.';
		}
		elseif($count == 0)
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
?>
<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
<fieldset id="" class="">
    <legend>ACM Learning Objective:</legend>
    <p>
	    <b>Learning Objective Description:</b>
	    <textarea name="description" rows="3" cols="40" id="description"></textarea>
    </p>
    <p>
    	<b>Knowledge Unit: </b>
    	<select name="knowledgeUnit">
    	<?php 
    		$knowledgeUnit = getAllKnowledgeUnits();
    		foreach($knowledgeUnit as $key=>$value)
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
    	<b>ACM Objective:</b>
    	<input type="radio" name="ACMObjective" value="Yes" checked="checked">Yes
    	<input type="radio" name="ACMObjective" value="No">No
    </p>
    <p>
    	<input type="submit" name="submit" value="submit" id="publish"/>
    </p>
</fieldset>
</form>
<?php 
echo endcolumn2();
echo footer();
echo endHtml();
?>