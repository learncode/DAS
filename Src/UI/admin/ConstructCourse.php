<?php
include_once 'CourseCRUD.php';
include_once 'KnowledgeUnitCRUD.php';
include_once 'LearningObjectiveCRUD.php';
include_once 'TopicCRUD.php';

$courseArray = getAllCourses();
?>
<html>
<head>
<script type="text/javascript" src="JQuery.js"></script>

<script type="text/javascript">
function selectCourse()
{
	document.getElementById('Course').disabled = true;
	document.getElementById('selectArea').style.display = 'block';
	var value = selectcourse.Course.value;
	$.post('AddConstructCourse.php',{name: value});
}

function selectAnotherCourse()
{
	document.getElementById('Course').disabled = false;
}

function getUnits()
{
	var querystring = $('#selectArea').serialize();
	
	$.post('AddCourseArea.php',{querystring: querystring},function(output){
		 $('#unitDiv').html(output);
		});	

	document.getElementById('selectUnit').style.display = 'block';
}

function getObjectives()
{
	var obj = $('#selectUnit').serialize();
	$.post('AddCourseUnit.php',{obj: obj},function(output){
		 $('#LODiv').html(output);
		});	
	document.getElementById('selectObjective').style.display = 'block';
}

function putDetails()
{
	var querystring = $('#selectObjective').serialize();
	$.post('AddCourseStructureData.php',{querystring:querystring}, function(output){ $('#detSum').html(output); });
	document.getElementById('detailSummary').style.display = 'block';
}
</script>
</head>
<body>
<a href="ViewCourse.php">View Courses</a><br/>
<form id="selectcourse" name="selectcourse">
Select Course:<br/>
<select id="Course" name="Course">
<?php 
foreach($courseArray as $key=>$value)
{
?>
	<option value="<?php echo $value->id;?>"><?php echo "CS ".$value->number." - ".$value->name; ?></option>
<?php 
}
?>
</select><br/>
<input type="button" name="submitCourse" value="Select Course" onclick="selectCourse();" />
<input type="button" name="anotherCourse" value="Select Another Course" onclick="selectAnotherCourse();" />
</form>

<form id="selectArea" name="selectArea" style="display: none;">
Select Knowledge Area(s):<br/>
<select id="areas" name="areas" multiple="multiple" size =10>
<?php 
$areaArray = getAllKnowledgeAreas();
foreach ($areaArray as $key=>$value)
{
?>
	<option value="<?php echo $value["id"];?>"><?php echo $value["name"]; ?></option>
<?php 
}
?>
</select><br/>
<input type="button" name="submitArea" value="Select Area" onclick="getUnits();" />
</form>
<form id="selectUnit" name="selectUnit" style="display: none;">
Select Units: <br/>
<div id="unitDiv">
</div>
</form>
<form id="selectObjective" name="selectObjective" style="display: none;">

<div id="LODiv">
</div>
</form>
<form id="detailSummary" name="detailSummary" style="display: none;">
<div id="detSum">
</div>
</form>
</body>
</html>