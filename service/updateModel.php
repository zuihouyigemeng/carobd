<?php
include '../../zend_obd/Vehicle.php';

$device = new Vehicle();

$ModelID = $_POST["modelId"];
$ModelName = $_POST["modelName"];

$obj = $device->updateModel($ModelID,$ModelName);

$veh = $obj['resultCode'];

echo json_encode($veh);

?>