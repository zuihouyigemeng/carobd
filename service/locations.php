<?php
include '../DBConnection.php';
require_once '../log4php/Logger.php';
Logger :: configure('../log4php.properties');
$deviceIDS = isset ($_GET['deviceIDS']) ? $_GET['deviceIDS'] : "";
if($deviceIDS==""){
	$deviceIDS = isset ($_POST['deviceIDS']) ? $_POST['deviceIDS'] : "";
}
$deviceIDS =str_replace(',', '\',\'', $deviceIDS);
$deviceIDS=' \''.$deviceIDS.'\'';
$logger = Logger :: getRootLogger();
$logger->debug("----------------deviceIDS:------" . $deviceIDS);
$data = array ();
mysql_select_db("obd_demo");
//		$query = "select * from VehicleInfo v ,obd_demo.LocationStatus l,provision_obd.Devices d where v.vin=d.d_vin and  l.deviceID=d.deviceID and d.depID in (" . $deptIDs . ") ";
$query = "select  l.*,iv.licenseNumber  from  LocationStatus l,IOV_demo.Devices_MT dm,IOV_demo.VehicleInfo iv  where l.deviceID=dm.deviceID and dm.vin=iv.vin and l.deviceID in (" . $deviceIDS . ")";

$logger->debug("----------------sql:------" . $query);
//echo $query;
$result = mysql_query($query);
$numRows = mysql_num_rows($result);
if ($numRows > 0) {
	while ($row = mysql_fetch_array($result)) {
		$node = array ();
		$node['deviceID'] = $row['deviceID'];
		$node['address_num'] = $row['address_num'];
		$node['latitude'] = $row['baidu_latitude'];
		$node['longitude'] = $row['baidu_longitude'];
		$node['onlineStatus'] = $row['onlineStatus'];
		$time=$row['gpsDate']." ".$row['gpsTime'];
		//date("Y-m-d H:i:s", strtotime($time . '+8hour'));
		if($time <>'0000-00-00 00:00:00'){
			$node['time'] =date("Y-m-d H:i:s", strtotime($time . '+8hour'));
		}
		else{
			$node['time']=$time;
		}
		$node['speed'] = $row['speed'];
		$node['engineRPM'] = $row['engineRPM'];
		$node['batt_level'] = $row['batt_level'];
		$node['fuel_level_now'] = $row['fuel_level_now'];
		if($node['fuel_level_now']==255){
			$node['fuel_level_now']=0;
		}
		$node['ign'] = $row['ign'];
		
		$node['licenseNumber'] = $row['licenseNumber'];
		$node['heading'] = $row['heading'];
		$node['alertStatus'] = $row['alertStatus1']+$row['alertStatus2']+$row['alertStatus3']+$row['alertStatus4']+$row['alertStatus5']+$row['alertStatus6']+$row['alertStatus7']+$row['alertStatus8'];
		
		if($node['latitude']=="0.000000" and $node['longitude']=="0.000000" and  $node['ign']<>-1){
			$his=getHistoryLocation($node['deviceID']);
			if($his<>null){
				$node['address_num'] =($his->address_num)."（最近有效位置）";
		        $node['latitude'] = $his->latitude;
		        $node['longitude'] =$his->longitude;
		        $node['time']=date("Y-m-d H:i:s", strtotime($his->time . '+8hour'));
			}
		    else{
		    	$node['address_num'] ="无有效位置";
		        $node['latitude'] = "31.243639";
		        $node['longitude'] ="121.508418";
		    }
		}
		
		array_push($data, $node);
	}
	mysql_free_result($result);
}

echo json_encode($data);

 function getHistoryLocation($deviceID) {
		mysql_select_db("obd_demo");
		$sql = "select l.address_num,
					l.baidu_latitude as latitude ,
					l.baidu_longitude as longitude,
					l.heading,concat( l.gpsDate, ' ', l.gpsTime ) as `time` from LocationHistory l 
				    where deviceID='$deviceID' and latitude <>'0.000000' and longitude<>'0.000000' order by locIndex  desc limit 1";
		$selectresult = mysql_query($sql);
		$selectRows = mysql_num_rows($selectresult);
		if ($selectRows > 0) {
			$row = mysql_fetch_object($selectresult);
			return $row;
		}
		return null;

	}

?>