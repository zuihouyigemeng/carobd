<?php

$conn = @mysql_connect('192.168.0.163','root','yuro{}tusi021401');
if (!$conn) {
	die('Could not connect: ' . mysql_error());
}
mysql_select_db('test', $conn);

?>