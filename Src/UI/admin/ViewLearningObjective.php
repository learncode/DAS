<?php
include_once 'LearningObjectiveCRUD.php';
echo beginHtml("ACM Learning Objective");
echo headerbar();
echo adminmenu();
echo acmcolumn();
echo startcolumn2();
session_start();
if(isset($_GET["id"]))
{
	if(is_numeric($_GET["id"]) )
	{
		$objectiveId = $_GET["id"];
		$objectiveArray = getLearningObjectiveById($objectiveId);
		if(!empty($objectiveArray))
		{
?>
			<h3>Learning Objective</h3><hr/>
			<b>Learning objective Description:</b><?php echo $objectiveArray["description"]; ?><br/>
			<b>Knowledge Unit Name:</b><?php echo $objectiveArray["knowledgeUnitName"]; ?><br/>
			<b>ACM Objective:</b><?php $result = ($objectiveArray["isACMObjective"]==1) ? "Yes" : "No"; echo $result; ?><br/>
<?php 
		}
	}
}

echo endcolumn2();
echo footer();
echo endHtml();