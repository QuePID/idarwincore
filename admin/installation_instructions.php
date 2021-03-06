<?php
include("header.php");
include("connect.php");
include("common.php");
?>
<center><h2>Installation Instructions For <i>iDarwinCore</i></h2></center>
<hr>
<br>
<h2>Server Configurations</h2>
<p>iDarwinCore requires a few things in order to be operational.  This includes a properly configured MySQL server, Apache server, and PHP.</p>
<p>This database package has been extensively tested with Apache 2.4, MySQL 5.7, and PHP 7.1.</p>

<p>I highly recommend <a href="http://www.wamp.com">WAMP64</a> for windows as it is easy to update and saves quite a bit of hassle in setting up these servers independently.</p>
<p>In order to use all of iDarwinCore's features you will want to make a few modifications to your servers.</p>
<p><strong><u>PHP</u></strong></p>
<p>I suggest changing the following settings in your php.ini:</p>


<p><i>max_execution_time = 3600;</i></p>
<p><i>file_uploads = On</i></p>
<p><i>upload_tmp_dir ="d:/wamp64/tmp"; (or whatever your server's tmp folder is.)</i></p>
<p><i>upload_max_filesize = 100M;</i></p>
<p><i>default_socket_timeout = 300;</i></p>
<p><i>max_input_time = 120;</i></p>
<p><i>memory_limit = 300M;</i></p>

<p>The above settings allow your scripts to execute for up to an hour, and permits you to upload files up to 100 mb, along with permitting sockets to wait up to 300 seconds before giving up, allows the script to parse input for up to 2 minutes, and for PHP to utilize up to 300 MB of physical memory.</p>

<p><strong><u>MySQL</u></strong></p>

<p>I suggest changing the following settings in your my.ini (or my.cnf):</p>

<p><i>secure_file_priv="d:/wamp64/tmp"</i></p>
<p><i>sql-mode=""</i></p>

<p>Secure_file_priv setting defines a directory from which you can import files into the MySQL database.  You will want to set this as your system (or servers) tmp folder location.  This must be the absolute path location and not a relative path.  The sql-mode setting turns off several strict modes that are by default set as on.  It is important to turn off strict mode as you most likely will be importing data into MySQL which has dates set as such: 0000-00-00 for various fields.</p>


<h2>Downloading iDarwinCore</h2>
<p>iDarwinCore is available for download from <a href="http://www.github.com/QuePID/idarwincore">GitHub</a>.  You can download it as a zip file from this location, or if you have git installed you can install it directly using git.</p>

<h2>Installing iDarwinCore</h2>
<p>You will want to unzip the zip file you downloaded from github.com into your webserver's root folder.</p>
<p>Rename the folder from idarwincore-master to idarwincore.</p>
<p>In a text editor open connect.sample.php and edit dbhost, dbuser, dbpass for your MySQL server, and save the file as connect.php.</p>

<p>In a text editor open common.sample.php and edit the file to customize for your needs, and save the file as common.php</p>

<p>You are now ready to create the database and it's tables.  If you have phpmyadmin installed you can use it to setup the iDarwinCore database tables by using it's import feature and selecting the create_db_structures.sql file.  If you do not have phpmyadmin installed then you can use the mysql.exe command line interface with the command mysql -u root -p < c:/wamp64/www/idarwincore/create_db_structures.php.  You will be prompted for the password to the wamp server.  You will also want to import the counties database using phpmyadmin or using the mysql command interface via mysql -u root -p < c:/wamp64/www/idarwincore/counties_db/counties_db.sql</p>
<p>You will also need to create /idarwincore/admin/dwca folder which will be used to generate DwC-A exports.</p>
<p>If you plan on using the distribution mapping functions you will need to signup for a free Google Maps Javascript API key and insert it into the "display_county_maps.php" found in the /idarwincore/ and also in /idarwincore/admin/ folders.</p>
<p>Congratulations!  You have installed iDarwinCore!</p>

<p>It is highly recommended that you password protect the admin folder, this can be done via .htaccess .</p>

<p>If you encountered an error, you can review your servers log files to diagnose the situation.  You should also test your php's installation with phpinfo command (google phpinfo for more info).</p>

<?php
include("footer.php");
?>
