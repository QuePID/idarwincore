<!DOCTYPE html>
  <html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Species Distribution Map</title>
    <style>
      #map {
        height: 100%;
      }
        html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>
  </head>
  <body>
    <div id="map"></div>

<script>
function initMap() {
var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 5,
    center: {lat: 38.9, lng: -94.7},
    mapTypeId: 'terrain'
});

<?php
//IDC_Distribution_Map
//v 1.0
//by Robert R. Pace
//robertrpace@gmail.com
//
//This code will display a map highlighting a county as a polygon on a google map.
//The main purpose of this code is to pass it a list of counties to which it will display county polygons on a map.
//This list of counties passed to this PHP will be generated from another PHP that generates a list of unique counties
//to which a specific taxa have been found.


//we need to include the connect.php which has all the MySQL connection information
include("connect.php");

//import the values chosen from the form in search.php and process them against nulls and bad characters then store them in variables

//Create variables that will house the GET values, which are then checked to see if 
//they contain a value, if not then set them as NULL.

//$DKstate = (isset($_GET['stateProvince']) ? $_GET['stateProvince'] : null);
$DKfips = (isset($_GET['fips']) ? $_GET['fips'] : null);
$DKbfips = (isset($_GET['bfips']) ? $_GET['bfips'] : null);

//clean the variable against any malicious code injection
$fips = mysqli_real_escape_string($mysqli, $DKfips);
$bfips = mysqli_real_escape_string($mysqli, $DKbfips);

//explode string into an array
$fipslist = explode(",", $fips);
$bfipslist = explode(",", $bfips);

//count how many counties are in the array
$fipscount = count($fipslist);
$bfipscount = count($bfipslist);

//set a counter for while looping
$numfips = '0';
$numbfips = '0';

//this while loop will start at zero and end at $countycount to ensure that every county is processed
while ($numfips < $fipscount) {

	//this is the name of the county currently being processed
        $processfips = @$fipslist[$numfips];
  	
	//build query string using the currently designated county (courtesy of the $processcounty variable)
	$query = "SELECT * FROM `counties` WHERE (stateProvince = \"$state\") AND (`fips` = \"$processfips\")";
	//Retrieve results of query from MySQL Server
	$result = mysqli_query($conn, $query) or die("MySQL Error..." . (mysqli_error($conn)));

	//how many rows were returned? (should be only 1)
	$rowcount = mysqli_num_rows($result);

	//define two arrays for latitude and longitude
	$latitude = array();
	$longitude = array();

	//while there are results from MySQL do the following with each
	while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)){
	
	// store the mysql column "coordinates" data in the $coordstring variable
	$coordstring = $row["coordinates"];
    // Parse individual elements of the coordinates string into an array
	$coordinates = explode("," , $coordstring);
    // how big is our array?
	$size = count($coordinates) ;
    // set a counter which we will use to read every element of the coordinates
	$counter = 0;

		// read precisely the number of coordinate elements and parse the coordinate elements into either longitude or latitude (the coordinates string always starts with longitude then latitude)
		while ($size > $counter ){
			// if the coordinates are divisible by 2 then they are even (remember that elements start at 0 in array
			if ($counter %2 == 0) {
				//this section of the if statement deals with the even number results (which is longitude)
				//set the longitude array to the even numbered elements
				$longitude[] = $coordinates[$counter];
				// finished with this element, time to increment counter and run the loop again for the next value
				$counter++;
			} else { 
				//this section of the if statement deals with the odd number elements (which are the latitude elements)
				// set the latitude array to the odd numbered element
				$latitude[] = $coordinates[$counter];
				// finished with this element time to increment counter and run the loop again with the next value
				$counter++ ;
		}  
		}
	}

//This section will build the code necessary for Google Map API to draw the counties polygons.
//define halfsize to hold the number of coordinate pairs (lat/long) from the county coordinate data
$halfsize = (count($coordinates)/2);

//define a counter which we will use to build all necessary lat/long coordinate pairs
$counter2 = 0;

//this line defines the variable which holds the coordinates needed to draw the county polygon via Google Map API
echo "var fips" . $numfips . " = [\n";

	//while the counter is less than the number of coordinate lines needed repeat.
	while ($counter2 < $halfsize) {
		//start by building the properly formated latitudes (should look like {lat: 37.2195, long: -84.7192},)
		echo "\t{lat: " . $latitude[$counter2] . ", ";
		//add on the longitude value and close with a curly brace and new line character
		echo "lng: " . $longitude[$counter2] . "},\n";
		//done with one line, increment counter and repeat until finished
		$counter2++;
	}
//ths line closes the var county1 tag with a new line character
echo "];\n\n";

//increment the numcounties variable so we can go back and repeat while loop with new value
$numfips++;
}

//start a new counter to add each county to a layer
$counter4 = '0';

//Create the script code which controls the visual nature of the polygon
while ($counter4 < $fipscount) {
	
	//defines new county list (eg county1, county2, county3) array so we can display as (eg county1, county2, county3)
	$fipslist[] = $fips[$counter4];
    //create new map polygon
	echo "var fipspoly" . $counter4 . " = new google.maps.Polygon({\n";	
	echo "\tpaths: " . "fips" . $counter4 . ",\n";
    echo "\tstrokeColor: '#000000',\n";
    echo "\tstrokeOpacity: 1,\n";
    echo "\tstrokeWeight: 2,\n";
    echo "\tfillColor: '#5E213B',\n";
    echo "fillOpacity: 0.35\n";
	echo "});\n\n";
	//add the county track path to the actual map
	echo "fipspoly" . $counter4 . ".setMap(map);\n\n";
	$counter4++;
	//close the first while loop (processing of counties)
}

// *********************************** Replicate Looping Above For Background Fips ************************************

//this while loop will start at zero and end at $countycount to ensure that every county is processed
while ($numbfips < $bfipscount) {

	//this is the name of the county currently being processed
	$processbfips = @$bfipslist[$numbfips];
  	
	//build query string using the currently designated county (courtesy of the $processcounty variable)
	$bquery = "SELECT * FROM `counties` WHERE `fips` = \"$processbfips\"";
	
	//Retrieve results of query from MySQL Server
	$bresult = mysqli_query($conn, $bquery) or die("MySQL Error..." . (mysqli_error($conn)));

	//how many rows were returned? (should be only 1)
	$browcount = mysqli_num_rows($bresult);

	//define two arrays for latitude and longitude
	$blatitude = array();
	$blongitude = array();

	//while there are results from MySQL do the following with each
	while ($brow = mysqli_fetch_array($bresult,MYSQLI_BOTH)){
	
	// store the mysql column "coordinates" data in the $coordstring variable
	$bcoordstring = $brow["coordinates"];
        // Parse individual elements of the coordinates string into an array
	$bcoordinates = explode("," , $bcoordstring);
        // how big is our array?
	$bsize = count($bcoordinates) ;
        // set a counter which we will use to read every element of the coordinates
	$bcounter = 0;

		// read precisely the number of coordinate elements and parse the coordinate elements into either longitude or latitude (the coordinates string always starts with longitude then latitude)
		while ($bsize > $bcounter ){
			// if the coordinates are divisible by 2 then they are even (remember that elements start at 0 in array
			if ($bcounter %2 == 0) {
				//this section of the if statement deals with the even number results (which is longitude)
				//set the longitude array to the even numbered elements
				$blongitude[] = $bcoordinates[$bcounter];
				// finished with this element, time to increment counter and run the loop again for the next value
				$bcounter++;
			} else { 
				//this section of the if statement deals with the odd number elements (which are the latitude elements)
				// set the latitude array to the odd numbered element
				$blatitude[] = $bcoordinates[$bcounter];
				// finished with this element time to increment counter and run the loop again with the next value
				$bcounter++ ;
		}  
		}
	}

//This section will build the code necessary for Google Map API to draw the counties polygons.
//define halfsize to hold the number of coordinate pairs (lat/long) from the county coordinate data
$bhalfsize = (count($bcoordinates)/2);

//define a counter which we will use to build all necessary lat/long coordinate pairs
$bcounter2 = 0;

//this line defines the variable which holds the coordinates needed to draw the county polygon via Google Map API
echo "var bfips" . $numbfips . " = [\n";

	//while the counter is less than the number of coordinate lines needed repeat.
	while ($bcounter2 < $bhalfsize) {
		//start by building the properly formated latitudes (should look like {lat: 37.2195, long: -84.7192},)
		echo "\t{lat: " . $blatitude[$bcounter2] . ", ";
		//add on the longitude value and close with a curly brace and new line character
		echo "lng: " . $blongitude[$bcounter2] . "},\n";
		//done with one line, increment counter and repeat until finished
		$bcounter2++;
	}
//ths line closes the var county1 tag with a new line character
echo "];\n\n";

//increment the numcounties variable so we can go back and repeat while loop with new value
$numbfips++;
}

//start a new counter to add each county to a layer
$bcounter4 = '0';

//Create the script code which controls the visual nature of the polygon
while ($bcounter4 < $bfipscount) {
	
    //defines new county list (eg county1, county2, county3) array so we can display as (eg county1, county2, county3)
    $bfipslist[] = $bfips[$bcounter4];
    //create new map polygon
    echo "var bfipspoly" . $bcounter4 . " = new google.maps.Polygon({\n";	
    echo "\tpaths: " . "bfips" . $bcounter4 . ",\n";
    echo "\tstrokeColor: '#000000',\n";
    echo "\tstrokeOpacity: 1,\n";
    echo "\tstrokeWeight: 2,\n";
    echo "\tfillColor: '#FFFFFF',\n";
    echo "\tfillOpacity: 0.35 \n";
    echo "});\n\n";
    //add the county track path to the actual map
    echo "bfipspoly" . $bcounter4 . ".setMap(map);\n\n";
    $bcounter4++;
    //close the first while loop (processing of counties)
}
// ************************************************ finished with background fips section **************************************
	// Close up this block of script code
	echo "}\n";

	//close the first script
 echo "</script>\n";	  
?>
    <script async defer src="Put Your Google Maps Javascript API Key Here.">
    </script>
  </body>
</html>
