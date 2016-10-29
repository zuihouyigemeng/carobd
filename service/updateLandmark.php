<?php
include 'operatLandmark.php';

$device = new OperatLandmark();

$id=$_POST["id"];
$landmarkName = $_POST["landmarkName"];
$lat = $_POST["lat"];
$lng = $_POST["lng"];
$departmentId = $_POST["departmentId"];
$address = $_POST["address"];

$obj = $device->updateLandmark($id,$landmarkName,$lng,$lat,$departmentId,$address);

$veh = $obj['resultCode'];

echo json_encode($veh);

?>