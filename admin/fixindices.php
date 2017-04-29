<?php
//Addes indices to MySQL tables in case they are needed
include("header.php");
include("common.php");
include("connect.php");

$query1="ALTER TABLE `occurrences` ADD INDEX (`id`)";
$query2="ALTER TABLE `images` ADD INDEX (`coreid`)";
$query3="ALTER TABLE `identifications` ADD INDEX (`coreid`)";
$query4="ALTER TABLE `occurrences` ADD INDEX (`catalogNumber`)";
$query5="ALTER TABLE `images` ADD INDEX (`identifier`)";

$result1 = mysqli_query($conn, $query1) or die ('Could not connect to mysqli (query1): ' . mysqli_error($conn));
$result2 = mysqli_query($conn, $query2) or die ('Could not connect to mysqli (query2): ' . mysqli_error($conn));
$result3 = mysqli_query($conn, $query3) or die ('Could not connect to mysqli (query3): ' . mysqli_error($conn));
$result4 = mysqli_query($conn, $query4) or die ('Could not connect to mysqli (query4): ' . mysqli_error($conn));
$result5 = mysqli_query($conn, $query5) or die ('Could not connect to mysqli (query5): ' . mysqli_error($conn));
echo "<br><br>Done!<br><br>";
include("footer.php");
?>