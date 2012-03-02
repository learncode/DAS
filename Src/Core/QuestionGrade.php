<?php
class QuestionGrade
{
	public $questionId;
	public $studentId;
	public $score;
	private $table = 'questiongrade';
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
	
	public function insertQuestionGrade() 
	{
		$query = "INSERT INTO {$this->table} (questionId, studentId, score)";
		$query = "VALUES ({$this->questionId}, {$this->studentId}, {$this->score})" ;
		$this->dbi->executeQuery($query);
		return $this->rowCount();
	}
	
	public function updateQuestionGrade()
	{
		$query = "UPDATE {$this->table} SET questionId = {$this->questionId}, studentId = {$this->studentId}, score = {$this->score} ";
		$query .= " WHERE questionId = {$this->questionId} AND studentId = {$this->studentId}";
		$this->dbi->executeQuery($query);
		return $this->rowCount();
	}
	
	private function rowCount()
	{
		return $this->dbi->rowCount();
	}
}