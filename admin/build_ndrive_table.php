<?php
/*iDarwinCore version 1.1
  By Robert R. Pace <robert.pace@eku.edu>
  
  This database software is designed for natural
  history collections utilizing Darwin Core Archive
  data for online querying of the collection's data
  
  This file (build_ndrive_table.php) is the heart of the IDarwinCore
  package, it is used for output of MySQL database records and
  is utilized by many other PHP files.
*/

//the include files:
//header.php - this contains the html header information such as university banner and icon along with title text
//common.php - this contains global variables that are needed for formatting or shaping queries (such as the maximum number of query results via LIMIT)
//connect.php - this contains the connection settings for the MySQL database (such as Db name, username, password, server)
//footer.php - this contains the information to be displayed at the bottom of the page (copyright, version)
//


include_once("connect.php");
include_once("common.php");
include_once("functions.php");

//select the database we are going to be using
mysqli_select_db($conn, $dbname);

//drop table
dwca_drop_table('ndrive', $conn);

//build a query that will create the ndrive table
$createquery = "CREATE TABLE IF NOT EXISTS ndrive (file VARCHAR(255), ncatalogNumber VARCHAR(16))";

//execute the query via MysQL that will drop the table
$createresults = mysqli_query($conn, $createquery) or die("MySQL Error in creating the ndrive table..." . (mysqli_error($conn)));

//build a query string that will have MySQL load Data from a file into the ndrive table
$query1 = "LOAD DATA INFILE \"$ndrivejpegs\" INTO TABLE ndrive FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"' LINES TERMINATED BY \"$lterms\"";

//load ndrive table
load_dwca_table($ndrive, $query1, 'ndrive', $conn);

//add indexes
idarwincore_add_index('ndrive', 'ncatalogNumber', $conn);

?>
