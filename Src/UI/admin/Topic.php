<?php
include 'TopicCRUD.php';
echo beginHtml("ACM Topic");
echo headerbar();
echo adminmenu();
echo acmcolumn();
echo startcolumn2();
session_start();

echo '<a href="AddTopic.php">Add Topic</a><br/>';

if(isset($_SESSION["message"]))
{
	echo $_SESSION["message"];
	echo "<br/>";
	$_SESSION['message'] = '';
}

$topicArray = getAllTopics();

if(empty($topicArray))
{
	echo "No Topic arrays.";
}

else 
{
	$_SESSION["topicArray"] = $topicArray;
	
?>
<table border='1' cellpadding='10'>
	<tr>
		<th>Knowledge Unit Name</th>
		<th>Topic Description</th>
		<th>ACM Topic</th>
		<th>View</th>
		<th>Edit</th>
		<th>Delete</th>
  	</tr>
<?php 
	foreach($topicArray as $key => $value)
	{
?>
	<tr>
		<td><?php echo $value["knowledgeUnitName"];?></td>
		<td><?php echo $value["description"];?></td>
		<td><?php echo $value["isACMTopic"];?></td>
		<td>
		<form action="ViewTopic.php" method="get">
		<a href="ViewTopic.php?id=<?php echo $value["id"];?>">View</a>
		</form>
		</td>
		<td>
		<form action="EditTopic.php" method="get">
		<a href="EditTopic.php?id=<?php echo $value["id"];?>">Edit</a>
		</form>
		</td>
		<td>
		<form action="DeleteTopic.php" method="get">
		<a href="DeleteTopic.php?id=<?php echo $value["id"];?>">Delete</a>
		</form>
		</td>
	</tr>
<?php 
	}
?>
</table>
<?php 
}
echo endcolumn2();
echo footer();
echo endHtml();
?>