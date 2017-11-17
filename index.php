<?php
/*IDarwinCore version 1.1
  By Robert R. Pace <robert.pace@eku.edu>
  
  This database software is designed for natural
  history collections utilizing Darwin Core Archive
  data for online querying of the collection's data
  
  This file (index.php) is the main starting point
  for users and has the menu of other PHP files
*/

//This file is the default file opened when someone visits IKnew, from here the other pages are subsequently linked
//

//the include files:
//header.php - this contains the html header information such as university banner and icon along with title text
//common.php - this contains global variables that are needed for formatting or shaping queries (such as the maximum number of query results via LIMIT)
//connect.php - this contains the connection settings for the MySQL database (such as Db name, username, password, server)
//footer.php - this contains the information to be displayed at the bottom of the page (copyright, version)
//

//include the header.php which displays the html headers and header image
include_once("header.php");

//include customized global variables for IDarwinCore
include("common.php");
?>
<br><br>
<p><center><h1><strong><u>Welcome to iDarwinCore @ <?php include("common.php"); echo $university; ?></u></strong></h1></center></p>
<br>
<p><h3><center>Welcome to iDarwinCore.  Here you will put a description of your utilization of iDarwinCore by simply editing the index.php file.</center></h3></p>
<br><br>

<br>
</body>
</html>
<?php

//display footer.php which holds software title, version, author, copyright, and contact information
include_once("footer.php");
?>