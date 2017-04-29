<?php
/*IDarwinCore version 1.0
  By Robert R. Pace <robert.pace@eku.edu>
  
  This database software is designed for natural
  history collections utilizing Darwin Core Archive
  data for online querying of the collection's data
  
  This file (truncate_all_tables.php) is the heart of the IDarwinCore
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
include("header.php");

echo "<br><br><br><center><strong>Cleaning Out Tables</strong></center><br><br>";
//define a series of queries which will empty a series of MySQL tables
$emptyq1 = "TRUNCATE TABLE barcodes";
$emptyq2 = "TRUNCATE TABLE blockedlist";
$emptyq3 = "TRUNCATE TABLE duplicates";
$emptyq4 = "TRUNCATE TABLE identifications";
$emptyq5 = "TRUNCATE TABLE images";
$emptyq6 = "TRUNCATE TABLE imagesys";
$emptyq7 = "TRUNCATE TABLE iplant";
$emptyq8 = "TRUNCATE TABLE ndrive";
$emptyq9 = "TRUNCATE TABLE noskeletalrecords";
$emptyq10 = "TRUNCATE TABLE occurrences";
$emptyq11 = "TRUNCATE TABLE occurrences_full";

//execute the above defined queries while checking for potential errors
$result1 = mysqli_query($conn, $emptyq1) or die("MySQL Error...(emptyq1)" . (mysqli_error($conn)));
$result2 = mysqli_query($conn, $emptyq2) or die("MySQL Error...(emptyq2)" . (mysqli_error($conn)));
$result3 = mysqli_query($conn, $emptyq3) or die("MySQL Error...(emptyq3)" . (mysqli_error($conn)));
$result4 = mysqli_query($conn, $emptyq4) or die("MySQL Error...(emptyq4)" . (mysqli_error($conn)));
$result5 = mysqli_query($conn, $emptyq5) or die("MySQL Error...(emptyq5)" . (mysqli_error($conn)));
$result6 = mysqli_query($conn, $emptyq6) or die("MySQL Error...(emptyq6)" . (mysqli_error($conn)));
$result7 = mysqli_query($conn, $emptyq7) or die("MySQL Error...(emptyq7)" . (mysqli_error($conn)));
$result8 = mysqli_query($conn, $emptyq8) or die("MySQL Error...(emptyq8)" . (mysqli_error($conn)));
$result9 = mysqli_query($conn, $emptyq9) or die("MySQL Error...(emptyq9)" . (mysqli_error($conn)));
$result10 = mysqli_query($conn, $emptyq10) or die("MySQL Error...(emptyq10)" . (mysqli_error($conn)));
$result11 = mysqli_query($conn, $emptyq11) or die("MySQL Error...(emptyq11)" . (mysqli_error($conn)));
echo "<br><br><center><strong>Tables have been Truncated.</strong></center><br><br>";

include("footer.php");

?>