<?php
include '../../zend_obd/jsonAPI/notiFaction.php';
$device = new Alarm();

$vin = $_GET["vin"]; 
$obj = $device->deleteDepartments($vin);


$veh = $obj['resultCode'];


echo json_encode($veh);

?>