<?php
include '../../zend_obd/jsonAPI/notiFaction.php';
require_once '../../zend_obd/Encypty.php';
include_once '../../common/AES.php';


$device = new Alarm();

$id = $_POST["id"];
$name = $_POST["name"];
$parentId = $_POST["parentId"];
$parentName = $_POST["parentName"];

$tel = $_POST["tel"];

$address = $_POST["address"];


$obj = $device->update_fleet($id,$name,$parentId,$parentName,$tel,$address);


$veh = $obj['resultCode'];


echo json_encode($veh);

?>