<?php
include_once '../Lib/DBWrapper.php';
include_once '../Lib/CustomErrorHandler.php';
include_once '../Core/ACMKnowledgeArea.php';

for ($i = 0; $i < 5; ++$i) {
    if ($i == 2)
        continue
    print "$i\n";
}

$instance = DBWrapper::getInstance();

$area = new ACMKnowledgeArea($instance);
$areas = $area->selectAllAreas();
if(!is_null($areas))
{
	var_dump($areas);
	foreach ($areas as $key=>$column)
	{
		echo $column->name."<br/>";
	}
}
else 
{
	echo "Something wrong";
}

echo "<hr/>";

if(isset($instance))
{
	echo "Connection to the database established.<br/>";
	
	$instance->beginTransaction();
	$instance->setTransaction();
	if($instance->inTransaction())
	{
		echo "<b>Yes in transaction</b><br/>";
	}
	else 
	{
		echo "<b>Not in transaction</b><br/>";
	}
	$instance->executeQuery("DELETE FROM acmtopic");
	echo "Count of rows updated: ".$instance->rowCount()."<br/>";
	$instance->rollbackTransaction();
	$instance->setTransaction();
	
	if($instance->inTransaction())
	{
		echo "<b>Yes in transaction</b><br/>";
	}
	else 
	{
		echo "<b>Not in transaction</b><br/>";
	}
	
	$instance->executeQuery("SELECT * FROM acmtopic WHERE id=1");
	$array = $instance->loadList();
	var_dump($array);	
	echo $array[0]["description"];
}
else 
	throw DASException("Database Connection failed.");