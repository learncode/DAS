<?php
include_once 'TopicCRUD.php';

session_start();
$message = "";

function addTopic($topicArray)
{
	$rowCount = -1;
	$tempArray = getTopicByDescription($topicArray["description"]);
	if(empty($tempArray))
	{
		$rowCount = insertTopic($topicArray);
	}
	return $rowCount;
}

if(isset($_POST["submit"]))
{
	if(!empty($_POST["description"]) && !empty($_POST["knowledgeUnit"]) && !empty($_POST["ACMTopic"]))
	{
		$topicArray["description"] = $_POST["description"];
		$topicArray["knowledgeUnitId"] = $_POST["knowledgeUnit"];
		$isCore = $_POST["ACMTopic"];
		$topicArray["isACMTopic"] = ($isCore == "Yes") ? true : false;
		$topicArray["state"] = true;
		$count = addTopic($topicArray);
		if($count == -1)
		{
			$message .= 'Topic <b>'.$topicArray["description"].'</b> exists.';
		}
		elseif($count == 0)
		{
			$message .= 'Topic <b>'.$topicArray["description"].'</b> could not be entered.';
		}
		else 
		{
			$message .= 'Topic <b>'.$topicArray["description"].'</b> entered.';
		}
	}
	else 
	{
		$message .= "All fields have to be entered.";
	}
	$_SESSION["message"] = $message;
	header("Location: Topic.php");
}
?>
<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
<fieldset id="" class="">
    <legend>ACM Topic:</legend>
    <p>
	    <b>Topic Description:</b>
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
    	<b>ACM Topic:</b>
    	<input type="radio" name="ACMTopic" value="Yes" checked="checked">Yes
    	<input type="radio" name="ACMTopic" value="No">No
    </p>
    <p>
    	<input type="submit" name="submit" value="submit" id="publish"/>
    </p>
</fieldset>
</form>