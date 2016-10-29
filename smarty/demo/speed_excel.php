<?php


/**
 * export xls
 * */

require ('../libs/Smarty.class.php');
require ('../../service/tj_speed.php');



$startDate = isset($_REQUEST['startDate']) ? $_REQUEST['startDate'] : null;
$stopDate = isset($_REQUEST['stopDate']) ? $_REQUEST['stopDate'] : null;
$devices=isset($_REQUEST['devices']) ? $_REQUEST['devices'] : null;
$speed=isset($_REQUEST['speed']) ? $_REQUEST['speed'] : null;
$device=isset($_REQUEST['device']) ? $_REQUEST['device'] : null;

$m = new tj_speed();
$objArray = $m->searchOverSpeed($devices, $startDate, $stopDate, $speed,1);

$numberArray = array();
$numRows = count($objArray);
for ($i = 0; $i < $numRows; $i++) {
	array_push($numberArray, ($i +1));
}





$objArray1 = $m->searchOverSpeedDetail($device, $startDate, $stopDate, $speed,1);
$numberArray1 = array();
$numRows1 = count($objArray1);
for ($i = 0; $i < $numRows1; $i++) {
	array_push($numberArray1, ($i +1));
}


//print_r($objArray1);

$list = array (
	"序号",
	"车牌号",
	"终端号",
	"超速次数",
	"最高速度"

);


$list1 = array (
	"序号",
	"车牌号",
	"超速时间",
	"最高速度",
	"位置"
);




$title = "超速统计统计（".$startDate."~".$stopDate."）";
$filename = iconv("utf-8", "gb2312", "超速统计（".$starDay."~".$stopDay."）");
$smarty = new Smarty;
$smarty->assign("title", $title);
$smarty->assign("list", $list);
$smarty->assign("objArray", $objArray);
$smarty->assign("numberArray", $numberArray);
$smarty->assign("list1", $list1);
$smarty->assign("objArray1", $objArray1);
$smarty->assign("numberArray1", $numberArray1);
header("Content-type:application/vnd.ms-excel");
header("Content-Disposition:filename=$filename.xls");
$smarty->display("speed.tpl");
?>
