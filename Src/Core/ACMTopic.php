<?php

class ACMTopic
{
	public $id;
	public $knowledgeUnitName;
	public $knowledgeUnitId;
	public $isACMTopic;
	public $description;
	public $state;
	
	private $table = "acmtopic";
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
			$topicArray = $this->dbi->loadList();
			if(count($topicArray) > 0)
			{
				if($this->getParent($topicArray[0]["knowledgeUnitId"]))
				{
					$this->id = $topicArray[0]["id"];
					$this->knowledgeUnitId = $topicArray[0]["knowledgeUnitId"];
					$this->isACMTopic = $topicArray[0]["isACMTopic"];
					$this->description = $topicArray[0]["description"];
					$this->state = $topicArray[0]["state"];
					$exists = true;
				}
				else 
				{
					$this->id = $topicArray[0]["id"];
					$this->knowledgeUnitId = $topicArray[0]["knowledgeUnitId"];
					$this->isACMTopic = $topicArray[0]["isACMTopic"];
					$this->description = $topicArray[0]["description"];
					$this->state = false;
					$this->updateTopic();
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
			$topics = null;
			$this->dbi->executeQuery($query);
			$topicArray = $this->dbi->loadList();
			$unitId = 0;
			$count = 0;
			
			if(count($topicArray) > 0)
			{
				$check = null;
				foreach($topicArray as $key=>$value)
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
							$obj = new ACMTopic();
							$obj->id = $value["id"];
							$obj->description = $value["description"];
							$obj->knowledgeUnitId = $this->knowledgeUnitId;
							$obj->knowledgeUnitName = $this->knowledgeUnitName;
							$obj->isACMTopic = $value["isACMTopic"];
							$obj->state = $value["state"];
							$topics[] = $obj;
						}
						else 
						{
							$this->id = $value["id"];
							$this->knowledgeUnitId = $value["knowledgeUnitId"];
							$this->isACMTopic = $value["isACMTopic"];
							$this->description = $value["description"];
							$this->state = false;
							$this->updateTopic();
						}
					}
				}
			}
			return $topics;
		}
		catch(DASException $ex)
		{
			echo $ex->getCustomError();
		}
	}
	
	public function selectTopicById($id)
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
	
	public function selectTopicByDescription($description)
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
	
	public function selectTopicByUnit($unitId)
	{
		try 
		{
			if(!$this->checkDBI())
				throw new DASException("Database reference not instantiated");
			$topics = null;
			$query = "SELECT * FROM {$this->table} WHERE knowledgeUnitId = {$unitId} AND state = 1";
			$topics = $this->executeMultipleItemSelectQuery($query);
			return $topics;
		}
		catch(DASException $ex)
		{
			echo $ex->getCustomError();
		}
	}
	
	public function selectAllTopics()
	{
		try 
		{
			if(!$this->checkDBI())
				throw new DASException("Database reference not instantiated");
			$topics = null;
			$query = "SELECT * FROM {$this->table} WHERE state = 1";
			$topics = $this->executeMultipleItemSelectQuery($query);
			return $topics;
		}
		catch(DASException $ex)
		{
			echo $ex->getCustomError();
		}
	}
	
	public function insertTopic()
	{
		try
		{
			if(!$this->checkDBI())
				throw new DASException("Database reference not instantiated");
			$query = "INSERT INTO {$this->table} (knowledgeUnitId, description, isACMTopic, state) VALUES (";
			$query .= $this->knowledgeUnitId .", '". $this->description ."', '". $this->isACMTopic ."', '". $this->state."');";
			$this->dbi->executeQuery($query);
		}
		catch(DASException $ex)
		{
			echo $ex->getCustomError();
		}
	}
	
	public function updateTopic()
	{
		try
		{
			if(!$this->checkDBI())
				throw new DASException("Database reference not instantiated");
			$query = "UPDATE {$this->table} SET ";
			$query .= "knowledgeUnitId = ". $this->knowledgeUnitId. ", ";
			$query .= "description = '". $this->description . "', ";
			$query .= "isACMTopic = '". $this->isACMTopic. "', ";
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