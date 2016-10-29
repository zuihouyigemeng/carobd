<?php


/**
 * export xls
 * */

require ('../libs/Smarty.class.php');
require (dirname(__FILE__).'/../../service/resoveledAlert.php');



$startDate = isset($_REQUEST['startDate']) ? $_REQUEST['startDate'] : null;
$stopDate = isset($_REQUEST['stopDate']) ? $_REQUEST['stopDate'] : null;
$devices=isset($_REQUEST['devices']) ? $_REQUEST['devices'] : null;
$alertTypes=isset($_REQUEST['alertTypes']) ? $_REQUEST['alertTypes'] : '0,1,2,3,4,5,6';

$ca = new resoveledAlert();
$objArray = $ca->getAlerts($devices, $startDate, $stopDate,1,$alertTypes);

$numberArray = array();
$numRows = count($objArray);
for ($i = 0; $i < $numRows; $i++) {
	array_push($numberArray, ($i +1));
}



//print_r($objArray);

$list = array (
	"序号",
	"车牌号",
	"终端号",
	"报警类型",
	"报警内容",
	"报警时间",
	"处理时间",

);

$title = "已处理报警统计（".$startDate."~".$stopDate."）";
$filename = iconv("utf-8", "gb2312", "已处理报警统计（".$starDay."~".$stopDay."）");
$smarty = new Smarty;
$smarty->assign("title", $title);
$smarty->assign("list", $list);
$smarty->assign("objArray", $objArray);
$smarty->assign("numberArray", $numberArray);
header("Content-type:application/vnd.ms-excel");
header("Content-Disposition:filename=$filename.xls");
$smarty->display("cancelAlert.tpl");
?>
