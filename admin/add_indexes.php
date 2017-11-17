<?php
include("connect.php");
include("common.php");
include("functions.php");
include("header.php");
$tablearray = ['barcodes', 'blockedlist', 'duplicates', 'identifications', 'images', 'images', 'imagesys', 'iplant', 'iplant', 'ndrive', 'noskeletalrecords', 'occurrences', 'occurrences'];
$fieldarray = ['barcodes', 'ScientificName', 'id', 'coreid', 'coreid', 'identifier', 'catalogNumber', 'guid', 'barcode', 'ncatalogNumber', 'id', 'id', 'catalogNumber'];

$count = 0;

while ($count < count($tablearray)) {
	idarwincore_add_index($tablearray[$count], $fieldarray[$count], $conn);
	$count++;
}

include("footer.php");
?>