<?php
include 'operatLandmark.php';
$device = new OperatLandmark();

$vin = $_GET["vin"]; 
$obj = $device->getLandmarkByDepartmentId($vin);


$veh = $obj['data'];


echo json_encode($veh);

?>