<?php
/* ServeThis v 1.0
by Robert R. Pace <robert.pace@eku.edu>

This script will build links to all files present within the folder
and display this list in a table
*/

//Include a few files which will allow the appropriate look for the display
include("header.php");
include("common.php");
include("connect.php");

//create a handle for the directory to be opened
$dir_to_list = opendir('.');

//create a table for output of our file list
echo "<br><br><br>";
echo '<center><table id=table1 style="border-collapse: collapse;"></center>';
echo "<thead><tr bgcolor=$color3><td><strong><center><u>Files</u></center></strong></td></tr></thead>";
echo "<tbody>";

//loop through the directory being sure to exclude files we do not want listed until we reach the end of the list
while(false !== ($file = readdir($dir_to_list))){
    if($file != "." && $file != ".." && $file != "index.php" && $file != "header.php" && $file != "common.php" && $file != "connect.php" && $file != "footer.php" && $file != "jquery-3.1.0.min.js" && $file != "menubar.php" && $file != "main.css"){
        $link = "<a href='./$file'> $file </a><br />";
        echo "<tr bgcolor=$color1><td><strong>$link</strong></td></tr>";
    }
}

//close up the table
echo "</tbody>";
echo "</table>";

//close the connection to the directory
closedir($dir_to_list);

//display our footer
include("footer.php");
?>