<?php
include_once '../Lib/DBWrapper.php';
include_once '../Lib/CustomErrorHandler.php';
include_once '../Core/ACMKnowledgeArea.php';

session_start();
if(isset($_SESSION["message"]))
{
	echo "<h3>".$_SESSION["message"]."</h3><br/>";
	unset($_SESSION["message"]);
}
function getAllAreas()
{
	$instance = DBWrapper::getInstance();
	$area = new ACMKnowledgeArea($instance);
	$areas = array();
	$areaObjects = $area->selectAllAreas();
	
	foreach($areaObjects as $key => $value)
	{
		array_push($areas, array($value->id,$value->code,$value->name,$value->description,$value->coreHours));
	}
	return $areas;
}
?>
<a href="AddKnowledgeArea.php">Add ACM Knowledge Areas</a>
<?php 
$areas = getAllAreas();
if(empty($areas))
{
	echo "No Knowledge Areas";
	session_destroy();
}
else 
{
	$_SESSION["areas"] = $areas;
?>

<table border='1' cellpadding='10'>
	<tr>
		<th>Code</th>
		<th>Name</th>
		<th>Hours</th>
		<th>View</th>
		<th>Edit</th>
		<th>Delete</th>
  	</tr>
<?php 
	foreach($areas as $key=>$value)
	{
?>
	<tr>
		<td>
			<?php echo $value[1];?>
		</td>
		<td>
			<?php echo $value[2];?>
		</td>
		<td>
			<?php echo $value[4];?>
		</td>
		<td>
			<form method="get" action="ViewKnowledgeArea.php">
			<a href="ViewKnowledgeArea.php?id=<?php echo $value[0];?>">View</a>
			</form>
		</td>	
		<td>
			<form method="get" action="EditKnowledgeArea.php">
			<a href="EditKnowledgeArea.php?id=<?php echo $value[0];?>">Edit</a>
			</form>
		</td>
		<td>
			<form method="get" action="DeleteKnowledgeArea.php">
			<a href="DeleteKnowledgeArea.php?id=<?php echo $value[0];?>">Delete</a>
			</form>
		</td>
	</tr>
		<?php 
	}
}
?>
</table>