<?php 
ob_start();
session_start();
 ?>
 
<?php
// test string:  http://180.166.124.142:9983/obd_web_dev/service/alert.php?sqlType=0&date=2014-09-10
// test string:  http://180.166.124.142:9983/obd_web_dev/service/alert.php?sqlType=10&recordId=&userId=243
include dirname(__FILE__).'/alertAPI.php';
define("alartTypes","'规定时间（防盗）','疲劳驾驶告警','出省告警','拔出告警','超速告警','超速告警','电池电量低告警','制冷剂水温告警','DTC告警'");
//	$sqlType: 
//		0 -- new alerts (from the $date to now);  
//		1 -- history alerts (up to the $date)
//		10 -- 标识一条消息为“已处理”
//		11 -- 探测有没有新消息
	$sqlType	= isset($_REQUEST['sqlType']) ? $_REQUEST['sqlType'] : -999;
	$date = isset($_REQUEST['date']) ? $_REQUEST['date'] : null;
	$recordId = isset($_REQUEST['recordId']) ? $_REQUEST['recordId'] : 0;
	$userId = isset($_REQUEST['userId']) ? $_REQUEST['userId'] : 0;
	//$depId = isset($_REQUEST['depId']) ? $_REQUEST['depId'] : 0;
	$depId = $_SESSION["userVo"]->depID;
	$isCustomer = isset($_SESSION["op"]) ?$_SESSION["op"] : "";
	
	$alertTitle = $_REQUEST['alertTitle'];//告警类型
	$deviceID = $_REQUEST['deviceID'];
	//print_r($_SESSION);
	//echo "<br>depID=$depId";
	
	$ret = array ();
	$obj = new AlertList(); 
	switch($sqlType){
	case 0:
	case 1:
		if (isCustomer == "cuslogin"){
			$ret['total'] = 0;
			$ret['rows'] =  array();
		}else{
			$data= $obj->getAlerts($sqlType, $date, $userId,$depId);
			//echo "abc";
			//echo ( $date);
			//$ret['total'] =count($data);
			//$ret['rows'] = $data;	
			//echo $data;
			$ret = $data;		
		}
		echo json_encode($ret);
		break;
	case 10:
		if ($recordId !=0 || $userId!=0){
			$result = $obj -> setHandled($recordId, $userId, $deviceID, $alertTitle);
			if ($result) 
				echo "执行成功";
			else
				echo "执行失败";
		}
		else
		{
			echo "参数缺失";
		}
		break;		
	case "11":
		if ($userId!=0 || $depId !=0){
			if (isCustomer == "cuslogin"){
				$result = 0;
			}else{
				$result = $obj -> hasNewAlerts($userId,$depId);
			}				
			echo $result;
		}else
		{
			echo "参数缺失";
		}
		break;
	case "101":	//test
		print_r($_SESSION);
		$result = null;
		//$result = $obj ->readDept();
		//print_r($result);
//		if ($result != null){
//			$deptTree = new OganizationTree();			
//			$deptTree->init($result["deptArray"], $result["fatherDeptArray"]);			
			//print_r($deptTree);			
			//echo $deptTree->getParent(1169);
//			print_r( $deptTree->searchChildren(1083));
//			print_r( $deptTree->searchChildren(1168));
//			print_r( $deptTree->searchChildren(1069));
//			echo "<br>";
//			print_r( $deptTree->searchDescendants(1003));
		
			//var_export($_SESSION);
	
//		}	
		
}
	
?>