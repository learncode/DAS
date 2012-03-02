<?php
function adminmenu()
{
	return "<div id=\"navHorizontal\"><ul>
            <li><a href=\"../../UI/admin/KnowledgeArea.php\" title=\"ACM Data\">ACM</a></li>
            <li><a href=\"../../UI/admin/ViewCourse.php\" title=\"Course\">Course</a></li>
            <li><a href=\"../../UI/admin/ViewCourseOffering.php\" title=\"Course Offering\">Course Offering</a></li>
            </ul></div>";
}

function tutormenu()
{
	return "<div id=\"navHorizontal\"><ul>
            <li><a href=\"../../UI/public/MyCourses.php\" title=\"Course Offering\">Course Offering</a></li>
            </ul></div>";
}
?>