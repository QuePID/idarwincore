<?php include("common.php"); include("header.php"); echo "<br><br><br><br>";?>

<!DOCTYPE html>
<html>
<body>
<center>
<form action="txtuploader.php" method="post" enctype="multipart/form-data">
    <strong>Select <i>blockedlist.csv</i> file to upload:</strong>
    <input type="file" name="fileToUpload" id="fileToUpload">
    <br><br>
    <input type="submit" value="Upload .TXT File" name="submit">
</form>
</center>
</body>
<?php include("footer.php")?>
</html>
