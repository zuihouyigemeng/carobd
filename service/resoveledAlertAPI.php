<?php
include '../DBConnection.php';
require_once '../log4php/Logger.php';
include 'resoveledAlert.php';
Logger :: configure('../log4php.properties');
$logger = Logger :: getRootLogger();

$opType = isset($_REQUEST['opType']) ? $_REQUEST['opType'] : null;
$startDate = isset($_REQUEST['startDate']) ? $_REQUEST['startDate'] : null;
$stopDate = isset($_REQUEST['stopDate']) ? $_REQUEST['stopDate'] : null;
$devices=isset($_REQUEST['devices']) ? $_REQUEST['devices'] : null;
$alertTypes=isset($_REQUEST['alertTypes']) ? $_REQUEST['alertTypes'] : '0,1,2,3,4,5,6,7';
$ca=new resoveledAlert();
if($opType=='0' or $opType==0){
$ret = array ();
$data= $ca->getAlerts($devices,$startDate,$stopDate,0,$alertTypes);
$ret['total'] = sizeof($data);
$ret['rows'] = $data;
echo json_encode($ret);
}
else if($opType=='1' or $opType==1){
	
}
else{
	echo 'optype error!';
}




?>