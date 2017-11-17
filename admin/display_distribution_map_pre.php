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
$searchstate = mysqli_real_escape_string($mysqli,$DKstate);

//time to build query string from the cleansed variables
$query = "SELECT DISTINCT(county) FROM occurrences WHERE (stateProvince = \"$searchstate\") and (genus = \"$searchgenus\") and (specificEpithet = \"$searchspecies\")";
//echo "query is $query<br>";

//run the query or die trying
$results = mysqli_query($conn, $query) or die("MySQL Error..." . (mysqli_error($conn)));

//define a new variable counties as an array
$counties = array();
$fips = array();

//define two new counters and set them to zero
$counter = '0';
$counter2 = '0';

//parse all results one by one
while ($row = mysqli_fetch_array($results)) {
    //set the array counties to the result returned
	$counties[$counter] = $row[0];

    //Build a query which will retrieve the fips codes given the state/county name.
	$query2 = "SELECT DISTINCT(fips) FROM `counties` WHERE (stateProvince = \"$searchstate\") and (county = \"$row[0]\")";
	//echo "query2 is $query2<br><br>";
	//retrieve the query results and store in to the rows2 array
	$results2 = mysqli_query($conn, $query2) or die("MySQL Error..." . (mysqli_error($conn)));
    //parse each county name returning the fips code
	while ($row2 = mysqli_fetch_array($results2)){
    //store fips from the mysql results
	$fips[$counter2] = $row2[0];
    //go to the next result returned by mysql until finished
	$counter2++;
	}
	//go to next result returned by mysql until finished
	$counter++;
}
//break the array down into comma separated values which can be stored in $countylist variable
$fipslist = implode(",", $fips);

//filter out double commas in the counties list
$fipslist2 = preg_replace('/,+/', ',', $fipslist);

//strip out any commas at the end of the string
$fipslistfinal = rtrim($fipslist2,',');

// ****************************** repeat the sequence above to generate the bfips list *****************************************
$counter3 = '0';
$counter4 = '0';

$bquery = "SELECT fips FROM `counties` WHERE ((stateProvince = \"$searchstate\") and (fips NOT IN ($fipslistfinal)))";
//echo "bquery is $bquery<br>";

if (empty($fipslistfinal)) {
	echo "<br><br><br><br><center>No occurrence records were found within $searchstate for <b>$searchgenus $searchspecies<b></center><br>";
	} else {
	
	$bresults = mysqli_query($conn, $bquery) or die("MySQL Error... ($bquery)" . (mysqli_error($conn)));

	while ($brow = mysqli_fetch_array($bresults)) {
		//set the array counties to the result returned
		$bfips[$counter3] = $brow[0];
		//go to next result returned by mysql until finished
		$counter3++;
	}
	//break the array down into comma separated values which can be stored in $countylist variable
	$bfipslist = implode(",", $bfips);

	//filter out double commas in the counties list
	$bfipslist2 = preg_replace('/,+/', ',', $bfipslist);

	//strip out any commas at the end of the string
	$bfipslistfinal = rtrim($bfipslist2,',');

	//echo "bfipslistfinal is $bfipslistfinal<br><br><br>";
	//build a url string which will be stored in the $url variable
	$url = $urlthree . 'display_county_map.php?fips=' . $fipslistfinal. '&bfips=' . $bfipslistfinal .'&state='.$searchstate;

	//echo "url is $url<br><br>";
	//Diagnostically dump all defined variables to screen
	//echo '<pre>' . print_r(get_defined_vars(), true) . '</pre>';

	//create a simple javascript to open the url above in existing web browser window
	echo "<script>";
	echo "window.open('$url','_self',false);"."PHP_EOL";
	echo "</script>";
	//echo "fipslistfinal = $fipslistfinal<br";
	//display footer
}

include_once("footer.php");
?>
</div>

</body>
</html>
