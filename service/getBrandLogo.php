<?php
include '../../zend_obd/Vehicle.php';

$device = new Vehicle();

$BrandID = $_POST["brandId"];

$obj = $device->getBrandLogo($BrandID);

$veh = $obj['data'];

echo json_encode($veh);

?>