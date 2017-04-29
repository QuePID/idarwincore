<?php
/*IDarwinCore version 1.0
  By Robert R. Pace <robert.pace@eku.edu>
  
  This database software is designed for natural
  history collections utilizing Darwin Core Archive
  data for online querying of the collection's data
  
  This file (barcode.php) retrieves the results of occidsearch.php and builds
  a link to the sernecportal page for that occid.
*/

//the include files:
//header.php - this contains the html header information such as university banner and icon along with title text
//common.php - this contains global variables that are needed for formatting or shaping queries (such as the maximum number of query results via LIMIT)
//connect.php - this contains the connection settings for the MySQL database (such as Db name, username, password, server)
//footer.php - this contains the information to be displayed at the bottom of the page (copyright, version)
//

//display the html header
//include_once("header.php");

// connect to database.
include("connect.php");

//load the global variables
include("common.php");

//initialize variables
$DKcatalogNumber = '';

//store the occid passed from occidsearch.php to the variable $DKoccid
$DKcatalogNumber = (isset($_GET['catalogNumber']) ? $_GET['catalogNumber'] : null);

//this checks to ensure that the GET information isn't malicious code by passing it through mysqli to strip out
//undesirable code passed to GET

$searchbarcode = mysqli_real_escape_string($mysqli,$DKcatalogNumber);

$preurl1="http://bisque.iplantcollaborative.org/data_service/image?tag_query=filename:";
$preurl2="*";
$url=$preurl1 . "$DKcatalogNumber" . $preurl2;

//Open url in browser
header("Location: $url");

//display footer
include_once("footer.php");
?>