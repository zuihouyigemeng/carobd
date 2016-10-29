<?php
set_time_limit(0);
include '../DBConnection.php';
require_once '../log4php/Logger.php';
Logger :: configure('../log4php.properties');
$logger = Logger :: getRootLogger();
$d_esn = isset ($_REQUEST['d_esn']) ? $_REQUEST['d_esn'] : null;

$routID = 1;



echo $d_esn.'</br>';
$num=substr($d_esn,6);

echo $num.'</br>';

$routID=$num%7;

//if ($num >= 1 and $num <= 40) {
//	$routID = 1;
//} else
//	if ($num >= 41 and $num <= 80) {
//		$routID = 2;
//	} else
//		if ($num >= 81 and $num <= 120) {
//			$routID = 3;
//		} else
//			if ($num >= 121 and $num <= 160) {
//				$routID = 4;
//			} else
//				if ($num >= 161 and $num <= 201) {
//					$routID = 5;
//				} else
//					if ($num >= 202 and $num <= 221) {
//						$routID = 6;
//					} else
//						if ($num >= 222) {
//							$routID = 7;
//						}

$routID=$routID+1;
mysql_select_db("simulator");
$query = "select * from routs where routID=$routID order  by `index`";
echo $query.'</br>';

$result = mysql_query($query);
$numRows = mysql_num_rows($result);
$data = array ();
if ($numRows > 0) {
	while ($row = mysql_fetch_object($result)) {
		$data[] = $row;
	}
	mysql_free_result($result);
}

echo 'size of route'.sizeof($data).'</br>';
while(true){
	
	for ($i = 0; $i < sizeof($data); $i++) {
	$code = 3004;
	$latitude = $data[$i]->latitude;
	$longitude = $data[$i]->longitude;
	$heading = $data[$i]->heading;
	$address_num = $data[$i]->address_num;

       $ign=1;
	//ign on
	if ($i == 0) {
		$code = 3015;
	}

	//ign off
	if ($i == sizeof($data)-1) {
		$code = 3016;
		$ign=0;
	}
	
	$now = date("Y-m-d H:i:s");
	$gpsNow=date("Y-m-d H:i:s", strtotime($now . '-8hour'));
	$nowDate=substr($now,0,10);
	$nowTime=substr($now,11,8);

	$gpsDate=substr($gpsNow,0,10);
	$gpsTime=substr($gpsNow,11,8);

	$sql="INSERT INTO `obd_demo`.`LocationHistory` (`deviceID`, `latitude`,`longitude`,`gpsTime`, `gpsDate`, `gpsStamp`, `serverTime`, `serverDate`, `code`, `address_num`, `baidu_latitude`, `baidu_longitude`, `baiduFlag`,`heading`) " .
			"VALUES ('$d_esn', '$latitude', '$longitude','$gpsTime', '$gpsDate', '$gpsNow', '$nowTime', '$nowDate', $code, '$address_num', '$latitude', '$longitude', 1,$heading)";
	
	mysql_query($sql);
	
	$sql="update `obd_demo`.`LocationStatus`  set code=$code, gpsTime='$gpsTime',gpsDate='$gpsDate' ,serverDate='$nowDate',serverTime='$nowTime', baidu_longitude='$longitude',baidu_latitude='$latitude', heading=$heading,baiduFlag=1,ign=1,address_num='$address_num' where deviceID='$d_esn' ";
	//echo $sql;
	
	mysql_query($sql);
	sleep(30);
}
	
}




?>