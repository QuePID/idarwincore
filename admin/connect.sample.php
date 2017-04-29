<?php
/*IDarwinCore version 1.0
  By Robert R. Pace <robert.pace@eku.edu>
  
  This database software is designed for natural
  history collections utilizing Darwin Core Archive
  data for online querying of the collection's data
  
  This file (connect.php) contains the credentials necessary
  for the PHP package to connect to MySQL server.  Such items
  as username, password, database name are stored in global
  variables available to all PHP which contain an
  include (connect.php) line.
*/

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

//mysqli connection string
$mysqli = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect to mysqli: ' . mysqli_connect_errno());

//select the database we want to be using for IDarwinCore (normally idarwincore)
mysqli_select_db($conn, $dbname);

?>
