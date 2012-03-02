<?php
include_once '../../Lib/DBWrapper.php';
include_once '../../Lib/CustomErrorHandler.php';
include_once '../../Core/ACMKnowledgeArea.php';
include_once '../../Core/ACMKnowledgeUnit.php';
include_once '../../Core/ACMLearningObjective.php';
include_once 'KnowledgeUnitCRUD.php';



$instance = DBWrapper::getInstance();
$objective = new ACMLearningObjective($instance);

function getAllLearningObjectives()
{
	global $objective;
	$objectiveArray = array();
	$objectiveObjects = $objective->selectAllObjectives();
	if(!is_null($objectiveObjects))
	{
		foreach($objectiveObjects as $key=>$value)
		{
			$tempArray = array();
			$tempArray["id"] = $value->id;
			$tempArray["knowledgeUnitId"] = $value->knowledgeUnitId;
			$tempArray["knowledgeUnitName"] = $value->knowledgeUnitName;
			$tempArray["description"] = $value->description;
			$tempArray["isACMObjective"] = $value->isACMObjective;
			$tempArray["state"] = $value->state;
			array_push($objectiveArray, $tempArray);
		}
	}
	return $objectiveArray;
}

function getLearningObjectiveById($id)
{
	global $objective;
	$objectiveArray = array();
	if($objective->selectObjectiveById($id))
	{
		$objectiveArray["id"] = $objective->id;
		$objectiveArray["knowledgeUnitId"] = $objective->knowledgeUnitId;
		$objectiveArray["knowledgeUnitName"] = $objective->knowledgeUnitName;
		$objectiveArray["description"] = $objective->description;
		$objectiveArray["isACMObjective"] = $objective->isACMObjective;	
	}
	return $objectiveArray;
}

function getLearningObjectiveByDescription($description)
{
	global $objective;
	$objectiveArray = array();
	if($objective->selectObjectiveByDescription($description))
	{
		$objectiveArray["id"] = $objective->id;
		$objectiveArray["knowledgeUnitId"] = $objective->knowledgeUnitId;
		$objectiveArray["knowledgeUnitName"] = $objective->knowledgeUnitName;
		$objectiveArray["description"] = $objective->description;
		$objectiveArray["isACMObjective"] = $objective->isACMObjective;	
	}
	return $objectiveArray;
}

function getLearningObjectivesByUnit($unitId)
{
	global $objective;
	global $objective;
	$objectiveArray = array();
	$objectiveObjects = $objective->selectObjectiveByUnit($unitId);
	if(!is_null($objectiveObjects))
	{
		foreach($objectiveObjects as $key=>$value)
		{
			$tempArray = array();
			$tempArray["id"] = $value->id;
			$tempArray["knowledgeUnitId"] = $value->knowledgeUnitId;
			$tempArray["knowledgeUnitName"] = $value->knowledgeUnitName;
			$tempArray["description"] = $value->description;
			$tempArray["isACMObjective"] = $value->isACMObjective;
			$tempArray["state"] = $value->state;
			array_push($objectiveArray, $tempArray);
		}
	}
	return $objectiveArray;
}

function insertLearningObjective($objectiveArray)
{
	global $objective;
	$objective->knowledgeUnitId = $objectiveArray["knowledgeUnitId"];
	$objective->description = $objectiveArray["description"];
	$objective->isACMObjective = ($objectiveArray["isACMObjective"] == true) ? 1 : 0;
	$objective->state = ($objectiveArray["state"] == true) ? 1 : 0;
	$objective->insertObjective();
	return $objective->rowCount();
}

function updateLearningObjective($objectiveArray)
{
	global $objective;
	$objective->id = $objectiveArray["id"];
	$objective->knowledgeUnitId = $objectiveArray["knowledgeUnitId"];
	$objective->description = $objectiveArray["description"];
	$objective->isACMObjective = $objectiveArray["isACMObjective"];
	$objective->state = ($objectiveArray["state"] == true) ? 1 : 0;
	$objective->updateObjective();
	return $objective->rowCount();
}