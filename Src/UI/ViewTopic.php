<?php
include_once 'TopicCRUD.php';

session_start();
if(isset($_GET["id"]))
{
	if(is_numeric($_GET["id"]) )
	{
		$topicId = $_GET["id"];
		$topicArray = getTopicById($topicId);
		if(!empty($topicArray))
		{
?>
			<h3>Topic</h3><hr/>
			<b>Topic Description:</b><?php echo $topicArray["description"]; ?><br/>
			<b>Knowledge Unit Name:</b><?php echo $topicArray["knowledgeUnitName"]; ?><br/>
			<b>ACM Topic:</b><?php $result = ($topicArray["isACMTopic"]==1) ? "Yes" : "No"; echo $result; ?><br/>
<?php 
		}
	}
}