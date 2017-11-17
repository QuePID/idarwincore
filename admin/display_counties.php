<?php
/*iDarwinCore version 1.1
  By Robert R. Pace <robert.pace@eku.edu>
  
  This database software is designed for natural
  history collections utilizing Darwin Core Archive
  data for online querying of the collection's data
  
  This file (display_counties.php) produces a county records
  list given a state and genus & specific epithet.
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

//import the values chosen from the form in search_counties.php and process them against nulls and bad characters then store them in variables

//Create variables that will house the GET values, which are then checked to see if 
//they contain a value, if not then set them as NULL.

$IKgenus = (isset($_GET['genus']) ? $_GET['genus'] : null);
$IKspecies = (isset($_GET['specificEpithet']) ? $_GET['specificEpithet'] : null);
$IKfamily = (isset($_GET['family']) ? $_GET['family'] : null);
$IKstate = (isset($_GET['stateProvince']) ? $_GET['stateProvince'] : null);

//initialize variables
$browsefamily ='';


//this checks to ensure that the GET information isn't malicious code by passing it through mysqli to strip out
//undesirable code passed to GET

$searchgenus = mysqli_real_escape_string($mysqli,$IKgenus);
$searchspecies = mysqli_real_escape_string($mysqli,$IKspecies);
$searchstate = mysqli_real_escape_string($mysqli,$IKstate);
$searchfamily = mysqli_real_escape_string($mysqli,$IKfamily);

//time to build query string from the cleansed variables
$query = "SELECT DISTINCT county FROM occurrences";
$where = "";

//these statements decide whether the field is empty or not, and will prefix the parameters with AND if needed
if($searchgenus) {
    if(strlen($where) > 0) $where .= ' AND';
    $where .= " genus ='$searchgenus'";
}
if($searchspecies) {
    if(strlen($where) > 0) $where .= ' AND';
    $where .= " specificEpithet ='$searchspecies'";
}
if($searchstate) {
    if(strlen($where) > 0) $where .= ' AND';
    $where .= " stateProvince ='$searchstate'";
}
if($searchfamily) {
    if(strlen($where) > 0) $where .= ' AND';
    $where .= " family ='$searchfamily'";
}

//build the actual query string
if(strlen($where) > 0) $query = $query . ' WHERE ' . $where  . ' Order by county ASC';


//initialize $row_count, this variable will hold the number of rows returned by the query
//and will be used to color resultant rows
$row_count = 0;


//echo the query string to screen for debugging
//echo "<br>";
//echo $query;
//echo "<br>";


// submit the query
$result = mysqli_query($conn, $query) or die("MS-Query Error in select-query");

//calculate number of results of the query ran and display
$querystats=mysqli_num_rows($result); 
echo "<center><p><b>Your query returned $querystats results (max queries = $maxsearch)</b></p></center>";
echo "<center><p><b>Found $searchgenus $searchspecies within the following counties of $searchstate:</b></p></center>";

//Start a HTML Table
echo '<table style="border-collapse: collapse;" align=center>';
// display results in HTML Table
echo "<tr><td bgcolor=$color3><b>Counties</td></tr>";

//initialize $resultcounter variable
$resultcounter=1;

// for every result returned from query do the below

while ($row = mysqli_fetch_array($result))
{

// determine row colour
$row_color = ($row_count % 2) ? $color1 : $color2;

//
//Define the variables that will be output via the table from the row array returned by MySQL query.
//
$species = "\"$urlthree"."display.php?family="."$browsefamily"."&genus="."$searchgenus"."&specificEpithet="."$searchspecies"."&stateProvince="."$IKstate"."&county="."$row[county]\"";
//echo "$species <br>";

// Now display actual data in the table cells via echo to browser of the $row's array of data
   echo "<td bgcolor=$row_color><b><a href=$species</a>$row[county]</b></td>";
   echo "</tr>";
   $resultcounter++;
   
   // Add 1 to the row count
   $row_count++;

}
echo "</table>";

//display footer
include_once("footer.php");
?>
</div>

</body>
</html>
