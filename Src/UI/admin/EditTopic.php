<?php
include_once 'TopicCRUD.php';
echo beginHtml("ACM Topic");
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
	$message = "Please use the Topic Screen to select the option";
	$_SESSION["message"] = $message;
	header("Location: Topic.php");
}

function editTopic($topicArray)
{
	$rowCount = -1;
	$rowCount = updateTopic($topicArray);
	return $rowCount;
}

if(isset($_GET["id"]))
{
	if(is_numeric($_GET["id"]))
	{
		$topicId = $_GET["id"];
		$topicArray = getTopicById($topicId);		
		if(!empty($topicArray))
		{
?>
<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
<fieldset id="" class="">
    <legend>ACM Topic:</legend>
    <input type="hidden" name="id" value="<?php echo $topicId;?>" />
    <p>
	    <b>Topic Description:</b>
	    <textarea name="description" rows="3" cols="40" id="description"><?php echo $topicArray["description"];?></textarea>
    </p>
    <p>
    	<b>Knowledge Unit: </b>
    	
    	<?php 
    		$knowledgeUnit = getAllKnowledgeUnits();
    		echo dropdown("knowledgeUnit", $knowledgeUnit, $topicArray["knowledgeUnitId"] );
    	?>
    	
    </p>
    <p>
    	<b>ACM topic:</b>
    	<?php 
    		if($topicArray["isACMTopic"] == 1)
    		{
    	?>
    	<input type="radio" name="ACMTopic" value="Yes" checked="checked">Yes
    	<input type="radio" name="ACMTopic" value="No">No
    	<?php 
    		}
    		else 
    		{
    	?>
    	<input type="radio" name="ACMTopic" value="Yes">Yes
    	<input type="radio" name="ACMTopic" value="No" checked="checked">No
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
	if(!empty($_POST["description"]) && !empty($_POST["knowledgeUnit"]) && !empty($_POST["ACMTopic"]))
	{
		$topicArray["id"] = $_POST["id"];
		$topicArray["description"] = $_POST["description"];
		$topicArray["knowledgeUnitId"] = $_POST["knowledgeUnit"];
		$isCore = $_POST["ACMTopic"];
		$topicArray["isACMTopic"] = ($isCore == "Yes") ? true : false;
		$topicArray["state"] = true;
		$count = editTopic($topicArray);
		if($count == 0)
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
echo endcolumn2();
echo footer();
echo endHtml();
?>