<?php
class DASException extends Exception
{
	public function __construct($message = '', $code = 0)
	{
		parent::__construct($message, $code);
	}
	
	public function getCustomError()
	{
		//Show friendly error message as well as the stack message
        $error = '<div style="font-size:14px; color:#000000;">';
		$error .= '<div style="padding:8px; background:#eee; font:\'Courier New\', Courier, mono; font-weight:bold;">';
		$error .= $this->getMessage();
		$error .= '</div>';
		$error .= '<div style="font-size:12px; padding:2px 8px; background:#FFFFCC; font:\'Courier New\', Courier, mono"><pre>';
		$error .= "Code: " . $this->getCode() . "\n" . "File: " . $this->getFile() . "\n" . "Line: " . $this->getLine() . " at: \n";
		$error .= $this->getTraceAsString() . "\n";
		$error .= '</pre></div>';		
		$error .= '</div>';
		
		return $error."<br/>";
	}
	
	public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }	
}