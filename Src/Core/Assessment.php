<?php

class Assessment
{
	public $id;
	public $name;
	public $description;
	public $assessmentTypeId;
	public $date;
	public $courseOfferingId;
	public $creatorBannerId;
	public $state;
	
	private $table = 'assessment';
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
	
	private function executeSingleItemSelect($query)
	{
		try
		{
			if(!$this->checkDBI())
				throw new DASException("Database reference not instantiated");
			$exists = false;
			$this->dbi->executeQuery($query);
			$assessmentArray = $this->dbi->loadList();
			if(count($assessmentArray) > 0)
			{
				$this->id = $assessmentArray[0]['id'];
				$this->name = $assessmentArray[0]['name'];
				$this->description = $assessmentArray[0]['description'];
				$this->assessmentTypeId = $assessmentArray[0]['assessmentTypeId'];
				$this->date = $assessmentArray[0]['date'];
				$this->courseOfferingId = $assessmentArray[0]['courseOfferingId'];
				$this->creatorBannerId = $assessmentArray[0]['creatorBannerId'];
				$this->state = $assessmentArray[0]['state'];
				
				$exists = true;
			}
			return $exists;
		}
		catch (DASException $ex)
		{
			echo $ex->getCustomError();
		}
	}
	
	private function executeMultipleItemSelect($query)
	{
		try
		{
			if(!$this->checkDBI())
				throw new DASException("Database reference not instantiated");
			$assessments = null;
			$this->dbi->executeQuery($query);
			$assessmentArray = $this->dbi->loadList();
			if(count($assessmentArray) > 0)
			{
				foreach ($assessmentArray as $key => $value) 
				{
					$obj = new Assessment($this->dbi);
					$obj->id = $value['id'];
					$obj->name = $value['name'];
					$obj->description = $value['description'];
					$obj->assessmentTypeId = $value['assessmentTypeId'];
					$obj->date = $value['date'];
					$obj->courseOfferingId = $value['courseOfferingId'];
					$obj->creatorBannerId = $value['creatorBannerId'];
					$obj->state = $value['state'];
					
					$assessments[] = $obj;
				}				
			}
			return $assessments;
		}
		catch (DASException $ex)
		{
			echo $ex->getCustomError();
		}
	}
	
	function selectAllAssessments()
	{
		$query = "SELECT * FROM {$this->table} WHERE state = 1";
		try
		{
			return $this->executeMultipleItemSelect($query);
		}
		catch (DASException $ex)
		{
			echo $ex->getCustomError();
		}
	}
	
	function selectAssessmentByCourseOfferingId($courseOfferingId)
	{
		$query = "SELECT * FROM {$this->table} WHERE courseOfferingId = {$courseOfferingId} AND state = 1";
		try
		{
			return $this->executeMultipleItemSelect($query);
		}
		catch (DASException $ex)
		{
			echo $ex->getCustomError();
		}
	}
	
	function selectAssessmentById($id)
	{
		$query = "SELECT * FROM {$this->table} WHERE id = {$id} AND state = 1";
		try
		{
			return $this->executeSingleItemSelect($query);
		}
		catch (DASException $ex)
		{
			echo $ex->getCustomError();
		}
	}
	
	function selectAssessmentByAssessmentType($assessmentTypeId)
	{
		$query = "SELECT * FROM {$this->table} WHERE assessmentTypeId = {$assessmentTypeId} AND state = 1";
		try
		{
			return $this->executeMultipleItemSelect($query);
		}
		catch (DASException $ex)
		{
			echo $ex->getCustomError();
		}
	}
	
	function insertAssessment()
	{
		try
		{
			$query = "INSERT INTO {$this->table} ";
			$query .= "(assessmentTypeId, name, description, date, courseOfferingId, creatorBannerId) VALUES ";
			$query .= "({$this->assessmentTypeId}, '{$this->name}', '{$this->description}', '$this->date',
					$this->courseOfferingId, $this->creatorBannerId)";
			$this->dbi->executeQuery($query);
			return $this->rowCount();
		}
		catch (DASException $ex)
		{
			echo $ex->getCustomError();
		}
	}
	
	function updateAssessment()
	{
		try
		{
			$query = "UPDATE {$this->table} SET ";
			$query .= " assessmentTypeId = {$this->assessmentTypeId}, ";
			$query .= " name = '{$this->name}', ";
			$query .= " description = '{$this->description}', ";
			$query .= " date = '{$this->date}', ";
			$query .= " courseOfferingId = {$this->courseOfferingId}, ";
			$query .= " creatorBannerId = {$this->creatorBannerId} WHERE id = {$this->id}";
			
			$this->dbi->executeQuery($query);
			return $this->rowCount();
		}
		catch (DASException $ex)
		{
			echo $ex->getCustomError();
		}
	}
	
	private function rowCount()
	{
		return $this->dbi->rowCount();
	}
}
