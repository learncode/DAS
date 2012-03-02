<?php
include_once 'CourseCRUD.php';
include_once 'CourseOfferingCRUD.php';
include_once '../../UI/layouts/adminmenu.php';
include_once '../../UI/layouts/body.php';
include_once '../../UI/layouts/header.php';
include_once '../../UI/layouts/footer.php';
include_once '../../UI/layouts/HTMLHelper.php';



if(isset($_POST['querystring']))
{
	$params = array();
	parse_str($_POST['querystring'], $params);
	$params['state'] = true;
	if(!empty($params['courseId']) && !empty($params['semester']) && !empty($params['year']) && !empty($params['prerequisite']) && !empty($params['userId']))
	{
		$retVal = insertCourseOffering($params);
		if($retVal == -1)
		{
			echo '<b style="color: red">For the present semester this Course Offering is already entered.</b>';
		}
		elseif($retVal == 1)
		{
			$id = getCourseOfferingId($params['courseId'], $params['semester'], $params['year']);
			$val = insertCourseOfferingFaculty($params['userId'], $id);
			if($val == 1)
			{
				echo '<b>Course Offering entered.</b>';
			}
			else
			{
				echo '<b>Course Offering could not be entered.</b>';
			}
		}
		else
		{
			echo '<b>Course Offering could not be entered.</b>';
		}
	}
	else {
		echo '<b style="color: red">Fill all the fields</b>';
	}
	exit;
}

$courseArray = getAllCourses();
$instructors = getInstructors();
$today = getdate();
$year = $today['year'];
$semester = '';

if($today['mon'] >= 1 || $today['mon'] <= 4)
{
	$semester = 'SPRING';
}
elseif($today['mon'] >= 5 || $today['mon'] <= 7)
{
	$semester = 'SUMMER';
}
else
{
	$semester = 'FALL';
}
$state = 1;

echo beginHtml("Department Course Offerings");
echo headerbar();
echo adminmenu();
echo acmcourseoffering();
echo startcolumn2();
?>

<script type="text/javascript" src="JQuery.js"></script>
<script type="text/javascript">
function putCourseOffering()
{
	$('#courseDiv').hide();
	var querystring = $('#entercourseoffering').serialize();
	$.post('AddCourseOffering.php',{querystring: querystring},function(output){
		 $('#courseDiv').html(output).fadeIn(1000);
		});	
}
</script>

<div id="courseDiv"></div>
<form id="entercourseoffering" name="entercourseoffering">
Select Course:<br/>
<select id="Course" name="courseId">
<?php 
foreach($courseArray as $key=>$value)
{
?>
	<option value="<?php echo $value->id;?>"><?php echo "CS ".$value->number." - ".$value->name; ?></option>
<?php 
}
?>
</select><br/>
Instructor:<br/>
<select id="Users" name="userId">
<?php 
foreach($instructors as $key=>$value)
{
?>
	<option value="<?php echo $value['id'];?>"><?php echo $value['name']; ?></option>
<?php 
}
?>
</select><br/>
Semester:<br/>
<input type="text" name="semester" size="30" maxlength="80" readonly="readonly" value="<?php echo $semester;?>" id="semester"/><br/>
Year:<br/>
<input type="text" name="year" size="30" maxlength="80" readonly="readonly" value="<?php echo $year;?>" id="year"/><br/>
Prerequisite:<br/>
<textarea name="prerequisite" rows="3" cols="40" id="description">No prerequisites.</textarea><br/>
<input type="button" name="submitCourse" value="Enter Course Offering" onclick="putCourseOffering();" /><br/>
</form>
<?php 
echo endcolumn2();
echo footer();
echo endHtml();
?>