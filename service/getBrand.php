<?php
include 'operatBrand.php';

$device = new OperatBrand();

$brand = $_POST["brand"];

$obj = $device->getBrand($brand);

$veh = $obj['data'];

echo json_encode($veh);

?>