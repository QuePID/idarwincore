<?php
/*iDarwinCore version 1.1
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
include_once("cleanup_indexes.php");
include_once("functions.php");

echo "<h2><center><strong>This script will import the DWC-A archive files along with the building of several tables including:</strong></center></h2>";
echo "<h3><center><strong><i>Images</i>, <i>Occurrences</i>, <i>Identifications</i>,</strong></center>";
echo "<center><strong><i>Duplicates</i>, <i>noSkeletalRecords</i>, <i>nDrive</i></strong></center></h3>";
echo "<h3><center><strong>This could take a few minutes to complete...</strong></center></h3>";

//flush the buffers so that the above echo command appears before the mysql queries
ob_flush();
flush();

//select the database we are going to be using and clear the four tables
mysqli_select_db($conn, $dbname);
truncate_mysql_table('occurrences', $conn);
truncate_mysql_table('identifications', $conn);
truncate_mysql_table('images', $conn);
truncate_mysql_table('measurementorfact', $conn);

//define queries for loading the four DwC-A files
$queryocc = "LOAD DATA INFILE \"$dwcaoccurrences\" INTO TABLE occurrences COLUMNS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"' ESCAPED BY '\"' LINES TERMINATED BY '\n' IGNORE 1 LINES";
$queryima = "LOAD DATA INFILE \"$dwcaimages\" INTO TABLE images COLUMNS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"' ESCAPED BY '\"' LINES TERMINATED BY '\n' IGNORE 1 LINES";
$queryide = "LOAD DATA INFILE \"$dwcaidentifications\" INTO TABLE identifications COLUMNS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"' ESCAPED BY '\"' LINES TERMINATED BY '\n' IGNORE 1 LINES";
$querymm = "LOAD DATA INFILE \"$measurementorfact\" INTO TABLE measurementOrFact COLUMNS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"' ESCAPED BY '\"' LINES TERMINATED BY '\n' IGNORE 1 LINES";

//load the four tables
load_dwca_table($dwcaoccurrences, $queryocc, 'occurrences', $conn);
load_dwca_table($dwcaidentifications, $queryide, 'identifications', $conn);
load_dwca_table($dwcaimages, $queryima, 'images', $conn);
load_dwca_table($measurementorfact, $querymm, 'measurementorfact', $conn);

//build indices for the tables
if (file_exists($dwcaoccurrences)) {
	idarwincore_add_index('occurrences', 'id', $conn);
	idarwincore_add_index('occurrences', 'catalogNumber', $conn);
}

if (file_exists($dwcaidentifications)) {
	idarwincore_add_index('identifications', 'coreid', $conn);
}

if (file_exists($dwcaimages)) {
	idarwincore_add_index('images', 'coreid', $conn);
	idarwincore_add_index('images', 'identifier', $conn);
}

//the following includes build three tables by calling separate PHP files
if (file_exists($dwcaoccurrences)) {
	include("build_duplicates_table.php");
}

if (file_exists($ndrive)) {
	include("parse_ndrive.php");
}

if (file_exists($iplant_t)) {
	include("parse_iplant.php");
}
if (file_exists($barcodesfile)) {
	include("build_barcodes_table.php");
}

if (file_exists($blockedlist)) {
	include("build_blockedlist_table.php");
}

?>