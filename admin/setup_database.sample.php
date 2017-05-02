<?php

/*IDarwinCore version 1.0
  By Robert R. Pace <robert.pace@eku.edu>
  
  This database software is designed for natural
  history collections utilizing Darwin Core Archive
  data for online querying of the collection's data
  
  This file (setup_database.php) is used to create
  the ikdarwin database and build all the tables.
  
  It is most likely only to be ran one time and then
  the php can be deleted.  It is important to note that
  this PHP contains MySQL login credentials independent of
  the connect.php file.
*/

//customization of IKdarwin is achieved through editing of 
//common.php, header.php, connect.php, and footer.php

//common.php holds color choices and variables used throughout the php package
include ("common.php");

//header.php creates the necessary html header data along with the header image
include ("header.php");

//mysql server ip:port
$dbhost = 'localhost';
//mysql server username
$dbuser = 'username';
//mysql server password
$dbpass = 'password';
//mysql database name
$dbname = 'idarwincore';

//connection variables which will establish connection to MySQL database or return error
$conn = mysqli_connect($dbhost, $dbuser, $dbpass) or die('Could not connect to mysqli: ' . mysqli_connect_errno());


//let the user know what is going on
echo "<h1><center>Creating the necessary database tables...please wait!</center></h1>";

//these query strings hold the mysql commands to create the database and subsequent tables and all their fields

//create query string to create database if it doesn't already exist
$query = "CREATE DATABASE IF NOT EXISTS $dbname";


//create query string to create the blockedlist table and all it's fields
$query1 = "CREATE TABLE `blockedlist` ( `Family` varchar(255) DEFAULT NULL, `ScientificName` varchar(255) DEFAULT NULL, `ScientificNameAuthorship` varchar(255) NOT NULL, `TaxonID` int(12) DEFAULT NULL) ENGINE=InnoDB DEFAULT CHARSET=latin1";

//create query string to create the duplicates table and all it's fields
$query2 = "CREATE TABLE `duplicates` ( `id` int(10) NOT NULL DEFAULT '0', `institutionCode` varchar(64) DEFAULT NULL, `collectionCode` varchar(64) DEFAULT NULL, `basisOfRecord` varchar(32) DEFAULT NULL, `occurrenceID` varchar(255) DEFAULT NULL, `catalogNumber` varchar(32) DEFAULT NULL, `otherCatalogNumbers` varchar(255) DEFAULT NULL, `kingdom` varchar(255) DEFAULT NULL, `phylum` varchar(255) DEFAULT NULL, `class` varchar(255) DEFAULT NULL, `order` varchar(255) DEFAULT NULL, `family` varchar(255) DEFAULT NULL, `scientificName` varchar(255) DEFAULT NULL, `tidInterpreted` int(10) DEFAULT NULL, `scientificNameAuthorship` varchar(255) DEFAULT NULL, `genus` varchar(255) DEFAULT NULL, `specificEpithet` varchar(255) DEFAULT NULL, `taxonRank` varchar(255) DEFAULT NULL, `infraspecificEpithet` varchar(255) DEFAULT NULL, `identifiedBy` varchar(255) DEFAULT NULL, `dateIdentified` varchar(45) DEFAULT NULL, `identificationReferences` text, `identificationRemarks` text, `taxonRemarks` text, `identificationQualifier` varchar(255) DEFAULT NULL, `typeStatus` varchar(255) DEFAULT NULL, `recordedBy` varchar(255) DEFAULT NULL, `recordedByID` int(10) DEFAULT NULL, `associatedCollectors` varchar(255) DEFAULT NULL, `recordNumber` varchar(45) DEFAULT NULL, `eventDate` date DEFAULT NULL, `year` int(10) DEFAULT NULL, `month` int(10) DEFAULT NULL, `day` int(10) DEFAULT NULL, `startDayOfYear` int(10) DEFAULT NULL, `endDayOfYear` int(10) DEFAULT NULL, `verbatimEventDate` varchar(255) DEFAULT NULL, `occurrenceRemarks` text, `habitat` text, `substrate` varchar(255) NOT NULL, `verbatimAttributes` varchar(255) DEFAULT NULL, `fieldNumber` varchar(45) DEFAULT NULL, `informationWithheld` varchar(250) DEFAULT NULL, `dataGeneralizations` varchar(250) DEFAULT NULL, `dynamicProperties` text, `associatedTaxa` text, `reproductiveCondition` varchar(255) DEFAULT NULL, `establishmentMeans` varchar(45) DEFAULT NULL, `cultivationStatus` varchar(255) DEFAULT NULL, `lifeStage` varchar(45) DEFAULT NULL, `sex` varchar(45) DEFAULT NULL, `individualCount` varchar(45) DEFAULT NULL, `samplingProtocol` varchar(100) DEFAULT NULL, `samplingEffort` varchar(200) DEFAULT NULL, `preparations` varchar(100) DEFAULT NULL, `country` varchar(64) DEFAULT NULL, `stateProvince` varchar(255) DEFAULT NULL, `county` varchar(64) DEFAULT NULL, `municipality` varchar(255) DEFAULT NULL, `locality` text, `locationRemarks` varchar(255) DEFAULT NULL, `localitySecurity` varchar(255) DEFAULT NULL, `localitySecurityReason` varchar(255) DEFAULT NULL, `decimalLatitude` double DEFAULT NULL, `decimalLongitude` double DEFAULT NULL, `geodeticDatum` varchar(255) DEFAULT NULL, `coordinateUncertaintyInMeters` int(10) DEFAULT NULL, `footprintWKT` text, `verbatimCoordinates` varchar(255) DEFAULT NULL, `georeferencedBy` varchar(255) DEFAULT NULL, `georeferenceProtocol` varchar(255) DEFAULT NULL, `georeferenceSources` varchar(255) DEFAULT NULL, `georeferenceVerificationStatus` varchar(32) DEFAULT NULL, `georeferenceRemarks` varchar(255) DEFAULT NULL, `minimumElevationInMeters` int(6) DEFAULT NULL, `maximumElevationInMeters` int(6) DEFAULT NULL, `minimumDepthInMeters` int(10) DEFAULT NULL, `maximumDepthinMeters` int(10) DEFAULT NULL, `verbatimDepth` int(10) DEFAULT NULL, `verbatimElevation` varchar(255) DEFAULT NULL, `disposition` varchar(100) DEFAULT NULL, `language` varchar(20) DEFAULT NULL, `genericcolumn1` varchar(255) DEFAULT NULL, `genericcolumn2` varchar(255) DEFAULT NULL, `storageLocation` varchar(255) DEFAULT NULL, `observerUid` int(10) DEFAULT NULL, `processingStatus` varchar(255) DEFAULT NULL, `duplicateQuantity` int(10) DEFAULT NULL, `recordEnteredBy` varchar(255) DEFAULT NULL, `dateEntered` datetime DEFAULT NULL, `dateLastModified` datetime DEFAULT NULL, `modified` datetime DEFAULT NULL, `sourcePrimaryKey` varchar(255) DEFAULT NULL, `recordId` int(10) DEFAULT NULL, `references` text) ENGINE=MyISAM DEFAULT CHARSET=latin1";

//create query string to create the identifications table and all it's fields
$query3 = "CREATE TABLE `identifications` ( `coreid` int(10) DEFAULT NULL, `identifiedBy` varchar(255) DEFAULT NULL, `IdentifiedByID` int(10) DEFAULT NULL, `dateIdentified` date DEFAULT NULL, `identificationQualifier` varchar(255) DEFAULT NULL, `scientificName` varchar(255) DEFAULT NULL, `tidInterpreted` varchar(255) DEFAULT NULL, `identificationIsCurrent` int(10) DEFAULT NULL, `scientificNameAuthorship` varchar(255) DEFAULT NULL, `genus` varchar(255) DEFAULT NULL, `specificEpithet` varchar(255) DEFAULT NULL, `taxonRank` int(10) DEFAULT NULL, `infraspecificEpithet` varchar(255) DEFAULT NULL, `identificationReferences` varchar(255) DEFAULT NULL, `identificationRemarks` varchar(255) DEFAULT NULL, `recordID` int(10) DEFAULT NULL, `modified` datetime DEFAULT NULL) ENGINE=InnoDB DEFAULT CHARSET=latin1";

//create query string to create the images table and all it's fields
$query4 = "CREATE TABLE `images` ( `coreid` int(10) DEFAULT NULL, `identifier` varchar(255) DEFAULT NULL, `accessURI` varchar(255) DEFAULT NULL, `thumbnailAccessURI` varchar(255) DEFAULT NULL, `goodQualityAccessURI` varchar(255) DEFAULT NULL, `rights` varchar(255) DEFAULT NULL, `caption` varchar(255) DEFAULT NULL, `comments` text, `providerManagedID` varchar(255) DEFAULT NULL, `MetadataDate` varchar(255) DEFAULT NULL, `associatedSpecimenReference` varchar(255) DEFAULT NULL, `type` varchar(255) DEFAULT NULL, `subtype` varchar(255) DEFAULT NULL, `format` varchar(255) DEFAULT NULL, `metadataLanguage` varchar(255) DEFAULT NULL, KEY `coreid` (`coreid`), KEY `coreid_2` (`coreid`), KEY `coreid_3` (`coreid`), KEY `coreid_4` (`coreid`), KEY `coreid_5` (`coreid`), KEY `coreid_6` (`coreid`), KEY `coreid_7` (`coreid`), KEY `coreid_8` (`coreid`), KEY `coreid_9` (`coreid`), KEY `coreid_10` (`coreid`), KEY `coreid_11` (`coreid`), KEY `coreid_12` (`coreid`), KEY `coreid_13` (`coreid`), KEY `coreid_14` (`coreid`), KEY `coreid_15` (`coreid`), KEY `coreid_16` (`coreid`)) ENGINE=InnoDB DEFAULT CHARSET=latin1";

//create query string to create the noskeletalrecords table and all it's fields
$query5 = "CREATE TABLE `noskeletalrecords` ( `id` int(10) NOT NULL DEFAULT '0', `institutionCode` varchar(64) DEFAULT NULL, `collectionCode` varchar(64) DEFAULT NULL, `basisOfRecord` varchar(32) DEFAULT NULL, `occurrenceID` varchar(255) DEFAULT NULL, `catalogNumber` varchar(32) DEFAULT NULL, `otherCatalogNumbers` varchar(255) DEFAULT NULL, `kingdom` varchar(255) DEFAULT NULL, `phylum` varchar(255) DEFAULT NULL, `class` varchar(255) DEFAULT NULL, `order` varchar(255) DEFAULT NULL, `family` varchar(255) DEFAULT NULL, `scientificName` varchar(255) DEFAULT NULL, `tidInterpreted` int(10) DEFAULT NULL, `scientificNameAuthorship` varchar(255) DEFAULT NULL, `genus` varchar(255) DEFAULT NULL, `specificEpithet` varchar(255) DEFAULT NULL, `taxonRank` varchar(255) DEFAULT NULL, `infraspecificEpithet` varchar(255) DEFAULT NULL, `identifiedBy` varchar(255) DEFAULT NULL, `dateIdentified` varchar(45) DEFAULT NULL, `identificationReferences` text, `identificationRemarks` text, `taxonRemarks` text, `identificationQualifier` varchar(255) DEFAULT NULL, `typeStatus` varchar(255) DEFAULT NULL, `recordedBy` varchar(255) DEFAULT NULL, `recordedByID` int(10) DEFAULT NULL, `associatedCollectors` varchar(255) DEFAULT NULL, `recordNumber` varchar(45) DEFAULT NULL, `eventDate` date DEFAULT NULL, `year` int(10) DEFAULT NULL, `month` int(10) DEFAULT NULL, `day` int(10) DEFAULT NULL, `startDayOfYear` int(10) DEFAULT NULL, `endDayOfYear` int(10) DEFAULT NULL, `verbatimEventDate` varchar(255) DEFAULT NULL, `occurrenceRemarks` text, `habitat` text, `substrate` varchar(255) NOT NULL, `verbatimAttributes` varchar(255) DEFAULT NULL, `fieldNumber` varchar(45) DEFAULT NULL, `informationWithheld` varchar(250) DEFAULT NULL, `dataGeneralizations` varchar(250) DEFAULT NULL, `dynamicProperties` text, `associatedTaxa` text, `reproductiveCondition` varchar(255) DEFAULT NULL, `establishmentMeans` varchar(45) DEFAULT NULL, `cultivationStatus` varchar(255) DEFAULT NULL, `lifeStage` varchar(45) DEFAULT NULL, `sex` varchar(45) DEFAULT NULL, `individualCount` varchar(45) DEFAULT NULL, `samplingProtocol` varchar(100) DEFAULT NULL, `samplingEffort` varchar(200) DEFAULT NULL, `preparations` varchar(100) DEFAULT NULL, `country` varchar(64) DEFAULT NULL, `stateProvince` varchar(255) DEFAULT NULL, `county` varchar(64) DEFAULT NULL, `municipality` varchar(255) DEFAULT NULL, `locality` text, `locationRemarks` varchar(255) DEFAULT NULL, `localitySecurity` varchar(255) DEFAULT NULL, `localitySecurityReason` varchar(255) DEFAULT NULL, `decimalLatitude` double DEFAULT NULL, `decimalLongitude` double DEFAULT NULL, `geodeticDatum` varchar(255) DEFAULT NULL, `coordinateUncertaintyInMeters` int(10) DEFAULT NULL, `footprintWKT` text, `verbatimCoordinates` varchar(255) DEFAULT NULL, `georeferencedBy` varchar(255) DEFAULT NULL, `georeferenceProtocol` varchar(255) DEFAULT NULL, `georeferenceSources` varchar(255) DEFAULT NULL, `georeferenceVerificationStatus` varchar(32) DEFAULT NULL, `georeferenceRemarks` varchar(255) DEFAULT NULL, `minimumElevationInMeters` int(6) DEFAULT NULL, `maximumElevationInMeters` int(6) DEFAULT NULL, `minimumDepthInMeters` int(10) DEFAULT NULL, `maximumDepthinMeters` int(10) DEFAULT NULL, `verbatimDepth` int(10) DEFAULT NULL, `verbatimElevation` varchar(255) DEFAULT NULL, `disposition` varchar(100) DEFAULT NULL, `language` varchar(20) DEFAULT NULL, `genericcolumn1` varchar(255) DEFAULT NULL, `genericcolumn2` varchar(255) DEFAULT NULL, `storageLocation` varchar(255) DEFAULT NULL, `observerUid` int(10) DEFAULT NULL, `processingStatus` varchar(255) DEFAULT NULL, `duplicateQuantity` int(10) DEFAULT NULL, `recordEnteredBy` varchar(255) DEFAULT NULL, `dateEntered` datetime DEFAULT NULL, `dateLastModified` datetime DEFAULT NULL, `modified` datetime DEFAULT NULL, `sourcePrimaryKey` varchar(255) DEFAULT NULL, `recordId` int(10) DEFAULT NULL, `references` text) ENGINE=MyISAM DEFAULT CHARSET=latin1";

//create query string to create the occurrences talbe and all it's fields
$query6 = "CREATE TABLE `occurrences` ( `id` int(10) NOT NULL DEFAULT '0', `institutionCode` varchar(64) DEFAULT NULL, `collectionCode` varchar(64) DEFAULT NULL, `basisOfRecord` varchar(32) DEFAULT NULL, `occurrenceID` varchar(255) DEFAULT NULL, `catalogNumber` varchar(32) DEFAULT NULL, `otherCatalogNumbers` varchar(255) DEFAULT NULL, `kingdom` varchar(255) DEFAULT NULL, `phylum` varchar(255) DEFAULT NULL, `class` varchar(255) DEFAULT NULL, `order` varchar(255) DEFAULT NULL, `family` varchar(255) DEFAULT NULL, `scientificName` varchar(255) DEFAULT NULL, `tidInterpreted` int(10) DEFAULT NULL, `scientificNameAuthorship` varchar(255) DEFAULT NULL, `genus` varchar(255) DEFAULT NULL, `specificEpithet` varchar(255) DEFAULT NULL, `taxonRank` varchar(255) DEFAULT NULL, `infraspecificEpithet` varchar(255) DEFAULT NULL, `identifiedBy` varchar(255) DEFAULT NULL, `dateIdentified` varchar(45) DEFAULT NULL, `identificationReferences` text, `identificationRemarks` text, `taxonRemarks` text, `identificationQualifier` varchar(255) DEFAULT NULL, `typeStatus` varchar(255) DEFAULT NULL, `recordedBy` varchar(255) DEFAULT NULL, `recordedByID` int(10) DEFAULT NULL, `associatedCollectors` varchar(255) DEFAULT NULL, `recordNumber` varchar(45) DEFAULT NULL, `eventDate` date DEFAULT NULL, `year` int(10) DEFAULT NULL, `month` int(10) DEFAULT NULL, `day` int(10) DEFAULT NULL, `startDayOfYear` int(10) DEFAULT NULL, `endDayOfYear` int(10) DEFAULT NULL, `verbatimEventDate` varchar(255) DEFAULT NULL, `occurrenceRemarks` text, `habitat` text, `substrate` varchar(255) NOT NULL, `verbatimAttributes` varchar(255) DEFAULT NULL, `fieldNumber` varchar(45) DEFAULT NULL, `informationWithheld` varchar(250) DEFAULT NULL, `dataGeneralizations` varchar(250) DEFAULT NULL, `dynamicProperties` text, `associatedTaxa` text, `reproductiveCondition` varchar(255) DEFAULT NULL, `establishmentMeans` varchar(45) DEFAULT NULL, `cultivationStatus` varchar(255) DEFAULT NULL, `lifeStage` varchar(45) DEFAULT NULL, `sex` varchar(45) DEFAULT NULL, `individualCount` varchar(45) DEFAULT NULL, `samplingProtocol` varchar(100) DEFAULT NULL, `samplingEffort` varchar(200) DEFAULT NULL, `preparations` varchar(100) DEFAULT NULL, `country` varchar(64) DEFAULT NULL, `stateProvince` varchar(255) DEFAULT NULL, `county` varchar(64) DEFAULT NULL, `municipality` varchar(255) DEFAULT NULL, `locality` text, `locationRemarks` varchar(255) DEFAULT NULL, `localitySecurity` varchar(255) DEFAULT NULL, `localitySecurityReason` varchar(255) DEFAULT NULL, `decimalLatitude` double DEFAULT NULL, `decimalLongitude` double DEFAULT NULL, `geodeticDatum` varchar(255) DEFAULT NULL, `coordinateUncertaintyInMeters` int(10) DEFAULT NULL, `footprintWKT` text, `verbatimCoordinates` varchar(255) DEFAULT NULL, `georeferencedBy` varchar(255) DEFAULT NULL, `georeferenceProtocol` varchar(255) DEFAULT NULL, `georeferenceSources` varchar(255) DEFAULT NULL, `georeferenceVerificationStatus` varchar(32) DEFAULT NULL, `georeferenceRemarks` varchar(255) DEFAULT NULL, `minimumElevationInMeters` int(6) DEFAULT NULL, `maximumElevationInMeters` int(6) DEFAULT NULL, `minimumDepthInMeters` int(10) DEFAULT NULL, `maximumDepthinMeters` int(10) DEFAULT NULL, `verbatimDepth` int(10) DEFAULT NULL, `verbatimElevation` varchar(255) DEFAULT NULL, `disposition` varchar(100) DEFAULT NULL, `language` varchar(20) DEFAULT NULL, `genericcolumn1` varchar(255) DEFAULT NULL, `genericcolumn2` varchar(255) DEFAULT NULL, `storageLocation` varchar(255) DEFAULT NULL, `observerUid` int(10) DEFAULT NULL, `processingStatus` varchar(255) DEFAULT NULL, `duplicateQuantity` int(10) DEFAULT NULL, `recordEnteredBy` varchar(255) DEFAULT NULL, `dateEntered` datetime DEFAULT NULL, `dateLastModified` datetime DEFAULT NULL, `modified` datetime DEFAULT NULL, `sourcePrimaryKey` varchar(255) DEFAULT NULL, `recordId` int(10) DEFAULT NULL, `references` text) ENGINE=InnoDB DEFAULT CHARSET=latin1";

//this section issues the mysql commands that create the necessary database, tables, and fields along with checking for any MySQL errors.

//run the query string that creates the idarwincore database and check for mysql errors
$result = mysqli_query($conn, $query) or die("MySQL Error with creation of database ikdarwin..." . mysqli_error($conn));

//select the database
mysqli_select_db($conn, $dbname);

//run the query string that creates the blockedlist table and check for mysql errors
$result = mysqli_query($conn, $query1) or die("MySQL Error with creation of blockedlist table..." . mysqli_error($conn));

//run the query string that creates the duplicates table and check for mysql errors
$result = mysqli_query($conn, $query2) or die("MySQL Error with creation of duplicates table..." . mysqli_error($conn));

//run the query string that creates the identifications table and check for mysql errors
$result = mysqli_query($conn, $query3) or die("MySQL Error with creation of identifications table..." . mysqli_error($conn));

//run the query string that creates the images table and check for mysql errors
$result = mysqli_query($conn, $query4) or die("MySQL Error with creation of images table..." . mysqli_error($conn));

//run the query string that creates the noskeletalrecords table and check for mysql errors
$result = mysqli_query($conn, $query5) or die("MySQL Error with creation of noskeletalrecords table..." . mysqli_error($conn));

//run the query string that creates the occurrences table and check for mysql errors
$result = mysqli_query($conn, $query6) or die("MySQL Error with creation of occurrences table..." . mysqli_error($conn));

//let the user know that the php is finished
echo "<h1><center>Finished creating database tables!</center></h1>";

//footer.php creates the small footer at the bottom of every page that contains the software name, version, author, copyright, and contact information
include("footer.php");

?>
