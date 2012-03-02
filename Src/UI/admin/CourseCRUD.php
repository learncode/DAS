<?php
include_once '../../Lib/DBWrapper.php';
include_once '../../Lib/CustomErrorHandler.php';
include_once '../../Lib/DBWrapper.php';
include_once '../../Core/Course.php';

$instance = DBWrapper::getInstance();
$course = new Course($instance);

function getAllCourses()
{
	global $course;
	return $course->selectAllCourses();
}

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

function getCourseByName($courseName)
{
	global $course;
	$courseArray = array();
	if($course->selectCourseByName($courseName))
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

function AddCourse($courseArray)
{
	global $course;
	$courseName = $courseArray["name"];
	$tempArray = getCourseByName($courseName);
	$rowCount = -1;
	if(empty($tempArray))
	{
		$course->name = $courseArray["name"];
		$course->number = $courseArray["number"];
		$course->description = $courseArray["description"];
		$course->creditHours = $courseArray["creditHours"];
		$course->state = $courseArray["state"];
		$course->insertCourse();
		$rowCount = $course->rowCount();
	}
	
	return $rowCount;
}

function EditCourse($courseArray)
{
	global $course;
	$courseName = $courseArray["name"];
	$tempArray = getCourseByName($courseName);
	$rowCount = -1;
	if(!empty($tempArray))
	{
		$course->id = $courseArray["id"];
		$course->name = $courseArray["name"];
		$course->number = $courseArray["number"];
		$course->description = $courseArray["description"];
		$course->creditHours = $courseArray["creditHours"];
		$course->state = $courseArray["state"];
		$course->updateCourse();
		$rowCount = $course->rowCount();
	}
	
	return $rowCount;
}