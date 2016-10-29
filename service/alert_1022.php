<?php
// test string:  http://180.166.124.142:9983/obd_web_dev/service/alert.php?sqlType=0&date=2014-09-10
// test string:  http://180.166.124.142:9983/obd_web_dev/service/alert.php?sqlType=10&recordId=&userId=146
include dirname(__FILE__).'/alertAPI.php';
//	$sqlType: 
//		0 -- new alerts (from the $date to now);  
//		1 -- history alerts (up to the $date)
//		10 -- 标识一条消息为“已处理”
//		11 -- 探测有没有新消息
	$sqlType	= isset($_REQUEST['sqlType']) ? $_REQUEST['sqlType'] : -999;
	$date = isset($_REQUEST['date']) ? $_REQUEST['date'] : null;
	$recordId = isset($_REQUEST['recordId']) ? $_REQUEST['recordId'] : 0;
	$userId = isset($_REQUEST['userId']) ? $_REQUEST['userId'] : 0;
	$depId = isset($_REQUEST['depId']) ? $_REQUEST['depId'] : 0;

	$ret = array ();
	$obj = new AlertList(); 
	switch($sqlType){
	case 0:
	case 1:
		$data= $obj->getAlerts($sqlType, $date, $userId);
		//echo "abc";
		//echo ( $date);
		$ret['total'] =count($data);
		$ret['rows'] = $data;
		echo json_encode($ret);
		break;
	case 10:
		if ($recordId !=0 || $userId!=0){
			$result = $obj -> setHandled($recordId,$userId);
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
			$result = $obj -> hasNewAlerts($userId,$depId);
			echo $result;
		}else
		{
			echo "参数缺失";
		}
	}
	
?>