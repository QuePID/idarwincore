<?php
/*IDarwinCore version 1.0
  By Robert R. Pace <robert.pace@eku.edu>
  
  This database software is designed for natural
  history collections utilizing Darwin Core Archive
  data for online querying of the collection's data
  
  This file (search.php) this file creates an html
  form which one can fill in various elements that will
  be used to query the MySQL database.
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
<center><strong><h2>Query For A Distribution Map</h2></strong></center>
<hr><br>

<form action="display_distribution_map_pre.php" method="get">
<center><table style="border-collapse: collapse;"></center>
<tr><td bgcolor="#C5C5C5"><center><strong>Genus: </strong><input type="text" size="4" name="genus" style="width: 241px" /></center></td></tr>
<tr><td bgcolor="#9D9D9D"><center><strong>Species: </strong><input type="text" size="4" name="specificEpithet" style="width: 241px" /></center></td></tr>
<tr><td bgcolor="#C5C5C5"><center><strong>State: </strong><input type="text" size="4" name="stateProvince" style="width: 241px" /></center></td></tr>
<tr><td bgcolor="#9D9D9D"><center><input type="submit" /></center></td></tr>
</form>
</table>
</body>
</html> 
<?php

//display footer which will display software title, version, copyright, author, and contact information
include_once("footer.php");
?>