<?php
/*IDarwinCore version 1.0
  By Robert R. Pace <robert.pace@eku.edu>
  
  This database software is designed for natural
  history collections utilizing Darwin Core Archive
  data for online querying of the collection's data
  
  This file (build_iplant_table.php) is the heart of the IDarwinCore
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

//build a query that will delete the iplant table
$dropquery = "DROP TABLE IF EXISTS iplant";

//build a query that will create the iplant table
$createquery = "CREATE TABLE IF NOT EXISTS iplant (guid VARCHAR(33), ifile VARCHAR(255), barcode VARCHAR(15))";

//execute the query via MysQL that will drop the table
$dropresults = mysqli_query($conn, $dropquery) or die("MySQL Error in deleting the iplant table..." . (mysqli_error($conn)));

//execute the query via MysQL that will drop the table
$createresults = mysqli_query($conn, $createquery) or die("MySQL Error in creating the iplant table..." . (mysqli_error($conn)));

//build a query string that will have MySQL load Data from a file into the iplant table
$query = "LOAD DATA INFILE \"$iplantjpegs\" INTO TABLE iplant FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"' LINES TERMINATED BY \"$lterms\"";

//this query string will fill ncatalogNumber with crude barcode data.  UPDATE iplant SET ncatalogNumber=(substring(file,-18, 14))
$query1 = "UPDATE iplant SET barcode=(substring(ifile,-18, 14))";

//this query string will add an index on guid field
$query2 = "ALTER TABLE `iplant` ADD INDEX `guid` (`guid`)";

//this query string will add an index on ncatalogNumber field
$query3 = "ALTER TABLE `iplant` ADD INDEX `barcode` (`barcode`)";

//execute the query through MySQL that will insert iplantdwca.txt file into the iplant table
if (file_exists($iplant_t)) {
	$result = mysqli_query($conn, $query) or die ('Could not connect to mysqli (loading iplant file): ' . mysqli_error($conn));

	//execute the query through MySQL that will insert iplantdwca.txt file into the iplant table
	$result1 = mysqli_query($conn, $query1) or die ('Could not connect to mysqli (populating barcode field): ' . mysqli_error($conn));
  
  //execute the query string through MySQL that will create an index on guid field
  $result2 = mysqli_query($conn, $query2) or die ('Could not connect to mysqli (adding index on guid): ' . mysqli_error($conn));

  //execute the query string through MySQL that will create an index on guid field
  $result3 = mysqli_query($conn, $query3) or die ('Could not connect to mysqli (adding index on ncatalogNumber): ' . mysqli_error($conn));

	//let the user know the process has concluded
	echo "<h3><center><strong><i>iPlant Table</i> was populated.</strong></center></h3>";

	//flush the buffers so that the above echo command appears before the mysql queries
	ob_flush();
	flush();

} else {
	echo "<center><strong>Skipping the addition of iplant table as file isn't present in <i>dwca</i> folder</strong></center>";
//flush the buffers so that the above echo command appears before the mysql queries
ob_flush();
flush();
}

?>