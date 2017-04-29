<?php
/*IDarwinCore version 1.0
  By Robert R. Pace <robert.pace@eku.edu>
  
  This database software is designed for natural
  history collections utilizing Darwin Core Archive
  data for online querying of the collection's data
  
  This file (build_occurrences_full_table.php) which creates
  an occurrences_full table that has all the DWC-A occurrences data
  along with all the images data_service urls along with the nDrive
  location of the images
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
$dropquery = "DROP TABLE IF EXISTS occurrences_full";

if ((file_exists($dwcaoccurrences)) && (file_exists($dwcaimages))) {
	//build a query that will create the ndrive table
	$createquery = "CREATE TABLE IF NOT EXISTS occurrences_full SELECT * FROM `imagesys`, `ndrive` WHERE `imagesys`.catalogNumber=`ndrive`.ncatalogNumber";

	//execute the query via MySQL that will drop the table
	$dropresults = mysqli_query($conn, $dropquery) or die("MySQL Error in deleting the ndrive table..." . (mysqli_error($conn)));

	//execute the query via MySQL that will create the new table
	$createresults = mysqli_query($conn, $createquery) or die("MySQL Error in creation of occurrences_full table..." . (mysqli_error($conn)));

	//let the user know the process has concluded
	echo "<h3><center><strong><i>Occurrences_Full Table</i> was populated.</strong></center></h3>";


	//flush the buffers so that the above echo command appears before the mysql queries
	ob_flush();
	flush();
} else {
	//let the user know the process has concluded
	echo "<h3><center><strong><h3><strong><i>Occurrences_Full Table</i> could not be created as <i>Occurrences</i> or <i>Images</i> files were not found in DWCA folder.</strong></center></h3>";

	//flush the buffers so that the above echo command appears before the mysql queries
	ob_flush();
	flush();
}

?>