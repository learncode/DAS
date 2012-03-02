<?php
include_once 'KnowledgeUnitCRUD.php';

session_start();

$objData = $_POST['querystring'];
$str = str_ireplace('&', '', $objData);

$str =  substr_replace($str, '',0, 6);
$areasArray = explode('areas=',$str);
$unitArray = array();

$_SESSION['areaArray'] = $areasArray;
$count = 0;

foreach($areasArray as $key=>$value)
{
	$tempArray = getKnowledgeUnitByArea($value);
	$unitArray[$count] = $tempArray;
	$count++;
}

$checkbox = "";

foreach ($unitArray as $key=>$value)
{
	foreach ($value as $row=>$column)
	{
		$checkbox .= "<input type ='checkbox' name = unitArray[] value = '{$column["id"]}'>".$column["name"]."<br/>";
	}
}
if(!empty($checkbox))
{
	$checkbox .= '<input type="button" name="submitUnit" value="Select Units" onclick="getObjectives();" />';
}

echo $checkbox;