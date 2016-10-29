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

//echo ($speed);
$m = new Maintain();
$obj = $m->getMonthDist4Web($deviceID, $time);
$dateArr = $obj['keys'];
$distanceArr = $obj['values'];

$numberArray = array();
$numRows = count($dateArr);
for ($i = 0; $i < $numRows; $i++) {
	array_push($numberArray, ($i +1));
}

$list = array (
	"序号",
	"日期",
	"里程(KM)"
);

$date=date("Y-m", strtotime($time));

$title = "里程统计" . "（ 月份：" . $date . "）";
$filename = iconv("utf-8", "gb2312", "里程"."_".$date);
$smarty = new Smarty;
$smarty->assign("title", $title);
$smarty->assign("list", $list);
$smarty->assign("numberArray", $numberArray);
$smarty->assign("dateArr", $dateArr);
$smarty->assign("distanceArr", $distanceArr);
header("Content-type:application/vnd.ms-excel");
header("Content-Disposition:filename=$filename.xls");
$smarty->display("date_distance.tpl");
?>
