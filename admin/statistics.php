<?PHP
/*iDarwinCore version 1.1
  By Robert R. Pace <robert.pace@eku.edu>
  
  This database software is designed for natural
  history collections utilizing Darwin Core Archive
  data for online querying of the collection's data
  
  This file (statistics.php) shows the number of distinct (unique) records based on a field
  It also shows a list of duplicates along with the number of times the field was replicated in the database
  catalogNumber, CoreID, and ID duplicates will be displayed as URLs to SernecPortal's Occurrence Editor
  which should make editing of these damaged records easier.
  
  This software packages utilizes JQuery
*/

//the include files:
//header.php - this contains the html header information such as university banner and icon along with title text
//common.php - this contains global variables that are needed for formatting or shaping queries (such as the maximum number of query results via LIMIT)
//connect.php - this contains the connection settings for the MySQL database (such as Db name, username, password, server)
//footer.php - this contains the information to be displayed at the bottom of the page (copyright, version)
//

//connect to database.
include("connect.php");

//load the global variables
include("common.php");

//display the html header
include("header.php");

//MySQL Query Strings used for Total # of Rows in each table
$queryrc1 = "Select `id` FROM occurrences";
$queryrc2 = "Select `coreid` FROM images";
$queryrc3 = "Select `id` FROM occurrences WHERE catalogNumber > 1";
$queryrc4 = "Select `id` FROM occurrences WHERE otherCatalogNumbers != ''";

//MySQL Query Strings to show Distinct Counts based on a field in a table
$querydico1 = "SELECT COUNT(DISTINCT(`id`)) FROM `occurrences`";
$querydico2 = "SELECT COUNT(DISTINCT(`catalogNumber`)) FROM `occurrences` WHERE `catalogNumber` > 1";
$querydico3 = "SELECT COUNT(DISTINCT(`otherCatalogNumbers`)) FROM `occurrences` WHERE `otherCatalogNumbers` != ''";
$querydico4 = "SELECT COUNT(DISTINCT(`coreid`)) FROM `images`";
$querydico5 = "SELECT COUNT(DISTINCT(identifier)) FROM `images`";

//MySQL Query Strings to show all Duplicate Counts based on a field in a table
$querydupc1 = "SELECT `id`, COUNT(*) as count FROM `occurrences` GROUP BY `id` having COUNT(*) >= 2";
$querydupc2 = "SELECT `catalogNumber`, COUNT(*) as count FROM `occurrences` WHERE `catalogNumber` > 1 GROUP BY `catalogNumber` having COUNT(*) >= 2";
$querydupc3 = "SELECT `otherCatalogNumbers`, COUNT(*) as count FROM `occurrences` WHERE otherCatalogNumbers != '' GROUP BY `otherCatalogNumbers` having COUNT(*) >= 2";
$querydupc4 = "SELECT `coreid`, COUNT(*) as count FROM `images` GROUP BY `coreid` having COUNT(*) >= 2";
$querydupc5 = "SELECT `identifier`, COUNT(*) as count FROM `images` GROUP BY `identifier` having COUNT(*) >= 2";

//MySQL Query to compare barcodes of occurrence table to iplant's barcodes
//and output any barcodes present in occurence table that do not have corresponding entry in iplant table
$querydisparity1 = "SELECT `catalogNumber` FROM `occurrences` WHERE (`occurrences`.`catalogNumber`> 1) AND ((`occurrences`.`catalogNumber` NOT IN (SELECT `iplant`.`barcode` FROM `iplant`)))";

//MySQL Query to find barcodes that are to short
$querytoshort = "SELECT catalogNumber FROM occurrences WHERE (LENGTH(catalogNumber) != $bclength) AND (catalogNumber > 1)";

//MySQL Query to compare barcodes of occurrence table to known valid barcodes list
//and output any barcodes present in occurence table that do not have corresponding entry in known barcode table
$querydisparity2 = "SELECT `catalogNumber` FROM `occurrences` WHERE (`occurrences`.`catalogNumber`> 1) AND ((`occurrences`.`catalogNumber` NOT IN (SELECT `barcodes`.`barcodes` FROM `barcodes`)))";

//MySQL Query for occurrence records that have images and occurrence records only having otherCatalogNumbers and catalogNumbers holding data
$querykeystrokeimages = "SELECT catalogNumber FROM `occurrences` WHERE (`catalogNumber` > 1) AND ((`otherCatalogNumbers` IS NOT NULL) AND (`otherCatalogNumbers` !='')) AND ((`scientificName` IS NULL) OR (`scientificName` = '')) ORDER BY `catalogNumber` ASC";
$resultskeystrokeimages = mysqli_query($conn,$querykeystrokeimages) or die ('Could not connect to mysqli(querykeystrokeimages): ' . mysqli_error($conn));
$rckeystrokeimages = mysqli_num_rows($resultskeystrokeimages) or die ('Could not connect to mysqli(resultkeystrokeimages): ' . mysqli_error($conn));

//MySQL Query Results for Distinct Counts
$resultsdico1 = mysqli_query($conn, $querydico1)  or die ('Could not connect to mysqli (querydico1): ' . mysqli_error($conn));
$resultsdico2 = mysqli_query($conn, $querydico2)  or die ('Could not connect to mysqli (querydico2): ' . mysqli_error($conn));
$resultsdico3 = mysqli_query($conn, $querydico3)  or die ('Could not connect to mysqli (querydico3): ' . mysqli_error($conn));
$resultsdico4 = mysqli_query($conn, $querydico4)  or die ('Could not connect to mysqli (querydico4): ' . mysqli_error($conn));
$resultsdico5 = mysqli_query($conn, $querydico5)  or die ('Could not connect to mysqli (querydico5): ' . mysqli_error($conn));

//Run query through MySQLi
$resultsrc1 = mysqli_query($conn, $queryrc1) or die ('Could not connect to mysqli (rc1 queryrc1): ' . mysqli_error($conn));
$resultsrc2 = mysqli_query($conn, $queryrc2) or die ('Could not connect to mysqli (rc2 queryrc2): ' . mysqli_error($conn));
$resultsrc3 = mysqli_query($conn, $queryrc3) or die ('Could not connect to mysqli (rc3 queryrc3): ' . mysqli_error($conn));
$resultsrc4 = mysqli_query($conn, $queryrc4) or die ('Could not connect to mysqli (rc4 queryrc4): ' . mysqli_error($conn));

//store the number of results
$rc1_rows = mysqli_num_rows($resultsrc1) or die ('Could not connect to mysqli (rc1 queryrc1): ' . mysqli_error($conn));
$rc2_rows = mysqli_num_rows($resultsrc2) or die ('Could not connect to mysqli (rc2 queryrc2): ' . mysqli_error($conn));
$rc3_rows = mysqli_num_rows($resultsrc3) or die ('Could not connect to mysqli (rc3 queryrc3): ' . mysqli_error($conn));
$rc4_rows = mysqli_num_rows($resultsrc4) or die ('Could not connect to mysqli (rc4 queryrc4): ' . mysqli_error($conn));

//MySQL Query Results for Duplicate Counts
$resultsdupc1 = mysqli_query($conn, $querydupc1)  or die ('Could not connect to mysqli (querydupc1): ' . mysqli_error($conn));
$resultsdupc2 = mysqli_query($conn, $querydupc2)  or die ('Could not connect to mysqli (querydupc2): ' . mysqli_error($conn));
$resultsdupc3 = mysqli_query($conn, $querydupc3)  or die ('Could not connect to mysqli (querydupc3): ' . mysqli_error($conn));
$resultsdupc4 = mysqli_query($conn, $querydupc4)  or die ('Could not connect to mysqli (querydupc4): ' . mysqli_error($conn));
$resultsdupc5 = mysqli_query($conn, $querydupc5)  or die ('Could not connect to mysqli (querydupc5): ' . mysqli_error($conn));

//MySQL Query Results for Disparity1
$resultdisparity1 = mysqli_query($conn, $querydisparity1)  or die ('Could not connect to mysqli (querydisparity1): ' . mysqli_error($conn));
$rc5_rows = mysqli_num_rows($resultdisparity1);

//MySQL Query Results for ToShort
$resulttoshort = mysqli_query($conn, $querytoshort)  or die ('Could not connect to mysqli (querytoshort): ' . mysqli_error($conn));
$rc6_rows = mysqli_num_rows($resulttoshort);

//MySQL Query Results for Disparity2
$resultdisparity2 = mysqli_query($conn, $querydisparity2)  or die ('Could not connect to mysqli (querydisparity2): ' . mysqli_error($conn));
$rc7_rows = mysqli_num_rows($resultdisparity2);

echo "<center><strong><h2>IDarwinCore Unique Record Statistics</h2></strong></center><br>";

//Start a HTML Table
echo '<center><table style="border-collapse: collapse;"></center>';
echo "<tr bgcolor=$color3><td><strong><center><u>Description</u></center></strong></td><td><center><strong><u>Location</u></strong></center></td><td><strong><center><u>Unique Records</u></center></strong></td><td><strong><center><u>Total Records</u></center></strong></td></tr>";

//Show ResultsDiCo1
while ($row1 = mysqli_fetch_array($resultsdico1)) { 
	echo "<tr bgcolor=$color1><td><strong>Unique Records (<i>ID</i>)</td><td><strong><center>Occurrences Table</center></strong></td><td><center><strong>" . number_format($row1['COUNT(DISTINCT(`id`))']) . "</strong></center></td><td><center><strong>" . number_format($rc1_rows) . "</i></strong></td></tr>"; }
	ob_flush();
	flush();

//Show ResultsDiCo2
while ($row2 = mysqli_fetch_array($resultsdico2)) { echo "<tr bgcolor=$color2><td><strong>Unique Barcodes (<i>CatalogNumber</i>)</td><td><strong><center>Occurrences Table</center></strong></td><td><center><strong>" . number_format($row2['COUNT(DISTINCT(`catalogNumber`))']) . "</strong></center></td><td><center><strong>" . number_format($rc3_rows) . "</i></strong></td></tr>"; }
	ob_flush();
	flush();

//Show ResultsDiCo3
while ($row3 = mysqli_fetch_array($resultsdico3)) { echo "<tr bgcolor=$color1><td><strong>Unique Accession Numbers (<i>otherCatalogNumbers</i>)</td><td><strong><center>Occurrences Table</center></strong></td><td><center><strong>" . number_format($row3['COUNT(DISTINCT(`otherCatalogNumbers`))']) .  "</strong></center></td><td><center><strong>" . number_format($rc4_rows) . "</i></strong></center></td></tr>"; }
	ob_flush();
	flush();

//Show ResultsDiCo4
while ($row4 = mysqli_fetch_array($resultsdico4)) { echo "<tr bgcolor=$color2><td><strong>Unique Images (<i>CoreID</i>)</td><td><strong><center>Images Table</center></strong></td><td><center><strong>" . number_format($row4['COUNT(DISTINCT(`coreid`))']) . "</center></td><td><center><strong>" . number_format($rc2_rows) . "</strong></i></strong></center></td></tr>"; }
	ob_flush();
	flush();

//Show ResultsDiCo5
while ($row5 = mysqli_fetch_array($resultsdico5)) { echo "<tr bgcolor=$color1><td><strong>Unique Image Links (<i>Identifier</i>)</td><td><strong><center>Images Table</center></strong></td><td><center><strong>" . number_format($row5['COUNT(DISTINCT(identifier))']) . "</center></td><td><center><strong>" . number_format($rc2_rows) . "</strong></i></strong></center></td></tr>"; }
	ob_flush();
	flush();
	
//End Table
echo "</table>";
echo "<hr>";

echo "<center><strong><h2>Show Duplicates</h2></strong></center>";

//Start a HTML Table
echo "<center><h3><strong><u>Display Duplicates Based on <i>ID</i> (Occurrences Table)</u></strong></h3></center>";
echo '<script>$(document).ready(function () { $(".expand").click(function () {$("#table1 tbody").show("slow");});$(".collapse").click(function () {$("#table1 tbody").hide("fast");});});</script>';
echo '<center><a class="expand" href="#"><strong>( + )</strong></a> | <a class="collapse" href="#"><strong>( - )</strong></a></center>';
echo '<center><table id=table1 style="border-collapse: collapse;"></center>';
echo "<thead><tr bgcolor=$color3><td><strong><center><u>ID</u></center></strong></td><td><center><strong><u>Times Duplicated</u></strong></center></td></tr></thead>";
echo "<tbody>";

//Show ResultsDupC1
while ($row6 = mysqli_fetch_array($resultsdupc1)) { echo "<tr bgcolor=$color1><td><strong><a href=\"http://www.sernecportal.org/portal/collections/editor/occurrenceeditor.php?q_recordedby=&q_recordnumber=&q_eventdate=&q_catalognumber=&q_othercatalognumbers=&q_observeruid=&q_recordenteredby=&q_dateentered=&q_datelastmodified=&q_processingstatus=&q_exsiccatiid=&q_customfield1=&q_customtype1=EQUALS&q_customvalue1=&q_customfield2=&q_customtype2=EQUALS&q_customvalue2=&q_customfield3=&q_customtype3=EQUALS&q_customvalue3=&collid=193&csmode=0&occid=" . $row6['id']. "&occindex=0&orderby=catalognumber&orderbydir=ASC\">" . $row6['id'] . "</a></strong></td><td><strong>" . number_format($row6['count']) . "</strong></td></tr>"; }
	ob_flush();
	flush();

//End Table
echo "</tbody>";
echo "</table>";
echo "<br>";

//Start a HTML Table
echo "<center><h3><strong><u>Display Duplicates Based on <i>CatalogNumber</i> (Barcode in Occurrences Table)</u></strong></h3></center>";
echo '<script>$(document).ready(function () { $(".expand").click(function () {$("#table2 tbody").show("slow");});$(".collapse").click(function () {$("#table2 tbody").hide("fast");});});</script>';
echo '<center><a class="expand" href="#"><strong>( + )</strong></a> | <a class="collapse" href="#"><strong>( - )</strong></a></center>';
echo '<center><table id=table2 style="border-collapse: collapse;"></center>';
echo "<thead><tr bgcolor=$color3><td><strong><center><u>CatalogNumbers</u></center></strong></td><td><center><strong><u>Times Duplicated</u></strong></center></td></tr></thead>";
echo "<tbody>";

//Show ResultsDupC2
while ($row7 = mysqli_fetch_array($resultsdupc2)) { echo "<tr bgcolor=$color1><td><strong><a href=\"http://www.sernecportal.org/portal/collections/editor/occurrenceeditor.php?q_recordedby=&q_recordnumber=&q_eventdate=&q_catalognumber=" . $row7['catalogNumber'] . "&q_othercatalognumbers=&q_observeruid=&q_recordenteredby=&q_dateentered=&q_datelastmodified=&q_processingstatus=&q_exsiccatiid=&q_customfield1=&q_customtype1=EQUALS&q_customvalue1=&q_customfield2=&q_customtype2=EQUALS&q_customvalue2=&q_customfield3=&q_customtype3=EQUALS&q_customvalue3=&collid=193&csmode=0&occid=&occindex=0&orderby=catalognumber&orderbydir=ASC\">" . $row7['catalogNumber'] . "</a></strong></td><td><strong>" . number_format($row7['count']) . "</strong></td></tr>"; }
	ob_flush();
	flush();

//End Table
echo "</tbody>";
echo "</table>";
echo "<br>";

//Start a HTML Table
echo "<center><h3><strong><u>Display Duplicates Based on <i>OtherCatalogNumbers</i> (Accession# in Occurrences Table)</u></strong></h3></center>";
echo '<script>$(document).ready(function () { $(".expand").click(function () {$("#table3 tbody").show("slow");});$(".collapse").click(function () {$("#table3 tbody").hide("fast");});});</script>';
echo '<center><a class="expand" href="#"><strong>( + )</strong></a> | <a class="collapse" href="#"><strong>( - )</strong></a></center>';
echo '<center><table id=table3 style="border-collapse: collapse;"></center>';
echo "<thead><tr bgcolor=$color3><td><strong><center><u>otherCatalogNumbers</u></center></strong></td><td><center><strong><u>Times Duplicated</u></strong></center></td></tr></thead>";
echo "<tbody>";

//Show ResultsDupC3
while ($row8 = mysqli_fetch_array($resultsdupc3)) { 
	echo "<tr bgcolor=$color1><tr><td><strong><a href=\"http://www.sernecportal.org/portal/collections/editor/occurrenceeditor.php?q_recordedby=&q_recordnumber=&q_eventdate=&q_catalognumber=&q_othercatalognumbers=" . $row8['otherCatalogNumbers'] . "&q_observeruid=&q_recordenteredby=&q_dateentered=&q_datelastmodified=&q_processingstatus=&q_exsiccatiid=&q_customfield1=&q_customtype1=EQUALS&q_customvalue1=&q_customfield2=&q_customtype2=EQUALS&q_customvalue2=&q_customfield3=&q_customtype3=EQUALS&q_customvalue3=&collid=193&csmode=0&occid=&occindex=0&orderby=catalognumber&orderbydir=ASC\">" . $row8['otherCatalogNumbers'] . "</a></strong></td><td><strong>" . number_format($row8['count']) . "</strong></td></tr>"; }
	ob_flush();
	flush();
echo "</tbody>";
echo "</table>";
echo "<br>";

//Start a HTML Table
echo "<center><h3><strong><u>Display Duplicates Based on <i>CoreID</i> (Images Table)</u></strong></h3></center>";
echo '<script>$(document).ready(function () { $(".expand").click(function () {$("#table4 tbody").show("slow");});$(".collapse").click(function () {$("#table4 tbody").hide("fast");});});</script>';
echo '<center><a class="expand" href="#"><strong>( + )</strong></a> | <a class="collapse" href="#"><strong>( - )</strong></a></center>';
echo '<center><table id=table4 style="border-collapse: collapse;"></center>';
echo "<thead><tr bgcolor=$color3><td><strong><center><u>CoreID</u> (Images Table)</center></strong></td><td><center><strong><u>Times Duplicated</u></strong></center></td></tr></thead>";
echo "<tbody>";

//Show ResultsDupC4
while ($row9 = mysqli_fetch_array($resultsdupc4)) { echo "<tr bgcolor=$color1><td><strong><a href=\"http://www.sernecportal.org/portal/collections/editor/occurrenceeditor.php?q_recordedby=&q_recordnumber=&q_eventdate=&q_catalognumber=&q_othercatalognumbers=&q_observeruid=&q_recordenteredby=&q_dateentered=&q_datelastmodified=&q_processingstatus=&q_exsiccatiid=&q_customfield1=&q_customtype1=EQUALS&q_customvalue1=&q_customfield2=&q_customtype2=EQUALS&q_customvalue2=&q_customfield3=&q_customtype3=EQUALS&q_customvalue3=&collid=193&csmode=0&occid=" .$row9['coreid'] . "&occindex=0&orderby=catalognumber&orderbydir=ASC\">". $row9['coreid'] . "</a></strong></td><td><strong>" . number_format($row9['count']) . "</strong></td></tr>"; }
	ob_flush();
	flush();

//End Table
echo "</tbody>";
echo "</table>";
echo "<br>";

//Start a HTML Table
echo "<center><h3><strong><u>Display Duplicates Based on <i>Identifier</i> (Image Links in Images Table)</u></strong></h3></center>";
echo '<script>$(document).ready(function () { $(".expand").click(function () {$("#table5 tbody").show("slow");});$(".collapse").click(function () {$("#table5 tbody").hide("fast");});});</script>';
echo '<center><a class="expand" href="#"><strong>( + )</strong></a> | <a class="collapse" href="#"><strong>( - )</strong></a></center>';
echo '<center><table id=table5 style="border-collapse: collapse;"></center>';
echo "<thead><tr bgcolor=$color3><td><strong><center><u>Identifier</u> (Image Links)</center></strong></td><td><center><strong><u>Times Duplicated</u></strong></center></td></tr></thead>";
echo "<tbody>";

//Show ResultsDupC5
while ($row10 = mysqli_fetch_array($resultsdupc5)) { echo "<tr bgcolor=$color1><td><strong>" . $row10['identifier'] . "</td><td><center><strong>" . number_format($row10['count']) . "</strong></center></td></tr>"; }
	ob_flush();
	flush();

//end table
echo "</tbody>";
echo "</table>";
echo "<br><hr>";

//Display a count of records and then start a HTML Table for Disparity1
echo "<center><h2>" . number_format($rc5_rows) . " Barcodes in <i>Occurrence</i> Table Without Corresponding <i>Image</i></h2></center>";
echo '<script>$(document).ready(function () { $(".expand").click(function () {$("#table6 tbody").show("slow");});$(".collapse").click(function () {$("#table6 tbody").hide("fast");});});</script>';
echo '<center><a class="expand" href="#"><strong>( + )</strong></a> | <a class="collapse" href="#"><strong>( - )</strong></a></center>';
echo '<center><table id=table6 style="border-collapse: collapse;"></center>';
echo "<thead><tr bgcolor=$color3><td><strong><u>Unmatched Barcodes</u></strong></td></tr></thead>";
echo "<tbody>";

//Show Disparity1 results
while ($row11 = mysqli_fetch_array($resultdisparity1)) { echo "<tr bgcolor=$color2><td><strong><center><a href=\"http://www.sernecportal.org/portal/collections/editor/occurrenceeditor.php?q_recordedby=&q_recordnumber=&q_eventdate=&q_catalognumber=" .$row11['catalogNumber'] . "&q_othercatalognumbers=&q_observeruid=&q_recordenteredby=&q_dateentered=&q_datelastmodified=&q_processingstatus=&q_exsiccatiid=&q_customfield1=&q_customtype1=EQUALS&q_customvalue1=&q_customfield2=&q_customtype2=EQUALS&q_customvalue2=&q_customfield3=&q_customtype3=EQUALS&q_customvalue3=&collid=193&csmode=0&occid=&occindex=0&orderby=catalognumber&orderbydir=ASC\">" . $row11['catalogNumber'] . "</a></center></strong></td></tr>"; }
	ob_flush();
	flush();

//end table
echo "</tbody>";
echo "</table>";
echo "<hr>";

//Start a HTML Table for ToShort
echo "<center><h2>" . number_format($rc6_rows) . " Barcodes Have Invalid Length Within <i>Occurrence</i> Table</h2></center>";
echo '<script>$(document).ready(function () { $(".expand").click(function () {$("#table7 tbody").show("slow");});$(".collapse").click(function () {$("#table7 tbody").hide("fast");});});</script>';
echo '<center><a class="expand" href="#"><strong>( + )</strong></a> | <a class="collapse" href="#"><strong>( - )</strong></a></center>';
echo '<center><table id=table7 style="border-collapse: collapse;"></center>';
echo "<thead><tr bgcolor=$color3><td><strong><u>Invalid Length</u></strong></td></tr></thead>";
echo "<tbody>";

//Show Disparity1 results
while ($row12 = mysqli_fetch_array($resulttoshort)) { echo "<tr bgcolor=$color2><td><strong><center><a href=\"http://www.sernecportal.org/portal/collections/editor/occurrenceeditor.php?q_recordedby=&q_recordnumber=&q_eventdate=&q_catalognumber=" .$row12['catalogNumber'] . "&q_othercatalognumbers=&q_observeruid=&q_recordenteredby=&q_dateentered=&q_datelastmodified=&q_processingstatus=&q_exsiccatiid=&q_customfield1=&q_customtype1=EQUALS&q_customvalue1=&q_customfield2=&q_customtype2=EQUALS&q_customvalue2=&q_customfield3=&q_customtype3=EQUALS&q_customvalue3=&collid=193&csmode=0&occid=&occindex=0&orderby=catalognumber&orderbydir=ASC\">" . $row12['catalogNumber'] . "</a></center></strong></td></tr>"; }
	ob_flush();
	flush();

//end table
echo "</tbody>";
echo "</table>";
echo "<br>";

echo "<hr>";
//Start a HTML Table for Disparity2
echo "<center><h2>" . number_format($rc7_rows) . " Invalid Barcodes - These Barcodes Do Not Occur in Known Barcode List</h2></center>";
echo '<script>$(document).ready(function () { $(".expand").click(function () {$("#table8 tbody").show("slow");});$(".collapse").click(function () {$("#table8 tbody").hide("fast");});});</script>';
echo '<center><a class="expand" href="#"><strong>( + )</strong></a> | <a class="collapse" href="#"><strong>( - )</strong></a></center>';
echo '<center><table id=table8 style="border-collapse: collapse;"></center>';
echo "<thead><tr bgcolor=$color3><td><strong><center><u>Invalid Barcodes</u></center></strong></td></tr></thead>";
echo "<tbody>";

//Show Disparity1 results
while ($row13 = mysqli_fetch_array($resultdisparity2)) { echo "<tr bgcolor=$color2><td><strong><center><a href=\"http://www.sernecportal.org/portal/collections/editor/occurrenceeditor.php?q_recordedby=&q_recordnumber=&q_eventdate=&q_catalognumber=" .$row13['catalogNumber'] . "&q_othercatalognumbers=&q_observeruid=&q_recordenteredby=&q_dateentered=&q_datelastmodified=&q_processingstatus=&q_exsiccatiid=&q_customfield1=&q_customtype1=EQUALS&q_customvalue1=&q_customfield2=&q_customtype2=EQUALS&q_customvalue2=&q_customfield3=&q_customtype3=EQUALS&q_customvalue3=&collid=193&csmode=0&occid=&occindex=0&orderby=catalognumber&orderbydir=ASC\">" . $row13['catalogNumber'] . "</a></center></strong></td></tr>"; }
	ob_flush();
	flush();

//end table
echo "</tbody>";
echo "</table>";
echo "<br><hr>";
//Start a HTML Table for keystrokeimages
echo "<center><h2>" . number_format($rckeystrokeimages) . " Images Needing Keystroking of Label Data</h2></center>";
echo '<script>$(document).ready(function () { $(".expand").click(function () {$("#table9 tbody").show("slow");});$(".collapse").click(function () {$("#table9 tbody").hide("fast");});});</script>';
echo '<center><a class="expand" href="#"><strong>( + )</strong></a> | <a class="collapse" href="#"><strong>( - )</strong></a></center>';
echo '<center><table id=table9 style="border-collapse: collapse;"></center>';
echo "<thead><tr bgcolor=$color3><td><strong><center><u>Barcodes</u></center></strong></td></tr></thead>";
echo "<tbody>";

//Show Keystroke Images results
while ($row15 = mysqli_fetch_array($resultskeystrokeimages)) { 
	echo "<tr bgcolor=$color2><td><strong><center><a href=\"http://www.sernecportal.org/portal/collections/editor/occurrenceeditor.php?q_recordedby=&q_recordnumber=&q_eventdate=&q_catalognumber=" .$row15['catalogNumber'] . "&q_othercatalognumbers=&q_observeruid=&q_recordenteredby=&q_dateentered=&q_datelastmodified=&q_processingstatus=&q_exsiccatiid=&q_customfield1=&q_customtype1=EQUALS&q_customvalue1=&q_customfield2=&q_customtype2=EQUALS&q_customvalue2=&q_customfield3=&q_customtype3=EQUALS&q_customvalue3=&collid=193&csmode=0&occid=&occindex=0&orderby=catalognumber&orderbydir=ASC\">" . $row15['catalogNumber'] . "</a></center></strong></td></tr>"; }
	ob_flush();
	flush();

//end table
echo "</tbody>";
echo "</table>";

//display footer
include("footer.php");
?>
