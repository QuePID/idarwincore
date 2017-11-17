<?php
/*iDarwinCore version 1.1
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
include_once("functions.php");

mysqli_select_db($conn, $dbname);

//drop tables
dwca_drop_table('duplicates', $conn);
dwca_drop_table('noskeletalrecords', $conn);

$query1="CREATE TABLE duplicates AS SELECT a.* FROM occurrences a INNER JOIN (SELECT otherCatalogNumbers, COUNT(*) FROM occurrences GROUP BY otherCatalogNumbers HAVING COUNT(*) > 1) b ON a.otherCatalogNumbers = b.otherCatalogNumbers";
$query2 = "CREATE TABLE noskeletalrecords SELECT * FROM duplicates where otherCatalogNumbers = ''";
$query3 = "DELETE FROM duplicates where otherCatalogNumbers=''";
$query4 = "DELETE FROM `noskeletalrecords` WHERE catalogNumber=''";

if (file_exists($dwcaoccurrences)) {
	$result1 = mysqli_query($conn, $query1) or die("MySQL Error...(Creating Duplicates Table) " . (mysqli_error($conn)));
	$result2 = mysqli_query($conn, $query2) or die("MySQL Error...(Inserting records into noskeletalrecords Table) " . (mysqli_error($conn)));
	$result3 = mysqli_query($conn, $query3) or die("MySQL Error...(Deleting noskeletalrecord data from duplicates table) " . (mysqli_error($conn)));
  	//delete records with no barcode
	$results4 = mysqli_query($conn, $query4) or die("MySQL Error...(Deleting records where no catalogNumber from noskeletalrecords Table)" . (mysqli_error($conn)));
	//add indexes
	idarwincore_add_index('duplicates', 'id', $conn);
	idarwincore_add_index('noskeletalrecords', 'id', $conn);

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