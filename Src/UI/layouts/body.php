<?php
function acmcolumn()
{
	return "<div id=\"columnOne\">
            <h2>ACM DATA</h2>
            <p></p>
            <div id=\"navVertical\">
            <ul>
            <li><a title=\"Knowledge Area\" href=\"../../UI/admin/KnowledgeArea.php\">Knowledge Area</a></li>
            <li><a href=\"../../UI/admin/KnowledgeUnit.php\" title=\"Knowledge Unit\">Knowledge Unit</a></li>
            <li><a href=\"../../UI/admin/LearningObjective.php\" title=\"Learning Objective\">Learning Objectives</a></li>
            <li><a href=\"../../UI/admin/Topic.php\" title=\"Topics\">Topics</a></li>
            </ul></div></div>";
}

function acmcoursecolumn()
{
	return "<div id=\"columnOne\">
            <h2>Department Courses</h2>
            <p></p>
            <div id=\"navVertical\">
            <ul>
            <li><a title=\"View Course\" href=\"../../UI/admin/ViewCourse.php\">View Course</a></li>
            <li><a href=\"../../UI/admin/AddCourse.php\" title=\"Construct Course\">Add Course</a></li>
            <li><a href=\"../../UI/admin/ConstructCourse.php\" title=\"Construct Course\">Construct Course</a></li>
            </ul></div></div>";
}

function acmcourseoffering()
{
	return "<div id=\"columnOne\">
            <h2>Department Course Offering</h2>
            <p></p>
            <div id=\"navVertical\">
            <ul>
            <li><a title=\"View Course\" href=\"../../UI/admin/ViewCourseOffering.php\">View Course Offering</a></li>
            <li><a href=\"../../UI/admin/AddCourseOffering.php\" title=\"Course Offering\">Add Course Offering</a></li>
            </ul></div></div>";
}

function startcolumn2()
{
	return "<div id=\"columnTwo\">";
}

function endcolumn2()
{
	return "</div>";
}
?>