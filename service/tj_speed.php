<?php
include  dirname(__FILE__).'/../DBConnection.php';
require_once dirname(__FILE__).'/../log4php/Logger.php';
Logger :: configure(dirname(__FILE__).'/../log4php.properties');

class tj_speed {
	public function searchOverSpeed($devices, $startDate, $stopDate, $speed,$objType) {
		$logger = Logger :: getRootLogger();
		$startDate = date("Y-m-d H:i:s", strtotime($startDate . '-8hour'));
		$stopDate = date("Y-m-d H:i:s", strtotime($stopDate . '-8hour'));
		$data = array ();
		$devices = str_replace(',', '\',\'', $devices);
		$devices = ' \'' . $devices . '\'';
//		$sql = "SELECT vm.ModelName,c.name as customer,d.deviceID,d.d_esn,vi.licenseNumber,max(speed) as max_speed,count(speed) as sum_speed  FROM obd_demo.LocationHistory l,VehModelNumber vn,VehModel vm,Devices_MT dm,VehicleInfo vi, provision_obd.Devices d  ,Customers c   " .
//		" where  l.deviceID=dm.deviceID " .
//		" and l.deviceID=d.deviceID" .
//		" and dm.ModelNumID=vn.ModelNumID" .
//		" and vn.ModelID=vm.ModelID" .
//		" and dm.customerID=c.id" .
//		" and  dm.vin=vi.vin and l.deviceID in (" . $devices . ")" .
//		" AND gpsStamp >= '" . $startDate . "' AND gpsStamp <= '" . $stopDate . "'  and speed>$speed" .
//		" group by l.deviceID ";

        $sql = "SELECT vm.ModelName,c.name as customer,d.deviceID,d.d_esn,vi.licenseNumber,max(speed) as max_speed,count(speed) as sum_speed  " .
		 " from provision_obd.Devices d  " .
	      " join  Devices_MT dm on d.deviceID=dm.deviceID".	
	      " left join  VehModelNumber vn on dm.ModelNumID=vn.ModelNumID".	
	      " join  VehicleInfo vi on  dm.vin=vi.vin".	
	      " left join  VehModel vm  on  vn.ModelID=vm.ModelID".
	      " left join  Customers c on dm.customerID=c.id".
	      " left join  obd_demo.LocationHistory l " .
	      " on  (l.deviceID=d.deviceID and   gpsStamp >= '$startDate' AND gpsStamp <= ' $stopDate'  and speed>$speed)".
	      " where  d.deviceID in ("  . $devices . ")" .
				" group by d.deviceID " ;

		//echo $sql;
		$logger->debug("----------------sql:------" . $sql);
		mysql_select_db("IOV_demo");
		$result = mysql_query($sql);
		$numRows = mysql_num_rows($result);
		$data = array ();
		if ($numRows > 0) {
			while ($row = mysql_fetch_object($result)) {
				//object
				if($objType==0){
					array_push($data, $row);
				}
				else if($objType==1){
					$tmp= array ();
					$tmp[0]=$row->licenseNumber;
					$tmp[1]=$row->d_esn;
					$tmp[2]=$row->sum_speed;
					$tmp[3]=$row->max_speed;
					array_push($data, $tmp);
				}
				
			}
		}
		return $data;
	}

	public function searchOverSpeedResult($devices, $startDate, $stopDate, $speed) {
		$ret = array ();
		$ret['rows'] = $this->searchOverSpeed($devices, $startDate, $stopDate, $speed,0);
		$ret['total'] = sizeof($ret['rows']);
		echo json_encode($ret);
	}

	public function searchOverSpeedDetail($devices, $startDate, $stopDate, $speed,$objType) {
		$logger = Logger :: getRootLogger();
		if($objType==0){
			$page = isset ($_REQUEST['page']) ? $_REQUEST['page'] : null;
		$rows = isset ($_REQUEST['rows']) ? $_REQUEST['rows'] : null;
		$total = 0;
		$page = ($page -1) * $rows;		
		
		$startDate = date("Y-m-d H:i:s", strtotime($startDate . '-8hour'));
		$stopDate = date("Y-m-d H:i:s", strtotime($stopDate . '-8hour'));
		
		$sqlCount = "select count(*) as total from obd_demo.LocationHistory l,Devices_MT dm,VehicleInfo vi  " .
		" where dm.deviceID=l.deviceID and dm.vin=vi.vin" .
		" and l.gpsStamp >= '" . $startDate . "' AND l.gpsStamp <= '" . $stopDate . "'  and speed>$speed and l.deviceID='$devices'";
		
		mysql_select_db("IOV_demo");
		$result = mysql_query($sqlCount);
		$numRows = mysql_num_rows($result);
		if ($numRows > 0) {
			while ($row = mysql_fetch_object($result)) {
				$total = $row->total;
			}
			mysql_free_result($result);
		}
		
		#echo $total."<--->".$sqlCount;
		
		

		$data = array ();
		$sql = "select vi.licenseNumber as licenseNumber ,l.gpsStamp as over_speed_time,l.speed as over_speed,address_num as address from obd_demo.LocationHistory l,Devices_MT dm,VehicleInfo vi  " .
		" where dm.deviceID=l.deviceID and dm.vin=vi.vin" .
		" and l.gpsStamp >= '" . $startDate . "' AND l.gpsStamp <= '" . $stopDate . "'  and speed>$speed and l.deviceID='$devices' order  by gpsStamp  desc limit $page,$rows";
		$logger->debug("----------------sql:------" . $sql);
		mysql_select_db("IOV_demo");
		$result = mysql_query($sql);
		$numRows = mysql_num_rows($result);
		//$ret = array ();
		$data = array ();
		if ($numRows > 0) {
			while ($row = mysql_fetch_object($result)) {
				$row->over_speed_time = date("Y-m-d H:i:s", strtotime($row->over_speed_time . '+8hour'));
				
				if($objType==0){
					array_push($data, $row);
				}
				else if($objType==1){
					$tmp= array ();
					$tmp[0]=$row->licenseNumber;
					$tmp[1]=$row->over_speed_time;
					$tmp[2]=$row->over_speed;
					$tmp[3]=$row->address;
					array_push($data, $tmp);
				}
			}
		}
		$ret = array();
		$ret['total'] = $total;
		$ret['rows'] = $data;
		return $ret;
		}
		else if($objType==1){
				$startDate = date("Y-m-d H:i:s", strtotime($startDate . '-8hour'));
		$stopDate = date("Y-m-d H:i:s", strtotime($stopDate . '-8hour'));
		$data = array ();
		$sql = "select vi.licenseNumber as licenseNumber ,l.gpsStamp as over_speed_time,l.speed as over_speed,address_num as address from obd_demo.LocationHistory l,Devices_MT dm,VehicleInfo vi  " .
		" where dm.deviceID=l.deviceID and dm.vin=vi.vin" .
		" and l.gpsStamp >= '" . $startDate . "' AND l.gpsStamp <= '" . $stopDate . "'  and speed>$speed and l.deviceID='$devices' order  by gpsStamp desc";
		$logger->debug("----------------sql:------" . $sql);
		mysql_select_db("IOV_demo");
		$result = mysql_query($sql);
		$numRows = mysql_num_rows($result);
		$ret = array ();
		$data = array ();
		if ($numRows > 0) {
			while ($row = mysql_fetch_object($result)) {
				$row->over_speed_time = date("Y-m-d H:i:s", strtotime($row->over_speed_time . '+8hour'));
				
				if($objType==0){
					array_push($data, $row);
				}
				else if($objType==1){
					$tmp= array ();
					$tmp[0]=$row->licenseNumber;
					$tmp[1]=$row->over_speed_time;
					$tmp[2]=$row->over_speed;
					$tmp[3]=$row->address;
					array_push($data, $tmp);
				}
			}
		}
		return $data;
		}
		
	}

	public function searchOverSpeedDetailResult($devices, $startDate, $stopDate, $speed) {
		$ret = array ();
		$ret = $this->searchOverSpeedDetail($devices, $startDate, $stopDate, $speed,0);
		//$ret['rows'] = $this->searchOverSpeedDetail($devices, $startDate, $stopDate, $speed,0);
		//$ret['total'] = sizeof($ret['rows']);
		echo json_encode($ret);
	}

}


?>