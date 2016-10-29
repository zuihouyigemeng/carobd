<?php
include 'operatLandmark.php';
$device = new OperatLandmark();

$vin = $_GET["vin"]; 

$obj = $device->deleteLandMarkById($vin);


$veh = $obj['resultCode'];


echo json_encode($veh);

?>