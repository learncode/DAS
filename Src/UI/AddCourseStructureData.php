<?php
include_once '../Core/CourseKnowledgeUnit.php';
include_once '../Core/CourseLearningObjective.php';
include_once '../Core/CourseTopic.php';

session_start();
//get the course Id and knowledge units
$courseId = $_SESSION['courseId'];
$unitArray = $_SESSION['unitArray'];
$data = $_POST['querystring'];

//the incoming string hs both objective and topic selections
//to break them I use strstr() function to get the first 
//occurance of 'topic' in the string and grab it, then use 
//strpos and substr to grab 'objectives' from the string
$topic = strstr($data,'topic');
$objective = strpos($data, 'topic');
$objective = substr($data, 0,$objective-1);

//After grabbing 'topics' and 'objectives' in a string now I push them in to an array
//to get the values.
$topic = str_ireplace('&', '', $topic);
$topic =  substr_replace($topic, '',0, strlen('topicArray%5B%5D='));
$topicArray = explode('topicArray%5B%5D=',$topic);

$objective = str_ireplace('&', '', $objective);
$objective =  substr_replace($objective, '',0, strlen('objectiveArray%5B%5D='));
$objectiveArray = explode('objectiveArray%5B%5D=',$objective);

//insert course-unit 
$instance = DBWrapper::getInstance();
$courseUnit = new CourseKnowledgeUnit($instance);
foreach ($unitArray as $key=>$value)
{
	if(!$courseUnit->selectCourseByCourseIdAndUnitId($courseId,$value))
	{
		$courseUnit->courseId = $courseId;
		$courseUnit->unitId = $value;
		$courseUnit->state = 1;
		$courseUnit->insertCourseUnit();
	}
	else 
	{
		echo 'Course: '.$courseId.' Unit: '.$value.'<br/>';
	}
}
//insert course-objective
$courseObjective = new CourseLearningObjective($instance);
foreach ($objectiveArray as $key=>$value) 
{
	if(!$courseObjective->selectCourseByCourseIdAndObjectiveId($courseId, $value))
	{
		$courseObjective->courseId = $courseId;
		$courseObjective->objectiveId = $value;
		$courseObjective->state = 1;
		$courseObjective->insertCourseObjective();
	}
	else 
	{
		echo 'Course: '.$courseId.' Objective: '.$value.'<br/>';
	}
}
//insert course-topic
echo '<hr/>';
echo 'Topics - Course<br/>';
$courseTopic = new CourseTopic($instance);
foreach ($topicArray as $key=>$value) 
{
	if(!$courseTopic->selectCourseByCourseIdAndTopicId($courseId, $value))
	{
		$courseTopic->courseId = $courseId;
		$courseTopic->topicId = $value;
		$courseTopic->state = 1;
		$courseTopic->insertCourseTopic();
	}
	else 
	{
		echo 'Course: '.$courseId.' Topic: '.$value.'<br/>';
	}
}