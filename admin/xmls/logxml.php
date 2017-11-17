<?php
/*iDarwinCore version 1.1
  By Robert R. Pace <robert.pace@eku.edu>
  
  This database software is designed for natural
  history collections utilizing Darwin Core Archive
  data for online querying of the collection's data
  
  This file (logxml.php) reads the identifier field from
  the imagesys table.  The identifier field houses a url
  that dispenses xml data for an image link on the bisque
  server.
*/

//include the connect.php file which holds the necessary credentials for MySQL connectivity along with database name selection
include("../connect.php");

//include common.phh which has many customization global variables
include("../common.php");

//include the header.php which displays a header on top every PHP page
include("../header.php");

//build a query string that selects all records from the imagesys table
$query = "SELECT * FROM imagesys";

//get results of MySQL query using the above $query string along with checking for potential MySQL errors
$result = mysqli_query($conn, $query) or die("MySQL Error..." . mysqli_error($conn));

//initialize a few variables used in this PHP such as $counter which is a simple incremental counter variable, and $row['coreid']
//which will hold the identifier field from the imagesys table field.
$counter = '1';
$row['coreid']='';

//while we have unfinished results, loop until we are at the end of results
while ($row = mysqli_fetch_array($result))
{
  //fetch the identifier field for the record and store in the variable $url
  $url = $row['identifier'];
  //get the html headers for the url held in the variable $url
  $file_headers = @get_headers($url);
  
//Check to see if the headers retrieved were 404 or 302 errors
if (($file_headers[0] == 'HTTP/1.1 404 Not Found') OR ($file_headers[0] == 'HTTP/1.1 302 Found')){
	
	//we have a 404 or 302 error, so we want to do nothing and go on to next record...and increment counter variable
	$counter++;

} else {

	   //we have good headers for the url, so we need to process the information and export to a xml log file
	
	   //create variable $url2 and have it replace the & with &amp, this prevents errors should the url contain an ampersand
     $url2 = preg_replace('#&(?=[a-z_0-9]+=)#', '&amp;', $url);
  
     //create the $xml variable which will retrieve the xml data from the $url2 url
     $xml = simplexml_load_file($url2);
  
     //show the counter so we have some indication of progress
     echo "$counter ";
  
    //build a line of text that will be output to the log file that indicates what coreid for the xml data that will be deposited next to the log
    $logcoreid = "coreid=" . $row['coreid'] . "\n";
  
    //either create if the file (xml.log) doesn't exist or append if the file does exist
  	$fh = fopen('xml.log', 'a');
	
	  //write to xml.log the variable $logcoreid which holds the coreid=<coreidnumber> tag so that we know what record the xml data is associated with
    fwrite($fh, $logcoreid );
    
    //write also the xml.log the xml data which we have fetched from the $url2
    fwrite($fh, $xml->asXML());
  
    //close the file
    fclose($fh);
  
    //flush the buffers so that we get results on screen immediately vs delayed
	  ob_flush();
	  flush();
	
	  //time to increment the counter since we finished with this record
	  $counter++;
}
}

//include footer.php which has information on the version of IDarwinCore along with the author and contact information
include("../footer.php");

?>