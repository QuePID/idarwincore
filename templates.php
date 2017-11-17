<?php
/*iDarwinCore version 1.1
  By Robert R. Pace <robert.pace@eku.edu>
  
  This database software is designed for natural
  history collections utilizing Darwin Core Archive
  data for online querying of the collection's data
  
  This file (templates.php)  this file displays a list of files
  which may be useful for offline recording of information that can be
  later imported into IDarwinCore.
  
*/

//
//the include files:
//header.php - this contains the html header information such as university banner and icon along with title text
//common.php - this contains global variables that are needed for formatting or shaping queries (such as the maximum number of query results via LIMIT)
//connect.php - this contains the connection settings for the MySQL database (such as Db name, username, password, server)
//footer.php - this contains the information to be displayed at the bottom of the page (copyright, version)
//

//include header.php which will display at the top of the page
include_once("header.php");

//include common.php which holds many global variables that provide customization for IDarwinCore
include("common.php");
?>

<br><br><br>
<center><a href="./templates/iDwCA_Workbook.xlsm">iDarwinCore Excel Template for entering specimen record data.</a></center>
<br>
<center><a href="./templates/DarwinCore_MailMerge.docx">iDarwinCore MailMerge Form - Use this to print herbarium labels from the iDarwinCore Excel Template.</a></center><br>
<br><br><br>

<?php

//include footer.php which displays a footer at the bottom of the page.  This footer displays software name, version, author, copyright, and contact information
include_once("footer.php");

?>