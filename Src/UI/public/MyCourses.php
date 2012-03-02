<?php
include_once 'MyCoursesCRUD.php';
include_once '../../UI/layouts/adminmenu.php';
include_once '../../UI/layouts/body.php';
include_once '../../UI/layouts/header.php';
include_once '../../UI/layouts/footer.php';
include_once '../../UI/layouts/HTMLHelper.php';

if(isset($_SESSION['id']))
{
	$userId = $_SESSION['id'];
}
else 
{
	header("Location: ../../UI/login/Login.php");
}
$userCourses = getCoursesByUserId($userId);
$today = getdate();
$year = $today['year'];
$semester = '';

if($today['mon'] >= 1 || $today['mon'] <= 5)
{
	$semester = 'SPRING';
}
elseif($today['mon'] >= 6 || $today['mon'] <= 7)
{
	$semester = 'SUMMER';
}
else
{
	$semester = 'FALL';
}
echo beginHtml("Assessment");
echo headerbar();
echo tutormenu();
echo startcolumn2();
?>
<table>
<tr>
<th>Course Name</th>
<th>Create Assessment</th>
<th>View Assessments</th>
</tr>
<?php 
foreach($userCourses as $key => $value)
{
	$tempArray = getCourseOfferingIdDetails($value->courseOfferingId, $semester, $year);
	if(!empty($tempArray))
	{
?>
	<tr>
	<td>
<?php 
		$courseArray = array();
		$courseArray = getCourseById($tempArray['courseId']);
?>
	<?php echo $courseArray["name"];?>
	</td>
	<td> <a href="CreateAssessment.php?id=<?php echo $tempArray["id"];?>">Create</a></td>
	<td> <a href="ViewAssessment.php?id=<?php echo $tempArray["id"];?>">View</a></td>
	<td> <a href="uploadRooster.php?id=<?php echo $tempArray["id"];?>">Upload Rooster</a></td>
	</tr>
<?php 
	}
}
?>
</table>
<?php 
echo endcolumn2();
echo footer();
echo endHtml();
?>