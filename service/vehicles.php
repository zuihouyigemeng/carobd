<?php
include '../DBConnection.php';
require_once '../log4php/Logger.php';
Logger :: configure('../log4php.properties');
$deptID = isset ($_POST['depID']) ? intval($_POST['depID']) : 0;
$logger = Logger :: getRootLogger();
$logger->debug("----------------depID:------" . $deptID);

if ($deptID == 0) {
	$deptID = isset ($_GET['depID']) ? intval($_GET['depID']) : 0;
	$logger->debug("----------------depID:------" . $deptID);

}
if ($deptID == 0) {
	echo '{"total":0,"rows":[]}';
	return;
}

$ign=isset ($_GET['ign']) ? intval($_GET['ign']) : null;

$data = array ();

//mysql_select_db("provision_obd");
//$rs = mysql_query("select * from Devices limit 10");
//$numRows = mysql_num_rows($rs);
//$result['total'] =$numRows ;
//while($row = mysql_fetch_array($rs)){
//	$node = array();
//	$node['deviceID'] = $row['deviceID'];
//	$node['d_esn'] = $row['d_esn'];
//	array_push($data,$node);
//}
//echo 'bbbbbbbbbb';
//$result['rows']=getVehiclesByDepID(1070);

mysql_select_db("IOV_demo");
$arrDeptID = getDeptLowerId($deptID);
array_push($arrDeptID, $deptID);
$deptIDs = implode(",", $arrDeptID);
//		$query = "select * from VehicleInfo v ,obd_demo.LocationStatus l,provision_obd.Devices d where v.vin=d.d_vin and  l.deviceID=d.deviceID and d.depID in (" . $deptIDs . ") ";
$query = "select d.deviceID,v.vin,d.d_esn,v.licenseNumber,l.ign,l.address_num,l.baidu_latitude as latitude ,l.baidu_longitude as longitude,l.heading,concat( l.gpsDate, ' ', l.gpsTime ) as time from VehicleInfo v ,provision_obd.Devices d,Devices_MT dm,obd_demo.LocationStatus l  where d.deviceID=dm.deviceID and dm.vin=v.vin and d.depID  in (" . $deptIDs . ") and d.deviceID=l.deviceID  ";

$logger->debug("----------------ign:------" . $ign);
if($ign==1 or $ign==0){
	$query.=" and l.ign=$ign";
}
$d_esn=isset ($_GET['d_esn']) ? intval($_GET['d_esn']) : null;
if($d_esn!=null){
	$query.=" and d.d_esn like '%$d_esn%'";
}

$licenseNumber=isset ($_GET['licenseNumber']) ? $_GET['licenseNumber'] : null;

if($licenseNumber!=null){
	$query.=" and  v.licenseNumber like '%$licenseNumber%'";
}

$logger->debug("----------------sql:------" . $query);
//echo $query;
$result = mysql_query($query);
$numRows = mysql_num_rows($result);
$ret = array ();
$ret['total'] = $numRows;
if ($numRows > 0) {
	while ($row = mysql_fetch_array($result)) {
		$node = array ();
		$node['licenseNumber'] = $row['licenseNumber'];
		$node['d_esn'] = $row['d_esn'];
		$node['address_num'] = $row['address_num'];
		$node['latitude'] = $row['latitude'];
		$node['longitude'] = $row['longitude'];
		$node['time'] =date("Y-m-d H:i:s", strtotime($row['time'] . '+8hour'));;
		$node['vin'] = $row['vin'];
		$node['deviceID'] = $row['deviceID'];
		$node['heading'] = $row['heading'];
		$node['ign'] = $row['ign'];
		array_push($data, $node);
	}
	mysql_free_result($result);
}

$ret['rows'] = $data;

echo json_encode($ret);

function getDeptLowerId($deptID) {
	$logger = Logger :: getRootLogger();
	mysql_select_db("IOV_demo");
	//	$query = "select id from Departments where parentId=$deptID ";
	$query = "select id from Opm_Organ where parentId=$deptID ";
	$logger->debug("----------------getDeptLowerId:------" . $query);
	$result = mysql_query($query);
	$numRows = mysql_num_rows($result);
	$ret = array ();
	$data = array ();
	if ($numRows > 0) {
		for ($d = 0; $d < $numRows; $d++) {
			$row = mysql_fetch_array($result);
			array_push($ret, $row["id"]); //set
			$data = getDeptLowerId($row["id"]); //query
			for ($i = 0; $i < count($data); $i++) { //set again
				array_push($ret, $data[$i]);
			}
		}
		mysql_free_result($result);
	}
	return $ret;
}
?>