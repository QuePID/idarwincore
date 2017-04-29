<?php
include("connect.php");
include("common.php");
include("header.php");

$target_dir = $tmp_folder;
$target_file = $target_dir ."/dwca/" . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$FileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Allow certain file formats
if($FileType == "txt" || $FileType == "csv"){
    $uploadOk = 1;
  } ELSE {
    echo "<br><br><br><center><strong>Sorry, only .txt files are allowed.</strong></center><br><br><br>";
    $uploadOk = 0;
}
if(file_exists("$target_file")){
	unlink($target_file);
	$uploadOk = 1;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "<br><br><br><br><center><strong>The file <i>". basename( $_FILES["fileToUpload"]["name"]). "</i> has been uploaded.</strong></center><br><br><br>";
    } else {
        echo "<br><br><br><br><center<strong>Sorry, there was an error uploading your file.</strong></center><br><br><br>";
    }
}
include("footer.php");
?>