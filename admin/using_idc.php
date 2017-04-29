<?php
include("header.php");
include("connect.php");
include("common.php");
?>
<center><h2>How To Use <i>iDarwinCore</i></h2></center>
<hr>
<br>
<h2><u>Prepping Data for iDarwinCore</u></h2>
<p>iDarwinCore requires Symbiota DwC-A Zip File, and in addition can optionally import a Remote Images File List, and Local Images File list</p>

<p>(1) <strong>Symbiota DwC-A Zip File</strong></p>
<p>(2) <strong>Remote Images File List</strong></p>
<p>(3) <strong>Local Images File List</strong></p>
<p>(4) <strong>Barcode List</strong></p>
<p>(5) <strong>Blocked List</strong></p>

<p>You will first need to make a folder called dwca inside your system or server's tmp folder (for mac users it is usually /Library/WebServer/Documents/tmp, for WAMP users it is usually C:/wamp64/tmp). You only have to do this once.</p>

<p>The only mandatory file for use of iDarwinCore is the Symbiota DwC-A Zip File.  The other files provide a more robust use of iDarwinCore functions.</p>

<p>The Symbiota DwC-A Zip File can be downloaded from the Symbiota portal which hosts your data.  Look under Administrative Control Panel for a link labeled "Download Backup".</p>

<p>The Remote Images File List is a text file that contains a list of all images hosted on a remote server (such as iPlant/CyVerse).  If you are using iPlant/CyVerse, then this list can be obtained by using <a href="https://pods.iplantcollaborative.org/wiki/display/DS/Using+iCommands">iCommands</a>. iCommands is available for many different platforms including Linux, Unix, Mac OS X, and Windows. You will need to know the path to your files on whatever remote system you are using.  Simply install iCommands, configure as instructed from the iCommands website, and then open a terminal (command prompt) and issue the command ils -Lr (path_to_your_folde_and_files_on_the_remote_system) > iplant_t.txt. This constructs a file called iplant_t.txt which contains the full image path and filename along with other important iPlant info.</p>
<p>The Local Images File List is a txt file containing a list of all local specimen images.  This can be obtained by opening a command prompt and changing directory to the root imaging folder and typing <i>dir /s /b > nDrive.txt</i>. For Mac OS users, you will generate your nDrive.txt with the following command <i>find (path_to_your_folders_or_files) -type f > nDrive.txt</i>. This will construct a file called nDrive.txt which contains the full path and file location for your specimens images.</p>
<p>The Barcode List is a list of all barcodes purchased for your collection.  This list can usually be produced with ease in excel and saved as a text file.</p>
<p>The Blocked List is a list of taxa in which you desire the locality and image to be hidden from the general public.  This should be a csv with four fields: Family, ScientificName, ScientificNameAuthorship, TaxonID.  This list can be exported from a Symbiota checklist.</p>


<h2>Importing Symbiota Portal Data</h2>
<p>In order to use iDarwinCore, you need to load it with your data</p>
<p>The first files you want to install (if available) are the iplant_t.txt, nDrive.txt, barcodes.txt, and blockedlist.txt.  These files can be imported by clicking on the Setup menu and choosing the appropriate menu item to upload the particular file(s) you may have.</p>
<p>iDarwinCore can import your Symbiota DwC-A backup files along with the files you placed in the "dwca" folder.  To download the DwC-A backup file log into the symbiota portal that is hosting the data you are interested in importing, and download a backup of your data.  Next open idarwincore up in your web browser (eg. http://localhost/idarwincore/) and click on Setup menu at the top, and then on Import DwC-A File.</p>
<p>Click on "Choose file" button and browse to the symbiota backup file you downloaded and click on it and then click on the "Upload" button.</p>
<p>The script can take a few minutes to import all your data along with generating new data tables.  The script provides some feedback as to what it is processing on your screen.</p>
<p>Once finished you should have 11 tables within your idarwincore database.</p>

<h2>Using iDarwinCore</h2>

<p><strong><u>iDarwinCore creates and utilizes a few MySQL data tables</u></strong></p>
<p>(1) <strong>Occurrences</strong> - A list of all specimen occurrence records</p>
<p>(2) <strong>Identifications</strong> - A list of all annotations to occurrence records</p>
<p>(3) <strong>Images</strong> - A list of all image links</p>
<p>(4) <strong>Blocked</strong> - A list of specimens of special concern to which locality data will be hidden in queries</p>
<p>(5) <strong>Barcodes</strong>- A list of all your barcodes (optional)</p>
<p>(6) <strong>NoSkeletalRecords</strong> - A list of occurrence records in which there exists only a catalogNumber and image file</p>
<p>(7) <strong>iPlant</strong> - A list of all images, image paths, and barcodes found on iPlant</p>
<p>(8) <strong>Duplicates</strong> - A list of duplicate occurrence records</p>
<p>(9) <strong>nDrive</strong> - A list of all images, image paths, and barcodes found in your local image storage</p>
<p>(10) <strong>ImageSys</strong> - A list of all occurrence records with images, which includes the occurrence record information along with image file paths, and filenames</p>
<p>(11) <strong>Occurrences_Full</strong> - A list similar to ImageSys but also includes all the local image file paths and filenames</p>

<p><strong><u>iDarwinCore Menu Options</u></strong></p>
<p><strong>SEARCH</strong></p>
<p><strong>Search Collection</strong> - Allows you to query the Occurrence Records for fields such as Family, State/Province, County, Genus, Species, Accession #, Collector, Collection #, and Barcode.  Output will be displayed in paginated table, with the id field being a hotlink to occurrence editor of the Symbiota portal.  Note this feature hides images, and locality data for taxa present in the blockedlist table.</p>
<p><strong>Admin Search</strong> - Allows you to query the Occurrence Records for fields such as Family, State/Province, County, Genus, Species, Accession #, Collector, Collection #, and Barcode.  Output will be displayed in paginated table, with the id field being a hotlink to occurrence editor of the Symbiota portal.  Note this feature does not hide images or locality data for taxa present in the blockedlist table</p>
<p><strong>Search By Family</strong> - Allows you to browse the Occurrence Records.  This feature starts by displaying all the plant families within the occurrence records.  You can then click on a family, which then displays a list of all genera, you can then click on a genus, in which it will display all species belonging to that genus held in the occurrence records.</p>
<p><strong>Show County Records</strong> - Allows you to enter the genus, species, and state.  A list of counties within your chosen state in which the taxa you chose are present in the occurrence records.</p>
<p><strong>SHOW TABLES</strong></p>
<p><strong>Show Tables</strong> - Allows you to peruse the contents of any of the 11 tables listed above</p>
<p><strong>DIAGNOSTICS</strong></p>
<p><strong>Jump To SernecPortal Record</strong> - This allows you to enter an OCCID (occurrence record id) for SernecPortal and to be taken to the occurrence editor for that particular occurrence record id.</p>
<p><strong>Search iPlant By Barcode</strong> - This allows you to enter a barcode and retrieve the iPlant Data Service Links information (which contains iPlant file location, guid, etc.)</p>
<p><strong>Show Duplicate Records</strong> - Displays a list of all duplicate occurrence records (see above in regards to Duplicate Table)</p>
<p><strong>Database Statistics</strong> - This generates several lists, such as: unique record statistics for several tables, displays a list of duplicates based on occurrence id (in occurrences table), displays duplicates based on catalogNumber (aka barcode in occurrences table), displays a list of duplicates based on otherCatalogNumbers (aka Accession# in occurrences table), displays duplicates based on coreid (Image Table), display a list of barcoded specimens (in occurrences table) without corresponding image file, displays a list of barcodes of invalid length (in occurrences table), displays a list of invalid barcodes (in occurrence table), and displays a list of barcodes (in occurrence records) for which no label data exists.  Clicking on any item in any of these lists takes one to the occurrence editor on SernecPortal.</p>
<p><strong>Log Image Records XML to File</strong> - This takes a list of barcodes and requests information via iPlant's Data Service for each barcode and stores the iPlant data service data (xml data) to a file in /idarwincore/xmls/ folder.</p>
<p><strong>DOCUMENTATION</strong></p>
<p><strong>Installation Instructions</strong> - Shows how to install iDarwinCore and configure MySQL/Apache/PHP for best results.</p>
<p><strong>Using iDarwinCore</strong> - (what you are currently reading)</p>
<?php
include("footer.php");
?>
