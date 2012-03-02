<?php
include 'LearningObjectiveCRUD.php';
echo beginHtml("ACM Learning Objective");
echo headerbar();
echo adminmenu();
echo acmcolumn();
echo startcolumn2();
session_start();

echo '<a href="AddLearningObjective.php">Add Learning Objective</a><br/>';

if(isset($_SESSION["message"]))
{
	echo $_SESSION["message"];
	echo "<br/>";
	$_SESSION['message'] = '';
}

$objectiveArray = getAllLearningObjectives();

if(empty($objectiveArray))
{
	echo "No objective arrays.";
}

else 
{
	$_SESSION["objectiveArray"] = $objectiveArray;
	
?>
<table border='1' cellpadding='10'>
	<tr>
		<th>Knowledge Unit Name</th>
		<th>Learning Objective Description</th>
		<th>ACM Objective</th>
		<th>View</th>
		<th>Edit</th>
		<th>Delete</th>
  	</tr>
<?php 
	foreach($objectiveArray as $key => $value)
	{
?>
	<tr>
		<td><?php echo $value["knowledgeUnitName"];?></td>
		<td><?php echo $value["description"];?></td>
		<td><?php echo $value["isACMObjective"];?></td>
		<td>
		<form action="ViewLearningObjective.php" method="get">
		<a href="ViewLearningObjective.php?id=<?php echo $value["id"];?>">View</a>
		</form>
		</td>
		<td>
		<form action="EditLearningObjective.php" method="get">
		<a href="EditLearningObjective.php?id=<?php echo $value["id"];?>">Edit</a>
		</form>
		</td>
		<td>
		<form action="DeleteLearningObjective.php" method="get">
		<a href="DeleteLearningObjective.php?id=<?php echo $value["id"];?>">Delete</a>
		</form>
		</td>
	</tr>
<?php 
	}
?>
</table>
<?php 
}
?>