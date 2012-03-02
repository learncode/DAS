<?php
include_once 'DASException.php';

class DBWrapper
{
	private $dbo;
	private static $instance;
	private $results;
	private $rowCount;
	private $inTransaction = false;
    
	private function __construct()
	{
		try 
		{
			$this->getConnection();
		}
		catch(DASException $ex)
		{
			echo $ex->getCustomError();
		}		
	}
	
	private function getConnection()
    {
		try
      	{
        	if(is_null($this->dbo))
        	{
	          list($dsn,$user, $password) = $this->setDSN();
	          $this->dbo = new PDO($dsn,$user,$password);
	          $this->dbo->setAttribute(PDO::ATTR_PERSISTENT, true);
	          $this->dbo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	        }
		}
		catch(DASException $ex)
	    {
	    	echo $ex->getCustomError();
	        exit;
	    }
		catch(PDOException $ex)
		{
			echo $ex->getMessage();
		}
    }
    
	public static function getInstance()
    {
    	try 
    	{
    		if(!self::$instance instanceof DBWrapper)
			{
	    		self::$instance = new DBWrapper();
			}
			return self::$instance;
    	}
    	catch(DASException $ex)
	    {
	    	echo $ex->getCustomError();
	        exit;
	    }    	
    }
    
    private function setDSN()
    {
    	try 
    	{
    		$file = $_SERVER{'DOCUMENT_ROOT'} .'DASTest/Lib/Connection.xml';
    		if(file_exists($file))
    		{
	    		$xml = simplexml_load_file($file);
	    		$dbtype = $xml->dbtype;
		      	$dbname = $xml->dbname;
		      	$location = $xml->host.":".$xml->port;
		      	$user = $xml->user;
		      	$password = $xml->password;
		      	$dsn = $dbtype.":dbname=".$dbname.";host=".$location;
		      	
		      	return array($dsn,$user,$password);
    		}
    		else 
    			throw new DASException("Connection.xml file not found ");
			
    	}
    	catch(DASException $ex)
		{
			echo $ex->getCustomError();
		}
    }
    
	public function setTransaction()
    {
    	$this->inTransaction = ($this->inTransaction == true) ? false : true;
    }
    
    public function inTransaction()
    {
    	return $this->inTransaction;
    }
    
    public function beginTransaction()
    {
      $this->dbo->beginTransaction();
    }

    public function commitTransaction()
    {
      $this->dbo->commit();
    }
   
	public function rollbackTransaction()
    {
      $this->dbo->rollBack();
    }
    
	public function executeQuery($query)
    {
    	$this->results = $this->dbo->prepare($query);
    	$this->results->execute();
    	$this->rowCount = $this->results->rowcount();
    }
    
    public function rowCount()
    {
    	return $this->rowCount;
    }
    
    public function loadList()
    {
    	$obj = array();
    	if($this->results)
    	{
    		$obj = $this->results->fetchAll(PDO::FETCH_ASSOC);
    	}
    	return $obj;    	
    }
}