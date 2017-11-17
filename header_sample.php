<?php
/*iDarwinCore version 1.1
  By Robert R. Pace <robert.pace@eku.edu>
  
  This database software is designed for natural
  history collections utilizing Darwin Core Archive
  data for online querying of the collection's data
  
  This file (header.php) is a commonly included
  file for all PHPs in this package.  It creates the
  HTML headers along with header image and link-backs
  
*/
?>
<html>
<head><title><?php include("common.php"); echo $university; ?></title>
	<style type="text/css"> table { empty-cells:show; } 
		td.center { 
       text-align: center;
       width: "91%";   
              }
	</style>
</head></html>
<BODY BGCOLOR="#E1F4E2" TEXT=BLACK LINK=DARKBLUE VLINK=PURPLE ALINK=RED>
<html>
<div style="width:1344; margin=auto">
<table bgcolor="#5E213B" style="width: 100%" cellspacing=0 cellpadding=0>
<tr><td width="9%"><a href="<?php include("common.php"); echo $urlthree; ?>"><img id="header" src="<?php include("common.php"); echo $headerimage; ?>" alt="<?php include("common.php"); echo $university; ?>" style="float: center"></a></td><td width="90%" valign="bottom" class="center"><font color="FFFFFF"><?php include("common.php"); echo "<h1><strong>$university</strong></h1>";?></font></td></tr>
</table>
</div>
<font color = "black">
