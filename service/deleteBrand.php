<?php
#include '../../zend_obd/Vehicle.php';
include 'operatBrand.php';

$device = new OperatBrand();//new Vehicle();

$BrandID = $_POST["brandId"];

$obj = $device->deleteBrand($BrandID);

$veh = $obj['resultCode'];

echo json_encode($veh);

?>