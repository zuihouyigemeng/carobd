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
$objArray = $m->getTjMonth($startDate,$stopDate,$devices);
//$dateArr = $obj['keys'];
//$distanceArr = $obj['values'];
$numberArray = array();
$numRows = count($objArray);
for ($i = 0; $i < $numRows; $i++) {
	array_push($numberArray, ($i +1));
}

$month=substr($startDate,0,7);
$list = array (
	"序号",
	"车牌号",
	"客户名称",
	"车型",
	"终端号",
	"总里程（KM）",
	"总油耗（L）",
	"最高速度(km/h)"
);

$title = "里程、油耗月统计（".$month."）";
$filename = iconv("utf-8", "gb2312", "里程_油耗月统计（".$month."）");
$smarty = new Smarty;
$smarty->assign("title", $title);
$smarty->assign("list", $list);
$smarty->assign("objArray", $objArray);
$smarty->assign("numberArray", $numberArray);
header("Content-type:application/vnd.ms-excel");
header("Content-Disposition:filename=$filename.xls");
$smarty->display("month.tpl");
?>
