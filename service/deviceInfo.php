<?php
include '../DBConnection.php';
require_once '../log4php/Logger.php';
Logger :: configure('../log4php.properties');
$logger = Logger :: getRootLogger();

$optype = isset($_POST['optype']) ? $_POST['optype'] : null;
$opvalue = isset($_POST['opvalue']) ? $_POST['opvalue'] : null;
$data = array();
if($optype=='VehNum'){
	$sql="select dm.deviceID,d.defenceFlag from Devices_MT dm ,VehicleInfo vi,provision_obd.Devices d  where dm.vin=vi.vin and  dm.deviceID=d.deviceID and vi.licenseNumber='$opvalue' limit 1";
}
else if($optype=='ESN'){
	$sql="select d.deviceID,d.defenceFlag from Devices_MT dm ,provision_obd.Devices d where dm.deviceID=d.deviceID and d.d_esn='$opvalue' limit 1";
}
else if($optype=='deviceID'){
	$sql="select d.deviceID,d.defenceFlag from provision_obd.Devices d where d.deviceID='$opvalue' limit 1";
}
//echo $sql;
$logger->debug("----------------sql:------" . $sql);
mysql_select_db("IOV_demo");
$result = mysql_query($sql);
$numRows = mysql_num_rows($result);
//echo "</br>".$numRows;
$ret = array ();
if ($numRows > 0) {
while($row = mysql_fetch_array($result)){
	$node = array();
	$node['deviceID'] = $row['deviceID'];
	$node['defenceFlag'] = $row['defenceFlag'];
	array_push($data,$node);
}
}
echo json_encode($data);

?>