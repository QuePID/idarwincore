<?PHP
/*iDarwinCore version 1.1
  By Robert R. Pace <robert.pace@eku.edu>
  
  This database software is designed for natural
  history collections utilizing Darwin Core Archive
  data for online querying of the collection's data
  
  This file (fgsi_count.php) shows the number of distinct (unique) records based family/genus/species/infraspecific epithet
  
*/

//the include files:
//header.php - this contains the html header information such as university banner and icon along with title text
//common.php - this contains global variables that are needed for formatting or shaping queries (such as the maximum number of query results via LIMIT)
//connect.php - this contains the connection settings for the MySQL database (such as Db name, username, password, server)
//footer.php - this contains the information to be displayed at the bottom of the page (copyright, version)
//

//connect to database.
include("connect.php");

//load the global variables
include("common.php");

//display the html header
include("header.php");

//initialize row count (used by $row_color)
$row_count = '1';

//build query strings
$fcnt_query = "SELECT `family`, `genus`, `specificEpithet`, `infraspecificEpithet`, count(*) AS count FROM `imagesys` GROUP BY `family`, `genus`, `specificEpithet`, `infraspecificEpithet`";

//fetch query results
$fresult = mysqli_query($conn, $fcnt_query)  or die ('Could not connect to mysqli (fcnt_query): ' . mysqli_error($conn));

//Start a HTML Table
echo '<br><br><center><strong><h2><u>Inventory of Specimens</u></h2></strong></center><br>';
echo '<center><table style="border-collapse: collapse;"></center>';
echo "<tr bgcolor=$color3><td><strong>Family</strong></td><td><strong><center>Genus</center></strong></td><td><center><strong>Specific Epithet</center></strong></td><td><center><strong>Infraspecific Epithet</center></strong></td><td><center><strong> Count </center></strong></td></tr>";

while ($frows = mysqli_fetch_array($fresult)) { 
// determine row colour
$row_color = ($row_count % 2) ? $color1 : $color2;

//set empty variables to hyphen
if(empty($frows[0])) {$frows[0] = "-";}
if(empty($frows[1])) {$frows[1] = "-";}
if(empty($frows[2])) {$frows[2] = "-";}
if(empty($frows[3])) {$frows[3] = "";}

//populate table based on mysql results
echo "<tr bgcolor=$row_color><td><strong>$frows[0]</strong></td><td><strong><center><i>$frows[1]</i></center></strong></td><td><strong><center><i>$frows[2]</i></center></strong></td><td><strong><center><i>$frows[3]</i></center></strong></td><td><strong><center>$frows[4]</center></strong></td></tr>";

//flush table to browser
ob_flush();
flush();

//increment row_count
$row_count++;
}

//close table
echo "</table>";

include("footer.php");

?>
