<?php
include_once 'AssessmentCRUD.php';
include_once '../../UI/layouts/adminmenu.php';
include_once '../../UI/layouts/body.php';
include_once '../../UI/layouts/header.php';
include_once '../../UI/layouts/footer.php';
include_once '../../UI/layouts/HTMLHelper.php';

session_start();
$courseOfferingId = 0;
if(isset($_POST['querystring']))
{
	$params = array();
	parse_str($_POST['querystring'], $params);
	$params['state'] = 1;
	$params['creatorBannerId'] = $_SESSION['id'];
	$tUnixTime = time();
	$sGMTMySqlString = gmdate("Y-m-d H:i:s", $tUnixTime);
	$params['date'] = $sGMTMySqlString;
	if(!empty($params['assessmentTypeId']) && !empty($params['name']) && !empty($params['description']))
	{
		$val = insertAssessment($params);
		if($val == 1)
		{
			echo 'Assessment Entered';
		}
		else 
		{
			echo 'Assessment Not Entered';
		}
	}
	exit;
}
if(isset($_GET['id']))
{
	echo beginHtml("Assessment");
	echo headerbar();
	echo tutormenu();
	echo startcolumn2();
	$courseOfferingId = $_GET['id'];
?>
<script type="text/javascript" src="JQuery.js"></script>
<script type="text/javascript">
function putAssessment()
{
	$('#courseDiv').hide();
	var querystring = $('#AddAssessment').serialize();
	$.post('CreateAssessment.php',{querystring: querystring},function(output){
		 $('#courseDiv').html(output).fadeIn(1000);
		});	
}
</script>

<div id="courseDiv"></div>
<form name="AddAssessment" id= "AddAssessment">
<input type="hidden" name="courseOfferingId" value="<?php echo $courseOfferingId;?>">
Assessment Type:<br/>
<select name="assessmentTypeId">
<option value="1">Assignment</option>
<option value="2">Mid Term</option>
<option value="3">Final</option>
</select><br/>

Name:<br/>
<input type="text" name="name" size="30" maxlength="80" value="" id="name"/><br/>

Description:<br/>
<textarea name="description" rows="3" cols="40" id="description"></textarea><br/>

<input type="button" name="submitCourse" value="Enter Assessment" onclick="putAssessment();" /><br/>
</form>
<?php 
echo endcolumn2();
echo footer();
echo endHtml();
}

if(empty($_GET['id']))
{
	header("Location: MyCourses.php");
}
?>