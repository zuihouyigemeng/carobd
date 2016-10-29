<?php
//$dis_ip="222.66.84.167";
//$dis_port=30005;
$dis_ip="116.228.171.33";
$dis_port=30005;

echo 'distination ip:'.$dis_ip;
echo '</br>distination port:'.$dis_port;
$sock = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
$packet = '';
$packet .= chr(0); 
$packet .= chr(0); 
$packet .= chr(10); 
$packet .= chr(0); 
$packet .= chr(0); 
$packet .= chr(0); 
$len = strlen($packet);
socket_sendto($sock, $packet, $len, 0, $dis_ip, $dis_port);
socket_close($sock);

echo '</br>send command success!'

//echo date('Y-m-d H:i:s',"1425484799");
?>
