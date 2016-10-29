<?php
include '../DBConnection.php';
require_once '../log4php/Logger.php';
Logger :: configure('../log4php.properties');
$logger = Logger :: getRootLogger();
//echo "Hello";

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
	$sql="SELECT vm.ModelName,c.name as customer,d.deviceID,d.d_esn,vi.licenseNumber,fuel_level_bef, fuel_level_now" . 
			" FROM obd_demo.LocationHistory l,VehModelNumber vn,VehModel vm,Devices_MT dm,VehicleInfo vi, provision_obd.Devices d  ,Customers c   " .
			" where  l.deviceID=dm.deviceID " .
			" and l.deviceID=d.deviceID" .
			" and dm.ModelNumID=vn.ModelNumID".
			" and vn.ModelID=vm.ModelID".
			" and dm.customerID=c.id".
			" and  dm.vin=vi.vin and l.deviceID in ("  . $devices . ")" .
			" and gpsStamp >= '" . $startDate . "' and gpsStamp < '" . $stopDate. "' " .
			" and code=3019 ". 
			" order by l.deviceID, gpsStamp"; 
	//echo $sql . "<BR>";

	$logger->debug("----------------sql:------" . $sql);
	mysql_select_db("IOV_demo");
	$result = mysql_query($sql);
	$numRows = mysql_num_rows($result);
	$ret = array ();
	$data= array ();
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
			$fuelChange = $row->fuel_level_now - $row->fuel_level_bef;
			if ($fuelChange>=0){ //分别统计加油和漏油
				$totalFuelCharge += $fuelChange;
			}else{
				$totalFuelLoss -= $fuelChange;
			}
			if ($row->deviceID != $lastDeviceID){	// 同一deviceID第一行记录 
				
				//$data[$i] = array();
				$data[$i]["deviceID"] = $row->deviceID;
				$data[$i]["d_esn"] = $row->d_esn;
				$data[$i]["licenseNumber"] = $row->licenseNumber;
				$data[$i]["customer"] = $row->customer;
				$data[$i]["modelName"] = $row->ModelName;
				$data[$i]["totalFuelCharge"] = "-";
				$data[$i]["totalFuelLoss"] = "-";			
						
				if ($i > 0){	//上一个deviceID的统计值 
					$data[$i-1]["totalFuelCharge"] = $totalFuelCharge . "%";
					$data[$i-1]["totalFuelLoss"] = $totalFuelLoss . "%";
					$totalFuelCharge=0;
					$totalFuelLoss=0;					
				}	
				$i++;
			}					
			$lastDeviceID = $row->deviceID;		
		}
		
		$data[$i-1]["totalFuelCharge"] = $totalFuelCharge . "%";	//最后一个device填写统计值 
		$data[$i-1]["totalFuelLoss"] = $totalFuelLoss . "%";		
	}
	$ret['total'] = $i;
	$ret['rows'] = $data;
	echo json_encode($ret);
}
else if($opType=='1' or $opType==1){
	$deviceID=$devices;
	$tmp=$startDate;
	$data1 = array();	//加油
	$data2 =array();	//漏油
	
	while($tmp<$stopDate){
			$data1[$tmp]=0;
			$data2[$tmp]=0;
			$tmp=date("Y-m-d",strtotime($tmp."+1 day"));
	}		
	mysql_select_db("obd_demo");
	$query="SELECT serverDate,fuel_level_bef, fuel_level_now" . 
		" FROM obd_demo.LocationHistory " .
		" where deviceID = '"  . $deviceID . "' " .
		" and gpsStamp >= '" . $startDate . "' and gpsStamp < '" . $stopDate. "' " .
		" and code=3019 " . 
		" order by gpsStamp "; 
	//echo $query ;		
	//$logger->debug("----------------sql:------" . $query);
	
	$result = mysql_query($query);
	$iRows = mysql_num_rows($result);
	$lastServerDate ="";
	$totalFuelCharge=0;
	$totalFuelLoss=0;	

	if ($iRows > 0) {
		while($row = mysql_fetch_object($result)){				
			$fuelChange = $row->fuel_level_now - $row->fuel_level_bef;
			if ($fuelChange>=0){ //分别统计加油和漏油
				$totalFuelCharge += $fuelChange;
			}else{
				$totalFuelLoss -= $fuelChange;
			}
			if ($row->serverDate != $lastServerDate){	// 同一天第一行记录 					
				if ($lastServerDate != ""){	//为上一天填写统计值 
					$data1["$lastServerDate"] = $totalFuelCharge ;
					$data2["$lastServerDate"] = $totalFuelLoss ;
					$totalFuelCharge=0;
					$totalFuelLoss=0;					
				}	
			}					
			$lastServerDate = $row->serverDate;					
		}
		$data1["$lastServerDate"] = $totalFuelCharge ;//最后一天填写统计值 
		$data2["$lastServerDate"] = $totalFuelLoss ;
	}
	else{
		$ret["resultCode"]="201";
		$ret["resultMsg"]="no data";
	}
	
	$arr2=array();
	$arr2[0]=array_keys($data1);
	$arr2[1]=array_values($data1);
	$arr2[2]=array_values($data2);

	echo json_encode($arr2);
}
else{
	echo 'optype error!';
}



?>