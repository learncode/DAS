<?php
// HTML functions
function beginHtml($title) {
	$meta = "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\" />";
	$css = "<link href=\"../../UI/layouts/reset.css\" rel=\"stylesheet\" type=\"text/css\" />";
    $css .= "<link href=\"../../UI/layouts/Style.css\" rel=\"stylesheet\" type=\"text/css\" />";
	return '<html><head><title>'.$title.'</title>'.$meta.$css.'</head><body>';
}
function endHtml() {
	return '</body></html>';
}
function cleanInput($input)
{
	return htmlspecialchars(mysql_real_escape_string(preg_replace('~<\s*\bscript\b[^>]*>(.*?)<\s*\/\s*script\s*>~is', '', $input)));
}
function cleanOutput($input)
{
	return stripslashes($input);
}
?>