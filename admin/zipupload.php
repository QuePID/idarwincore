<?php
/*IDarwinCore version 1.0
  By Robert R. Pace <robert.pace@eku.edu>
  
  This database software is designed for natural
  history collections utilizing Darwin Core Archive
  data for online querying of the collection's data
  
  This file (zipupload.php) This file allows the user to
  select a DarwinCore Archive (DwC-A) zip file to upload.
  The file is uploaded to a temp folder and then extracted to
  the dwca folder.  Then the identifications, occurrences, and images
  are imported into MySQL tables, along with building of novel
  MySQL data tables using the simplecsv.php.
  
  It is important that the dwca folder that houses the images.csv,
  occurrences.csv, identifications.csv be located directly from the webserver's
  root folder.  Eg. /tmp/dwca otherwise MySQL may balk at loading the data files.
  
 The file paths for the DWC-A files should be set in the common.php file along with
 tmppath which should be set to the dwca folder of the Apache Temp folder.
*/

//include a few phps which contain global variables necessary for MySQL connectivity and file paths
include("common.php");
include("connect.php");

//display a header on the webpage
include("header.php");

//Initialize some variables
$zip_file = "";
$message = "";

/*If the variable $_FILES is set, then
set variables like filename, name, source, type, accepted type, along with mime types
and destination.
*/
if(@$_FILES["zip_file"]["name"]) {
	//set filename from information submitted by html form
	$filename = $_FILES["zip_file"]["name"];

	//set the source filename submitted by html form
	$source = $_FILES["zip_file"]["tmp_name"];

	//set the file type as defined by html form data
	$type = $_FILES["zip_file"]["type"];
	
	//get the filename sans extension
	$name = explode(".", $filename);

  //set the accepted mime filetypes to an array
	$accepted_types = array('application/zip', 'application/x-zip-compressed', 'multipart/x-zip', 'application/x-compressed');

	//Check to see if type of file is within our list of accepted mime filetypes, if so then continue, if not then
	//prompt user that the file isn't the right type
	foreach($accepted_types as $mime_type) {
		if($mime_type == $type) {
			$okay = true;
			break;
		} 
	}
	
	//set the continue variable to the lower case and see if it is a zip
	$continue = strtolower($name[1]) == 'zip' ? true : false;

	//if the variable continue is false then set a message indicating the file was not a .zip
	if(!$continue) {
		$message = "The file you are trying to upload is not a .zip file. Please try again.";
	}

  //set the path you want the zip file extracted to
	$ziptarget_path =  $tmp_folder . $filename;  // change this to the correct site path

	//Check to see where file was move dto and destination folder
	if(move_uploaded_file($source, $ziptarget_path)) {
		//set the zip file
		$zip = new ZipArchive();

		//open the zip file
		$x = $zip->open($ziptarget_path);

		//if the zip file is a good zip file then extract contents to path defined below
		if ($x === true) {
			$zip->extractTo($tmppath); // change this to the correct site path

			//close the zip file
			$zip->close();

			//delete the zip file after extraction
			unlink($ziptarget_path);
		}

		//set a message to alert the user as to status
		$message = "Your .zip file was uploaded and unpacked.";
	} else {	
		$message = "There was a problem with the upload. Please try again.";
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Import DwC-A Zip File</title>
</head>
<br><br><br>
<center><strong><h3>If you plan on using the full functionality of iDarwinCore and haven't uploaded <i>iplant_t.txt</i>, <i>nDrive.txt</i>, <i>barcodelist.txt</i>, or <i>blockedlist.csv</i> and wish to do so, then do so now before proceeding to importation of DwC-A file.</h3></strong></center>

<body>
<br><br><br>

<?php 
//time to give the user some feedback and start reading the files into MySQL tables
//if message is set then tell what happened and pause for 10 seconds before starting the
//importation of the DwC-A files into MySQL tables
if($message) {
	echo "<p><center><h2><strong>$message</strong></h2></center></p>";

	sleep(10);
  //this include processes all the files in the dwca folder inserting them into MySQL along
  //with building several novel data tables
	include("simplecsv.php");
}
?> 

<hr>
<center><form enctype="multipart/form-data" method="post" action="">
<label><h2></h2><strong>Choose the DwC-A zip file you wish to upload: </strong></h2><input type="file" name="zip_file" /></label>
<br /><br><br>
<input type="submit" name="submit" value="Upload" />
</form></center>
</body>
<?php include("footer.php");?>
</html>