<?php
/*
 * This class is very important in setting up the knowledge units required for the ACM Data entry.
 */
include_once('../Lib/DBWrapper.php');

class ACMKnowledgeUnit
{
	private $dbi = null;
	private $table = "acmknowledgeunit";
	public $id;
	public $name;
	public $knowledgeAreaId;
	public $knowledgeAreaName;
	public $coverageHours;
	public $isCore;
	public $state;
	
	public function __construct()
	{
		$num_args = func_num_args();
		if($num_args == 1)
		{
			$this->dbi = func_get_arg(0);
		}		
	}
	
	private function checkDBI()
	{
		return $this->dbi instanceof DBWrapper;
	}
	
	private function getParent($id)
	{
		try 
		{
			$exists = false;
			$area = new ACMKnowledgeArea($this->dbi);
			if($area->selectAreaById($id))
			{
				$this->knowledgeAreaName = $area->name;
				$this->knowledgeAreaId = $area->id;
				return $exists = true;
			}
			unset($area);
			return $exists;
		}
		catch(DASException $ex)
		{
			$ex->getCustomError();
		}
	}	
	
	private function executeSingleItemSelectQuery($query)
	{
		$this->dbi->executeQuery($query);
		$areaArray = $this->dbi->loadList();
		if(count($areaArray) == 1)
		{
			if($this->getParent($areaArray[0]["knowledgeAreaId"]))
			{
				$this->id = $areaArray[0]["id"];
				$this->name = $areaArray[0]["name"];
				$this->coverageHours = $areaArray[0]["coverageHours"];
				$this->isCore = $areaArray[0]["isCore"];
				$this->state = $areaArray[0]["state"];
				return true;
			}
			else 
			{
				$this->id = $areaArray[0]["id"];
				$this->name = $areaArray[0]["name"];
				$this->coverageHours = $areaArray[0]["coverageHours"];
				$this->knowledgeAreaId = $areaArray[0]["knowledgeAreaId"];
				$this->isCore = $areaArray[0]["isCore"];
				$this->state = false;
				$this->updateUnit();
				return false;
			}
		}
		else
		{
			return false;
		}
	}
	
	public function selectUnitById($id)
	{
		$query = "SELECT * FROM {$this->table} WHERE state = 1 AND id = {$id}";
		return $this->executeSingleItemSelectQuery($query);
	}
	
	public function selectUnitByName($name)
	{
		$query = "SELECT * FROM {$this->table} WHERE state = 1 AND name = '{$name}'";
		
		return $this->executeSingleItemSelectQuery($query);
	}
	
	public function selectUnitByArea($knowledgeAreaId)
	{
		$units = null;
		//first check the area is active
		if($this->getParent($knowledgeAreaId))
		{
			$query = "SELECT * FROM {$this->table} WHERE state = 1 and knowledgeAreaId = {$knowledgeAreaId} ";
			$this->dbi->executeQuery($query);
			$unitArrays = $this->dbi->loadList();
			
			foreach($unitArrays as $key => $column)
			{
				$obj = new ACMKnowledgeUnit();
				$obj->id = $column["id"];
				$obj->name = $column["name"];
				$obj->coverageHours = $column["coverageHours"];
				$obj->isCore = $column["isCore"];
				$obj->state = $column["state"];
				$obj->knowledgeAreaId = $this->knowledgeAreaId;
				$obj->knowledgeAreaName = $this->knowledgeAreaName;
				
				$units[] = $obj; 
			}
		}
		else 
		{
			$query = "SELECT * FROM {$this->table} WHERE state = 1 and knowledgeAreaId = {$knowledgeAreaId} ";
			$this->dbi->executeQuery($query);
			$unitArrays = $this->dbi->loadList();
			
			foreach ($unitArrays as $key=>$column)
			{
				$this->id = $column["id"];
				$this->name = $column["name"];
				$this->coverageHours = $column["coverageHours"];
				$this->isCore = $column["isCore"];
				$this->knowledgeAreaId = $column["knowledgeAreaId"];
				$this->state = false;
				$this->updateUnit();
			}
		}
		return $units;
	}
	
	public function selectAllUnits()
	{
		if(!$this->checkDBI())
			throw new DASException("Database reference not instantiated");
		$query = "SELECT * FROM {$this->table} WHERE state = 1";
		$this->dbi->executeQuery($query);
		$unitArray = $this->dbi->loadList();
		$units = null;
		$areaId=0;
		$count = 0;
		
		foreach($unitArray as $key=>$column)
		{
			if($areaId != $unitArray[$count]["knowledgeAreaId"])
			{				
				$areaId = $unitArray[$count]["knowledgeAreaId"];
				$state = $this->getParent($areaId);
			}			
			if($areaId == $unitArray[$count]["knowledgeAreaId"])
			{
				if($state)
				{
					$obj = new ACMKnowledgeUnit();
					$obj->id = $column["id"];
					$obj->name = $column["name"];
					$obj->coverageHours = $column["coverageHours"];
					$obj->isCore = $column["isCore"];
					$obj->state = $column["state"];
					$obj->knowledgeAreaId = $this->knowledgeAreaId;
					$obj->knowledgeAreaName = $this->knowledgeAreaName;
					
					$units[] = $obj; 
				}
				else 
				{
					$this->id = $column["id"];
					$this->name = $column["name"];
					$this->coverageHours = $column["coverageHours"];
					$this->isCore = $column["isCore"];
					$this->state = false;
					$this->knowledgeAreaId = $column["knowledgeAreaId"];
					$this->updateUnit();
				}
			}
			$count++;
		}
		return $units;
	}
	
	public function insertUnit()
	{
		if(!$this->checkDBI())
			throw new DASException("Database reference not instantiated");
		$query = "INSERT INTO {$this->table} (name, knowledgeAreaId, coverageHours, isCore, state) VALUES (";
		$query .= "'{$this->name}', {$this->knowledgeAreaId}, {$this->coverageHours}, '{$this->isCore}', '{$this->state}')";
		echo $query;
		$this->dbi->executequery($query);
	}
	
	public function updateUnit()
	{
		if(!$this->checkDBI())
			throw new DASException("Database reference not instantiated");
		$query = "UPDATE {$this->table} SET ";
		$query .= " name = '".$this->name."', ";
		$query .= " knowledgeAreaId = ".$this->knowledgeAreaId.", ";
		$query .= " isCore = ".$this->isCore.", ";
		$query .= " coverageHours = '".$this->coverageHours."', ";
		$query .= " state = '".$this->state."' WHERE id = ".$this->id;
		$this->dbi->executeQuery($query);
	}
	
	public function rowCount()
	{
		return $this->dbi->rowCount();
	}
}