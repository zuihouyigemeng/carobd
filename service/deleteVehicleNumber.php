<?php
#include '../../zend_obd/Vehicle.php';
include 'operatBrand.php';

$device = new OperatBrand();//Vehicle();

$ModelNumID = $_POST["modelNumID"];

$obj = $device->deleteVehModelNumber($ModelNumID);

$veh = $obj['resultCode'];

echo json_encode($veh);

?>