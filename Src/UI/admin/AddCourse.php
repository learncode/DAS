<?php
include_once 'CourseCRUD.php';
include_once 'KnowledgeUnitCRUD.php';
include_once 'LearningObjectiveCRUD.php';
include_once 'TopicCRUD.php';
include_once '../../Core/CourseKnowledgeUnit.php';
include_once '../../Core/CourseLearningObjective.php';
include_once '../../Core/CourseTopic.php';

if(isset($_POST['querystring']))
{
	$params = array();
	parse_str($_POST['querystring'], $params);
	$params['state'] = true;
	$rowCount = AddCourse($params);
	if($rowCount == 1)
	{
		echo 'Course added.';
	}
	elseif($rowCount == 0)
	{
		echo 'Course could not be added';
	}
	else 
	{
		'Course Already existing';
	}
	exit;
}
echo beginHtml("Department Courses");
echo headerbar();
echo adminmenu();
echo acmcoursecolumn();
echo startcolumn2();
?>

<script type="text/javascript" src="JQuery.js"></script>

<script type="text/javascript">
function putCourse()
{
	$('#courseDiv').hide();
	var querystring = $('#course').serialize();
	
	$.post('AddCourse.php',{querystring: querystring},function(output){
		 $('#courseDiv').html(output).fadeIn(1000);
		});	
}
</script>
<h3>View Course:</h3><br/>
<div id="courseDiv"></div><br/>
<form name="course" id ="course">
	Course Name:<br/>
	<input type="text" name="name" size="30" maxlength="80" value="" id="name"/><br/>
	Course Number:<br/>
	<input type="text" name="number" size="30" maxlength="80" value='' id="number"/><br/>
	Course Description:<br/>
	<textarea name="description" rows="3" cols="40" id="description"></textarea><br/>
	Course Credit Hours:<br/>
	<input type="text" name="creditHours" size="30" maxlength="5" value="" id="creditHours"/><br/>
	<input type="button" name="submitCourse" value="Enter Course Offering" onclick="putCourse();" /><br/>
</form>