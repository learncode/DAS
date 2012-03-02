<?php
include_once 'LearningObjectiveCRUD.php';
include_once 'TopicCRUD.php';
session_start();

$str = $_REQUEST['obj'];
$str = str_ireplace('&', '', $str);

//use 16 here because i want to remove the occurance of 'unitArray%5B%5D=' whose
//length is 16.
$str =  substr_replace($str, '',0, 16);
$unitArray = explode('unitArray%5B%5D=',$str);

//Store the knowledge units in sessions
$_SESSION['unitArray'] = $unitArray;

//Store the learning objectives and topics of the knowledge unit into the array.
$objectiveArray = array();
$topicArray = array();

$count = 0;
foreach($unitArray as $key=>$value)
{
	$tempArray = getLearningObjectivesByUnit($value);
	$objectiveArray[$count] = $tempArray;
	
	$tempArray = getTopicsByUnit($value);
	$topicArray[$count] = $tempArray;
	$count++;
}

//populate learning objectives into the construct course screen
$checkbox = "";
foreach ($objectiveArray as $key=>$value)
{
	foreach ($value as $row=>$column)
	{
		$checkbox .= "<input type ='checkbox' name = objectiveArray[] value = '{$column["id"]}'>".$column["description"]."<br/>";
	}
}

//populate topics into the construct course screen
$checkbox1 = '';
foreach ($topicArray as $key=>$value)
{
	foreach($value as $row=>$column)
	{
		$checkbox1 .= "<input type ='checkbox' name = topicArray[] value = '{$column["id"]}'>".$column["description"]."<br/>";
	}
}

if(!empty($checkbox1) && !empty($checkbox))
{
	$checkbox1 .= '<input type="button" name="detail" value="Submit Details" onclick="putDetails();" />';
}

$checkbox = "Select Learning Objectives: <br/>".$checkbox;
$checkbox1 = "Select Topics: <br/>".$checkbox1;

echo $checkbox."<br/>".$checkbox1;