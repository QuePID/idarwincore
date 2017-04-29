<?php
/*IDarwinCore version 1.0
  By Robert R. Pace <robert.pace@eku.edu>
  
  This database software is designed for natural
  history collections utilizing Darwin Core Archive
  data for online querying of the collection's data
  
  This file (duplicates.php) creates a new table called
  duplicates.  The duplicates table will house records that
  are not unique by otherCatalogNumber (accession#) within the
  occurrences table.
  
  Records within the newly populated duplicates table that have no
  skeletal record data (only image data) will be moved from duplicates table
  to the noskeletalrecords table
*/

//the include files:
//header.php - this contains the html header information such as university banner and icon along with title text
//common.php - this contains global variables that are needed for formatting or shaping queries (such as the maximum number of query results via LIMIT)
//connect.php - this contains the connection settings for the MySQL database (such as Db name, username, password, server)
//footer.php - this contains the information to be displayed at the bottom of the page (copyright, version)
//

include("connect.php");
include("common.php");

//query to delete table duplicates
$delquery = "DROP TABLE if exists duplicates";

//delete table duplicates
$result1 = mysqli_query($conn, $delquery) or die("MySQL Error..." . (mysqli_error($conn)));

//query that will create a new table duplicates that will house all duplicated records within database
//query2 that will empty noskeletalrecords table
//query3 that will insert any duplicate with empty accession number (otherCatalogNumbers) into noskeletalrecord table
//query4 that will delete any empty accession number (otherCatalogNumbers) entries from the duplicates table
$query="CREATE TABLE duplicates AS SELECT a.* FROM occurrences a INNER JOIN (SELECT otherCatalogNumbers, COUNT(*) FROM occurrences GROUP BY otherCatalogNumbers HAVING COUNT(*) > 1) b ON a.otherCatalogNumbers = b.otherCatalogNumbers";
$query2="TRUNCATE TABLE noskeletalrecords";
$query3 = "INSERT INTO noskeletalrecords SELECT * FROM duplicates where otherCatalogNumbers='' ";
$query4 = "DELETE FROM duplicates where otherCatalogNumbers=''";

//add idices to duplicates and noskeletalrecords table to speed up queries
$query5 = "ALTER TABLE `duplicates` ADD INDEX(`id`)";
$query6 = "ALTER TABLE `noskeletalrecords` ADD INDEX(`id`)";

//delete records from noskeletalrecords that have no barcode
$query7 = "DELETE FROM `noskeletalrecords` WHERE catalogNumber=''";

//query to drop id index on noskeletalrecords table
$query8 = "ALTER TABLE `noskeletalrecords` DROP INDEX `ID`";

if (file_exists($dwcaoccurrences)) {

	//Drop id key on noskeletalrecords table
	//create new table duplicates
	//empty the noskeletalrecords table
	//populate noskeletalrecords table with duplicates missing accession number (otherCatalogNumbers)
	//delete rows without accession number (otherCatalogNumbers)
	//$results8 = mysqli_query($conn, $query8) or die("MySQL Error...(Dropping id index on noskeletalrecords)" . (mysqli_error($conn)));
	$result = mysqli_query($conn, $query) or die("MySQL Error...(Creating Duplicates Table)" . (mysqli_error($conn)));
	$result2 = mysqli_query($conn, $query2) or die("MySQL Error...(Truncating noskeletalrecords Table)" . (mysqli_error($conn)));
	$result3 = mysqli_query($conn, $query3) or die("MySQL Error...(Inserting records into noskeletalrecords Table)" . (mysqli_error($conn)));
	$result4 = mysqli_query($conn, $query4) or die("MySQL Error...(Deleting noskeletalrecord data from duplicates table)" . (mysqli_error($conn)));

	//add indices
	$results5 = mysqli_query($conn, $query5) or die("MySQL Error...(Adding id index to duplicates table)" . (mysqli_error($conn)));
	$results6 = mysqli_query($conn, $query6) or die("MySQL Error...(Adding id index to noskeletalrecords table)" . (mysqli_error($conn)));

	//delete records with no barcode
	$results7 = mysqli_query($conn, $query7) or die("MySQL Error...(Deleting records where no catalogNumber from noskeletalrecords Table)" . (mysqli_error($conn)));

	//let the user know we are finished building the tables
	echo "<h3><center><strong><i>Duplicates</i> and <i>Noskeletalrecords Tables</i> were populated.</strong></center></h3>";
	//flush the buffers so that the above echo command appears before the mysql queries
	ob_flush();
	flush();
} else {
	echo "<h3><center><strong>Could yout build <i>duplicates</i> and <i>noskeletalrecords tables</i>! as the <i>occurrence</i> file isn't in the DWCA folder</strong></center></h3>";
	//flush the buffers so that the above echo command appears before the mysql queries
	ob_flush();
	flush();
}
?>