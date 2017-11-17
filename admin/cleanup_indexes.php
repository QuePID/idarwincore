<?php
include_once("common.php");
include_once("connect.php");
include_once("header.php");
include_once("functions.php");

$row_count = '1';

$indexlistquery = "SELECT DISTINCT TABLE_NAME, INDEX_NAME FROM INFORMATION_SCHEMA.STATISTICS WHERE TABLE_SCHEMA = 'idarwincore';";
$indexresult=mysqli_query($conn,$indexlistquery) or die ('MySQL Error: ' . mysqli_error($conn));

//echo "<br><center><table>";
//echo "<tr><td bgcolor=$color3><center><strong>Table Name</strong></center></td><td bgcolor=$color3><center><strong>Index Name</strong></center></td></tr>";

while ($myindexes = mysqli_fetch_array($indexresult, MYSQLI_ASSOC)) {
	$row_color = ($row_count % 2) ? $color1 : $color2;
  idarwincore_delete_indexes($myindexes, $row_color, $conn);
	$row_count++;
	}

echo "</table></center>";
include_once("footer.php");
?>