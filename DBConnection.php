<?php
//$mysql=mysql_connect ("192.168.1.29:3306", "enterprise", "demo") or die ('Error: ' . mysql_error());
//$mysql=mysql_connect ("127.0.0.1:3306", "admin", "lbs_proj") or die ('Error: ' . mysql_error());
$mysql=mysql_connect ("127.0.0.1:3306", "admin", "lbs_proj") or die ('Error: ' . mysql_error());
// $mysql=mysql_connect ("192.168.0.202:3306", "root", "anydata") or die ('Error: ' . mysql_error());
mysql_query("SET NAMES 'utf8'"); // UTF 8 support
?>
