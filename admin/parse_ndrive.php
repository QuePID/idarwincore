<?php
/*iDarwinCore version 1.1
  By Robert R. Pace <robert.pace@eku.edu>
  
  This database software is designed for natural
  history collections utilizing Darwin Core Archive
  data for online querying of the collection's data
  
  This file (parse_ndrive.php) reads the nDrive.txt and
  outputs ndjpegs_with_paths.txt which is then imported into the MySQL database
*/

//the include files:
//header.php - this contains the html header information such as university banner and icon along with title text
//common.php - this contains global variables that are needed for formatting or shaping queries (such as the maximum number of query results via LIMIT)
//connect.php - this contains the connection settings for the MySQL database (such as Db name, username, password, server)
//footer.php - this contains the information to be displayed at the bottom of the page (copyright, version)
//

//display the html header
include_once("header.php");

// connect to database.
include("connect.php");

//load the global variables
include("common.php");

//open file handler for nDrive.txt in read mode
$handle_in = fopen("$ndrive", "r");
//open file handler for ndjpegs_with_paths.txt in write mode
$handle_out = fopen("$ndrivejpegs","w");

//Let the end user know what is happening.
echo "<center><strong><h3>Populating <i>nDrive</i> Table</h3></strong></center>";

//flush the buffers so that the above echo command appears before the mysql queries
ob_flush();
flush();

//if filehandle is set process through the file line by line
if ($handle_in) {
	  //while their is more to read from the file
    while (($line = fgets($handle_in)) !== false) {
       //check to see if the line has /irods and .jpg in the line if so then we want to process it and output, otherwise skip the line
       if(strpos($line,'.jpg') == True) {
         //explode the line fetched from file, trim off all extra spaces, and assign to an array
         $linearray = array_map('trim',explode(" ",$line));
         //find the position at which .jpg occurs within the line string
         $pos = strpos($linearray[0],'.jpg');
         //set the position to the left 14 characters of where .jpg occurs in the line
         $pos = ($pos - 14);
         //read fourteen characters at position set to coincide with where barcode occurs in the line, set this information to the bcode variable
         $bcode = substr($linearray[0], $pos, 14);
         //create a line out string which we will dump to the iplantdwca.txt file
         $lineout = "\"$linearray[0]\",\"$bcode\"$lterms";
         //write the lineout string to the iplantdwca file
         fwrite($handle_out, $lineout);
       }
    }
    //close the file handler for iplant_t.txt and iplantdwca
    fclose($handle_in);
    fclose($handle_out);
} else {
}

//displays a footer at the bottom of the page containing software name, copyright info, and version number.
include_once("build_ndrive_table.php");
//include_once("footer.php");
?>