<?php
function myErrorHandler($errno, $errstr, $errfile, $errline)
{
    if (!(error_reporting() & $errno)) {
        // This error code is not included in error_reporting
        return;
    }

    /*
     * $error = '<div style="font-size:14px; color:#000000;">';
		$error .= '<div style="padding:8px; background:#eee; font:\'Courier New\', Courier, mono; font-weight:bold;">';
		$error .= $this->getMessage();
		$error .= '</div>';
		$error .= '<div style="font-size:12px; padding:2px 8px; background:#FFFFCC; font:\'Courier New\', Courier, mono"><pre>';
		$error .= "Code: " . $this->getCode() . "\n" . "File: " . $this->getFile() . "\n" . "Line: " . $this->getLine() . " at: \n";
		$error .= $this->getTraceAsString() . "\n";
		$error .= '</pre></div>';		
		$error .= '</div>';
     */
    switch ($errno) 
    {
	    case E_USER_ERROR:
	    	$error = '<div style="font-size:14px; color:#000000;">';
			$error .= '<div style="padding:8px; background:#eee; font:\'Courier New\', Courier, mono; font-weight:bold;">';
	        $error .= "<b>Application ERROR</b><br />\n";
	        $error .= '</div>';
			$error .= '<div style="font-size:12px; padding:2px 8px; background:#FFFFCC; font:\'Courier New\', Courier, mono"><pre>';
			$error .= "[$errno]:". $errstr."<br />";
			$error .= " Fatal error on line $errline in file $errfile";
	        $error .= ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";

	        echo $error;
	        exit(1);
	        break;
	
	    case E_USER_WARNING:
			$error = '<div style="font-size:14px; color:#000000;">';
			$error .= '<div style="padding:8px; background:#eee; font:\'Courier New\', Courier, mono; font-weight:bold;">';
	        $error .= "<b>Application WARNING</b><br />\n";
	        $error .= '</div>';
			$error .= '<div style="font-size:12px; padding:2px 8px; background:#FFFFCC; font:\'Courier New\', Courier, mono"><pre>';
			$error .= "[$errno]:". $errstr."<br />";
			$error .= "Fatal error on line $errline in file $errfile";
	        $error .= ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
	        echo $error;
	        exit(1);
	        break;
	
	    case E_USER_NOTICE:
	        $error = '<div style="font-size:14px; color:#000000;">';
			$error .= '<div style="padding:8px; background:#eee; font:\'Courier New\', Courier, mono; font-weight:bold;">';
	        $error .= "<b>Application NOTICE</b> <br />\n";
	        $error .= '</div>';
			$error .= '<div style="font-size:12px; padding:2px 8px; background:#FFFFCC; font:\'Courier New\', Courier, mono"><pre>';
			$error .= "[$errno]:". $errstr."<br />";
			$error .= "Fatal error on line $errline in file $errfile";
	        $error .= ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
	        echo $error;
	        exit(1);
	        break;
	
	    default:
	        $error = '<div style="font-size:14px; color:#000000;">';
			$error .= '<div style="padding:8px; background:#eee; font:\'Courier New\', Courier, mono; font-weight:bold;">';
	        $error .= "<b>UNKNOWN ERROR</b><br />\n";
	        $error .= '</div>';
			$error .= '<div style="font-size:12px; padding:2px 8px; background:#FFFFCC; font:\'Courier New\', Courier, mono"><pre>';
			$error .= "[$errno]:". $errstr."<br />";
			$error .= "Fatal error on line $errline in file $errfile";
	        $error .= ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
	        echo $error;
	        exit(1);
	        break;
    }
    
    /* Don't execute PHP internal error handler */
    return true;
}
set_error_handler('myErrorHandler');
?>