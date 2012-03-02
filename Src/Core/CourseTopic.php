<?php
include_once '../Lib/DBWrapper.php';
include_once '../Core/ACMKnowledgeArea.php';
include_once '../Core/ACMKnowledgeUnit.php';
include_once '../Core/ACMTopic.php';
include_once '../Core/Course.php';

class CourseTopic
{
	private $table = 'coursetopic';
	private $dbi;
	public $courseId;
	public $courseName;
	public $topicDescription;
	public $topicId;
	public $state;
	
	function __construct()
	{
		$num_args = func_num_args();
		if($num_args == 1)
		{
			$this->dbi = func_get_arg(0);
		}
	}
	
	public function checkDBI()
	{
		return $this->dbi instanceof DBWrapper;
	}
	
	private function executeSingleItemQuery($query)
	{
		try 
		{
			if(!$this->checkDBI())
				throw new DASException("Database reference not instantiated");
			$exists = false;
			$this->dbi->executeQuery($query);
			$courseArray = $this->dbi->loadList();
			if(count($courseArray) > 0)
			{
				//Once you get the course-topic list from the database,
				//now run through the individual courses and topics 
				//to check if they are active.
				$course = new Course($this->dbi);
				$topic = new ACMTopic($this->dbi); 
				//If they are active assign to the class variables 
				if($course->selectCourseById($courseArray[0]['courseId']) && $topic->selectTopicById($courseArray[0]['topicId']))
				{
					$this->courseId = $courseArray[0]['courseId'];
					$this->topicId = $courseArray[0]['topicId'];
					$this->courseName = $course->name;
					$this->topicName = $topic->description;
					$this->state = 1;
					$exists = true;
				}
				//else update the respective entry in the database as false.
				else 
				{
					$this->courseId = $courseArray[0]['courseId'];
					$this->topicId = $courseArray[0]['topicId'];
					$this->state = 0;
					$this->updateCourseTopic();
				}
			}
			return $exists;
		}
		catch(DASException $ex)
		{
			echo $ex->getCustomError();
		}
	}
	
	private function executeMultipleItemQuery($query)
	{
		try 
		{
			if(!$this->checkDBI())
				throw new DASException("Database reference not instantiated");
			$courseTopics = array();
			$this->dbi->executeQuery($query);
			$courseArray = $this->dbi->loadList();
			if(count($courseArray) > 0)
			{
				//Once you get the course-topic list from the database,
				//now run through the individual courses and topics
				//to check if they are active.
				$course = new Course($this->dbi);
				$topic = new ACMTopic($this->dbi); 
				
				foreach ($courseArray as $key=>$value)
				{
					if($course->selectCourseById($value['courseId']) && $topic->selectTopicById($value['topicId']))
					{
						$obj = new CourseTopic($this->dbi);
						$obj->courseId = $value['courseId'];
						$obj->topicId = $value['topicId'];
						$obj->courseName = $course->name;
						$obj->topicDescription = $topic->description;
						$obj->state = 1;
						$courseTopics[] = $obj;
					}
					else
					{
						$this->courseId = $value['courseId'];
						$obj->topicId = $value['topicId'];
						$this->state = 0;
						$this->updateCourseTopic();
					}
				}
			}
			return $courseTopics;
		}
		catch(DASException $ex)
		{
			echo $ex->getCustomError();
		}
	}
	
	function selectAllCourses()
	{
		$query = "SELECT * FROM {$this->table} WHERE state = 1";
		return $this->executeMultipleItemQuery($query);
	}
	
	function selectCourseById($courseId)
	{
		$query = "SELECT * FROM {$this->table} WHERE state = 1 AND courseId = {$courseId}";
		return $this->executeMultipleItemQuery($query);
	}
	
	function selectCourseByTopic($topicId)
	{
		$query = "SELECT * FROM {$this->table} WHERE state = 1 AND topicId = {$topicId}";
		return $this->executeMultipleItemQuery($query);
	}
	
	function selectCourseByCourseIdAndTopicId($courseId, $topicId)
	{
		$query = "SELECT * FROM {$this->table} WHERE state = 1 AND courseId = {$courseId} AND topicId = {$topicId}";
		return $this->executeSingleItemQuery($query);
	}
	
	function insertCourseTopic()
	{
		$query = "INSERT INTO {$this->table} (courseId, topicId, state) VALUES ({$this->courseId}, {$this->topicId}, '{$this->state}')";
		$this->dbi->executeQuery($query);
	}
	
	function updateCourseTopic()
	{
		$query = "UPDATE {$this->table} SET state = '{$this->state}'
			WHERE courseId = {$this->courseId} AND topicId = {$this->topicId}";
		$this->dbi->executeQuery($query);
	}
	
	public function rowCount()
	{
		return $this->dbi->rowCount();
	}
}