<?php
include dirname(__FILE__) . '/../DBConnection.php';
require_once dirname(__FILE__) . '/../log4php/Logger.php';
Logger :: configure(dirname(__FILE__) . '/../log4php.properties');

class tj_fuelChange {
	public function getTjFuelChange($startDate, $stopDate, $devices, $forExcel = false) {
		$logger = Logger :: getRootLogger();
		//	参数： $forExcel = true:  按excel导出要求决定输出数组的索引方式
		//	$startDate = date("Y-m-d H:i:s", strtotime($startDate . '-8hour'));
		//	$stopDate= date("Y-m-d H:i:s", strtotime($stopDate . '-8hour'));

		$data = array ();
		$devices = str_replace(',', '\',\'', $devices);
		$devices = ' \'' . $devices . '\'';
		//		$sql="SELECT vm.ModelName,c.name as customer,d.deviceID,d.d_esn,vi.licenseNumber,fuel_level_bef, fuel_level_now, fuel_level_now1" . 
		//				" FROM obd_demo.LocationHistory l,VehModelNumber vn,VehModel vm,Devices_MT dm,VehicleInfo vi, provision_obd.Devices d  ,Customers c   " .
		//				" where  l.deviceID=dm.deviceID " .
		//				" and l.deviceID=d.deviceID" .
		//				" and dm.ModelNumID=vn.ModelNumID".
		//				" and vn.ModelID=vm.ModelID".
		//				" and dm.customerID=c.id".
		//				" and  dm.vin=vi.vin and l.deviceID in ("  . $devices . ")" .
		//				" and gpsStamp >= '" . $startDate . "' and gpsStamp < '" . $stopDate. "' " .
		//				" and code=3019 ". 
		//				" order by l.deviceID, gpsStamp"; 

		//				$sql="SELECT vm.ModelName,c.name as customer,d.deviceID,d.d_esn,vi.licenseNumber,fuel_level_bef, fuel_level_now, fuel_level_now1" . 
		//		          " from provision_obd.Devices d  " .
		//			      " join  Devices_MT dm on d.deviceID=dm.deviceID".	
		//			      " left join  VehModelNumber vn on dm.ModelNumID=vn.ModelNumID".	
		//			      " join  VehicleInfo vi on  dm.vin=vi.vin".	
		//			      " left join  VehModel vm  on  vn.ModelID=vm.ModelID".
		//			      " left join  Customers c on dm.customerID=c.id".
		//			      " left join  obd_demo.LocationHistory l " .
		//			      " on  (l.deviceID=d.deviceID and   gpsStamp >= '$startDate' AND gpsStamp <= '$stopDate' and code=3019)".
		//			      " where d.deviceID in ("  . $devices . ") ".
		//			      " order by l.deviceID, gpsStamp"; 

		$sql = "select    aa.*,bb. totalFuelLoss from (SELECT vm.ModelName,c.name as customer,d.deviceID,d.d_esn,vi.licenseNumber,sum(fuel_level_now-fuel_level_bef)  as  totalFuelCharge
		from provision_obd.Devices d   
		join  Devices_MT dm on d.deviceID=dm.deviceID 
		left join  VehModelNumber vn on dm.ModelNumID=vn.ModelNumID 
		join  VehicleInfo vi on  dm.vin=vi.vin 
		left join  VehModel vm  on  vn.ModelID=vm.ModelID 
		left join  Customers c on dm.customerID=c.id 
		left join  obd_demo.LocationHistory l  on  (l.deviceID=d.deviceID and   gpsStamp >= '$startDate' AND gpsStamp <= '$stopDate' and code=3019) 
		where d.deviceID in (" . $devices . ")   and  ( (fuel_level_now-fuel_level_bef ) >0   or   (fuel_level_now-fuel_level_bef )  is null ) group by  d.deviceID)  as   aa   left join 
		 (select  l.deviceID ,sum(fuel_level_now-fuel_level_bef)  as  totalFuelLoss
		from   obd_demo.LocationHistory l  
		where   gpsStamp >= '$startDate' AND gpsStamp <= '$stopDate' 
		and code=3019 and l.deviceID in (" . $devices . ")   
		and  ( (fuel_level_now-fuel_level_bef ) <0  or   (fuel_level_now-fuel_level_bef )  is null ) group by  l.deviceID order by l.deviceID , gpsStamp) as bb  on   aa.deviceID=bb.deviceID";

		//echo $sql . "<BR>";

		$logger->debug("----------------sql:------" . $sql);
		mysql_select_db("IOV_demo");
		$result = mysql_query($sql);
		$numRows = mysql_num_rows($result);
		if ($numRows > 0) {

			while ($row = mysql_fetch_object($result)) {
				     if($row->totalFuelCharge==null){
				     	$row->totalFuelCharge=0;
				     }
				     if($row->totalFuelLoss==null){
				     	$row->totalFuelLoss=0;
				     }
				     
				     if($forExcel == false){
				     	 $data[]=$row;
				     }
				     else{
					    $tmp= array ();
					    $tmp[0] = $row->deviceID;
						$tmp[1] = $row->d_esn;
						$tmp[2] = $row->licenseNumber;
						$tmp[3] = $row->customer;
						$tmp[4] = $row->ModelName;
						$tmp[5] = $row->totalFuelCharge;
						$tmp[6] = $row->totalFuelLoss;	
					array_push($data, $tmp);
				   }
					 
					} 
		}
	
		return $data;
	}

	public function getTjFuelChangeDetail($startDate, $stopDate, $devices) {
		$data = array ();
		$devices = str_replace(',', '\',\'', $devices);
		$devices = ' \'' . $devices . '\'';
		$sql = "SELECT d.deviceID,d.d_esn,vi.licenseNumber,fuel_level_now - fuel_level_bef as fuel_change,l.gpsStamp,l.address_num" .
		" from provision_obd.Devices d  " .
		" join  Devices_MT dm on d.deviceID=dm.deviceID" .
		" join  VehicleInfo vi on  dm.vin=vi.vin" .
		" join  obd_demo.LocationHistory l " .
		" on  (l.deviceID=d.deviceID and   gpsStamp >= '$startDate' AND gpsStamp <= '$stopDate' and code=3019)" .
		" where d.deviceID in (" . $devices . ") " .
		" order by  gpsStamp desc";
		mysql_select_db("IOV_demo");
		$result = mysql_query($sql);
		$numRows = mysql_num_rows($result);

		if ($numRows > 0) {
			while ($row = mysql_fetch_object($result)) {
				$row->gpsStamp = date("Y-m-d H:i:s", strtotime($row->gpsStamp . '+8hour'));
				array_push($data, $row);
			}
		}

		return $data;

	}

	public function getTjFuelChange4BarChart($startDate, $stopDate, $devices) {
		$data = array ();
		$time = array ();
		$fuel_change = array ();
		$devices = str_replace(',', '\',\'', $devices);
		$devices = ' \'' . $devices . '\'';
		$sql = "SELECT d.deviceID,d.d_esn,vi.licenseNumber,fuel_level_now - fuel_level_bef as fuel_change,l.gpsStamp,l.address_num" .
		" from provision_obd.Devices d  " .
		" join  Devices_MT dm on d.deviceID=dm.deviceID" .
		" join  VehicleInfo vi on  dm.vin=vi.vin" .
		" join  obd_demo.LocationHistory l " .
		" on  (l.deviceID=d.deviceID and   gpsStamp >= '$startDate' AND gpsStamp <= '$stopDate' and code=3019)" .
		" where d.deviceID in (" . $devices . ") " .
		" order by  gpsStamp desc";
		mysql_select_db("IOV_demo");
		$result = mysql_query($sql);
		$numRows = mysql_num_rows($result);

		if ($numRows > 0) {
			while ($row = mysql_fetch_object($result)) {
				$row->gpsStamp = date("Y-m-d H:i:s", strtotime($row->gpsStamp . '+8hour'));
				$time[] = $row->gpsStamp;
				$fuel_change[] = $row->fuel_change;
			}
		}
		$data[0] = $time;
		$data[1] = $fuel_change;
		return $data;

	}

}
?>