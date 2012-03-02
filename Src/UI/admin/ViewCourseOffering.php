<?php
include_once 'CourseOfferingCRUD.php';
include_once 'CourseCRUD.php';
include_once '../../UI/layouts/adminmenu.php';
include_once '../../UI/layouts/body.php';
include_once '../../UI/layouts/header.php';
include_once '../../UI/layouts/footer.php';
include_once '../../UI/layouts/HTMLHelper.php';

$today = getdate();
$year = $today['year'];
$semester = '';

if($today['mon'] >= 1 || $today['mon'] <= 4)
{
	$semester = 'SPRING';
}
elseif($today['mon'] >= 5 || $today['mon'] <= 6)
{
	$semester = 'SUMMER';
}
else
{
	$semester = 'FALL';
}
$state = 1;
$courseOfferingArray = getCourseOfferingBySemesterByYear($semester, $year);

echo beginHtml("Department Course Offerings");
echo headerbar();
echo adminmenu();
echo acmcourseoffering();
echo startcolumn2();
?>
<table>
	<tr>
		<th>
		Course Name
		</th>
		<th>
		Semester
		</th>
		<th>
		Year
		</th>
		<th>
		Prerequisites
		</th>
	</tr>
<?php 
foreach($courseOfferingArray as $key => $value)
{
	$courseArray = getCourseById($value['courseId']);
?>
	<tr>
		<td>
		<?php echo $courseArray['name'];?>
		</td>
		<td>
		<?php echo $value['semester'];?>
		</td>
		<td>
		<?php echo $value['year'];?>
		</td>
		<td>
		<?php echo $value['prerequisite'];?>
		</td>
		<td>
		<form action="DeleteCourseOffering.php" method="get">
		<a href="DeleteCourseOffering.php?id=<?php echo $value["id"];?>">Delete</a>
		</form>
		</td>
	</tr>
<?php 
}?>
</table>

<?php 
echo endcolumn2();
echo footer();
echo endHtml();
?>