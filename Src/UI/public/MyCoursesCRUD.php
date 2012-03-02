<?php
include_once '../../Lib/DBWrapper.php';
include_once '../../Lib/CustomErrorHandler.php';
include_once '../../Core/CourseOffering.php';
include_once '../../Core/CourseOfferingFaculty.php';
include_once '../../Core/Course.php';
include_once '../../Core/User.php';

$instance = DBWrapper::getInstance();
$courseOffering = new CourseOffering($instance);
$courseOfferingFaculty = new CourseOfferingFaculty($instance);
$course = new Course($instance);

function getCourseById($courseId)
{
	global $course;
	$courseArray = array();
	if($course->selectCourseById($courseId))
	{
		$courseArray["id"] = $course->id;
		$courseArray["name"] = $course->name;
		$courseArray["number"] = $course->number;
		$courseArray["description"] = $course->description;
		$courseArray["creditHours"] = $course->creditHours;
		$courseArray["state"] = $course->state;
	}
	return $courseArray;
}

function getCoursesByUserId($userId)
{
	global $courseOfferingFaculty;
	$courseOfferingFacultyObjects = $courseOfferingFaculty->selectCourseOfferingIdByUserId($userId);
	$courseOfferingFacultyArray = array();
	if(count($courseOfferingFacultyObjects) > 0)
	{
		foreach($courseOfferingFacultyObjects as $key => $value)
		{
			$tempArray = array();
			$tempArray['courseOfferingId'] = $value->courseOfferingId;
			$tempArray['userId'] = $value->userId;
			$tempArray['state'] = $value->state;
			array_push($courseOfferingFacultyArray, $value);
		}
	}
	return $courseOfferingFacultyArray;
}

function getCourseOfferingIdDetails($id, $semester, $year)
{
	global $courseOffering;
	$tempArray = array();
	if($courseOffering->selectCourseOfferingByIdBySemesterByYear($id, $semester, $year))
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
