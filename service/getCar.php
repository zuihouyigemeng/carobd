<?php
include 'operatBrand.php';

$device = new OperatBrand();

$flag = $_POST["flag"];//查询的内容

$modelId = $_POST["modelId"];

$obj = $device->getCar($modelId,$flag);

$veh = $obj['data'];

echo json_encode($veh);

?>