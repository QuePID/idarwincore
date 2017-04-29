<?php
/*IDarwinCore version 1.0
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


include("connect.php");
include("common.php");

//select the database we are going to be using
mysqli_select_db($conn, $dbname);

//build a query that will delete the ndrive table
$dropquery = "DROP TABLE IF EXISTS ndrive";

//build a query that will create the ndrive table
$createquery = "CREATE TABLE IF NOT EXISTS ndrive (file VARCHAR(255), ncatalogNumber VARCHAR(16))";

//execute the query via MysQL that will drop the table
$dropresults = mysqli_query($conn, $dropquery) or die("MySQL Error in deleting the ndrive table..." . (mysqli_error($conn)));

//execute the query via MysQL that will drop the table
$createresults = mysqli_query($conn, $createquery) or die("MySQL Error in creating the ndrive table..." . (mysqli_error($conn)));

//build a query string that will have MySQL load Data from a file into the ndrive table
$query1 = "LOAD DATA INFILE \"$ndrivejpegs\" INTO TABLE ndrive FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"' LINES TERMINATED BY \"$lterms\"";

//this query string will add an index on ncatalogNumber field
$query2 = "ALTER TABLE `ndrive` ADD INDEX `ncatalogNumber` (`ncatalogNumber`)";

//execute the query through MySQL that will insert ndrive_jpegs_with_paths.txt file into the ndrive table
if (file_exists($ndrive)) {
	$result1 = mysqli_query($conn, $query1) or die ('Could not connect to mysqli (loading ndrive): ' . mysqli_error($conn));

	//execute the query through MySQL that will insert ndrive_jpegs_with_paths.txt file into the ndrive table

	//execute the query through MySQL that will add an index (ncatalogNumber) to ndrive table
	$result2 = mysqli_query($conn, $query2) or die ('Could not connect to mysqli (adding index on ncatalogNumber field): ' . mysqli_error($conn));

	//let the user know the process has concluded
	echo "<h3><center><strong><i>Ndrive Table</i> was populated.</strong></center></h3>";

	//flush the buffers so that the above echo command appears before the mysql queries
	ob_flush();
	flush();

} else {
	echo "<center><strong>Skipping the addition of ndjpegs table as file isn't present in <i>dwca</i> folder</strong></center>";
//flush the buffers so that the above echo command appears before the mysql queries
ob_flush();
flush();
}


?>
