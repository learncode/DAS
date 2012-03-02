<?php
include_once '../../Lib/DBWrapper.php';
include_once '../../Lib/CustomErrorHandler.php';
include_once '../../Core/CourseOffering.php';
include_once '../../Core/CourseOfferingFaculty.php';
include_once '../../Core/User.php';

$instance = DBWrapper::getInstance();
$courseOffering = new CourseOffering($instance);
$courseOfferingFaculty = new CourseOfferingFaculty($instance);
$user = new user($instance);

function getInstructors()
{
	global $user;
	$instructors = $user->getUserByType(2);
	return $instructors;
}

function insertCourseOfferingFaculty($userId, $courseOfferingId)
{
	global $courseOfferingFaculty;
	$courseOfferingFaculty->userId = $userId;
	$courseOfferingFaculty->courseOfferingId = $courseOfferingId;
	$courseOfferingFaculty->state = 1;
	return $courseOfferingFaculty->insertCourseOfferingFaculty();
}

function getCourseOfferings($courseOfferingObjectArray)
{
	$courseOfferingArray = array();
	if(!empty($courseOfferingObjectArray))
	{
		foreach ($courseOfferingObjectArray as $key=>$value)
		{
			$tempArray = array();
			$tempArray["id"] = $value->id;
			$tempArray["courseId"] = $value->courseId;
			$tempArray["semester"] = $value->semester;
			$tempArray["year"] = $value->year;
			$tempArray["prerequisite"] = $value->prerequisite;
			$tempArray["state"] = $value->state;
			array_push($courseOfferingArray, $tempArray);
		}
	}
	return $courseOfferingArray;
}

function getCourseOfferingById($id)
{
	global $courseOffering;
	$tempArray = array();
	if($courseOffering->selectCourseOfferingById($id))
	{
		$tempArray["id"] = $courseOffering->id;
		$tempArray["courseId"] = $courseOffering->courseId;
		$tempArray["semester"] = $courseOffering->semester;
		$tempArray["year"] = $courseOffering->year;
		$tempArray["prerequisite"] = $courseOffering->prerequisite;
		$tempArray["state"] = $courseOffering->state;
	}
	return $tempArray;
}

function getCourseOfferingId($courseId, $semester, $year)
{
	global $courseOffering;
	$id = 0;
	$courseOffering->courseId = $courseId;
	$courseOffering->semester = $semester;
	$courseOffering->year = $year;
	if($courseOffering->courseExists())
	{
		$id = $courseOffering->id;
	}
	return $id;
}

function getAllCourseOfferings()
{
	global $courseOffering;
	$courseOfferingObjectArray = $courseOffering->selectAllCourseOfferings();
	$courseOfferingArray = getCourseOfferings($courseOfferingObjectArray);
	return $courseOfferingArray;
}

function getCourseOfferingByYear($year)
{
	global $courseOffering;
	$courseOfferingObjectArray = $courseOffering->selectCourseOfferingByYear($year);
	$courseOfferingArray = getCourseOfferings($courseOfferingObjectArray);
	return $courseOfferingArray;
}

function getCourseOfferingBySemester($semester)
{
	global $courseOffering;
	$courseOfferingObjectArray = $courseOffering->selectCourseOfferingBySemester($semester);
	$courseOfferingArray = getCourseOfferings($courseOfferingObjectArray);
	return $courseOfferingArray;
}

function getCourseOfferingBySemesterByYear($semester,$year)
{
	global $courseOffering;
	$courseOfferingObjectArray = $courseOffering->selectCourseOfferingBySemesterByYear($semester, $year);
	$courseOfferingArray = getCourseOfferings($courseOfferingObjectArray);
	return $courseOfferingArray;
}

function insertCourseOffering($value)
{
	global $courseOffering;
	//$courseOffering->id = $value["id"];
	$courseOffering->courseId = $value["courseId"];
	$courseOffering->semester = $value["semester"];
	$courseOffering->year = $value["year"];
	$courseOffering->prerequisite = $value["prerequisite"];
	$courseOffering->state = $value["state"];
	
	return $courseOffering->insertCourseOffering();
}

function updateCourseOffering($value)
{
	global $courseOffering;
	$courseOffering->id = $value["id"];
	$courseOffering->courseId = $value["courseId"];
	$courseOffering->semester = $value["semester"];
	$courseOffering->year = $value["year"];
	$courseOffering->prerequisite = $value["prerequisite"];
	$courseOffering->state = $value["state"];
	
	return $courseOffering->updateCourseOffering();
}

function updateCourseOfferingFaculty($courseOfferingId)
{
	global $courseOfferingFaculty;
	if($courseOfferingFaculty->selectUserIdByCourseOfferingId($courseOfferingId))
	{
		$courseOfferingFaculty->state = 0;
		$courseOfferingFaculty->updateCourseOfferingFaculty();
	}
}