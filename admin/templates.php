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
<center><a href="./templates/iknew_template.xlsm">IKnew Lite Template (No Taxon Lookups)</a></center>
<br>
<center><a href="./templates/iknew_template_with_taxon.xlsm">IKnew Complete Template with Taxon Lookups</a></center>
<br>
<center><a href="./templates/Symbiota_template_v1.4a.xlsm">Symbiota Template with Taxon Lookups(Version 1.4a)</a></center>
<br>
<center><a href="./templates/Symbiota_MailMerge.docx">Symbiota MailMerge Form - Use this to print herbarium labels from the Symbiota Excel Template (must not have cell formulas in excel sheet)</a></center><br>
<center><a href="./templates/EKY_MailMerge.docx">IKnew MailMerge Form - Use this to print herbarium labels from the Excel Templates (must not have cell formulas in excel sheet)</a></center><br>
<br><br><br>

<?php

//include footer.php which displays a footer at the bottom of the page.  This footer displays software name, version, author, copyright, and contact information
include_once("footer.php");

?>