<?php
//include 'notiFaction.php';
include '../../zend_obd/jsonAPI/notiFaction.php';
require_once '../../zend_obd/Encypty.php';
include_once '../../common/AES.php';


$device = new Alarm();

$parentID = $_POST["parentID"];
$parentName = $_POST["parentName"];
$name = $_POST["name"];
$tel = $_POST["tel"];
$address = $_POST["address"];

$obj = $device->insert_fleet($parentID,$parentName,$name,$tel,$address);


$veh = $obj['resultCode'];


echo json_encode($veh);

?>