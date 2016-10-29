<?php
include  dirname(__FILE__).'/../DBConnection.php';
require_once dirname(__FILE__).'/../log4php/Logger.php';
Logger :: configure(dirname(__FILE__).'/../log4php.properties');

//$_USER_TIMEZONE_ = +8;	//常量
/*
 * 时区转换
 */

// function toTimeZone1($src, $from_tz = DateTimeZone::UTC, $to_tz = 'Asia/Shanghai', $fm = 'Y-m-d H:i:s') {
    // $datetime = new DateTime($src, new DateTimeZone($from_tz));
    // $datetime->setTimezone(new DateTimeZone($to_tz));
    // return $datetime->format($fm);
// }
// function toTimeZone(){
	// $date = date_create('2012-07-16 01:00:00 +00', timezone_open('Etc/GMT+0'));
	// echo '<p>'.date_format($date, 'Y-m-d H:i:s').'</p>';

	// date_timezone_set($date, timezone_open('Etc/GMT+4'));
	// echo '<p>'.date_format($date, 'Y-m-d H:i:s').'</p>';
// }
class tj_canbus{
	 public function getTjCanbus($startDate,$stopDate,$devices,$forExcel=false){
		//	参数： $forExcel = true:  按excel导出要求决定输出数组的索引方式
		//	$startDate = date("Y-m-d H:i:s", strtotime($startDate . '-8hour'));
		//	$stopDate= date("Y-m-d H:i:s", strtotime($stopDate . '-8hour'));
		
		$page = isset ($_REQUEST['page']) ? $_REQUEST['page'] : null;
		$rows = isset ($_REQUEST['rows']) ? $_REQUEST['rows'] : null;
		$total = 0;
		$page = ($page -1) * $rows;
		$data = array();
		$devices =str_replace(',', '\',\'', $devices);
		$devices=' \''.$devices.'\'';
		
		$sqlCount = "SELECT count(*) as total" . 
				" FROM obd_demo.LocationHistory l,VehModelNumber vn,VehModel vm,Devices_MT dm,VehicleInfo vi, provision_obd.Devices d  ,Customers c   " .
				" where  l.deviceID=dm.deviceID " .
				" and l.deviceID=d.deviceID" .
				" and dm.ModelNumID=vn.ModelNumID".
				" and vn.ModelID=vm.ModelID".
				" and dm.customerID=c.id".
				" and  dm.vin=vi.vin and l.deviceID in ("  . $devices . ")" .
				" and gpsStamp >= '" . $startDate . "' and gpsStamp < '" . $stopDate. "' " .
				" and code in (3004,3005,3015,3016) ";
		
		
		$sql="SELECT vm.ModelName,c.name as customer,d.deviceID,d.d_esn,vi.licenseNumber, l.gpsStamp,l.address_num , l.engineRPM,l.high_temp, l.num_of_dtc, l.speed, l.fuel_level_now, l.batt_level" . 
				" FROM obd_demo.LocationHistory l,VehModelNumber vn,VehModel vm,Devices_MT dm,VehicleInfo vi, provision_obd.Devices d  ,Customers c   " .
				" where  l.deviceID=dm.deviceID " .
				" and l.deviceID=d.deviceID" .
				" and dm.ModelNumID=vn.ModelNumID".
				" and vn.ModelID=vm.ModelID".
				" and dm.customerID=c.id".
				" and  dm.vin=vi.vin and l.deviceID in ("  . $devices . ")" .
				" and gpsStamp >= '" . $startDate . "' and gpsStamp < '" . $stopDate. "' " .
				" and code in (3004,3005,3015,3016) ". 
		//		" order by l.deviceID, gpsStamp desc".
		        " order by  gpsStamp desc".
				" limit $page,$rows"; 
		//echo $sql . "<BR>";
	
		//$logger->debug("----------------sql:------" . $sql);
		mysql_select_db("IOV_demo");
		
		
		$result = mysql_query($sqlCount);
		$numRows = mysql_num_rows($result);
		if ($numRows > 0) {
			while ($row = mysql_fetch_object($result)) {
				$total = $row->total;
			}
			mysql_free_result($result);
		}
		
		

		mysql_select_db("IOV_demo");
		$result = mysql_query($sql);
		$numRows = mysql_num_rows($result);
//		$ret = array ();
//		$data= array ();
		$i =0;	//number of rows in table (not in db)
		
		if ($numRows > 0) {
			$lastDeviceID = "";	
			$totalFuelCharge=0;
			$totalFuelLoss=0;	
	
	//sample data record:
	//	dev01 licence01  fuel_level_bef01 fuel_level_now01
	//	dev01 licence01  fuel_level_bef02 fuel_level_now02
	//	dev02 licence02  fuel_level_bef03 fuel_level_now03
	//	dev02 licence02  fuel_level_bef04 fuel_level_now04
	
			while($row = mysql_fetch_object($result)){
				// $fuelChange = $row->fuel_level_now - $row->fuel_level_bef;
				// if ($fuelChange>=0){ //分别统计加油和漏油
					// $totalFuelCharge += $fuelChange;
				// }else{
					// $totalFuelLoss -= $fuelChange;
				// }
				//if ($row->deviceID != $lastDeviceID){	// 同一deviceID第一行记录 
					if ($forExcel == false){	
						//$data[$i] = array();
						$data[$i]["deviceID"] = $row->deviceID;
						$data[$i]["d_esn"] = $row->d_esn;
						$data[$i]["licenseNumber"] = $row->licenseNumber;
						$data[$i]["customer"] = $row->customer;
						$data[$i]["modelName"] = $row->ModelName;//l.gpsStamp,l.address_num , l.engineRPM,l.high_temp, l.num_of_dtc, l.speed, l.fuel_level_now, l.batt_level" . 
						$data[$i]["gpsStamp"] = date("Y-m-d H:i:s", strtotime($row->gpsStamp . '+8hour')); 	//toTimeZone( $row->gpsStamp);
						date("Y-m-d H:i:s", strtotime($time . '+8hour'));
						$data[$i]["address"] = $row->address_num;
						$data[$i]["engineRPM"] = $row->engineRPM;
						$data[$i]["high_temp"] = $row->high_temp;
						$data[$i]["num_of_dtc"] = $row->num_of_dtc;
						$data[$i]["speed"] = $row->speed;
						$data[$i]["fuel_level_now"] = $row->fuel_level_now;
						$data[$i]["batt_level"] = $row->batt_level;
						//debug
						//if ($i<3) {echo "<br>" . $row->gpsStamp . "->" . $data[$i]["gpsStamp"] . "<br>" ;};
						// if ($i > 0){	//上一个deviceID的统计值 
							// $data[$i-1]["totalFuelCharge"] = $totalFuelCharge . "%";
							// $data[$i-1]["totalFuelLoss"] = $totalFuelLoss . "%";
							// $totalFuelCharge=0;
							// $totalFuelLoss=0;					
						// }							
					}else{	
						//$data[$i] = array();
						$data[$i][0] = $row->deviceID;
						$data[$i][1] = $row->d_esn;
						$data[$i][2] = $row->licenseNumber;
						$data[$i][3] = $row->customer;
						$data[$i][4] = $row->ModelName;
						$data[$i][5] = date("Y-m-d H:i:s", strtotime($row->gpsStamp . '+8hour'));
						$data[$i][6] = $row->address_num;
						$data[$i][7] = $row->engineRPM;
						$data[$i][8] = $row->high_temp;
						$data[$i][9] = $row->num_of_dtc;
						$data[$i][10] = $row->speed;
						$data[$i][11] = $row->fuel_level_now;
						$data[$i][12] = $row->batt_level;
								
						// if ($i > 0){	//上一个deviceID的统计值 
							// $data[$i-1]["5"] = $totalFuelCharge . "%";
							// $data[$i-1]["6"] = $totalFuelLoss . "%";
							// $totalFuelCharge=0;
							// $totalFuelLoss=0;					
						// }							
						
					}
					
					$i++;
				//}					
				//$lastDeviceID = $row->deviceID;		
			}
			// if ($forExcel == false){				
				// $data[$i-1]["totalFuelCharge"] = $totalFuelCharge . "%";	//最后一个device填写统计值 
				// $data[$i-1]["totalFuelLoss"] = $totalFuelLoss . "%";
			// }else{
				// $data[$i-1]["5"] = $totalFuelCharge . "%";	//最后一个device填写统计值 
				// $data[$i-1]["6"] = $totalFuelLoss . "%";
			// }		
		}
//		$ret['total'] = $i;
//		$ret['rows'] = $data;
//		//echo json_encode($ret);
		//echo $data[0]["totalFuelLoss"];
		
		$ret = array();
		$ret['total'] = $total;
		$ret['rows'] = $data;
		return $ret;		
	}
}
?>