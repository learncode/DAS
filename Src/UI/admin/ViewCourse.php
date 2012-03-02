<?php
include_once 'CourseCRUD.php';
include_once 'KnowledgeUnitCRUD.php';
include_once 'LearningObjectiveCRUD.php';
include_once 'TopicCRUD.php';
include_once '../../Core/CourseKnowledgeUnit.php';
include_once '../../Core/CourseLearningObjective.php';
include_once '../../Core/CourseTopic.php';

if(isset($_POST['id']))
{
	$instance = DBWrapper::getInstance();
	$courseUnit = new CourseKnowledgeUnit($instance);
	$courseObjective = new CourseLearningObjective($instance);
	$courseTopic = new CourseTopic($instance);
	
	$courseId = $_POST['id'];
	$courseArray = getCourseById($courseId);
	echo '<b>Course: </b>'.$courseArray['name'].'<br/>';
	echo '<hr/>';
	echo '<b>Knowledge Units:</b><br/>';
	echo '<hr/>';
	$courseUnitArray = $courseUnit->selectCourseById($courseId);	
	foreach ($courseUnitArray as $key => $value) 
	{
		echo $value->unitName.'<br/>';		
	}	
	echo '<b>Learning Objectives:</b><br/>';
	echo '<hr/>';
	$courseObjectiveArray = $courseObjective->selectCourseById($courseId);
	foreach ($courseObjectiveArray as $key => $value) 
	{
		echo $value->objectiveDescription.'<br/>';		
	}
	echo '<b>Topics:</b><br/>';
	echo '<hr/>';
	$courseTopicArray = $courseTopic->selectCourseById($courseId);
	foreach ($courseTopicArray as $key => $value) 
	{
		echo $value->topicDescription.'<br/>';		
	}
	exit;
}

echo beginHtml("Department Courses");
echo headerbar();
echo adminmenu();
echo acmcoursecolumn();
echo startcolumn2();
session_start();


$courseArray = getAllCourses();
?>
<script type="text/javascript" src="JQuery.js"></script>

<script type="text/javascript">
function selectCourse()
{
	var value = selectcourse.Course.value;
	$.post('ViewCourse.php',{id: value}, function(output){$('#detailsDiv').html(output);});	
	document.getElementById('Course').disabled = true;
	document.getElementById('selectArea').style.display = 'block';
}

function selectAnotherCourse()
{
	document.getElementById('Course').disabled = false;
}
</script>

<h3>View Course:</h3>
<form id="selectcourse" name="selectcourse">
Select Course:<br/>
<select id="Course" name="Course">
<?php 
foreach($courseArray as $key=>$value)
{
?>
	<option value="<?php echo $value->id;?>"><?php echo "CS ".$value->number." - ".$value->name; ?></option>
<?php 
}
?>
</select><br/>
<input type="button" name="submitCourse" value="Select Course" onclick="selectCourse();" />
<input type="button" name="anotherCourse" value="Select Another Course" onclick="selectAnotherCourse();" />
</form>
<div id='detailsDiv'>

</div>
<?php 
echo endcolumn2();
echo footer();
echo endHtml();
?>