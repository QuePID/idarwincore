<?php
/*IDarwinCore version 1.0
  By Robert R. Pace <robert.pace@eku.edu>
  
  This database software is designed for natural
  history collections utilizing Darwin Core Archive
  data for online querying of the collection's data
  
  This file (search_counties.php) allows one to display county records
  for a genus & species and state
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
<form action="display_counties.php" method="get">
</select></center>
<center><strong>Genus: </strong><input type="text" size="6" name="genus" style="width: 241px" /></center>
<center><strong>Species: </strong><input type="text" size="6" name="specificEpithet" style="width: 241px" /></center>
<center><strong>State: </strong><input type="text" size="6" name="stateProvince" style="width: 241px" /></center>
<center><input type="submit" /></center>
</form>
</body>
</html> 
<?php
//display footer displays software title, version, author, copyright, and contact information
include_once("footer.php");
?>