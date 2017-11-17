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

//Create variables that will house the GET values, which are then checked to see if 
//they contain a value, if not then set them as NULL.
$DKgenus = (isset($_GET['genus']) ? $_GET['genus'] : null);
$DKspecies = (isset($_GET['specificEpithet']) ? $_GET['specificEpithet'] : null);
$DKstate = (isset($_GET['stateProvince']) ? $_GET['stateProvince'] : null);

//ECHO "_GET[stateProvince] = $_GET[stateProvince]<br><br>";

//this checks to ensure that the GET information isn't malicious code by passing it through mysqli to strip out
//undesirable code passed to GET
$searchgenus = mysqli_real_escape_string($mysqli,$DKgenus);
$searchspecies = mysqli_real_escape_string($mysqli,$DKspecies);
$searchstates = mysqli_real_escape_string($mysqli,$DKstate);

//determine how many states we need process
$states = explode(",",$searchstates);
$scount = substr_count($searchstates, ",");

$fipsfinal='';
$counter = 0;
$ccounter = 0;
$fcounter = 0;
$bfcounter = 0;
$bfipsfinal = 0;

while($scount >= $counter) {
	$s1query = "SELECT DISTINCT(county) FROM `occurrences` WHERE (`occurrences`.`stateProvince` = \"$states[$counter]\") AND (genus = \"$searchgenus\") AND (specificEpithet = \"$searchspecies\")";
	$s1results = mysqli_query($conn, $s1query);
	
	while ($row = mysqli_fetch_assoc($s1results)) {
		$counties[$ccounter] = $row['county'];
		$ccounter++;
		}
	
	$s2query = "SELECT DISTINCT(fips) FROM `counties` WHERE (stateProvince = \"$states[$counter]\")  AND (`county` IN ('" . implode("', '", $counties) . "')) ORDER BY fips ASC";
	$s2results = mysqli_query($conn, $s2query);
	
	while ($frow = mysqli_fetch_assoc($s2results)) {
		$fips[$fcounter] = $frow['fips'];
		$fcounter++;
		}
	
	$bfipsquery = "SELECT DISTINCT(fips) FROM `counties` WHERE (stateProvince = \"$states[$counter]\")  AND (`fips` NOT IN ('" . implode("', '", $fips) . "')) ORDER BY fips ASC";
	$bfresults = mysqli_query($conn, $bfipsquery);
	
	while($bfrow = mysqli_fetch_assoc($bfresults)) {
		$bfips[$bfcounter] = $bfrow['fips'];
		$bfcounter++;
		}
	
	$row = '';
	$frow = '';
	$bfrow ='';
	$s1results = '';
	$s2results = '';
	$bfresults = '';
	$bfcounter = '';
	$ccounter = 0;
	$fcounter = 0;
	
	$fipsfinal = $fipsfinal . "," . implode(",", $fips);
	$bfipsfinal = $bfipsfinal . "," . implode(",", $bfips);
	$counter++;
	
}

$fipsfinal = substr($fipsfinal,1);
$bfipsfinal = substr($bfipsfinal,2);
$bfipsfinal = $str = implode(',',array_unique(explode(',', $bfipsfinal)));
$url = $urlthree . 'display_county_map.php?fips=' . $fipsfinal. '&bfips=' . $bfipsfinal;

//create a simple javascript to open the url above in existing web browser window
echo "<script>";
echo "window.open('$url','_self',false);"."PHP_EOL";
echo "</script>";

include_once("footer.php");
?>
