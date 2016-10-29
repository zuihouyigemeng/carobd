<?php
include '../DBConnection.php';
require_once '../log4php/Logger.php';
Logger :: configure('../log4php.properties');
$logger = Logger :: getRootLogger();


$ret = array();
$data = array();

$intervals=new stdClass();
$intervals->smsNotice=1;

$obd=new stdClass();
$obd->MDN='15800892321';
$obd->status='1';
$data[]=$obd;

$obd1=new stdClass();
$obd1->MDN='15800892321';
$obd1->status='1';
$data[]=$obd1;


$intervals->intervals=$data;

$ret['result']=$intervals;


$ret['resultMsg'] = 'ok';
$ret['resultCode'] ='200' ;
echo json_encode($ret);


?>