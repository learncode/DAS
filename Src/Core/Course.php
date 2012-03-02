<?php
include_once '../Lib/DBWrapper.php';

class Course
{
	public $id;
	public $number;
	public $name;
	public $description;
	public $creditHours;
	public $state;
	private $dbi = null;
	private $table = 'course';
	
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
	
	private function executeSingleItemSelectQuery($query)
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
				$this->id = $courseArray[0]["id"];
				$this->name = $courseArray[0]["name"];
				$this->number = $courseArray[0]["number"];
				$this->description = $courseArray[0]["description"];
				$this->creditHours = $courseArray[0]["creditHours"];
				$this->state = $courseArray[0]["state"];
				
				$exists = true;
			}
			return $exists;
		}
		catch(DASException $ex)
		{
			echo $ex->getCustomError();
		}
	}
	
	private function executeMultipleItemSelectQuery($query)
	{
		try
		{
			if(!$this->checkDBI())
				throw new DASException("Database reference not instantiated");
			$courses = null;
			$this->dbi->executeQuery($query);
			$courseArray = $this->dbi->loadList();
			if(count($courseArray) > 0)
			{
				foreach ($courseArray as $key=>$value)
				{
					$obj = new Course($this->dbi);
					$obj->id = $value["id"];
					$obj->name = $value["name"];
					$obj->number = $value["number"];
					$obj->description = $value["description"];
					$obj->creditHours = $value["creditHours"];
					$obj->state = $value["state"];
					$courses[] = $obj;
				}
			}
			return $courses;
		}
		catch(DASException $ex)
		{
			echo $ex->getCustomError();
		}
	}
	
	public function selectCourseById($id) 
	{
		$query = "SELECT * FROM {$this->table} WHERE id = {$id} AND state = 1"; 		
		return $this->executeSingleItemSelectQuery($query);
	}
	
	public function selectCourseByNumber($number) 
	{
		$query = "SELECT * FROM {$this->table} WHERE state = 1 and number = '{$number}'";		
		return $this->executeSingleItemSelectQuery($query);
	}
	
	public function selectCourseByName($name) 
	{
		$query = "SELECT * FROM {$this->table} WHERE state = 1 and name like '{$name}'";
		return $this->executeSingleItemSelectQuery($query);
	}
	
	public function selectAllCourses() 
	{
		$query = "SELECT * FROM {$this->table} WHERE state = 1"; 
		return $this->executeMultipleItemSelectQuery($query);
	}
	
	public function insertCourse() 
	{
		try
		{
			if(!$this->checkDBI())
				throw new DASException("Database reference not instantiated");
			$query = "INSERT INTO {$this->table} (number, name, description, creditHours, state) VALUES (";
			$query .= "'{$this->number}', '{$this->name}', '{$this->description}', $this->creditHours, '{$this->state}' ";
			$query .= ")";
			$this->dbi->executeQuery($query);
		}
		catch(DASException $ex)
		{
			echo $ex->getCustomError();
		}
	}
	
	public function updateCourse() 
	{
		try
		{
			if(!$this->checkDBI())
				throw new DASException("Database reference not instantiated");
			$query = "UPDATE {$this->table} SET ";
			$query .= " number = '{$this->number}', name = '{$this->name}', description = '{$this->description}', 
				creditHours = $this->creditHours, state = '{$this->state}'  WHERE id = {$this->id}";
			$this->dbi->executeQuery($query);
		}
		catch(DASException $ex)
		{
			echo $ex->getCustomError();
		}
	}
	
	public function rowCount()
	{
		return $this->dbi->rowCount();
	}
}