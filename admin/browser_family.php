<?php
/*iDarwinCore version 1.1
  By Robert R. Pace <robert.pace@eku.edu>
  
  This database software is designed for natural
  history collections utilizing Darwin Core Archive
  data for online querying of the collection's data
  
  This file (browser_family.php) displays a list of all the taxonomic
  families within the collection.  It then allows one to select from a
  list of families, and outputs a list of all genera belonging to that family
  which is also selectable.
*/

//the include files:
//header.php - this contains the html header information such as university banner and icon along with title text
//common.php - this contains global variables that are needed for formatting or shaping queries (such as the maximum number of query results via LIMIT)
//connect.php - this contains the connection settings for the MySQL database (such as Db name, username, password, server)
//footer.php - this contains the information to be displayed at the bottom of the page (copyright, version)
//

//display the html header
include_once("header.php");

// connect to database.
include("connect.php");

//load the global variables
include("common.php");

//initialize $row_count, this variable will hold the number of rows returned by the query
//and will be used to color resultant rows
$row_count = 0;
//
// Statistics
//

//Count the number of unique families within the collection
$famresults = mysqli_query($conn, "SELECT COUNT(DISTINCT family) AS family FROM occurrences");
$stats_f = mysqli_fetch_assoc($famresults);
$statsf = $stats_f['family'];
//Count the number of unique genera within the collection
$genresults = mysqli_query($conn, "SELECT COUNT(DISTINCT family, genus) AS genus FROM occurrences");
$stats_g = mysqli_fetch_assoc($genresults);
$statsg = $stats_g['genus'];
//count the number of unique species within the collection
$speresults = mysqli_query($conn, "SELECT COUNT(DISTINCT family, genus, specificEpithet) AS specificEpithet FROM occurrences");
$stats_s = mysqli_fetch_assoc($speresults);
$statss = $stats_s['specificEpithet'];
//count the total number of records within the collection
$totresults = mysqli_query($conn, "SELECT COUNT(*) AS Total FROM occurrences");
$stats_t = mysqli_fetch_assoc($totresults);
$statst = $stats_t['Total'];

//Build a query string that will display unique families
$query = "SELECT DISTINCT family from occurrences ORDER BY family";

// submit the query
$result = mysqli_query($conn, $query) or die("MS-Query Error in select-query");

//calculate number of results of the query ran and display
$querystats=mysqli_num_rows($result); 

//Display statistics
echo "<br><center><p><b>This database houses $statsf plant families, $statsg genera, and $statss species, totaling $statst specimens. </b></p></center><br>";

//Start a HTML Table for results
echo '<center><table style="border-collapse: collapse;">';

// displaying results in a HTML Table
echo "<tr><td bgcolor=$color3><b>Family</b></td></tr>";

//initialize $resultcounter variable
$resultcounter=1;

// for every result returned from query do the below

while ($row = mysqli_fetch_array($result))
{

// determine row colour
$row_color = ($row_count % 2) ? $color1 : $color2;

// prepare url for genera browsing
$genurl = "$urlthree"."browser_genera.php"."?"."family="."$row[family]";

//
// Now display actual data in the table cells via echo to browser of the $row's array of data
   echo "<tr><td bgcolor=$row_color><a href='$genurl'><b>$row[family]</b></a></td></tr>";
      $resultcounter++;
   
   // Add 1 to the row count
   $row_count++;

}
// close the table
echo "</table></center>";

//display footer
include_once("footer.php");
?>
</div>

</body>
</html>
