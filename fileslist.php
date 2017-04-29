<?php 
include("header.php");
include("common.php");
?>
<br><br><br>
<center><strong>Files of iDarwinCore</strong></center><br><br>
<b>admindisplay.php</b> - Given input from supersearch.php, allows displaying of results without locality being hidden due to blockedlist.<br>
<b>barcode.php</b> - Given a barcode, will open Bisque's data service links query for the barcode, showing a list of iplant files matching the barcode (script is partnered with barcodesearch)<br>
<b>barcodesearch.php</b> - Allows entry of a barcode which is passed to barcode.php (script is partnered with barcode.php).<br>
<b>browser_family.php</b> - Displays a list of plant families present within collection.  Each family listed is also a link to a list of genera belonging to that family (script is partnered with browse_genera.php).<br>
<b>browser_genera.php</b> - Given a plant family, displays a list of genera for that family.  Each genera listed is also a link to a list of species belonging to that genus (script is partnered with browse_family.php and browse_species.php).<br>
<b>browser_species.php</b> - Given a family and genus, displays a list of taxa.  Each taxon listed is a link to all occurrences for that taxon (script is partnered with browse_family.php and browse_genera.php).<br>
<b>build_barcodes_table.php</b> - Builds the barcode table in MySQL by loading the data from an uploaded barcodes.txt file.<br>
<b>build_blockedlist_table.php</b> - Builds the blockedlist table in MySQL by loading the data from an uploaded blockedlist.csv file.<br>
<b>build_duplicates_table.php</b> - Builds the duplicates and noskeletal records tables of MySQL, which contains a list of all records with non-unique otherCatalogNumbers (accession #), records with a non-null catalogNumber and null otherCatalogNumbers populate the noskeletalrecords MySQL table, (script is partnered with duplicate)<br>
<b>build_imagesys_table.php</b> - Builds the imagesys table in MySQL which is a join of the occurrences table and images table via MySQL queries.<br>
<b>build_iplant_table.php</b> - Builds the iplant table in MySQL by loading the data from an uploaded iplant.txt file (script is partnered with parse_iplant.php).<br>
<b>build_ndrive_table.php</b> - Builds the ndrive table in MySQL by loading the data from an uploaded ndrive.txt file (script is partnered with parse_ndrive.php).<br>
<b>build_occurrences_full_table.php</b> - Builds the occurrences_full table in MySQL by joining of imagesys table with ndrive table.<br>
<b>common.php</b> - The config file for iDarwinCore, this file contains a plethora of variables that control everything from text/table colors, file and path locations, and various text labels used throughout iDarwinCore.<br>
<b>common.sample.php</b> - Sample config file which will be edited to form common.php.<br>
<b>connect.php</b> - Holds all the MySQL credentials and database name used for PHP to form connections to the MySQL server.<br>
<b>connect.sample.php</b> - Sample connect.php file which will be edited to form connect.php.<br>
<b>display.php</b> - Displays MySQL query results produced from various other PHP files (script is partnered with search.php, search_counties, browser_family.php, browser_genera.php, browser_species.php, display_counties.php)<br>
<b>display_counties.php</b> - Displays a list of counties given a state and taxon (script is partnered with search_counties.php and display.php).<br>
<b>favicon.ico</b> - Icon used by browser.<br>
<b>fgsi_count.php</b> - Displays a count of all imaged specimens in alphabetic order by family/genus/species/infraspecific epithet.<br>
<b>fixindices.php</b> - Adds indices to various MySQL tables which facilitate faster query times, normally the build scripts listed above handle indexing the table, sometimes if an error occurs in the building of tables this script is needed.<br>
<b>footer.php</b> - Displays a footer at the bottom of each page.<br>
<b>header.php</b> - Displays a header at the top of each page, also sets various HTML settings for iDarwinCore.<br>
<b>header_sample.php</b> - Sample header file which when edited becomes the header.php file.<br>
<b>index.php</b> - Main start page of iDarwinCore.<br>
<b>installation_instructions.php</b> - Documentation showing installation of iDarwinCore using PHP/MySQL/Apache.<br>
<b>jquery-3.1.0.min.js</b> - JavaScript package which assists in building tables and pagination.<br>
<b>main.css</b> - Main Cascading Style Sheet for iDarwinCore, necessary for formatting of display (table formatting, pull down menus).<br>
<b>menubar.php</b> - Contains the pull down menu selections for iDarwinCore.<br>
<b>occid.php</b> - Given a occurrence id, it opens up SernecPortal's occurrence editor for that particular occurrence id (script is partnered with occid_search.php).<br>
<b>occid_search.php</b> - Allows the input of an occid number which is passed to occid.php (script is partnered with occid.php).<br>
<b>paginator.php</b> - Displays with pagination any MySQL table which is passed to the script (script is partnered with menubar.php).<br>
<b>parse_iplant.php</b> - Parses the iplant_t.txt file to produce iplantdwca.txt that will be imported into the MySQL database by build_iplant_table.php (script is partnered with build_iplant_table.php).<br>
<b>parse_ndrive.php</b> - Parses the nDrive.txt file to produce ndjpegs_with_paths.txt that will be imported into the MySQL database by build_ndrive_table.php (script is partnered with build_ndrive_table.php).<br>
<b>search.php</b> - Allows input such as genus, species, state/Province, county, collector, collection number, catalogNumber, otherCatalogNumbers which are then passed to the display.php for query and display of results (script is partnered with display.php).<br>
<b>search_counties.php</b> - Allows input of genus, species, and state which are then passed to display_counties.php (script is partnered with display_counties.php).<br>
<b>setup_database.php</b> - Builds the initial iDarwinCore MySQL database and tables, is usually ran only once then this file is often deleted).<br>
<b>setup_database.sample.php</b> - Sample file which is edited and saved to setup_database.php.<br>
<b>showdupes.php</b> - Displays the output of the duplicates MySQL Table (script is partnered with build_duplicates_table.php).<br>
<b>shownoskeletalrecords.php</b> - Displays the contents of the noskeletalrecords MySQL table (script is partnered with build_duplicates_table.php).<br>
<b>simplecsv.php</b> - Used to build and populate most of the iDarwinCore MySQL tables by calling the various build_xxxxxx_table.php files (script is partnered with build_barcodes_table.php, build_blockedlist_table.php, build_blockedlist_table.php, build_duplicates_table.php, build_imagesys_table.php, build_iplant_table.php, build_ndrive_table.php and build_occurrences_full_table.php).<br>
<b>statistics.php</b> - Provides detailed record of all unique and duplicate records present within iDarwinCore using a plethora of MySQL queries.<br>
<b>supersearch.php</b> - Allows input such as genus, species, state/Province, county, collector, collecton number, catalogNumber, otherCatalogNumbers which are then passed to the admindisplay.php (script is partnered with admindisplay.php).<br>
<b>templates.php</b> - Displays a list of excel templates and mail merge documents.<br>
<b>testphp.php</b> - Displays PHP settings.<br>
<b>truncate_all_tables.php</b> - Deletes all records from all iDarwinCore tables, used when you want to rebuild the tables.<br>
<b>txtuploader.php</b> - Used to upload a file passed to it from any of the upload_xxxxxx.php files (script is partnered with upload_barcodes_txt.php, upload_blockedlist_csv.php, upload_iplant_t_txt.php, and upload_ndrive_txt.php).<br>
<b>upload_barcodes_txt.php</b> - Allows you to select the barcodes.txt file you wish to upload (script is partnered with txtuploader.php).<br>
<b>upload_blockedlist_csv.php</b> - Allows you to select the blockedlist.csv file you wish to upload (script is partnered with txtuploader.php).<br>
<b>upload_iplant_t_txt.php</b> - Allows you to select the iplant_t.txt file you wish to upload (script is partnered with txtuploader.php).<br>
<b>upload_ndrive_txt.php</b> - Allows you to select the ndrive.txt file you wish to upload (script is partnered with txtuploader.php).<br>
<b>using_idc.php</b> - Documentation showing the various iDarwinCore functions.<br>
<b>zipupload.php</b> - Allows you to select, upload, and uncompress a DwC-A backup zip file, it then executes the simplecsv.php to populate the iDarwinCore MySQL database tables (script is partnered with simplecsv.php).<br>
<b>/images/comingsoon.jpg</b> - Place holder image used when there are no image thumbnails for the record.<br>
<b>/images/headerimage.jpg</b> - Default header image for iDarwinCore.<br>
<b>/xmls/logxml.php</b> - Records the XML output of the Bisque Data Service information for each identifier field present in the images table to a file.<br>
<b>/xmls/logxml_from_barcodefile.php</b> Records the XML output of the Bisque Data Service information given a text file containing barcodes.<br>
<b>logxml_from_file.php</b> - Records the XML output of the Bisque Data Service information given a text (or csv) file containing the identifier field to an output file showing good and bad data service call links.<br>
<br><br>
<?php include("footer.php"); ?>