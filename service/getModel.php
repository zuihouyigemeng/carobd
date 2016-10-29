<?php
include 'operatBrand.php';

$device = new OperatBrand();

$brandId = $_POST["brandId"];

$model = $_POST["model"];

$obj = $device->getModel($brandId,$model);

$veh = $obj['data'];

echo json_encode($veh);

?>