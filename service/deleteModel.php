<?php
#include '../../zend_obd/Vehicle.php';
include 'operatBrand.php';

$device = new OperatBrand();//new Vehicle();

$ModelID = $_POST["modelId"];

$obj = $device->deleteModel($ModelID);

$veh = $obj['resultCode'];

echo json_encode($veh);

?>