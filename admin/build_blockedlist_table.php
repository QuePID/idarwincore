<?php
/*IDarwinCore version 1.0
  By Robert R. Pace <robert.pace@eku.edu>
  
  This database software is designed for natural
  history collections utilizing Darwin Core Archive
  data for online querying of the collection's data
  
  This file (build_blockedlist_table.php) is the heart of the IDarwinCore
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

//build a query that will delete the blockedlist table
$dropquery = "DROP TABLE IF EXISTS blockedlist";

//build a query that will create the blockedlist table
$createquery = "CREATE TABLE IF NOT EXISTS blockedlist (Family VARCHAR(255), ScientificName VARCHAR(255), ScientificNameAuthorship VARCHAR(255), TaxonID INT(12))";

//execute the query via MysQL that will drop the table
$dropresults = mysqli_query($conn, $dropquery) or die("MySQL Error in deleting the ndrive table..." . (mysqli_error($conn)));

//execute the query via MysQL that will create the table
$createresults = mysqli_query($conn, $createquery) or die("MySQL Error in creating the ndrive table..." . (mysqli_error($conn)));

//build a query string that will have MySQL load Data from a file into the blockedlist table
$query1 = "LOAD DATA INFILE \"$blockedlist\" INTO TABLE blockedlist FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"' LINES TERMINATED BY \"\n\"";

//this query string will add an index on ScientificName field
$query2 = "ALTER TABLE `blockedlist` ADD INDEX `ScientificName` (`ScientificName`)";

//execute the query through MySQL that will insert ndrive_jpegs_with_paths.txt file into the ndrive table
if (file_exists($blockedlist)) {
	$result1 = mysqli_query($conn, $query1) or die ('Could not connect to mysqli (loading blockedlist): ' . mysqli_error($conn));

	//execute the query through MySQL that will insert blockedlist.csv file into the blockedlist table

	//execute the query through MySQL that will add an index (ScientificName) to blockedlist table
	$result2 = mysqli_query($conn, $query2) or die ('Could not connect to mysqli (adding index on ScientificName field): ' . mysqli_error($conn));

	//let the user know the process has concluded
	echo "<h3><center><strong><i>BlockedList<i> Table was populated.</strong></center></h3>";

	//flush the buffers so that the above echo command appears before the mysql queries
	ob_flush();
	flush();

} else {
	echo "<center><strong>Skipping the addition of <i>Blocked</i> Table as file isn't present in <i>dwca</i> folder</strong></center>";
//flush the buffers so that the above echo command appears before the mysql queries
ob_flush();
flush();
}

?>
