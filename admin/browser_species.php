<?php
/*IDarwinCore version 1.0
  By Robert R. Pace <robert.pace@eku.edu>
  
  This database software is designed for natural
  history collections utilizing Darwin Core Archive
  data for online querying of the collection's data
  
  This file (browser_species.php) displays a list of
  specific epithets belonging to a particular family and
  genus.  One can then select the particular specific epithet
  and get a list of all records that belong to that family, genus,
  and specific epithet.
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

//get the values for genus and family from the previous php
$browsegenera = mysqli_real_escape_string($mysqli,$_GET['genus']);
$browsefamily = mysqli_real_escape_string($mysqli,$_GET['family']);


//initialize $row_count, this variable will hold the number of rows returned by the query
//and will be used to color resultant rows
$row_count = 0;

//Display return to search link
echo "<center><a href=browser_family.php>Return to Search-by-Family</a><br></center>";

//Build a query string for unique species
$psql = "SELECT DISTINCT specificEpithet FROM `occurrences` WHERE genus = '";
$p2sql = "' ORDER BY specificEpithet ASC";
$query = $psql . $browsegenera .$p2sql;

// submit the query
$result = mysqli_query($conn, $query) or die("MS-Query Error in select-query");

//calculate number of results of the query ran and display
$querystats=mysqli_num_rows($result); 
echo "<center><p><b>Your query returned $querystats results (max queries = $maxsearch)</b></p></center>";

//Start a HTML Table
echo '<center><table style="border-collapse: collapse;">';

// display results in HTML Table
echo "<tr><td bgcolor=$color3><b>Family</td><td bgcolor=$color3><b>Genus</b></td><td bgcolor=$color3><b>Species</b></td><td bgcolor=$color3><b>KY Map</b></td></tr>";

//initialize $resultcounter variable
$resultcounter=1;

// for every result returned from query do the below

while ($row = mysqli_fetch_array($result))
{

// determine row colour
$row_color = ($row_count % 2) ? $color1 : $color2;

// create variable to hold the url to display specimens
$species = "$urlthree"."display.php?family="."$browsefamily"."&genus="."$browsegenera"."&specificEpithet="."$row[specificEpithet]";

// create variable to store the distribution map link for the species
$mapit = "$urlthree"."display_distribution_map_pre.php?genus="."$browsegenera"."&specificEpithet="."$row[specificEpithet]&stateProvince=Kentucky";

//
// Now display actual data in the table cells via echo to browser of the $row's array of data
   echo "<tr><td bgcolor=$row_color><b>$browsefamily<b></td><td bgcolor=$row_color><b>$browsegenera</b></td><td bgcolor=$row_color><a href='$species'>$row[specificEpithet]</a></td><td bgcolor=$row_color><a href=$mapit> Map</a></td></tr>";
   $resultcounter++;
   
   // Add 1 to the row count
   $row_count++;
}
echo "</table></center>";

//display footer
include_once("footer.php");
?>
</div>
<center><a href=browser_genera.php>Return to Search-by-Genus</a></center>
</body>
</html>
