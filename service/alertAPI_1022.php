<?php
include  dirname(__FILE__).'/../DBConnection.php';
require_once dirname(__FILE__).'/../log4php/Logger.php';
Logger :: configure(dirname(__FILE__).'/../log4php.properties');
define("alartTypes","'规定时间（防盗）','疲劳驾驶告警','出省告警','拔出告警','超速告警','超速告警','电池电量低告警','制冷剂水温告警','DTC告警'");


class AlertList{
	 public function getAlerts($sqlType, $date, $userId){
		// $sqlType: 0 -- new alerts (from the $date to now);  1 -- history alerts (up to the $date)

		//	$startDate = date("Y-m-d H:i:s", strtotime($startDate . '-8hour'));
		//	$stopDate= date("Y-m-d H:i:s", strtotime($stopDate . '-8hour'));
		
		$data = array();
		$sql = "select vm.ModelName,c.name as customer,d.d_esn,vi.licenseNumber,n.title,n.createTime,n.canceltime,n.cancelFlag,n.id as recordId,n.address" .
		" from  Notifaction n  ,provision_obd.Devices d,VehModelNumber vn,VehModel vm,Devices_MT dm,VehicleInfo vi,Customers c " .
		" where dm.ModelNumID=vn.ModelNumID" .
		" and vn.ModelID=vm.ModelID" .
		" and dm.customerID=c.id" .
		" and n.vin=dm.vin" .
		" and d.deviceID=dm.deviceID" .
		" and  dm.vin=vi.vin " .
		" and n.dealFlag =0".
		" and n.title in (" . alartTypes. ")";
		if ($sqlType ==1 ) 	
			$sql = $sql . " and n.createTime < '$date'";
		else 
			$sql = $sql . " and n.createTime >= '$date'";
		$sql = $sql . " order by createTime desc ";
		//echo $sql . "<BR>"	;
		mysql_select_db("IOV_demo");
		$result = mysql_query($sql);
		$numRows = mysql_num_rows($result);
//		$ret = array ();
//		$data= array ();
		$i =0;	//number of rows in table (not in db)
		
		if ($numRows > 0) {
			while($row = mysql_fetch_object($result)){
				//$data[$i] = array();
				$data[$i]["recordId"] = $row->recordId;
				$data[$i]["d_esn"] = $row->d_esn;
				$data[$i]["licenseNumber"] = $row->licenseNumber;
				$data[$i]["customer"] = $row->customer;
				$data[$i]["modelName"] = $row->ModelName; 
				$data[$i]["createTime"] = $row->createTime; 	//toTimeZone( $row->gpsStamp);
				$data[$i]["title"] = $row->title;
				$data[$i]["cancelTime"] = $row->canceltime;
				$data[$i]["cancelFlag"] = ($row->cancelFlag ==0)? "":"已解除";
				$data[$i]["address"] = $row->address;
				$i++;				
			}
		}
//		//echo json_encode($ret);
		if($sqlType==0){
			//保存读告警数据时间
			$sql = "update Users_Admin set  ReadAlertTime = now() where userID = $userId;";
			mysql_select_db("IOV_demo");
			mysql_query($sql);
		}
		return $data;		
	}
	
	public function setHandled($recordId,$userId){
		$sql = "update Notifaction set dealTime = now(), dealFlag=1,dealer= $userId where id=$recordId";
		mysql_select_db("IOV_demo");
		mysql_query($sql);
		if( mysql_affected_rows()>0) return true;
		else return false;
			
	}	
	public function hasNewAlerts($userId,$depId){
		$sql = "select ReadAlertTime from Users_Admin where userID = $userId";
		mysql_select_db("IOV_demo");
		$result = mysql_query($sql);
		$numRows = mysql_num_rows($result);
		if ($numRows ==0) return 0;		//用户查不到
		$row = mysql_fetch_object($result);
		
		$sql = "select count(n.id) " .
		" from  Notifaction n  ,provision_obd.Devices d,VehModelNumber vn,VehModel vm,Devices_MT dm,VehicleInfo vi,Customers c " .
		" where dm.ModelNumID=vn.ModelNumID" .
		" and vn.ModelID=vm.ModelID" .
		" and dm.customerID=c.id" .
		" and n.vin=dm.vin" .
		" and d.deviceID=dm.deviceID" .
		" and  dm.vin=vi.vin " .
		" and n.dealFlag =0";
		
		if  (isset($row->ReadAlertTime)){	//null 则 查询所有
			$sql = $sql. " and n.createTime > '$row->ReadAlertTime'";
		}		
		
		$result=null;
		$numRows =0;
		//echo $sql . "<br>";		
		$result = mysql_query($sql);
		//$numRows = mysql_num_rows($result);
		$numOfRows = mysql_fetch_array($result);
		//print_r($numOfRows);
		return $numOfRows["count(n.id)"];
		
	}
	
	private function getDeptsUnder ($depId ){	
		$resultDepts = "";	
		$sizeOfDepts =0;	
		$depts = $depId.toString();
		mysql_select_db("IOV_demo");

		while ($depts != ""){
			$sql = "SELECT id FROM IOV_demo.Departments WHERE parentID in (" . $depts. ");" ;
			$depts = "";
			$result = null;
			$result = mysql_query($sql);
			$numRows = mysql_num_rows($result);
			if ($numRows >0){
				$row = mysql_fetch_array($result);
				$depts =  $row->id;
				while (	$row = mysql_fetch_array($result)){
					$depts = $depts . "," . $row->id;
				}		
				if ($resultDepts == "")  $resultDepts .= $depts;
				else $resultDepts .= "," . $depts; 
			}
		}
	}		
}

?>