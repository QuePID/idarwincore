<?php
/*IDarwinCore version 1.0
  By Robert R. Pace <robert.pace@eku.edu>
  
  This database software is designed for natural
  history collections utilizing Darwin Core Archive
  data for online querying of the collection's data
  
  This file (pager.php) is capable of displaying any MySQL table within the database
  package.
*/

//the include files:
//header.php - this contains the html header information such as university banner and icon along with title text
//common.php - this contains global variables that are needed for formatting or shaping queries (such as the maximum number of query results via LIMIT)
//connect.php - this contains the connection settings for the MySQL database (such as Db name, username, password, server)
//footer.php - this contains the information to be displayed at the bottom of the page (copyright, version)
//

//display the html header
include("header.php");
//set MySQL connection variables
include("connect.php");
//set a variety of global variables needed for iDarwinCore
include("common.php");

//set a variable to hold the name of a mysql table passed to script via url or form action
$tablename = (isset($_GET['tablename']) ? $_GET['tablename'] : null);

//initialize variables
$page = '';
$row_color = '';
$row_count = '';
//check to see if page is set if not start with page 1
if(isset($_GET["page"]))  
	{  
  	$page = $_GET["page"];  
	}  
	else  
	{  
      $page = 1;  
	}  
	
$start_from = ($page-1)*$maxsearch;  
$query = "SELECT * FROM $tablename LIMIT $start_from, $maxsearch";  
$result = mysqli_query($conn, $query);  

echo '<body>';  
echo '<br>';  
$page_query = "SELECT * FROM $tablename";  
$page_result = mysqli_query($conn, $page_query);  
$total_records = mysqli_num_rows($page_result);  
$total_pages = ceil($total_records/$maxsearch);  
echo "<center>";
for($i=1; $i<=$total_pages; $i++)
{  
	echo "<a href='paginator.php?&tablename=$tablename&page=".$i."'>".$i."</a> ";  
}
echo "</center><br>";
echo '<center><table border=1 style="border-collapse: collapse;">';
$fieldnames = mysqli_query($conn,"SHOW COLUMNS FROM $tablename");
echo '<center><tr>';
while($row1 = mysqli_fetch_array($fieldnames))
{
    echo "<td bgcolor=#5B9360><strong><center>$row1[Field]</center></strong></td>";
}
echo '</tr></center>';
while($row = mysqli_fetch_row($result))  
{
	$row_color = ($row_count % 2) ? $color1 : $color2;
	echo '<tr>';
	FOREACH($row AS $cell) echo "<td bgcolor=$row_color>$cell</td>\n";
	echo '</tr>';
	$row_count++;
}  
echo '</table></center>';

$page_query = "SELECT * FROM $tablename"; 
$page_result = mysqli_query($conn, $page_query);
$total_records = mysqli_num_rows($page_result);
$total_pages = ceil($total_records/$maxsearch);
echo "<center><br>";
for($i=1; $i<=$total_pages; $i++)
{  
	echo "<a href='paginator.php?&tablename=$tablename&page=".$i."'>".$i."</a> ";  
}
echo "</center>";
echo '</body>';
echo '</html>';
//display footer
include("footer.php");
?>