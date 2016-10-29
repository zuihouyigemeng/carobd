<?php
include dirname(__FILE__).'/tj_fuelChangeAPI.php';
//echo "Hello";

$opType = isset($_REQUEST['opType']) ? $_REQUEST['opType'] : null;
$startDate = isset($_REQUEST['startDate']) ? $_REQUEST['startDate'] : null;
$stopDate = isset($_REQUEST['stopDate']) ? $_REQUEST['stopDate'] : null;
$devices=isset($_REQUEST['devices']) ? $_REQUEST['devices'] : null;

if($opType=='0' or $opType==0){
	$ret = array ();
	$obj = new tj_fuelChange(); 
	$data= $obj->getTjFuelChange($startDate,$stopDate,$devices);
	//echo "abc";
	//echo ( $data[0]["licenseNumber"]);
	$ret['total'] =count($data);
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
	$query="SELECT serverDate,fuel_level_bef, fuel_level_now, fuel_level_now1" . 
		" FROM obd_demo.LocationHistory " .
		" where deviceID = '"  . $deviceID . "' " .
		" and gpsStamp >= '" . $startDate . "' and gpsStamp < '" . $stopDate. "' " .
		" and code=3019 " . 
		" order by gpsStamp desc"; 
	//echo $query ;		
	//$logger->debug("----------------sql:------" . $query);
	
	$result = mysql_query($query);
	$iRows = mysql_num_rows($result);
	$lastServerDate ="";
	$totalFuelCharge=0;
	$totalFuelLoss=0;	

	if ($iRows > 0) {
		while($row = mysql_fetch_object($result)){				
			$fuelChange = $row->fuel_level_now1 - $row->fuel_level_bef;
			if ($fuelChange>=0){ //分别统计加油和漏油
				$totalFuelCharge += $fuelChange;
			}else{
				//if ($fuelChange <= -80) $totalFuelLoss -= $fuelChange;
				$totalFuelLoss =0;//-= $fuelChange;
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

else if($opType=='2' or $opType==2){
	$ret = array ();
	$obj = new tj_fuelChange(); 
	$data= $obj->getTjFuelChangeDetail($startDate,$stopDate,$devices);
	$ret['total'] =count($data);
	$ret['rows'] = $data;
	echo json_encode($ret);
}
else if($opType=='3' or $opType==3){
	$obj = new tj_fuelChange(); 
	$data= $obj->getTjFuelChange4BarChart($startDate,$stopDate,$devices);
	echo json_encode($data);
}
else{
	echo 'optype error!';
}



?>