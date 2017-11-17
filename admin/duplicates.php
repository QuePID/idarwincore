<?php
/*iDarwinCore version 1.1
  By Robert R. Pace <robert.pace@eku.edu>
  
  This database software is designed for natural
  history collections utilizing Darwin Core Archive
  data for online querying of the collection's data
  
  This file (duplicates.php) creates a new table called
  duplicates.  The duplicates table will house records that
  are not unique by otherCatalogNumber (accession#) within the
  occurrences table.
  
  Records within the newly populated duplicates table that have no
  skeletal record data (only image data) will be moved from duplicates table
  to the noskeletalrecords table
*/

//the include files:
//header.php - this contains the html header information such as university banner and icon along with title text
//common.php - this contains global variables that are needed for formatting or shaping queries (such as the maximum number of query results via LIMIT)
//connect.php - this contains the connection settings for the MySQL database (such as Db name, username, password, server)
//footer.php - this contains the information to be displayed at the bottom of the page (copyright, version)
//

include("connect.php");
include("common.php");
include("header.php");


//query to delete table duplicates
$delquery = "DROP TABLE if exists duplicates";

//delete table duplicates
$result1 = mysqli_query($conn, $delquery) or die("MySQL Error..." . (mysqli_error($conn)));

//query that will create a new table duplicates that will house all duplicated records within database
//query2 that will empty noskeletalrecords table
//query3 that will insert any duplicate with empty accession number (otherCatalogNumbers) into noskeletalrecord table
//query4 that will delete any empty accession number (otherCatalogNumbers) entries from the duplicates table
$query="CREATE TABLE duplicates AS SELECT a.* FROM occurrences a INNER JOIN (SELECT otherCatalogNumbers, COUNT(*) FROM occurrences GROUP BY otherCatalogNumbers HAVING COUNT(*) > 1) b ON a.otherCatalogNumbers = b.otherCatalogNumbers";
$query2="TRUNCATE TABLE noskeletalrecords";
$query3 = "INSERT INTO noskeletalrecords SELECT * FROM duplicates where otherCatalogNumbers='' ";
$query4 = "DELETE FROM duplicates where otherCatalogNumbers=''";

//add idices to duplicates and noskeletalrecords table to speed up queries
$query5 = "ALTER TABLE `duplicates` ADD INDEX(`id`)";
$query6 = "ALTER TABLE `noskeletalrecords` ADD INDEX(`id`)";

//delete records from noskeletalrecords that have no barcode
$query7 = "DELETE FROM `noskeletalrecords` WHERE catalogNumber=''";

//create new table duplicates
//empty the noskeletalrecords table
//populate noskeletalrecords table with duplicates missing accession number (otherCatalogNumbers)
//delete rows without accession number (otherCatalogNumbers)
$result = mysqli_query($conn, $query) or die("MySQL Error..." . (mysqli_error($conn)));
$result2 = mysqli_query($conn, $query2) or die("MySQL Error..." . (mysqli_error($conn)));
$result3 = mysqli_query($conn, $query3) or die("MySQL Error..." . (mysqli_error($conn)));
$result4 =  mysqli_query($conn, $query4) or die("MySQL Error..." . (mysqli_error($conn)));

//add indices
$results5 = mysqli_query($conn, $query5) or die("MySQL Error..." . (mysqli_error($conn)));
$results6 = mysqli_query($conn, $query6) or die("MySQL Error..." . (mysqli_error($conn)));

//delete records with no barcode
$results7 = mysqli_query($conn, $query7) or die("MySQL Error..." . (mysqli_error($conn)));

//initialize $row_count, this variable will hold the number of rows returned by the query
//and will be used to color resultant rows
$row_count = 0;

//concantenate all the prequery variables into a query string which will be used to query the database
$query = "SELECT * FROM duplicates ORDER BY otherCatalogNumbers";

//echo the query string to screen for debugging
//echo $query;

// submit the query
$result = mysqli_query($conn, $query) or die("MySQL Error..." . (mysqli_error($conn)));

//calculate number of results of the query ran and display
$querystats=mysqli_num_rows($result); 
echo "<center><p><b>Your query returned $querystats results</b></p></center>";

//Start a HTML Table
echo '<table style="border-collapse: collapse;">';

// display results in HTML Table
echo "<tr><td bgcolor=$color3><b>#</b></td><td bgcolor=$color3><b>ID</td><td bgcolor=$color3><b>Herbarium</b></td><td bgcolor=$color3><b>Taxon</td><td bgcolor=$color3><b>Bar Code</td><td bgcolor=$color3><b>Accession</td><td bgcolor=$color3><b>State</td><td bgcolor=$color3><b>County</td><td bgcolor=$color3><b>Family</b></td><td bgcolor=$color3><b>Genus</b></td><td bgcolor=$color3><b>Species</td><td bgcolor=$color3><b>InfraSpecificEpithet</td><td bgcolor=$color3><b>Taxon Author</td><td bgcolor=$color3><b>Habitat</td><td bgcolor=$color3><b>Locality</td><td bgcolor=$color3><b>Latitude</td><td bgcolor=$color3><b>Longitude</td><td bgcolor=$color3><b>Natural_Areas</td><td bgcolor=$color3><b>Collector</td><td bgcolor=$color3><b>Collection_Number</td><td bgcolor=$color3><b>Country</td><td bgcolor=$color3><b>Col_Date</td></tr>";

//initialize $resultcounter variable
$resultcounter=1;

// for every result returned from query do the below

while ($row = mysqli_fetch_array($result))
{

// determine row colour
$row_color = ($row_count % 2) ? $color1 : $color2;
$IKid = "$row[id]";
$IKherbarium = "$row[institutionCode]";
$IKtaxon = "$row[scientificName]";
$IKbarcode = "$row[catalogNumber]";
$IKkingdom = "$row[kingdom]";
$IKphylum = "$row[phylum]";
$IKclass = "$row[class]";
$IKorder = "$row[order]";
$IKfamily = "$row[family]";
$IKgenus = "$row[genus]";
$IKspecies = "$row[specificEpithet]";
$IKvarietyname = "$row[infraspecificEpithet]";
$IKtaxonauthor = "$row[scientificNameAuthorship]";
$IKaccession = "$row[otherCatalogNumbers]";
$IKstate = "$row[stateProvince]";
$IKcounty = "$row[county]";
$IKhabitat = "$row[habitat]";
$IKlocality = "$row[locality]";
$IKlatitude = "$row[decimalLatitude]";
$IKlongitude = "$row[decimalLongitude]";
$IKcollector1 = "$row[recordedBy]";
$IKcollectionnumber = "$row[recordNumber]";
$IKcountry = "$row[country]";
$IKcolyear = "$row[year]";
$IKcolmonth = "$row[month]";
$IKcolday = "$row[day]";
$IKnaturalarea = "$row[municipality]";
//Initialize variables to store urls for more indepth queries
$stateq = "$urlq"."state="."$IKstate";
$countyq = "$urlq"."county="."$IKcounty"."&state="."$IKstate";


// Now display actual data in the table cells via echo to browser of the $row's array of data
   echo "<tr><td bgcolor = $row_color>$resultcounter</td>";
   echo "<td bgcolor=$row_color>$IKid</td>";
   echo "<td bgcolor=$row_color>$IKherbarium</td>";
   echo "<td bgcolor=$row_color><i>$IKtaxon</i> $IKtaxonauthor</td>";
   echo "<td bgcolor=$row_color>$IKbarcode</td>";
   echo "<td bgcolor=$row_color>$IKaccession</td>";
   echo "<td bgcolor=$row_color><a href='$stateq'>$IKstate</a></td>";
   echo "<td bgcolor=$row_color><a href='$countyq'>$IKcounty</a></td>";
   echo "<td bgcolor=$row_color>$IKfamily</td>";
   echo "<td bgcolor=$row_color>$IKgenus</td>";
   echo "<td bgcolor=$row_color>$IKspecies</td>";
   echo "<td bgcolor=$row_color>$IKvarietyname</td>";
   echo "<td bgcolor=$row_color>$IKtaxonauthor</td>";
   echo "<td bgcolor=$row_color>$IKhabitat</td>";
   echo "<td bgcolor=$row_color>$IKlocality</td>";
   echo "<td bgcolor=$row_color>$IKlatitude</td>";
   echo "<td bgcolor=$row_color>$IKlongitude</td>";
   echo "<td bgcolor=$row_color>$IKnaturalarea</td>";
   echo "<td bgcolor=$row_color>$IKcollector1</td>";
	 echo "<td bgcolor=$row_color>$IKcollectionnumber</td>";
   echo "<td bgcolor=$row_color>$IKcountry</td>";
   echo "<td bgcolor=$row_color>$IKcolyear"."-"."$IKcolmonth"."-"."$IKcolday</td>";
   echo "</tr>";

   $resultcounter++;
   
   // Add 1 to the row count
   $row_count++;

}
echo "</table>";

//include footer.php which will display software name, version, author, copyright, and contact information at the bottom of the page
include_once("footer.php");

?>

</div>

</body>
</html>


?>