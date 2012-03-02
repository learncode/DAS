<?php

class ACMLearningObjective
{
	public $id;
	public $knowledgeUnitName;
	public $knowledgeUnitId;
	public $isACMObjective;
	public $description;
	public $state;
	
	private $table = "acmlearningobjective";
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
	
	private function getParent($unitId)
	{
		try 
		{
			if(!$this->checkDBI())
				throw new DASException("Database reference not instantiated");
			$exists = false;
			$unit = new ACMKnowledgeUnit($this->dbi);
			if($unit->selectUnitById($unitId))
			{
				$this->knowledgeUnitName = $unit->name;
				$exists = true;
			}
			unset($unit);
			return $exists;
		}
		catch(DASException $ex)
		{
			echo $ex->getCustomError();
		}
	}
	private function executeSingleItemSelectQuery($query)
	{
		try
		{
			if(!$this->checkDBI())
				throw new DASException("Database reference not instantiated");
			$exists = false;
			$this->dbi->executeQuery($query);
			$objectiveArray = $this->dbi->loadList();
			if(count($objectiveArray) > 0)
			{
				if($this->getParent($objectiveArray[0]["knowledgeUnitId"]))
				{
					$this->id = $objectiveArray[0]["id"];
					$this->knowledgeUnitId = $objectiveArray[0]["knowledgeUnitId"];
					$this->isACMObjective = $objectiveArray[0]["isACMObjective"];
					$this->description = $objectiveArray[0]["description"];
					$this->state = $objectiveArray[0]["state"];
					$exists = true;
				}
				else 
				{
					$this->id = $objectiveArray[0]["id"];
					$this->knowledgeUnitId = $objectiveArray[0]["knowledgeUnitId"];
					$this->isACMObjective = $objectiveArray[0]["isACMObjective"];
					$this->description = $objectiveArray[0]["description"];
					$this->state = false;
					$this->updateObjective();
				}
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
			$objectives = null;
			$this->dbi->executeQuery($query);
			$objectiveArray = $this->dbi->loadList();
			$unitId = 0;
			$count = 0;
			
			if(count($objectiveArray) > 0)
			{
				$check = null;
				foreach($objectiveArray as $key=>$value)
				{
					if($unitId != $value["knowledgeUnitId"])
					{
						$unitId = $value["knowledgeUnitId"];
						$state = $this->getParent($unitId);
					}
					
					if($unitId == $value["knowledgeUnitId"])
					{
						if($state)
						{
							$obj = new ACMLearningObjective();
							$obj->id = $value["id"];
							$obj->description = $value["description"];
							$obj->knowledgeUnitId = $this->knowledgeUnitId;
							$obj->knowledgeUnitName = $this->knowledgeUnitName;
							$obj->isACMObjective = $value["isACMObjective"];
							$obj->state = $value["state"];
							$objectives[] = $obj;
						}
						else 
						{
							$this->id = $value["id"];
							$this->knowledgeUnitId = $value["knowledgeUnitId"];
							$this->isACMObjective = $value["isACMObjective"];
							$this->description = $value["description"];
							$this->state = false;
							$this->updateObjective();
						}
					}
				}
			}
			return $objectives;
		}
		catch(DASException $ex)
		{
			echo $ex->getCustomError();
		}
	}
	
	public function selectObjectiveById($id)
	{
		try
		{
			if(!$this->checkDBI())
				throw new DASException("Database reference not instantiated");
			$query = "SELECT * FROM {$this->table} WHERE state = 1 AND id = {$id}";
			return $this->executeSingleItemSelectQuery($query);
		}
		catch(DASException $ex)
		{
			echo $ex->getCustomError();
		}	
	}
	
	public function selectObjectiveByDescription($description)
	{
		try 
		{
			if(!$this->checkDBI())
				throw new DASException("Database reference not instantiated");
			$query = "SELECT * FROM {$this->table} WHERE state = 1 AND description LIKE '{$description}'";
			return $this->executeSingleItemSelectQuery($query);
		}
		catch(DASException $ex)
		{
			echo $ex->getCustomError();
		}	
	}
	
	public function selectObjectiveByUnit($unitId)
	{
		try
		{
			if(!$this->checkDBI())
				throw new DASException("Database reference not instantiated");
			$objectives = null;
			$query = "SELECT * FROM {$this->table} WHERE knowledgeUnitId = {$unitId} AND state = 1";
			$objectives = $this->executeMultipleItemSelectQuery($query);
			return $objectives;
		}
		catch(DASException $ex)
		{
			echo $ex->getCustomError();
		}
	}
	
	public function selectAllObjectives()
	{
		try
		{
			if(!$this->checkDBI())
				throw new DASException("Database reference not instantiated");
			$objectives = null;
			$query = "SELECT * FROM {$this->table} WHERE state = 1";
			$objectives = $this->executeMultipleItemSelectQuery($query);
			return $objectives;
		}
		catch(DASException $ex)
		{
			echo $ex->getCustomError();
		}
	}
	
	public function insertObjective()
	{
		try 
		{
			if(!$this->checkDBI())
				throw new DASException("Database reference not instantiated");
			$query = "INSERT INTO {$this->table} (knowledgeUnitId, description, isACMObjective, state) VALUES (";
			$query .= $this->knowledgeUnitId .", '". $this->description ."', '". $this->isACMObjective ."', '". $this->state."');";
			$this->dbi->executeQuery($query);
		}
		catch(DASException $ex)
		{
			echo $ex->getCustomError();
		}
	}
	
	public function updateObjective()
	{
		try
		{
			if(!$this->checkDBI())
					throw new DASException("Database reference not instantiated");
			$query = "UPDATE {$this->table} SET ";
			$query .= "knowledgeUnitId = ". $this->knowledgeUnitId. ", ";
			$query .= "description = '". $this->description . "', ";
			$query .= "isACMObjective = '". $this->isACMObjective. "', ";
			$query .= "state = '". $this->state ."' WHERE id = ".$this->id;
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