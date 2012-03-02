<?php
include_once 'AssessmentCRUD.php';
include_once '../../UI/layouts/adminmenu.php';
include_once '../../UI/layouts/body.php';
include_once '../../UI/layouts/header.php';
include_once '../../UI/layouts/footer.php';
include_once '../../UI/layouts/HTMLHelper.php';

if(isset($_GET['id']))
{
	echo beginHtml("Assessment");
	echo headerbar();
	echo tutormenu();
	echo startcolumn2();
	$courseOfferingId = $_GET['id'];
	$assessmentArray = getAllAssessmentsByCourseOffering($courseOfferingId);
?>
<table>
	  <tr>
	  	<th>Assessment Id</th>
	    <th>Name</th>
	    <th>Description</th>
	    <th>Assessment Type</th>
	  </tr>
<?php 
	foreach ($assessmentArray as $key => $value) 
	{
?>
	
	  <tr>
	  	<td><?php echo $value['id'];?></td>
	    <td><?php echo $value['name'];?></td>
	    <td><?php echo $value['description'];?></td>
	    <td><?php echo $value['assessmentTypeName'];?></td>
	    <td> <a href="uploadQuestions.php?id=<?php echo $value["id"];?>">Upload Questions</a></td>
	    <td> <a href="uploadQuestionGrade.php?id=<?php echo $value["id"];?>">Upload Grades</a></td>
	  </tr>

<?php 
	}
	?>
	</table>
	<?php 
	echo endcolumn2();
	echo footer();
	echo endHtml();
}

if(empty($_GET['id']))
{
	header("Location: MyCourses.php");
}