<?php

include_once 'KnowledgeUnitCRUD.php';
echo beginHtml("ACM KnowledgeUnit");
echo headerbar();
echo adminmenu();
echo acmcolumn();
echo startcolumn2();

session_start();

if(isset($_SESSION["message"]))
{
	echo $_SESSION["message"];
	echo "<br/>";
	$_SESSION['message'] = '';
}

echo '<a href="AddKnowledgeUnit.php">Add Knowledge Unit</a>';

$unitArray = getAllKnowledgeUnits();

if(empty($unitArray))
{
	echo "No Knowledge Areas";	
}

else 
{
	$_SESSION["unitArray"] = $unitArray;
?>
<table border='1' cellpadding='10'>
	<tr>
		<th>Knowledge Unit Name</th>
		<th>Knowledge Area Name</th>
		<th>Coverage Hours</th>
		<th>Core</th>
		<th>View</th>
		<th>Edit</th>
		<th>Delete</th>
  	</tr>
<?php 
	foreach($unitArray as $key => $value)
	{
?>
	<tr>
		<td><?php echo $value["name"];?></td>
		<td><?php echo $value["knowledgeAreaName"];?></td>
		<td><?php echo $value["coverageHours"];?></td>
		<td><?php echo $value["isCore"];?></td>
		<td>
		<form action="ViewKnowledgeUnit.php" method="get">
		<a href="ViewKnowledgeUnit.php?id=<?php echo $value["id"];?>">View</a>
		</form>
		</td>
		<td>
		<form action="EditKnowledgeUnit.php" method="get">
		<a href="EditKnowledgeUnit.php?id=<?php echo $value["id"];?>">Edit</a>
		</form>
		</td>
		<td>
		<form action="DeleteKnowledgeUnit.php" method="get">
		<a href="DeleteKnowledgeUnit.php?id=<?php echo $value["id"];?>">Delete</a>
		</form>
		</td>
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