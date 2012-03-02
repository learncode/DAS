<?php
include_once 'CourseOfferingCRUD.php';
$id = $_GET['id'];

$courseOfferingArray = getCourseOfferingById($id);
if(!empty($courseOfferingArray))
{
	$courseOfferingArray['state'] = 0;
	updateCourseOffering($courseOfferingArray);
	updateCourseOfferingFaculty($id);
}
header("Location: ViewCourseOffering.php");