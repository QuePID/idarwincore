<?php
/*IDarwinCore version 1.0
  By Robert R. Pace <robert.pace@eku.edu>
  
  This database software is designed for natural
  history collections utilizing Darwin Core Archive
  data for online querying of the collection's data
  
  This file (barcodesearch.php) this file allows one to enter a filename (otherCatalogNumber) for SernecPortal and
  it return links for the file from Bisque
*/

//the include files:
//header.php - this contains the html header information such as university banner and icon along with title text
//common.php - this contains global variables that are needed for formatting or shaping queries (such as the maximum number of query results via LIMIT)
//connect.php - this contains the connection settings for the MySQL database (such as Db name, username, password, server)
//footer.php - this contains the information to be displayed at the bottom of the page (copyright, version)
//

include_once("header.php");
include("common.php");

?>
<br>
<center><strong><h2>Search <?php include('common.php'); echo $university; ?>'s Collection</h2></strong></center>
<hr><br>

<form action="barcode.php" method="get">
<center><table border="1"></center>
<tr><td bgcolor="#9D9D9D"><center><strong>Bar Code (catalogNumber) : </strong><input type="text" size="4" name="catalogNumber" style="width: 241px" /></center></td></tr>
<tr><td bgcolor="#C5C5C5"><center><input type="submit" /></center></td></tr>
</form>
</table>
</body>
</html> 
<?php

//display footer which will display software title, version, copyright, author, and contact information
include_once("footer.php");
?>