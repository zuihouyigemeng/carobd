<?php
include '../DBConnection.php';
require_once '../log4php/Logger.php';
include 'cancelAlert.php';
Logger :: configure('../log4php.properties');
$logger = Logger :: getRootLogger();

$opType = isset($_REQUEST['opType']) ? $_REQUEST['opType'] : null;
$startDate = isset($_REQUEST['startDate']) ? $_REQUEST['startDate'] : null;
$stopDate = isset($_REQUEST['stopDate']) ? $_REQUEST['stopDate'] : null;
$devices=isset($_REQUEST['devices']) ? $_REQUEST['devices'] : null;
$ca=new cancelAlert();
if($opType=='0' or $opType==0){
$ret = array ();
$data= $ca->getAlerts($devices,$startDate,$stopDate,0);
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