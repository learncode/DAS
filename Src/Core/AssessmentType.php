<?php
class AssessmentType
{
	public $id;
	public $name;
	public $state;
	private $table = 'assessmentType';
	private $dbi = null;
	
	function __construct()
	{
		$num_args = func_num_args();
		if($num_args == 1)
		{
			$this->dbi = func_get_arg(0);
		}	
	}
	
	function checkDBI()
	{
		return $this->dbi instanceof DBWrapper;
	}
	
	function selectAllAssessmentTypes()
	{
		$query = 'SELECT * FROM {$this->table} WHERE state = 1';
		try 
		{
			if(!$this->checkDBI())
				throw new DASException("Database reference not instantiated");
			$exists = false;
			$this->dbi->executeQuery($query);
			$assessmentTypeArray = $this->dbi->loadList();
			if(count($assessmentTypeArray) > 0)
			{
				$this->id = $assessmentTypeArray[0]['id'];
				$this->name = $assessmentTypeArray[0]['name'];
				$this->state = $assessmentTypeArray[0]['state'];
				$exists = true;
			}
			return  $exists;
		}
		catch(DASException $ex)
		{
			echo $ex->getCustomError();
		}
	}
	
	function selectAssessmentTypeById($id)
	{
		$query = "SELECT * FROM {$this->table} WHERE state = 1 and id = {$id}";
		try 
		{
			if(!$this->checkDBI())
				throw new DASException("Database reference not instantiated");
			$this->dbi->executeQuery($query);
			$assessmentTypeArray = $this->dbi->loadList();
			$assessmentTypes = array();
			if(count($assessmentTypeArray) > 0)
			{
				foreach($assessmentTypeArray as $key => $value)
				{
					$obj = new AssessmentType($this->dbi);
					$obj->id = $value['id'];
					$obj->name = $value['name'];
					$obj->state = $value['state'];
					
					$assessmentTypes[] = $obj;
				}
			}
			return  $assessmentTypes;
		}
		catch(DASException $ex)
		{
			echo $ex->getCustomError();
		}
	}
	
	function insertAssementType()
	{
		$query = "INSERT INTO {$this->table} (id, name, state) VALUES ($this->id,'$this->name', '$this->state')";
		$this->dbi->executeQuery($query);
	}
	
	function updateAssessmentType()
	{
		$query = "UPDATE {$this->table} SET name = '{$this->name}' AND state = '{$this->state}' WHERE id = {$this->id}";
		$this->dbi->executeQuery($query);
	}
}