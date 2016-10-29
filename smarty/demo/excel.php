<?php


/**
 * export xls
 * */

require ('../libs/Smarty.class.php');
require ('../../../zend_obd/Maintain.php');

$deviceID = $_POST["deviceID"];
$time = $_POST["time"];

if ($deviceID == null) {
	$deviceID = $_GET["deviceID"];
}

if ($time == null) {
	$time = $_GET["time"];
}

//echo $deviceID."</br>";


//echo $time."</br>";

//echo ($speed);
$m = new Maintain();
$obj = $m->getMonthFuel4Web($deviceID, $time);
$dateArr = $obj['keys'];


$consumptionArr = $obj['values'];

//print_r($consumptionArr);

//echo '</br>';

//print_r($dateArr);

//$dateArr=array("2014-07-01","2014-07-02","2014-07-03","2014-07-04","2014-07-05","2014-07-06");
//$consumptionArr =array("1","2","3","4","5","6");

$numberArray = array();
$numRows = count($dateArr);
for ($i = 0; $i < $numRows; $i++) {
	array_push($numberArray, ($i +1));
}

$list = array (
	"序号",
	"日期",
	"油耗(L)"
);
$date=date("Y-m", strtotime($time));
$title = "油耗统计" . "（ 月份：" . $date . "）";
$filename = iconv("utf-8", "gb2312", "油耗"."_".$date);
$smarty = new Smarty;
$smarty->assign("title", $title);
$smarty->assign("list", $list);
$smarty->assign("numberArray", $numberArray);
$smarty->assign("dateArr", $dateArr);
$smarty->assign("consumptionArr", $consumptionArr);
header("Content-type:application/vnd.ms-excel");
header("Content-Disposition:filename=$filename.xls");
$smarty->display("date_fuel_consumption.tpl");
?>
