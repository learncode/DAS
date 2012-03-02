<?php
include_once '../Lib/DBWrapper.php';
include_once '../Core/ACMKnowledgeArea.php';
include_once '../Core/ACMKnowledgeUnit.php';
include_once '../Core/ACMLearningObjective.php';
include_once '../Core/Course.php';

class CourseLearningObjective
{
	private $table = 'courselearningobjective';
	private $dbi;
	public $courseId;
	public $courseName;
	public $objectiveDescription;
	public $objectiveId;
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
				//Once you get the course-objective list from the database,
				//now run through the individual courses and learning objectives 
				//to check if they are active.
				$course = new Course($this->dbi);
				$objective = new ACMLearningObjective($this->dbi); 
				//If they are active assign to the class variables 
				if($course->selectCourseById($courseArray[0]['courseId']) && $objective->selectObjectiveById($courseArray[0]['objectiveId']))
				{
					$this->courseId = $courseArray[0]['courseId'];
					$this->objectiveId = $courseArray[0]['objectiveId'];
					$this->courseName = $course->name;
					$this->objectiveName = $objective->description;
					$this->state = 1;
					$exists = true;
				}
				//else update the respective entry in the database as false.
				else 
				{
					$this->courseId = $courseArray[0]['courseId'];
					$this->objectiveId = $courseArray[0]['objectiveId'];
					$this->state = 0;
					$this->updateCourseObjective();
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
			$courseObjectives = array();
			$this->dbi->executeQuery($query);
			$courseArray = $this->dbi->loadList();
			if(count($courseArray) > 0)
			{
				//Once you get the course-unit list from the database,
				//now run through the individual courses and knowledge units 
				//to check if they are active.
				$course = new Course($this->dbi);
				$objective = new ACMLearningObjective($this->dbi); 
				
				foreach ($courseArray as $key=>$value)
				{
					if($course->selectCourseById($value['courseId']) && $objective->selectObjectiveById($value['objectiveId']))
					{
						$obj = new CourseLearningObjective($this->dbi);
						$obj->courseId = $value['courseId'];
						$obj->objectiveId = $value['objectiveId'];
						$obj->courseName = $course->name;
						$obj->objectiveDescription = $objective->description;
						$obj->state = 1;
						$courseObjectives[] = $obj;
					}
					else
					{
						$this->courseId = $value['courseId'];
						$obj->objectiveId = $value['objectiveId'];
						$this->state = 0;
						$this->updateCourseObjective();
					}
				}
			}
			return $courseObjectives;
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
	
	function selectCourseByObjective($objectiveId)
	{
		$query = "SELECT * FROM {$this->table} WHERE state = 1 AND objectiveId = {$objectiveId}";
		return $this->executeMultipleItemQuery($query);
	}
	
	function selectCourseByCourseIdAndObjectiveId($courseId, $objectiveId)
	{
		$query = "SELECT * FROM {$this->table} WHERE state = 1 AND courseId = {$courseId} AND objectiveId = {$objectiveId}";
		return $this->executeSingleItemQuery($query);
	}
	
	function insertCourseObjective()
	{
		$query = "INSERT INTO {$this->table} (courseId, objectiveId, state) VALUES ({$this->courseId}, {$this->objectiveId}, '{$this->state}')";
		$this->dbi->executeQuery($query);
	}
	
	function updateCourseObjective()
	{
		$query = "UPDATE {$this->table} SET state = '{$this->state}'
			WHERE courseId = {$this->courseId} AND objectiveId = {$this->objectiveId}";
		$this->dbi->executeQuery($query);
	}
	
	public function rowCount()
	{
		return $this->dbi->rowCount();
	}
}