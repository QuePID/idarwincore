<?PHP
/*iDarwinCore version 1.1
  By Robert R. Pace <robert.pace@eku.edu>
  
  This database software is designed for natural
  history collections utilizing Darwin Core Archive
  data for online querying of the collection's data
  
  This file (common.php) houses global variables which
  can be accessed by any php file that contains an
  include(common.php) line.
  
  This file provides customization of IDarwinCore without
  the need to manually edit a plethora of php files
*/

//create a variable which will house the path to the images folder
$urlone = 'http://localhost/idarwincore/images/';

//create a variable to retrieve family data for the browse collection function, this is used by display.php
$urlthree = "http://localhost/idarwincore/";

//create a variable which will be used to build query strings via url in display.php
$urlq = 'http://localhost/idarwincore/display.php?';

//create a variable to hold the college/university name
$university = 'Your Websites Name';

//headerlogo
$headerimage = 'http://localhost/idarwincore/images/eky.jpg';

//create a variable to store the maximum number of results to be displayable...note more results means slower searchs!
$maxsearch = 1000;

//create a variable to store the path to DWCA folder inside the Apache Temp folder
$tmppath = 'C:/wamp64/tmp/dwca/';

//create a variable to store the path to the Apache Temp folder
$tmp_folder = 'C:/wamp64/tmp/';

//this variable should contain the appropriate line terminations for your particular operating system.
//for windows based machines you should set $lterms to '\r\n' (carriage return and new line)
//for MacOS you should set $lterms to '\n' (new line)
$lterms = "\r\n";

//absolute path to DWC-A's identifications.csv file
$dwcaidentifications = "C:/wamp64/tmp/dwca/identifications.csv";

//absolute path to DWC-A's images.csv file
$dwcaimages = "C:/wamp64/tmp/dwca/images.csv";

//absolute path to DWC-A's occurrences.csv file
$dwcaoccurrences = "C:/wamp64/tmp/dwca/occurrences.csv";

//absolute path to ndrive's jpeg list including paths
$ndrivejpegs = "C:/wamp64/tmp/dwca/ndjpegs_with_paths.txt";

//absolute path to ndrive.txt file in /tmp/dwca/ folder
$ndrive = "C:/wamp64/tmp/dwca/nDrive.txt";

//absolute path to iplant's jpeg list including paths
$iplantjpegs = "C:/wamp64/tmp/dwca/iplantdwca.txt";

//absolute path to iplant_t.txt file list in /tmp/dwca/ folder
$iplant_t = "C:/wamp64/tmp/dwca/iplant_t.txt";

//absolute path to barcodes file list (should be in /tmp/dwca) folder.
$barcodesfile = "C:/wamp64/tmp/dwca/barcodes.txt";

//number of characters found in barcode
$bclength = "14";

//absolute path to blockedlist.csv (should be in /tmp/dwca) folder.
$blockedlist = "C:/wamp64/tmp/dwca/blockedlist.csv";

//absolute path to files (to be written) in the generation of a DwC-A export file.
$dwcafileo = "c:/wamp64/www/idarwincore/dwca/occurrences.csv";
$dwcafilea = "c:/wamp64/www/idarwincore/dwca/identifications.csv";
$dwcafilei = "c:/wamp64/www/idarwincore/dwca/images.csv";
$dwcafilem = "c:/wamp64/www/idarwincore/dwca/measurementOrFact.csv";
$dwcarootPath = realpath('C:/wamp64/www/idarwincore/dwca/');
$dwcameta = "c:/wamp64/www/idarwincore/dwca/meta.xml";
$dwcaeml = "c:/wamp64/www/idarwincore/dwca/eml.xml";
$exportdbfile = 'c:/wamp64/www/idarwincore/admin/create_db_structures.sql';
$measurementorfact = 'c:/wamp64/tmp/dwca/measurementOrFact.csv';

//Define your colors for the alternating rows and headers
//$color1 & $color2 are for alternating rows, wheras
//$color 3 is for the column headers
//
//$color1 = "#99CCFF"; 
$color1 = "#C5C5C5";
//$color2 = "#88AAFF";
$color2 = "#9D9D9D";
//$color3 = "#CCFF99";
$color3 = "#5B9360";

?>
