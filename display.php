<?php
/*iDarwinCore version 1.1
  By Robert R. Pace <robert.pace@eku.edu>
  
  This database software is designed for natural
  history collections utilizing Darwin Core Archive
  data for online querying of the collection's data
  
  This file (display.php) is the heart of the IDarwinCore
  package, it is used for output of MySQL database records and
  is utilized by many other PHP files.
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

//initialize variables
$row_count = '1';
$srow_count = '1';
$ssrow_count = '1';
$sssrow_count = '1';
$DKcollectors = '';
$DKimage = '';
$DKicon = '';
$DKgenus = '';
$DKspecies = '';
$DKstate = '';
$DKcounty = '';
$DKfamily = '';
$DKlocality = '';
$DKaccession = '';
$DKcollector = '';
$DKcollno = '';
$DKbarcode = '';
$DKsort = '';
$DKthumbnail ='';
$qscientificname ='';
$annotated ='';
//import the values chosen from the form in search.php and process them against nulls and bad characters then store them in variables

//Create variables that will house the GET values, which are then checked to see if 
//they contain a value, if not then set them as NULL.

$DKgenus = (isset($_GET['genus']) ? $_GET['genus'] : null);
$DKspecies = (isset($_GET['specificEpithet']) ? $_GET['specificEpithet'] : null);
$DKstate = (isset($_GET['stateProvince']) ? $_GET['stateProvince'] : null);
$DKcounty = (isset($_GET['county']) ? $_GET['county'] : null);
$DKfamily = (isset($_GET['family']) ? $_GET['family'] : null);
$DKlocality = (isset($_GET['locality']) ? $_GET['locality'] : null);
$DKaccession = (isset($_GET['otherCatalogNumbers']) ? $_GET['otherCatalogNumbers'] : null);
$DKcollector = (isset($_GET['recordedBy']) ? $_GET['recordedBy'] : null);
$DKcollno = (isset($_GET['recordNumber']) ? $_GET['recordNumber'] : null);
$DKbarcode = (isset ($_GET['catalogNumber']) ? $_GET['catalogNumber'] : null);
$DKsort = (isset ($_GET['sort']) ? $_GET['sort'] : null);

//this checks to ensure that the GET information isn't malicious code by passing it through mysqli to strip out
//undesirable code passed to GET

$searchgenus = mysqli_real_escape_string($mysqli,$DKgenus);
$searchspecies = mysqli_real_escape_string($mysqli,$DKspecies);
$searchstate = mysqli_real_escape_string($mysqli,$DKstate);
$searchcounty = mysqli_real_escape_string($mysqli,$DKcounty);
$searchfamily = mysqli_real_escape_string($mysqli,$DKfamily);
$searchlocality = mysqli_real_escape_string($mysqli,$DKlocality);
$searchaccession = mysqli_real_escape_string($mysqli,$DKaccession);
$searchcollector = mysqli_real_escape_string($mysqli,$DKcollector);
$searchcollno = mysqli_real_escape_string($mysqli,$DKcollno);
$searchbarcode = mysqli_real_escape_string($mysqli,$DKbarcode);
$searchsort = mysqli_real_escape_string($mysqli,$DKsort);

//time to build query string from the cleansed variables
//$query = "SELECT * FROM altoccurrences";
$query = "SELECT a.* FROM `occurrences` AS a LEFT JOIN `identifications` AS b ON a.id=b.coreid AND a.scientificName=b.scientificName";
$where = "";

//check to see if searchgenus and searchspecies are empty, if so do nothing further, if both are not blank then build $Qscientificname to hold scientific name

if((strlen($searchgenus) > 1) && ((strlen($searchspecies) > 1))) {
$qscientificname = $DKgenus . ' ' . $DKspecies;
}
//decide whether the field is empty or not, and will prefix the parameters witneded

if($qscientificname) {
    if(strlen($where) > 0) $where .= ' AND';
    $where .= " a.scientificName='$qscientificname'";
    // AND (b.scientificName!='$qscientificname')";
}

if($searchgenus) {
    if(strlen($where) > 0) $where .= ' AND';
    $where .= " a.genus ='$searchgenus'";
}
if($searchspecies) {
    if(strlen($where) > 0) $where .= ' AND';
    $where .= " a.specificEpithet ='$searchspecies'";
}
if($searchstate) {
    if(strlen($where) > 0) $where .= ' AND';
    $where .= " a.stateProvince ='$searchstate'";
}
if($searchcounty) {
    if(strlen($where) > 0) $where .= ' AND';
    $where .= " a.county ='$searchcounty'";
}
if($searchfamily) {
    if(strlen($where) > 0) $where .= ' AND';
    $where .= " a.family ='$searchfamily'";
}
if($searchlocality) {
    if(strlen($where) > 0) $where .= ' AND';
    $where .= " a.locality ='$searchlocality'";
}
if($searchaccession) {
    if(strlen($where) > 0) $where .= ' AND';
    $where .= " a.otherCatalogNumbers ='$searchaccession'";
}
if($searchcollector) {
    if(strlen($where) > 0) $where .= ' AND';
    $where .= " ((a.recordedBy LIKE '%$searchcollector%') OR (a.associatedCollectors LIKE '%$searchcollector%'))";
}
if($searchcollno) {
    if(strlen($where) > 0) $where .= ' AND';
    $where .= " a.recordNumber ='$searchcollno'";
}
if($searchbarcode) {
    if(strlen($where) > 0) $where .= ' AND';
    $where .= " a.catalogNumber ='$searchbarcode'";
}
if($searchsort) {
    if(strlen($where) > 0) $where .= ' Order By';
    $where .= " $searchsort ASC";
}

//build the actual query string
if(strlen($where) > 0) $query = $query . ' WHERE ' . $where;

//echo the query string to screen for debugging
//echo "<br>";
//echo $query;
//echo "<br>";

// submit the query
$result = mysqli_query($conn, $query) or die("MySQL Error..." . (mysqli_error($conn)));

//calculate number of results of the query ran and display
$querystats=mysqli_num_rows($result); 
echo "<center><p><b>Your query returned $querystats results (max queries = $maxsearch)</b></p></center>";

//Start a HTML Table
echo '<table style="border-collapse: collapse;">';

// display results in HTML Table
echo "<tr><td bgcolor=$color3><b>#</b></td><td bgcolor=$color3><b>ID</td><td bgcolor=$color3><b>Image</b></td><td bgcolor=$color3><b>Taxon</td><td bgcolor=$color3><b>Bar Code</td><td bgcolor=$color3><b>Accession</td><td bgcolor=$color3><b>State</td><td bgcolor=$color3><b>County</td><td bgcolor=$color3><b>Family</b></td><td bgcolor=$color3><b>Genus</b></td><td bgcolor=$color3><b>Species</td><td bgcolor=$color3><b>InfraSpecificEpithet</td><td bgcolor=$color3><b>Taxon Author</td><td bgcolor=$color3><b>Habitat</td><td bgcolor=$color3><b>Locality</td><td bgcolor=$color3><b>Latitude</td><td bgcolor=$color3><b>Longitude</td><td bgcolor=$color3><b>Natural_Areas</td><td bgcolor=$color3><b>Collector</td><td bgcolor=$color3><b>Associated Collectors</td><td bgcolor=$color3><b>Collection_Number</td><td bgcolor=$color3><b>Country</td><td bgcolor=$color3><b>Col_Date</td></tr>";

//initialize $resultcounter variable
$resultcounter="1";

// for every result returned from query do the below

while ($row = mysqli_fetch_array($result))
{

// determine row colour
$row_color = ($row_count % 2) ? $color1 : $color2;

//
//Define the variables that will be output via the table from the row array returned by MySQL query.
//
$DKid = "";
$DKid = "$row[id]";
$DKtaxon = "$row[scientificName]";
$DKbarcode = "$row[catalogNumber]";
$DKkingdom = "$row[kingdom]";
$DKphylum = "$row[phylum]";
$DKclass = "$row[class]";
$DKorder = "$row[order]";
$DKfamily = "$row[family]";
$DKgenus = "$row[genus]";
$DKspecies = "$row[specificEpithet]";
$DKvarietyname = "$row[infraspecificEpithet]";
$DKtaxonauthor = "$row[scientificNameAuthorship]";
$DKaccession = "$row[otherCatalogNumbers]";
$DKstate = "$row[stateProvince]";
$DKcounty = "$row[county]";
$DKhabitat = "$row[habitat]";
$DKlocality = "$row[locality]";
$DKlatitude = "$row[decimalLatitude]";
$DKlongitude = "$row[decimalLongitude]";
$DKcollector1 = "$row[recordedBy]";
$DKacollectors = "$row[associatedCollectors]";
$DKcollectionnumber = "$row[recordNumber]";
$DKcountry = "$row[country]";
$DKcolyear = "$row[year]";
$DKcolmonth = "$row[month]";
$DKcolday = "$row[day]";
$DKnaturalarea = "$row[municipality]";
$DKscientificname = "$row[scientificName]";

//Begin new query of the altimages table for the $DKid matching coreid of altimages table so that we can retrieve
//the thumbnail url and image url
//
// query the id of altoccurrence table against coreid field in altimages table and read the thumbnail url and image url
$subquery = "SELECT * FROM images WHERE coreid = $DKid";
$subresults = mysqli_query($conn, $subquery)  or die ('Could not connect to mysqli: ' . mysqli_error($conn));

while ($srow = mysqli_fetch_array($subresults))
{
if (mysqli_num_rows($subresults) < 1 ) {
	$DKthumbnail = "$urlone"."comingsoon.jpg";
	$DKimage = "$urlone"."comingsoon.jpg";
	$DKicon = "$urlone"."comingsoon.jpg";
}
{		$DKthumbnail = "$srow[thumbnailAccessURI]";
	  $DKimage = "$srow[accessURI]";
    $DKicon = (str_replace('"', "", $DKthumbnail));
}{}
$srow_count++;
}
$BLscientificname = $DKgenus.' '.$DKspecies;
$subsubquery = "SELECT * FROM blockedlist WHERE ScientificName = '$BLscientificname'";
$subsubresults = mysqli_query($conn, $subsubquery)  or die ('Could not connect to mysqli: ' . mysqli_error($conn));

while ($ssrow = mysqli_fetch_array($subsubresults))
{
if (mysqli_num_rows($subsubresults) > 0 ) {

		$DKlocality = "Locality Data is restricted for this specimen";
	  $DKhabitat = "Habitat Data is restricted for this specimen";
	  $DKthumbnail = "$urlone"."comingsoon.jpg";
	  $DKimage = "$urlone"."comingsoon.jpg";
	  $DKicon = "$urlone"."comingsoon.jpg";
}
$ssrow_count++;
}

//catch the $DKthumbnail variable to see if it has value if not then assign the comingsoon.jpg image

//Initialize variables to store urls for more indepth queries
$stateq = "$urlq"."&stateProvince="."$DKstate"."&genus="."$DKgenus"."&specificEpithet="."$DKspecies"."&recordedBy="."$DKcollectors";
$countyq = "$urlq"."county="."$DKcounty"."&stateProvince="."$DKstate"."&family="."$DKfamily"."&genus="."$DKgenus"."&specificEpithet="."$DKspecies"."&recordedBy="."$DKcollectors";

if(empty($DKthumbnail)){
	$DKthumbnail = "$urlone"."comingsoon.jpg";
	$DKimage = "$urlone"."comingsoon.jpg";
	$DKicon = (str_replace('"', "", $DKthumbnail));
}{}
	
//Check to see if this row has annotation info in altidentifications table	
$sssquery="SELECT * FROM `identifications` WHERE coreid=$DKid";

/*$subsubsubresults = mysqli_query($conn, $sssquery)  or die ('Could not connect to mysqli: ' . mysqli_error($conn));
if (mysqli_num_rows($subsubsubresults) > 0 ) {
$annotated='1';
$DKid='*' . $DKid;
}
*/
$sssrow_count++;

//Initialize SPID and then define it as the url to SernecPortal's Occurrences Record Editor
$SPID ='';
$SPID = "http://sernecportal.org/portal/collections/editor/occurrenceeditor.php?occid=" . $DKid;

// Now display actual data in the table cells via echo to browser of the $row's array of data
   echo "<tr><td bgcolor = $row_color>$resultcounter</td>";
   echo "<td bgcolor=$row_color><a href=\"$SPID\">$DKid</a></td>";  
   echo "<td bgcolor=$row_color><a href=\"$DKimage\"><img src=\"$DKicon\"</a></td>";
   echo "<td bgcolor=$row_color><i>$DKgenus $DKspecies $DKvarietyname </i> $DKtaxonauthor</td>";
   echo "<td bgcolor=$row_color>$DKbarcode</td>";
   echo "<td bgcolor=$row_color>$DKaccession</td>";
   echo "<td bgcolor=$row_color><a href=\"$stateq\">$DKstate</a></td>";
   echo "<td bgcolor=$row_color><a href=\"$countyq\">$DKcounty</a></td>";
   echo "<td bgcolor=$row_color>$DKfamily</td>";
   echo "<td bgcolor=$row_color><i>$DKgenus </i></td>";
   echo "<td bgcolor=$row_color><i>$DKspecies</i></td>";
   echo "<td bgcolor=$row_color><i>$DKvarietyname</i></td>";
   echo "<td bgcolor=$row_color>$DKtaxonauthor</td>";
   echo "<td bgcolor=$row_color>$DKhabitat</td>";
   echo "<td bgcolor=$row_color>$DKlocality</td>";
   echo "<td bgcolor=$row_color>$DKlatitude</td>";
   echo "<td bgcolor=$row_color>$DKlongitude</td>";
   echo "<td bgcolor=$row_color>$DKnaturalarea</td>";
   echo "<td bgcolor=$row_color>$DKcollector1</td>";
   echo "<td bgcolor=$row_color>$DKacollectors</td>";
	 echo "<td bgcolor=$row_color>$DKcollectionnumber</td>";
   echo "<td bgcolor=$row_color>$DKcountry</td>";
   echo "<td bgcolor=$row_color>$DKcolyear"."-"."$DKcolmonth"."-"."$DKcolday</td>";
   echo "</tr>";
   
   //flush old values for these variables so the values do not persist in the next loop iteration
   $DKthumbnail ="";
   $DKicon = "";
   $DKimage = "";
   $DKid = "";
   $SPID = "";
   $annotated ='';
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
