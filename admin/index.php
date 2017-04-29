<?php
/*IDarwinCore version 1.0
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
<p><h3>The EKU Herbarium (EKY) contains ~77,000 specimens and is the largest collection in Kentucky, and the second largest in the Kentucky-Tennessee region (surpassed only by the University of Tennessee). Most specimens are from central and eastern Kentucky, but also there is a good representation of western Kentucky and of the southeastern United States. There is also a set of woody plant specimens recently collected in Costa Rica. Nearly all specimens are of vascular plants. A number of important sets of specimens are housed at EKY, including sets from Lilley Cornett Woods, Maywoods Environmental and Educational Laboratory, Pine Mountain, Breaks Interstate Park, Brodhead Swamp, the headwater regions of the Green River, collections from the Kentucky State Nature Preserves Commission, collections of Mary Wharton, E.T. Browne, Raymond Athey, and county collections from Madison, Estill, Jackson, and Garrard Counties.</h3></p>
<br><br>
<p><center><a href="http://herbarium.eku.edu/">Click Here For More Information On Our Herbarium</a></strong></center></p>
<p><center><a href="http://sernecportal.org/portal/collections/harvestparams.php?&jsoncollstarr={%22db%22:%22193;%22}">Click Here To Search Our Collection On SernecPortal</a></center></p>
<br>
</body>
</html>
<?php

//display footer.php which holds software title, version, author, copyright, and contact information
include_once("footer.php");
?>