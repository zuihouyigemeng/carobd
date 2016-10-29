<?php
include '../DBConnection.php';
require_once '../log4php/Logger.php';
Logger :: configure('../log4php.properties');
$logger = Logger :: getRootLogger();

$opType = isset($_REQUEST['opType']) ? $_REQUEST['opType'] : null;
$startDate = isset($_REQUEST['startDate']) ? $_REQUEST['startDate'] : null;
$stopDate = isset($_REQUEST['stopDate']) ? $_REQUEST['stopDate'] : null;
$devices=isset($_REQUEST['devices']) ? $_REQUEST['devices'] : null;
//$startDate = date("Y-m-d H:i:s", strtotime($startDate . '-8hour'));
//$endDate= date("Y-m-d H:i:s", strtotime($endDate . '-8hour'));
if($opType=='0' or $opType==0){
$startDate = date("Y-m-d H:i:s", strtotime($startDate . '-8hour'));
$stopDate= date("Y-m-d H:i:s", strtotime($stopDate . '-8hour'));
$data = array();
$devices =str_replace(',', '\',\'', $devices);
$devices=' \''.$devices.'\'';
//$sql="SELECT vm.ModelName,c.name as customer,d.deviceID,d.d_esn,vi.licenseNumber,max(speed) as max_speed,sum(fuel_consumption) as sum_fuel_consumption,sum(driving_dist)/1000 as sum_distance  FROM obd_demo.LocationHistory l,VehModelNumber vn,VehModel vm,Devices_MT dm,VehicleInfo vi, provision_obd.Devices d  ,Customers c   " .
//		" where  l.deviceID=dm.deviceID " .
//		" and l.deviceID=d.deviceID" .
//		" and dm.ModelNumID=vn.ModelNumID".
//		" and vn.ModelID=vm.ModelID".
//		" and dm.customerID=c.id".
//		" and  dm.vin=vi.vin and l.deviceID in ("  . $devices . ")" .
//		" AND DATE_FORMAT( concat( gpsDate, ' ', gpsTime ) , GET_FORMAT( DATETIME, 'ISO' ) ) >= '".$startDate."' AND DATE_FORMAT( concat( gpsDate, ' ', gpsTime ) , GET_FORMAT( DATETIME, 'ISO' ) ) <= '".$stopDate."' " .
//				" group by l.deviceID " ;
				
	$sql="select vm.ModelName,c.name as customer,d.deviceID,d.d_esn,vi.licenseNumber,sum(fuel_consumption) as sum_fuel_consumption,sum(driving_dist)*1.03/1000 as sum_distance "	.
	      " from provision_obd.Devices d  " .
	      " join  Devices_MT dm on d.deviceID=dm.deviceID".	
	      " left join  VehModelNumber vn on dm.ModelNumID=vn.ModelNumID".	
	      " join  VehicleInfo vi on  dm.vin=vi.vin".	
	      " left join  VehModel vm  on  vn.ModelID=vm.ModelID".
	      " left join  Customers c on dm.customerID=c.id".
	      " left join  obd_demo.LocationHistory l " .
	      " on  (l.deviceID=d.deviceID and  l.code=3016 and  gpsStamp >= '$startDate' AND gpsStamp <= '$stopDate')".
	      " where  d.deviceID in ("  . $devices . ")" .
				" group by d.deviceID " ;
	      
//echo $sql;
$logger->debug("----------------sql:------" . $sql);
mysql_select_db("IOV_demo");
$result = mysql_query($sql);
$numRows = mysql_num_rows($result);
$ret = array ();
$data= array ();
$ret['total'] = $numRows;
if ($numRows > 0) {
$max_s=getMaxSpeedByDevices($devices,$startDate,$stopDate);
while($row = mysql_fetch_object($result)){
	$time1=getIgnTime($row->deviceID,$startDate,$stopDate,3015);
	$time2=getIgnTime($row->deviceID,$startDate,$stopDate,3016);
	$time=floor(($time2-$time1)/60);
//	if($time<0){
//		$time=0;
//	}
	$row->ign_time=$time;
	$row->sum_fuel_consumption=round($row->sum_fuel_consumption,1);
	$row->sum_distance=round($row->sum_distance,1);
	for($i=0;$i<sizeof($max_s);$i++){
		if($row->deviceID==$max_s[$i]->deviceID){
			$row->max_speed=$max_s[$i]->max_speed;
		}
	}
	if($row->max_speed==null){
		$row->max_speed=0;
	}
	$row->afc=round($row->sum_fuel_consumption*100/$row->sum_distance,1);
	array_push($data,$row);
}
}
$ret['rows'] = $data;
echo json_encode($ret);
}
else if($opType=='1' or $opType==1){
	$deviceID=$devices;
	$tmp=substr($startDate,0,10);
	$arr= array();
	$arr1= array();
	while($tmp<$stopDate){
			$arr[$tmp]=0;
			$arr1[$tmp]=0;
			$tmp=date("Y-m-d",strtotime($tmp."+1 day"));
		}
		
		$stopDate1  = date("Y-m-d H:i:s", strtotime($stopDate."-8hour"));
		$startDate1 = date("Y-m-d H:i:s", strtotime($startDate. '-8hour'));	
		mysql_select_db("obd_demo");
		$query="select deviceID,serverDate,sum(fuel_consumption) as sum_fuel_consumption,sum(driving_dist)*1.03 as sum_distance  from LocationHistory  where deviceID='$deviceID'  and code=3016  and gpsStamp>'$startDate1' and gpsStamp<='$stopDate1'  and serverDate=gpsDate group by serverDate order by serverDate";
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
				if(array_key_exists($row->serverDate, $arr)) {
					$arr[$row->serverDate]=$arr[$row->serverDate]+$row->sum_distance;
					$arr1[$row->serverDate]=$arr1[$row->serverDate]+$row->sum_fuel_consumption;

				}
			}
			mysql_free_result($result);
		}else{
			$ret["resultCode"]="201";
			$ret["resultMsg"]="no data";
		}
		
		
		$query="select deviceID,gpsDate,gpsTime,serverDate,fuel_consumption as sum_fuel_consumption,driving_dist*1.03 as sum_distance  from LocationHistory  where deviceID='$deviceID'  and code=3016  and gpsStamp>'$startDate1' and gpsStamp<='$stopDate1'  and serverDate <> gpsDate  order by serverDate";
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
					$arr[$row->gpsDate]=$arr[$row->gpsDate]+$row->sum_distance;
					$arr1[$row->gpsDate]=$arr1[$row->gpsDate]+$row->sum_fuel_consumption;
				}
				else{
					$tmpTime = date("Y-m-d",strtotime($row->gpsDate. '+1day'));
					$arr[$tmpTime]=$arr[$tmpTime]+$row->sum_distance;
					$arr1[$tmpTime]=$arr1[$tmpTime]+$row->sum_fuel_consumption;
				}
			//	$ret1[] = $row;
			}
			mysql_free_result($result);
		}else{
			$ret["resultCode"]="201";
			$ret["resultMsg"]="no data";
		}
		
	  $arr2=array();
     $arr2[0]=array_keys($arr);
     $arr2[1]=array_values($arr);
     
     foreach ($arr2[1] as &$value) {
      $value = round($value/1000,1);
        }
      $arr2[2]=array_values($arr1);
     
       foreach ($arr2[2] as &$value) {
        $value =  round($value,1);
        }
		echo json_encode($arr2);
}
else{
	echo 'optype error!';
}


function getIgnTime($deviceID,$startDate,$stopDate,$code){
$logger = Logger :: getRootLogger();
$sql="select sum(UNIX_TIMESTAMP(gpsStamp)) as time  from  LocationHistory where deviceID='$deviceID' and gpsStamp>'$startDate' and gpsStamp<'$stopDate' and code=$code"  ;
$logger->debug("----------------sql:------" . $sql);
//echo $sql.'</br>';
mysql_select_db("obd_demo");
$result = mysql_query($sql);
$numRows = mysql_num_rows($result);
if ($numRows > 0) {
 $row = mysql_fetch_object($result);
 return $row->time;
}
return null;
}

function getMaxSpeedByDevices($devices,$startDate,$stopDate){
	$logger = Logger :: getRootLogger();
	$speed_arr = array();
	mysql_select_db("obd_demo");
	$sql="select deviceID,max(speed) as max_speed  from LocationHistory where  deviceID in ("  . $devices . ") and gpsStamp >= '$startDate' AND gpsStamp <= '$stopDate' group by deviceID   ";
	$logger->debug("----------------sql:------" . $sql);
		$result = mysql_query($sql);
		$iRows = mysql_num_rows($result);
		$ret=array();
		$ret1=array();
		if($iRows>0){
			while($row = mysql_fetch_object($result)){
	          array_push($speed_arr,$row);
                  }
		}
		return $speed_arr;
}



?>