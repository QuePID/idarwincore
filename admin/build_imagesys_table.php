<?php
/*IDarwinCore version 1.0
  By Robert R. Pace <robert.pace@eku.edu>
  
  This database software is designed for natural
  history collections utilizing Darwin Core Archive
  data for online querying of the collection's data
  
  This file (build_imagesys_table.php) creates a new table
  called imagesys which is the product of the occurrences and images table.
  This table is populated by records from occurrences and images table joined
  where coreid of images table matches the id of occurrences table.
*/

//include connect.php which has the MySQL credentials along with db name to be selected
include("connect.php");

//query to delete table imagesys if it exists
$delquery = "DROP TABLE if exists imagesys";

//run the above query string through MySQL and thus delete the imagesys table should it exist
$resultdelquery = mysqli_query($conn, $delquery) or die("MySQL Error in deletion of imagesys table..." . (mysqli_error($conn)));


//build a query string that will create a new table which will be records from images table and occurrences table joined where the coreid of
//the images table matches the id of the occurrences table
$query = "CREATE TABLE `imagesys` SELECT * FROM `occurrences`, `images` WHERE `images`.coreid=`occurrences`.id";

//Build a query string because we need to replace image_service within the urls found n the identifier field with data_service, as data_service urls return xml data
$query2 = "UPDATE `imagesys` SET identifier=REPLACE(identifier, 'image_service', 'data_service')";

//build query string which will remove the image size and format portion of the urls stored in the identifier field as these are not needed for data_service calls
$query3 = "UPDATE `imagesys` SET identifier=REPLACE(identifier, '?resize=4000&format=jpeg', '')";

//build a query string which will add an index on catalogNumber field
$query4 = "ALTER TABLE `imagesys` ADD INDEX `catalogNumber` (`catalogNumber`)";

if ((file_exists($dwcaoccurrences)) && (file_exists($dwcaimages))) {
	//run the query string through MySQL and check for any errors
	$result = mysqli_query($conn, $query) or die("MySQL Error in creation of imagesys table...." . mysqli_error($conn));

	//run the above query string through MySQL and check for errors
	$result2 = mysqli_query($conn, $query2) or die("MySQL Error in converting links from image service to data service in identifier field...." . mysqli_error($conn));

	//run the above query string through MySQL and check for errors
	$result3 = mysqli_query($conn, $query3) or die("MySQL Error in image formatting from identifier field...." . mysqli_error($conn));

	//run the above query string through MySQL and check for errors
	$result4 = mysqli_query($conn, $query4) or die("MySQL Error in adding index to catalogNumber field...." . mysqli_error($conn));

	//let the user know the script has concluded
	echo "<h3><center><strong><i>Imagesys Table</i> was populated.</strong></h3></center>";

	//ensure that the above echo statement is delivered promptly to the screen and not delayed
	ob_flush();
	flush();

} else {
	echo "<h3><center><strong>Could not construct <i>imagesys</i> table as <i>Occurrences</i> and or <i>Images</i> file(s) were not present in the DWCA folder</strong></center></h3>";

	//ensure that the above echo statement is delivered promptly to the screen and not delayed
	ob_flush();
	flush();
}
?>