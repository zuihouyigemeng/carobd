<?php
include '../DBConnection.php';
include '../../zend_obd/History.php';

$startDate = isset($_REQUEST['startDate']) ? $_REQUEST['startDate'] : null;
$stopDate = isset($_REQUEST['stopDate']) ? $_REQUEST['stopDate'] : null;
$deviceID = isset($_REQUEST['deviceID']) ? $_REQUEST['deviceID'] : null;

$ca=new History();

#echo 'hello world!==='.$startDate.'==='.$stopDate.'==='.$deviceID.'\n\n\n';

#$ret = array ();

$obj = $ca->getTracksNew("obd_demo",$deviceID,$startDate,$stopDate);

#$data= $ca->getTracks("obd_demo",$deviceID,$startDate,$stopDate);
#$ret['total'] = sizeof($data);
#$ret['rows'] = $data;

echo json_encode($obj);


?>