<?php
/*IDarwinCore version 1.0
  By Robert R. Pace <robert.pace@eku.edu>
  
  This database software is designed for natural
  history collections utilizing Darwin Core Archive
  data for online querying of the collection's data
  
  This file (logxml_from_file.php) reads the identifier field
  from a CSV or TXT file located in the same folder as this php,
  it then reads this file line by line, checks to ensure the
  link in the line is valid by checking for http headers.
  If the link is good it will retrieve the XML and write that along
  line number to a log file.
*/

//include the common.php file which holds customization of IDarwinCore package, including urls
include("../idarwincore/common.php");

//include the header.php which displays a header on top every PHP page
include("../idarwincore/header.php");

//define the file that will be read line by line, this
//file should contain a list of bisque data_service links
//bisque data links return XML
$file = fopen("url_list.txt","r");

//initialize a counter which will indicate the line number read from file
//this number will also be written to the output file as line number
$counter = 1;

//while the end of file has not been reached do a bunch of stuff
while(! feof($file))
  {
  //define the variable url as a line from the file to be read
  $url = fgets($file);
  
  //get the html headers for the url held in the variable $url
  $file_headers = @get_headers($url);
  
  //flush the buffers so that output to screen is timely and not
  //lagged
  ob_flush();
  flush();
  
//Check to see if the headers retrieved were 404 or 302 errors
if (($file_headers[0] == 'HTTP/1.1 404 Not Found') OR ($file_headers[0] == 'HTTP/1.1 302 Found')){
	 //Houston we have a problem, our link read from the file is either dead (404) or it is redirected (302)
	 //Let's display a message on the screen so the user has some feedback
	 echo "Line: $counter $file_headers[0] (Skipping)<br>";
	 
	 //let's build a variable to store a line of text that will be added to the log file indicating
	 //that the line in the read file is a dud
	 $logskipped = "Line $counter Skipped ($file_headers[0])\n";
	 
	 //Open the xml_from_file.log in an append mode
	 $fh = fopen('xml_from_file.log', 'a');
	 
	 //Write the variable holding the reason the line was skipped to the log file
	 fwrite($fh, $logskipped);
	 
	 //close the writing to the log file
	 fclose($fh);
	 
	//we have a 404 or 302 error, so we want to do nothing and go on to next record...and increment counter variable
 $counter++;
 
} else {

	   //we have good headers for the url, so we need to process the information and export to a xml log file
	
	   //create variable $url2 and have it replace the & with &amp, this prevents errors should the url contain an ampersand
     $url2 = preg_replace('#&(?=[a-z_0-9]+=)#', '&amp;', $url);
  
     //create a variable $logfound which will be added later to the log file as a notice
     //that this line in the read file has indeed received information that will need to be written to log file.
     $logfound = "Line $counter recording ($file_headers[0])\n";
     
     //create the $xml variable which will retrieve the xml data from the $url2 url
     $xml = simplexml_load_file($url2);
  
     //display the XML to screen so user knows something is happening
     echo "Line: $counter $file_headers[0] (recording)<br>";
     
    //flush the buffers so that we get results on screen immediately vs delayed
	  ob_flush();
	  flush();
    
    //either create if the file (xml.log) doesn't exist or append if the file does exist
  	$fh = fopen('xml_from_file.log', 'a');
	    
    //write the message saying that this line in the read file was good
    fwrite($fh, $logfound);
    
    //write also the xml.log the xml data which we have fetched from the $url2
    fwrite($fh, $xml->asXML());
  
    //close the file
    fclose($fh);
  
    //flush the buffers so that we get results on screen immediately vs delayed
	  ob_flush();
	  flush();
	  
	  //time to increment the counter as we move on to read the next line
	  $counter++;
  }
 
}

//time to close the read file (url_list.txt) since we have come to the end of the file
fclose($file);

//alert the user that we have finished parsing the file
echo "<br>Finished!<br>";

//include the file footer.php which displays software name, version, author, copyright, and contact information.
include("../idarwincore/footer.php");

?>