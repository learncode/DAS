<?php
include_once '../Lib/DBWrapper.php';
include_once '../Core/ACMKnowledgeArea.php';
include_once '../Core/ACMKnowledgeUnit.php';
include_once '../Core/Course.php';

class CourseKnowledgeUnit
{
	private $table = 'courseknowledgeunit';
	private $dbi;
	public $courseId;
	public $courseName;
	public $unitName;
	public $unitId;
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
				//Once you get the course-unit list from the database,
				//now run through the individual courses and knowledge units 
				//to check if they are active.
				$course = new Course($this->dbi);
				$unit = new ACMKnowledgeUnit($this->dbi);
				//If they are active assign to the class variables 
				if($course->selectCourseById($courseArray[0]['courseId']) && $unit->selectUnitById($courseArray[0]['unitId']))
				{
					$this->courseId = $courseArray[0]['courseId'];
					$this->unitId = $courseArray[0]['unitId'];
					$this->courseName = $course->name;
					$this->unitName = $unit->name;
					$this->state = 1;
					$exists = true;
				}
				//else update the respective entry in the database as false.
				else 
				{
					$this->courseId = $courseArray[0]['courseId'];
					$this->unitId = $courseArray[0]['unitId'];
					$this->state = 0;
					$this->updateCourseUnit();
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
			$courseUnits = array();
			$this->dbi->executeQuery($query);
			$courseArray = $this->dbi->loadList();
			if(count($courseArray) > 0)
			{
				//Once you get the course-unit list from the database,
				//now run through the individual courses and knowledge units 
				//to check if they are active.
				$course = new Course($this->dbi);
				$unit = new ACMKnowledgeUnit($this->dbi);
				
				foreach ($courseArray as $key=>$value)
				{
					if($course->selectCourseById($value['courseId']) && $unit->selectUnitById($value['unitId']))
					{
						$obj = new CourseKnowledgeUnit($this->dbi);
						$obj->courseId = $value['courseId'];
						$obj->unitId = $value['unitId'];
						$obj->courseName = $course->name;
						$obj->unitName = $unit->name;
						$obj->state = 1;
						$courseUnits[] = $obj;
					}
					else
					{
						$this->courseId = $value['courseId'];
						$this->unitId = $value['unitId'];
						$this->state = 0;
						$this->updateCourseUnit();
					}
				}
			}
			return $courseUnits;
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
	
	function selectCourseByUnit($unitId)
	{
		$query = "SELECT * FROM {$this->table} WHERE state = 1 AND unitId = {$unitId}";
		return $this->executeMultipleItemQuery($query);
	}
	
	function selectCourseByCourseIdAndUnitId($courseId, $unitId)
	{
		$query = "SELECT * FROM {$this->table} WHERE state = 1 AND courseId = {$courseId} AND unitId = {$unitId}";
		return $this->executeSingleItemQuery($query);
	}
	
	function insertCourseUnit()
	{
		$query = "INSERT INTO {$this->table} (courseId, unitId, state) VALUES ({$this->courseId}, {$this->unitId}, '{$this->state}')";
		$this->dbi->executeQuery($query);
	}
	
	function updateCourseUnit()
	{
		$query = "UPDATE {$this->table} SET state = '{$this->state}'
			WHERE courseId = {$this->courseId} AND unitId = {$this->unitId}";
		$this->dbi->executeQuery($query);
	}
}

/*
if(!$courseUnit->selectCourseByCourseIdAndUnitId(2,1))
{
$courseUnit->courseId = 2;
$courseUnit->unitId = 1;
$courseUnit->state = 1;
$courseUnit->insertCourseUnit();
}
//$courseArray = $courseUnit->selectCourseByCourseIdAndUnitId(2,2, $unitId);
$courseArray = $courseUnit->selectAllCourses();
var_dump($courseArray);
*/