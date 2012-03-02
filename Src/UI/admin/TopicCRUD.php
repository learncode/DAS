<?php
include_once '../../Lib/DBWrapper.php';
include_once '../../Lib/CustomErrorHandler.php';
include_once '../../Core/ACMKnowledgeArea.php';
include_once '../../Core/ACMKnowledgeUnit.php';
include_once '../../Core/ACMTopic.php';
include_once 'KnowledgeUnitCRUD.php';


$instance = DBWrapper::getInstance();
$topic = new ACMTopic($instance);

function getAllTopics()
{
	global $topic;
	$topicArray = array();
	$topicObjects = $topic->selectAllTopics();
	if(!is_null($topicObjects))
	{
		foreach($topicObjects as $key=>$value)
		{
			$tempArray = array();
			$tempArray["id"] = $value->id;
			$tempArray["knowledgeUnitId"] = $value->knowledgeUnitId;
			$tempArray["knowledgeUnitName"] = $value->knowledgeUnitName;
			$tempArray["description"] = $value->description;
			$tempArray["isACMTopic"] = $value->isACMTopic;
			$tempArray["state"] = $value->state;
			array_push($topicArray, $tempArray);
		}
	}
	return $topicArray;
}

function getTopicById($id)
{
	global $topic;
	$topicArray = array();
	if($topic->selectTopicById($id))
	{
		$topicArray["id"] = $topic->id;
		$topicArray["knowledgeUnitId"] = $topic->knowledgeUnitId;
		$topicArray["knowledgeUnitName"] = $topic->knowledgeUnitName;
		$topicArray["description"] = $topic->description;
		$topicArray["isACMTopic"] = $topic->isACMTopic;	
	}
	return $topicArray;
}

function getTopicByDescription($description)
{
	global $topic;
	$topicArray = array();
	if($topic->selectTopicByDescription($description))
	{
		$topicArray["id"] = $topic->id;
		$topicArray["knowledgeUnitId"] = $topic->knowledgeUnitId;
		$topicArray["knowledgeUnitName"] = $topic->knowledgeUnitName;
		$topicArray["description"] = $topic->description;
		$topicArray["isACMTopic"] = $topic->isACMTopic;	
	}
	return $topicArray;
}

function getTopicsByUnit($unitId)
{
	global $topic;
	$topicArray = array();
	$topicObjects = $topic->selectTopicByUnit($unitId);
	if(!is_null($topicObjects))
	{
		foreach($topicObjects as $key=>$value)
		{
			$tempArray = array();
			$tempArray["id"] = $value->id;
			$tempArray["knowledgeUnitId"] = $value->knowledgeUnitId;
			$tempArray["knowledgeUnitName"] = $value->knowledgeUnitName;
			$tempArray["description"] = $value->description;
			$tempArray["isACMTopic"] = $value->isACMTopic;
			$tempArray["state"] = $value->state;
			array_push($topicArray, $tempArray);
		}
	}
	return $topicArray;
}

function insertTopic($topicArray)
{
	global $topic;
	$topic->knowledgeUnitId = $topicArray["knowledgeUnitId"];
	$topic->description = $topicArray["description"];
	$topic->isACMTopic = ($topicArray["isACMTopic"] == true) ? 1 : 0;
	$topic->state = ($topicArray["state"] == true) ? 1 : 0;
	$topic->insertTopic();
	return $topic->rowCount();
}

function updateTopic($topicArray)
{
	global $topic;
	$topic->id = $topicArray["id"];
	$topic->knowledgeUnitId = $topicArray["knowledgeUnitId"];
	$topic->description = $topicArray["description"];
	$topic->isACMTopic = ($topicArray["isACMTopic"] == true) ? 1 : 0;
	$topic->state = ($topicArray["state"] == true) ? 1 : 0;
	$topic->updateTopic();
	return $topic->rowCount();
}