<?php
include '../DBConnection.php';
require_once '../log4php/Logger.php';
Logger :: configure('../log4php.properties');
$logger = Logger :: getRootLogger();

$opType = isset ($_REQUEST['opType']) ? $_REQUEST['opType'] : null;
$startDate = isset ($_REQUEST['startDate']) ? $_REQUEST['startDate'] : null;
$stopDate = isset ($_REQUEST['stopDate']) ? $_REQUEST['stopDate'] : null;
$devices = isset ($_REQUEST['devices']) ? $_REQUEST['devices'] : null;
//$startDate = date("Y-m-d H:i:s", strtotime($startDate . '-8hour'));
//$endDate= date("Y-m-d H:i:s", strtotime($endDate . '-8hour'));
if ($opType == '0' or $opType == 0) {
	$startDate = date("Y-m-d H:i:s", strtotime($startDate . '-8hour'));
	$stopDate = date("Y-m-d H:i:s", strtotime($stopDate . '-8hour'));
	$data = array ();
	$devices = str_replace(',', '\',\'', $devices);
	$devices = ' \'' . $devices . '\'';

	$sql = "select vm.ModelName,c.name as customer,d.deviceID,d.d_esn,vi.licenseNumber,  sum(case when  code =3024 then 1 else 0 end) as hard_accel,sum(case when  code =3025 then 1 else 0 end) as hard_corner
	,sum(case when  code =3026 then 1 else 0 end) as hard_break" .
	" from provision_obd.Devices d  " .
	" join  Devices_MT dm on d.deviceID=dm.deviceID" .
	" left join  VehModelNumber vn on dm.ModelNumID=vn.ModelNumID" .
	" join  VehicleInfo vi on  dm.vin=vi.vin" .
	" left join  VehModel vm  on  vn.ModelID=vm.ModelID" .
	" left join  Customers c on dm.customerID=c.id" .
	" left join  obd_demo.LocationHistory l " .
	" on  (l.deviceID=d.deviceID and  (l.code=3024 or l.code=3025  or l.code=3026 )  and  gpsStamp >= '$startDate' AND gpsStamp <= '$stopDate')" .
	" where  d.deviceID in (" . $devices . ")" .
	" group by d.deviceID ";
	//echo $sql;
	$logger->debug("----------------sql:------" . $sql);
	mysql_select_db("IOV_demo");
	$result = mysql_query($sql);
	$numRows = mysql_num_rows($result);
	$ret = array ();
	$data = array ();
	$ret['total'] = $numRows;
	if ($numRows > 0) {
		while ($row = mysql_fetch_object($result)) {
			array_push($data, $row);
		}
	}
	$ret['rows'] = $data;
	echo json_encode($ret);
} else
	if ($opType == '1' or $opType == 1) {
		$deviceID = $devices;
		$tmp = substr($startDate, 0, 10);
		$arr = array ();
		$arr1 = array ();
		$arr2 = array ();
		while ($tmp < $stopDate) {
			$arr[$tmp] = 0;
			$arr1[$tmp] = 0;
			$arr2[$tmp] = 0;
			$tmp = date("Y-m-d", strtotime($tmp . "+1 day"));
		}

		$stopDate1 = date("Y-m-d H:i:s", strtotime($stopDate . "-8hour"));
		$startDate1 = date("Y-m-d H:i:s", strtotime($startDate . '-8hour'));
		mysql_select_db("obd_demo");
		$query = "select deviceID,serverDate,sum(case when  code =3024 then 1 else 0 end) as hard_accel,sum(case when  code =3025 then 1 else 0 end) as hard_corner
	        ,sum(case when  code =3026 then 1 else 0 end) as hard_break  from LocationHistory  where deviceID='$deviceID'  and (code=3024 or code=3025 or  code=3026)  and gpsStamp>'$startDate1' and gpsStamp<='$stopDate1'  and serverDate=gpsDate group by serverDate order by serverDate";
		$logger->debug("----------------sql:------" . $query);
		$result = mysql_query($query);
		$iRows = mysql_num_rows($result);
		$ret = array ();
		$ret1 = array ();
		if ($iRows > 0) {
			$ret["resultCode"] = "200";
			$ret["resultMsg"] = "";

			while ($row = mysql_fetch_object($result)) {
				//$ret1[] = $row;
				if (array_key_exists($row->serverDate, $arr)) {
					$arr[$row->serverDate] = $arr[$row->serverDate] + $row->hard_accel;
					$arr1[$row->serverDate] = $arr1[$row->serverDate] + $row->hard_corner;
					$arr2[$row->serverDate] = $arr1[$row->serverDate] + $row->hard_break;
				}
			}
			mysql_free_result($result);
		} else {
			$ret["resultCode"] = "201";
			$ret["resultMsg"] = "no data";
		}
		
		
		$query="select deviceID,gpsDate,gpsTime,serverDate,sum(case when  code =3024 then 1 else 0 end) as hard_accel,sum(case when  code =3025 then 1 else 0 end) as hard_corner
	        ,sum(case when  code =3026 then 1 else 0 end) as hard_break from LocationHistory  where deviceID='$deviceID'  and and (code=3024 or code=3025 or  code=3026)   and gpsStamp>'$startDate1' and gpsStamp<='$stopDate1'  and serverDate <> gpsDate  order by serverDate";
		$logger->debug("----------------sql:------" . $query);
		$result = mysql_query($query);
		$iRows = mysql_num_rows($result);
		$ret=array();
		$ret1=array();
		if($iRows>0){
			$ret["resultCode"]="200";
			$ret["resultMsg"]="";
			
			while($row = mysql_fetch_object($result))
			{
				//$ret1[] = $row;
				if($row->gpsTime<'16:00:00'){
					$arr[$row->gpsDate]=$arr[$row->gpsDate]+$row->hard_accel;
					$arr1[$row->gpsDate]=$arr1[$row->gpsDate]+$row->hard_corner;
					$arr2[$row->gpsDate]=$arr1[$row->gpsDate]+$row->hard_break;
				}
				else{
					$tmpTime = date("Y-m-d",strtotime($row->gpsDate. '+1day'));
					$arr[$tmpTime]=$arr[$tmpTime]+$row->hard_accel;
					$arr1[$tmpTime]=$arr1[$tmpTime]+$row->hard_corner;
					$arr2[$tmpTime]=$arr1[$tmpTime]+$row->hard_break;	
				}
			}
			mysql_free_result($result);
		}else{
			$ret["resultCode"]="201";
			$ret["resultMsg"]="no data";
		}
		
		$arr3 = array ();
		$arr3[0] = array_keys($arr);
		$arr3[1] = array_values($arr);
		$arr3[2] = array_values($arr1);
		$arr3[3] = array_values($arr2);
		echo json_encode($arr3);
	} else {
		echo 'optype error!';
	}
?>