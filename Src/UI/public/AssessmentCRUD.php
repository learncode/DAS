<?php
include_once '../../Lib/DBWrapper.php';
include_once '../../Lib/CustomErrorHandler.php';
include_once '../../Core/Assessment.php';

$instance = DBWrapper::getInstance();
$assessment = new Assessment($instance);

function genericMethod($assessmentObject)
{
	$assessmentArray = array();
	
	if(count($assessmentObject) > 0)
	{
		foreach ($assessmentObject as $key => $value)
		{
			$tempArray = array();
			$tempArray['id'] = $value->id;
			$tempArray['name'] = $value->name;
			$tempArray['description'] = $value->description;
			$tempArray['assessmentTypeId'] = $value->assessmentTypeId;
			/*Hard code the assessmentTypeName*/
			switch ($tempArray['assessmentTypeId'])
			{
				case 1:
					$tempArray['assessmentTypeName'] = 'Assignment';
					break;
				case 2:
					$tempArray['assessmentTypeName'] = 'Mid Term';
					break;
				case 3:
					$tempArray['assessmentTypeName'] = 'Final';
					break;
			}
			$tempArray['date'] = $value->date;
			$tempArray['courseOfferingId'] = $value->courseOfferingId;
			$tempArray['creatorBannerId'] = $value->creatorBannerId;
			
			array_push($assessmentArray, $tempArray);
		}
	}
	return $assessmentArray;
}

function getAllAssessmentsByCourseOffering($courseOfferingId)
{
	global $assessment;
	$assessmentObject = $assessment->selectAssessmentByCourseOfferingId($courseOfferingId);
	$assessmentArray = genericMethod($assessmentObject);
	return $assessmentArray;
}

function getAllAssessments()
{
	global $assessment;
	$assessmentObject = $assessment->selectAllAssessments();
	$assessmentArray = genericMethod($assessmentObject);
	return $assessmentArray;
}

function getAssessmentById($assessmentId)
{
	global $assessment;
	$assessmentArray = array();
	if($assessment->selectAssessmentById($assessmentId))
	{
		$assessmentArray['id'] = $assessment->id;
		$assessmentArray['name'] = $assessment->name;
		$assessmentArray['description'] = $assessment->description;
		$assessmentArray['assessmentTypeId'] = $assessment->assessmentTypeId;
		/*Hard code the assessmentTypeName*/
		switch ($assessmentArray['assessmentTypeId'])
		{
			case 1:
				$assessmentArray['assessmentTypeName'] = 'Assignment';
				break;
			case 2:
				$assessmentArray['assessmentTypeName'] = 'Mid Term';
				break;
			case 3:
				$assessmentArray['assessmentTypeName'] = 'Final';
				break;
		}
		$assessmentArray['date'] = $assessment->date;
		$assessmentArray['courseOfferingId'] = $assessment->courseOfferingId;
		$assessmentArray['creatorBannerId'] = $assessment->creatorBannerId;
	}
	return $assessmentArray;
}

function insertAssessment($assessmentArray)
{
	global $assessment;
	$assessment->name = $assessmentArray['name'];
	$assessment->description = $assessmentArray['description'];
	$assessment->assessmentTypeId = $assessmentArray['assessmentTypeId'];
	$assessment->date = $assessmentArray['date'];
	$assessment->courseOfferingId = $assessmentArray['courseOfferingId'];
	$assessment->creatorBannerId = $assessmentArray['creatorBannerId'];
	return $assessment->insertAssessment();	
}

function updateAssessment($assessmentArray)
{
	global $assessment;
	$assessment->id = $assessmentArray['id'];
	$assessment->name = $assessmentArray['name'];
	$assessment->description = $assessmentArray['description'];
	$assessment->assessmentTypeId = $assessmentArray['assessmentTypeId'];
	$assessment->date = $assessmentArray['date'];
	$assessment->courseOfferingId = $assessmentArray['courseOfferingId'];
	$assessment->creatorBannerId = $assessmentArray['creatorBannerId'];
	return $assessment->updateAssessment();	
}