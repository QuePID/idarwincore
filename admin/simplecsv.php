<?php
/*IDarwinCore version 1.0
  By Robert R. Pace <robert.pace@eku.edu>
  
  This database software is designed for natural
  history collections utilizing Darwin Core Archive
  data for online querying of the collection's data
  
  This file (simplecsv.php) This file allows one to
  import natural history collections data present within
  a Darwin Core Archive zip into IDarwinCore database tables.
  
  It is important that the dwca folder that houses the images.csv,
  occurrences.csv, identifications.csv be located directly from the webserver's
  root folder.  Eg. /www/dwca otherwise MySQL may balk at loading the data files.
  
 The file paths for the DWC-A files should be set in the common.php file
*/
//display the html header on top of the page
//include_once("./header.php");

//include connect.php which holds the necessary credentials for logging into MySQL server to do queries, along with the database name to be selected for use
//include("./connect.php");

//include the common.php file which holds many global variables used in the customization of IDarwinCore
//include("./common.php");

//provide feedback on process by displaying output to the screen
echo "<h2><center><strong>This script will import the DWC-A archive files along with the building of several tables including:</strong></center></h2>";
echo "<h3><center><strong><i>Images</i>, <i>Occurrences</i>, <i>Identifications</i>,</strong></center>";
echo "<center><strong><i>Imagesys</i>, <i>Duplicates</i>, <i>Noskeletalrecords</i>, <i>Ndrive</i>, and <i>Occurrences_full</i></strong></center></h3>";
echo "<h3><center><strong>This could take a few minutes to complete...</strong></center></h3>";

//flush the buffers so that the above echo command appears before the mysql queries
ob_flush();
flush();

//select the database we are going to be using
mysqli_select_db($conn, $dbname);

//truncate (empty) the three tables
//empty the occurrences table
mysqli_query($conn, 'TRUNCATE TABLE occurrences;') or die ('Could not connect to mysqli (truncating occurrences): ' . mysqli_error($conn));

//empty the identifications table
mysqli_query($conn, 'TRUNCATE TABLE identifications;') or die ('Could not connect to mysqli (truncating identifications): ' . mysqli_error($conn));

//empty the images table
mysqli_query($conn, 'TRUNCATE TABLE images;') or die ('Could not connect to mysqli (truncating images): ' . mysqli_error($conn));

//drop indexes on occurrences, identifications, and images tables
mysqli_query($conn, 'ALTER TABLE `occurrences` DROP INDEX `id`') or die ('Could not connect to mysqli (dropping id index on occurrences): ' . mysqli_error($conn));
mysqli_query($conn, 'ALTER TABLE `images` DROP INDEX `coreid`') or die ('Could not connect to mysqli (dropping coreid index on images): ' . mysqli_error($conn));
mysqli_query($conn, 'ALTER TABLE `identifications` DROP INDEX `coreid`') or die ('Could not connect to mysqli (dropping coreid index on identifications): ' . mysqli_error($conn));
mysqli_query($conn, 'ALTER TABLE `occurrences` DROP INDEX `catalogNumber`') or die ('Could not connect to mysqli (dropping catalogNumber index on occurrences): ' . mysqli_error($conn));
mysqli_query($conn, 'ALTER TABLE `images` DROP INDEX `identifier`') or die ('Could not connect to mysqli (dropping identifier index on  images): ' . mysqli_error($conn));


//build query strings that will load datafiles into the tables
//build a query string that will have MySQL load Data from a file into the occurrences table
$query = "LOAD DATA INFILE \"$dwcaoccurrences\" INTO TABLE occurrences COLUMNS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"' ESCAPED BY '\"' LINES TERMINATED BY '\n' IGNORE 1 LINES";

//build a query string that will have MySQL Load Data from a file into the images table

$query2 = "LOAD DATA INFILE \"$dwcaimages\" INTO TABLE images COLUMNS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"' ESCAPED BY '\"' LINES TERMINATED BY '\n' IGNORE 1 LINES";

//build a query string that will have MysQL load Data from a file into the identifications table

$query3 = "LOAD DATA INFILE \"$dwcaidentifications\" INTO TABLE identifications COLUMNS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"' ESCAPED BY '\"' LINES TERMINATED BY '\n' IGNORE 1 LINES";

//build a query string that will add an index to the occurrences table (speeds up queries)
$query4 = "ALTER TABLE `occurrences` ADD INDEX(`id`)";

//build a query string that will add an index to the identifications table (speeds up queries)
$query5 = "ALTER TABLE `identifications` ADD INDEX(`coreid`)";

//build a query string that will add an index to the images table (speeds up queries)
$query6 = "ALTER TABLE `images` ADD INDEX(`coreid`)";

//build a query string that will add an index to the occurrences table (speeds up queries)
$query7 = "ALTER TABLE `occurrences` ADD INDEX `catalogNumber` (`catalogNumber`)";

//build a query string that will add an index to the images table (speeds up queries)
$query8 = "ALTER TABLE `images` ADD INDEX `identifier` (`identifier`)";


//send queries to MySQL and check for potential errors.
if (file_exists($dwcaoccurrences)) {
	//send the query string to MySQL server that causes the loading of the occurrences.csv into the occurrences table and check for any mysql errors
	$result = mysqli_query($conn, $query) or die ('Could not connect to mysqli (loading occurrences): ' . mysqli_error($conn));
	echo "<h3><center><strong><i>Occurrences Table</i> was populated.</i></strong></center></h3>";
	//flush the buffers so that the above echo statement appears immediately and not later.
	ob_flush();
	flush();
} else {
    echo "<h3><center><strong>Skipping the creation of <i>Occurrences</i> Table as the file does not exist within the DWCA folder</h3>";
	//flush the buffers so that the above echo statement appears immediately and not later.
	ob_flush();
	flush();
}
	
if (file_exists($dwcaimages)) {
	//send the query string to MySQL server that causes the loading of the images.csv into the images table and check for any mysql errors
	$result2 = mysqli_query($conn, $query2)  or die ('Could not connect to mysqli (loading images): ' . mysqli_error($conn));
	echo "<h3><center><strong><i>Images</i> Table was populated.</strong></center></h3>";
	//flush the buffers so that the above echo statement appears immediately and not later.
	ob_flush();
	flush();
} else {
    echo "<h3><center><strong>Skipping the creation of <i>Images</i> Table as the file does not exist within the DWCA folder</h3>";
	//flush the buffers so that the above echo statement appears immediately and not later.
	ob_flush();
	flush();
}

if (file_exists($dwcaidentifications)) {
	//send the query string to MySQL server that causes the loading of the identifications.csv into the identifications table and check for any mysql errors
	$result3 = mysqli_query($conn, $query3)  or die ('Could not connect to mysqli (Loading identifications): ' . mysqli_error($conn));
	echo "<h3><center><strong><i>Identifications</i> Table was populated.</strong></center></h3>";
	//flush the buffers so that the above echo statement appears immediately and not later.
	ob_flush();
	flush();
} else {
    echo "<h3><center><strong>Skipping the creation of <i>Identifications</i> Table as the file does not exist within the DWCA folder</h3>";
	//flush the buffers so that the above echo statement appears immediately and not later.
	ob_flush();
	flush();
}

if (file_exists($dwcaoccurrences)) {
	//send queries which will add indices to the tables to speed up queries
	//send the query string that adds an index to the occurrences table and check for any mysql errors
	$result4 = mysqli_query($conn, $query4)  or die ('Could not connect to mysqli (add id index on occurrences): ' . mysqli_error($conn));
	$result7 = mysqli_query($conn, $query7)  or die ('Could not connect to mysqli (add catalogNumber index on occurrences): ' . mysqli_error($conn));
	echo "<h3><center><strong><i>Occurrences</i> Table Index was created.</strong></center></h3>";
	//flush the buffers so that the above echo statement appears immediately and not later.
	ob_flush();
	flush();
} else {
    echo "<h3><center><strong>Skipping the creation of Index for <i>Occurrences</i> Table  as the file does not exist within the DWCA folder</h3>";
	//flush the buffers so that the above echo statement appears immediately and not later.
	ob_flush();
	flush();
}

if (file_exists($dwcaidentifications)) {
	//send the query string that adds an index to the identifications table and check for any mysql errors
	$result5 = mysqli_query($conn, $query5)  or die ('Could not connect to mysqli (add index on identifications): ' . mysqli_error($conn));
	echo "<h3><center><strong><i>Identifications</i> Table Index was created.</strong></center></h3>";
	//flush the buffers so that the above echo statement appears immediately and not later.
	ob_flush();
	flush();
} else {
    echo "<h3><center><strong>Skipping the creation of Index for <i>Identifications</i> Table  as the file does not exist within the DWCA folder</h3>";
	//flush the buffers so that the above echo statement appears immediately and not later.
	ob_flush();
	flush();
}

if (file_exists($dwcaimages)) {
	//send the query string that adds an index to the images table and check for any mysql errors
	$result6 = mysqli_query($conn, $query6)  or die ('Could not connect to mysqli (add index on images): ' . mysqli_error($conn));
	$result8 = mysqli_query($conn, $query8)  or die ('Could not connect to mysqli (add index on images): ' . mysqli_error($conn));
	echo "<h3><center><strong><i>Images</i> Table Index was created.</strong></center></h3>";
	//flush the buffers so that the above echo statement appears immediately and not later.
	ob_flush();
	flush();
} else {
    echo "<h3><center><strong>Skipping the creation of Index for <i>Images</i> Table  as the file does not exist within the DWCA folder</h3>";
	//flush the buffers so that the above echo statement appears immediately and not later.
	ob_flush();
	flush();
}

//the following includes build three tables by calling a php

if (file_exists($dwcaoccurrences)) {
	//build the duplicates and noskeletalrecords tables
	include("build_duplicates_table.php");
} else {
    echo "<h3><center><strong>Skipping the creation of <i>Duplicates</i> Table as the Occurrences file does not exist within the DWCA folder</strong></center></h3>";
	//flush the buffers so that the above echo statement appears immediately and not later.
	ob_flush();
	flush();
}

if (file_exists($ndrive)) {
	//build the ndrive table which houses the nDrive location of all our image files
	include("parse_ndrive.php");
} else {
    echo "<h3><center><strong>Skipping the creation of <i>nDrivejpegs</i> Table  as the file does not exist within the DWCA folder</strong></center></h3>";
	//flush the buffers so that the above echo statement appears immediately and not later.
	ob_flush();
	flush();
}

if (file_exists($iplant_t)) {
	//build the ndrive table which houses the iplant location of all our image files
	include("parse_iplant.php");
} else {
    echo "<h3><center><strong>Skipping the creation of <i>iPlant</i> Table as the file does not exist within the DWCA folder</strong></center></h3>";
	//flush the buffers so that the above echo statement appears immediately and not later.
	ob_flush();
	flush();
}

if ((file_exists($dwcaimages)) && (file_exists($dwcaoccurrences))) {
	//build the imagesys table which is a crossreferenced occurrence and images tables
	include("build_imagesys_table.php");
} else {
    echo "<h3><center><strong>Skipping the creation of <i>Imagesys</i> Table  as the Occurrence (and or) Images file(s) does not exist within the DWCA folder</strong></center></h3>";
	//flush the buffers so that the above echo statement appears immediately and not later.
	ob_flush();
	flush();
}

if ((file_exists($dwcaoccurrences)) && (file_exists($dwcaimages)) && (file_exists($ndrivejpegs))) {
	//build the occurrences_full table which is a cross reference of occurrence table, image table, and ndrive table
	include("build_occurrences_full_table.php");
} else {
    echo "<h3><center><strong>Skipping the creation of <i>images</i> Table as the file does not exist within the DWCA folder</strong></center></h3>";
	//flush the buffers so that the above echo statement appears immediately and not later.
	ob_flush();
	flush();
}

if (file_exists($barcodesfile)) {
	//build the barcodes table which holds all of the collection's barcodes
	include("build_barcodes_table.php");
} else {
    echo "<h3><center><strong>Skipping the creation of <i>barcodes</i> Table as the file does not exist within the DWCA folder</strong></center></h3>";
	//flush the buffers so that the above echo statement appears immediately and not later.
	ob_flush();
	flush();
}

if (file_exists($blockedlist)) {
	//build the blockedlist table which holds a list of specimens for which locality data should be withheld from the general public
	include("build_blockedlist_table.php");
} else {
    echo "<h3><center><strong>Skipping the creation of <i>blockedlist</i> Table as the file does not exist within the DWCA folder</strong></center></h3>";
	//flush the buffers so that the above echo statement appears immediately and not later.
	ob_flush();
	flush();
}

?>