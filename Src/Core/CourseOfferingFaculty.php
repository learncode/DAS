<?php
class CourseOfferingFaculty
{
	public $courseOfferingId;
	public $userId;
	public $state;
	
	private $table = 'courseofferingfaculty';
	private $dbi;
	
	public function __construct()
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
	
	public function selectUserIdByCourseOfferingId($courseOfferingId)
	{
		$query = "SELECT * FROM {$this->table} WHERE state = 1 AND courseOfferingId = {$courseOfferingId}";
		$exists = false;
		$this->dbi->executeQuery($query);
		$courseOfferingArray = $this->dbi->loadList();
		if(count($courseOfferingArray) == 1)
		{
			$this->courseOfferingId = $courseOfferingArray[0]['courseOfferingId'];
			$this->userId = $courseOfferingArray[0]['userId'];
			$this->state = 1;
			
			$exists = true;
		}
		return $exists;
	}
	
	private function selectUserIdAndCourseOfferingId($courseOfferingId, $userId)
	{
		$query = "SELECT * FROM {$this->table} WHERE state = 1 AND courseOfferingId = {$courseOfferingId} AND userId = {$userId}";
		$exists = false;
		$this->dbi->executeQuery($query);
		$courseOfferingArray = $this->dbi->loadList();
		if(count($courseOfferingArray) == 1)
		{
			$this->courseOfferingId = $courseOfferingArray[0]['courseOfferingId'];
			$this->userId = $courseOfferingArray[0]['userId'];
			$this->state = 1;
			
			$exists = true;
		}
		return $exists;
	}
	
	public function selectCourseOfferingIdByUserId($userId)
	{
		$query = "SELECT * FROM {$this->table} WHERE state = 1 AND userId = {$userId}";
		$courseOfferingFaculty = array();
		$this->dbi->executeQuery($query);
		$courseOfferingArray = $this->dbi->loadList();
		if(count($courseOfferingArray) > 0)
		{
			foreach ($courseOfferingArray as $key => $value)
			{
				$obj = new CourseOfferingFaculty($this->dbi);
				$obj->courseOfferingId = $value['courseOfferingId'];
				$obj->userId = $value['userId'];
				$obj->state = 1;
				
				$courseOfferingFaculty[] = $obj;
			}
		}
		return $courseOfferingFaculty;
	}
	
	public function insertCourseOfferingFaculty()
	{
		if(!$this->selectUserIdAndCourseOfferingId($this->courseOfferingId, $this->userId))
		{
			$query = "INSERT INTO {$this->table} (courseOfferingId, userId, state) VALUES ";
			$query .= "($this->courseOfferingId, $this->userId, '$this->state')";
			$this->dbi->executeQuery($query);
			if($this->rowCount() == 1)
			{
				return 1;
			}
			return 0;
		}
		return -1;
	}
	
	public function updateCourseOfferingFaculty()
	{
		$query = "UPDATE {$this->table} SET courseOfferingId = $this->courseOfferingId, 
				userId = $this->userId, state = '$this->state' WHERE 
					courseOfferingId = $this->courseOfferingId AND userId = $this->userId";
		$this->dbi->executeQuery($query);
		return $this->rowCount();
	}
	
	private function rowCount()
	{
		return $this->dbi->rowCount();
	}
}