<?php
include_once('../Lib/DBWrapper.php');

class ACMKnowledgeArea
{
	public $id;
	public $code;
	public $name;
	public $state;
	public $description;
	public $coreHours;
	private $dbi = null;
	private $table = 'acmknowledgearea';
	
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
	
	public function selectAreaById($id)
	{
		try
		{
			if(!$this->checkDBI())
				throw new DASException("Database reference not instantiated");
			$query = "SELECT * FROM {$this->table} WHERE state = 1 AND id = {$id}";
			$this->dbi->executeQuery($query);
			
			$areaArray = $this->dbi->loadList();
			if(count($areaArray) == 1)
			{
				//$obj = new ACMKnowledgeArea();
				$this->id = $areaArray[0]["id"];
				$this->code = $areaArray[0]["code"];
				$this->name = $areaArray[0]["name"];
				$this->description = $areaArray[0]["description"];
				$this->coreHours = $areaArray[0]["coreHours"];
				$this->state = $areaArray[0]["state"];
				return true;
			}
			return false;
		}
		catch(DASException $ex)
		{
			echo $ex->getCustomError();
		}
	}
	
	public function selectAreaByName($name)
	{
		try
		{
			if(!$this->checkDBI())
				throw new DASException("Database reference not instantiated");
			$query = "SELECT * FROM {$this->table} WHERE state = 1 AND name LIKE '{$name}'";
			$this->dbi->executeQuery($query);
			
			$areaArray = $this->dbi->loadList();
			if(count($areaArray) == 1)
			{
				$this->id = $areaArray[0]["id"];
				$this->code = $areaArray[0]["code"];
				$this->name = $areaArray[0]["name"];
				$this->description = $areaArray[0]["description"];
				$this->coreHours = $areaArray[0]["coreHours"];
				$this->state = $areaArray[0]["state"];
				return true;
			}
			return false;
		}
		catch(DASException $ex)
		{
			echo $ex->getCustomError();
		}
	}
	
	public function selectAreaByCode($code)
	{
		try
		{
			if(!$this->checkDBI())
				throw new DASException("Database reference not instantiated");
			$query = "SELECT * FROM {$this->table} WHERE state = 1 AND code LIKE '{$code}'";
			$this->dbi->executeQuery($query);
			
			$areaArray = $this->dbi->loadList();
			if(count($areaArray) == 1)
			{
				$this->id = $areaArray[0]["id"];
				$this->code = $areaArray[0]["code"];
				$this->name = $areaArray[0]["name"];
				$this->description = $areaArray[0]["description"];
				$this->coreHours = $areaArray[0]["coreHours"];
				$this->state = $areaArray[0]["state"];
				return true;
			}
			return false;
		}
		catch(DASException $ex)
		{
			echo $ex->getCustomError();
		}
	}
	
	public function selectAllAreas()
	{
		try
		{
			if(!$this->checkDBI())
				throw new DASException("Database reference not instantiated");
			$areas = null;
			$query = "SELECT * FROM {$this->table} WHERE state = 1";
			$this->dbi->executeQuery($query);
			
			$areaArray = $this->dbi->loadList();
			if(count($areaArray) > 0)
			{
				foreach ($areaArray as $key=>$column)
				{
					$obj = new ACMKnowledgeArea();
					$obj->id = $column["id"];
					$obj->code = $column["code"];
					$obj->name = $column["name"];
					$obj->description = $column["description"];
					$obj->coreHours = $column["coreHours"];
					$obj->state = $column["state"];
					$areas[] = $obj;
				}				
			}
			return $areas;
		}
		catch(DASException $ex)
		{
			echo $ex->getCustomError();
		}
	}
	
	public function insertArea()
	{
		try 
		{
			$query = "INSERT INTO {$this->table} (code, name, description, coreHours, state) VALUES ";
			$query .= "( '". $this->code ."', ";
			$query .= "'". $this->name ."', ";
			$query .= "'". $this->description ."', ";
			$query .= $this->coreHours .", ";
			$query .= "'". true ."'); ";
			
			$this->dbi->executeQuery($query);
			return $this->dbi->rowCount();
		}
		catch(DASException $ex)
		{
			echo $ex->getCustomError();
		}
	}
	
	public function updateArea()
	{
		try 
		{
			$query = "UPDATE {$this->table} SET ";
			$query .= "code ='". $this->code ."', ";
			$query .= "name = '". $this->name ."', ";
			$query .= "description = '". $this->description ."', ";
			$query .= "coreHours = ".$this->coreHours .", ";
			$query .= "state = '". $this->state ."' ";
			$query .= "WHERE id = ".$this->id;

			$this->dbi->executeQuery($query);
			return $this->dbi->rowCount();
		}
		catch(DASException $ex)
		{
			echo $ex->getCustomError();
		}
	}
}