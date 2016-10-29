<?php


/**
 * export xls
 * */

require ('../libs/Smarty.class.php');
require (dirname(__FILE__).'/../../service/cancelAlert.php');



$startDate = isset($_REQUEST['startDate']) ? $_REQUEST['startDate'] : null;
$stopDate = isset($_REQUEST['stopDate']) ? $_REQUEST['stopDate'] : null;
$devices=isset($_REQUEST['devices']) ? $_REQUEST['devices'] : null;


$ca = new cancelAlert();
$objArray = $ca->getAlerts($devices, $startDate, $stopDate,1);

$numberArray = array();
$numRows = count($objArray);
for ($i = 0; $i < $numRows; $i++) {
	array_push($numberArray, ($i +1));
}



print_r($objArray);

$list = array (
	"序号",
	"车牌号",
	"终端号",
	"报警类型",
	"报警内容",
	"报警时间",
	"解除时间",

);



$title = "解除报警统计（".$startDate."~".$stopDate."）";
$filename = iconv("utf-8", "gb2312", "解除报警统计（".$starDay."~".$stopDay."）");
$smarty = new Smarty;
$smarty->assign("title", $title);
$smarty->assign("list", $list);
$smarty->assign("objArray", $objArray);
$smarty->assign("numberArray", $numberArray);
header("Content-type:application/vnd.ms-excel");
header("Content-Disposition:filename=$filename.xls");
$smarty->display("cancelAlert.tpl");
?>
