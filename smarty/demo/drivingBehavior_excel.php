<?php


/**
 * export xls
 * */

require ('../libs/Smarty.class.php');
require ('../../../zend_obd/Maintain.php');



$startDate = isset($_REQUEST['startDate']) ? $_REQUEST['startDate'] : null;
$stopDate = isset($_REQUEST['stopDate']) ? $_REQUEST['stopDate'] : null;
$devices=isset($_REQUEST['devices']) ? $_REQUEST['devices'] : null;
//echo 'ppppp';
$m = new Maintain();
$objArray = $m->getDrivingBehavior($startDate,$stopDate,$devices);
//$dateArr = $obj['keys'];
//$distanceArr = $obj['values'];
$numberArray = array();
$numRows = count($objArray);
for ($i = 0; $i < $numRows; $i++) {
	array_push($numberArray, ($i +1));
}

$list = array (
	"序号",
	"日期",
	"车牌号",
	"客户名称",
	"车型",
	"终端号",
	"急加速(次)",
	"急刹车(次)",
	"急转弯(次)"
);

$starDay=substr($startDate,0,10);
$stopDay=substr($stopDate,0,10);

$title = "驾驶行为日统计（".$starDay."~".$stopDay."）";
$filename = iconv("utf-8", "gb2312", "驾驶行为日统计（".$starDay."~".$stopDay."）");
$smarty = new Smarty;
$smarty->assign("title", $title);
$smarty->assign("list", $list);
$smarty->assign("objArray", $objArray);
$smarty->assign("numberArray", $numberArray);
header("Content-type:application/vnd.ms-excel");
header("Content-Disposition:filename=$filename.xls");
$smarty->display("daily.tpl");
?>
