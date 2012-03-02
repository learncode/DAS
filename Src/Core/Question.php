<?php
class Question
{
	public $id;
	public $assessmentId;
	public $questionText;
	public $maxScore;
	public $objectiveId;
	public $creatorBannerId;
	
	private $dbi;
	private $table = 'Question';
	
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
		if(!$this->checkDBI())
			throw new DASException("Database reference not instantiated");
		$exists = false;
		$this->dbi->executeQuery($query);
		$questionArray = $this->dbi->loadList();
		if (count($questionArray) > 0) 
		{
			$this->id = $questionArray[0]['id'];
			$this->assessmentId = $questionArray[0]['assessmentId'];
			$this->questionText = $questionArray[0]['questionText'];
			$this->maxScore = $questionArray[0]['maxScore'];
			$this->objectiveId = $questionArray[0]['objectiveId'];
			$this->creatorBannerId = $questionArray[0]['creatorBannerId'];
			
			$exists = true;
		}
		return $exists;
	}
	
	private function executeMultipleItemSelect($query)
	{
		if(!$this->checkDBI())
			throw new DASException("Database reference not instantiated");
		$questions = array();
		$this->dbi->executeQuery($query);
		$questionArray = $this->dbi->loadList();
		
		if (count($questionArray) > 0) 
		{
			foreach ($questionArray as $key => $value) 
			{
				$obj = new Question($this->dbi);
				$obj->id = $questionArray[0]['id'];
				$obj->assessmentId = $questionArray[0]['assessmentId'];
				$obj->questionText = $questionArray[0]['questionText'];
				$obj->maxScore = $questionArray[0]['maxScore'];
				$obj->objectiveId = $questionArray[0]['objectiveId'];
				$obj->creatorBannerId = $questionArray[0]['creatorBannerId'];
				
				$questions[] = $obj;
			}			
		}
		return $questions;
	}
	
	public function selectQuestionById($id)
	{
		$query = "SELECT * FROM {$this->table} WHERE id = {$id}";
		return $this->executeSingleItemSelect($query);
	}
	
	public function selectQuestionByAssessmentId($assessmentId)
	{
		$query = "SELECT * FROM {$this->table} WHERE assessmentid = {$assessmentId}";
		return $this->executeMultipleItemSelect($query);
	}
	
	public function insertQuestion()
	{
		$query = "INSERT INTO {$this->table} ";
		$query .= "(assessmentId, questionText, maxScore, objectiveId, creatorBannerId) VALUES ";
		$query .= "($this->assessmentId, '$this->questionText', $this->maxScore, $this->objectiveId, $this->creatorBannerId)";
		$this->dbi->executeQuery($query);
		return $this->rowCount();
	}
	
	public function updateQuestion()
	{
		$query = "UPDATE {$this->table} SET ";
		$query .= " assessmentId = $this->assessmentId,";
		$query .= "questionText = '$this->questionText', maxScore = $this->maxScore, objectiveId = $this->objectiveId, 
			creatorBannerId = $this->creatorBannerId WHERE id = {$this->id}";
		$this->dbi->executeQuery($query);
		return $this->rowCount();
	}
	
	private function rowCount()
	{
		return $this->dbi->rowCount();
	}
}