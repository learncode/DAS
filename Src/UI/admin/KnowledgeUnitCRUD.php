<?php
include_once '../../Lib/DBWrapper.php';
include_once '../../Lib/CustomErrorHandler.php';
include_once '../../Core/ACMKnowledgeArea.php';
include_once '../../Core/ACMKnowledgeUnit.php';

include_once '../../UI/layouts/adminmenu.php';
include_once '../../UI/layouts/body.php';
include_once '../../UI/layouts/header.php';
include_once '../../UI/layouts/footer.php';
include_once '../../UI/layouts/HTMLHelper.php';


$instance = DBWrapper::getInstance();
$unit = new ACMKnowledgeUnit($instance);
$area = new ACMKnowledgeArea($instance);

function getAllKnowledgeUnits()
{
	global $unit;
	$unitArray = array();
	$unitObjects = $unit->selectAllUnits();
	if(!is_null($unitObjects))
	{
		foreach($unitObjects as $key => $value)
		{
			$tempArray = array();
			$tempArray["id"] = $value->id;
			$tempArray["name"] = $value->name;
			$tempArray["knowledgeAreaId"] = $value->knowledgeAreaId;
			$tempArray["knowledgeAreaName"] = $value->knowledgeAreaName;
			$tempArray["isCore"] = $value->isCore;
			$tempArray["coverageHours"] = $value->coverageHours;
			$tempArray["state"] = $value->state;
			array_push($unitArray, $tempArray);
		}
		unset($tempArray);
	}
	return $unitArray;
}

function getAllKnowledgeAreas()
{
	global $area;
	$areaArray = array();
	$areaObjects = $area->selectAllAreas();
	if(!empty($areaObjects))
	{
		foreach($areaObjects as $key=>$value)
		{
			$tempArray = array();
			$tempArray["id"] = $value->id;
			$tempArray["code"] = $value->code;
			$tempArray["name"] = $value->name;
			array_push($areaArray, $tempArray);
		}
	}
	return $areaArray;
}
function getKnowledgeUnitById($unitId)
{
	global $unit;
	$unitArray = array();
	if($unit->selectUnitById($unitId))
	{
		$unitArray["id"] = $unit->id;
		$unitArray["name"] = $unit->name;
		$unitArray["knowledgeAreaId"] = $unit->knowledgeAreaId;
		$unitArray["knowledgeAreaName"] = $unit->knowledgeAreaName;
		$unitArray["isCore"] = $unit->isCore;
		$unitArray["coverageHours"] = $unit->coverageHours;
		$unitArray["state"] = $unit->state;
	}
	return $unitArray;
}

function getKnowledgeUnitByName($unitName)
{
	global $unit;
	$unitArray = array();
	if($unit->selectUnitByName($unitName))
	{
		$unitArray["id"] = $unit->id;
		$unitArray["name"] = $unit->name;
		$unitArray["knowledgeAreaId"] = $unit->knowledgeAreaId;
		$unitArray["isCore"] = $unit->isCore;
		$unitArray["coverageHours"] = $unit->coverageHours;
		$unitArray["state"] = $unit->state;
	}
	return $unitArray;
}

function getKnowledgeUnitByArea($areaId)
{
	global $unit;
	$unitArray = array();
	$unitObjects = $unit->selectUnitByArea($areaId);
	if(!is_null($unitObjects))
	{
		foreach($unitObjects as $key => $value)
		{
			$tempArray = array();
			$tempArray["id"] = $value->id;
			$tempArray["name"] = $value->name;
			$tempArray["knowledgeAreaId"] = $value->knowledgeAreaId;
			$tempArray["knowledgeAreaName"] = $value->knowledgeAreaName;
			$tempArray["isCore"] = $value->isCore;
			$tempArray["coverageHours"] = $value->coverageHours;
			$tempArray["state"] = $value->state;
			array_push($unitArray, $tempArray);
		}
		unset($tempArray);
	}
	return $unitArray;
}

function insertKnowledgeUnit($unitArray)
{
	global $unit;
	$unit->name = $unitArray["name"];
	$unit->knowledgeAreaId = $unitArray["knowledgeAreaId"];
	$unit->isCore = ($unitArray["isCore"] == true) ? 1: 0;
	$unit->coverageHours = $unitArray["coverageHours"];
	$unit->state = ($unitArray["state"] == true) ? 1: 0;
	$unit->insertUnit();
	return $unit->rowCount();
}

function updateKnowledgeUnit($unitArray)
{
	global $unit;
	$unit->id = $unitArray["id"];
	$unit->name = $unitArray["name"];
	$unit->knowledgeAreaId = $unitArray["knowledgeAreaId"];
	$unit->isCore = ($unitArray["isCore"] == true) ? 1: 0;
	$unit->coverageHours = $unitArray["coverageHours"];
	$unit->state = ($unitArray["state"] == true) ? 1: 0;
	$unit->updateUnit();
	return $unit->rowCount();
}
