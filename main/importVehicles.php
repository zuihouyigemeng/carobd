<?php
set_time_limit(0);
require_once ("../Excel/reader.php");
include '../DBConnection.php';
require_once '../log4php/Logger.php';
Logger :: configure('../log4php.properties');
$logger = Logger :: getRootLogger();
session_start();
ob_start();

$dup=array();
$format_err=array();

$repeat_arr=array();
//echo '111111' . $_FILES["file"]["type"] . '</br>';
if ($_FILES["file"]["type"] == "application/vnd.ms-excel" or  $_FILES["file"]["type"] == "application/octet-stream" or $_FILES["file"]["type"] == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet") {
	if ($_FILES["file"]["error"] > 0) {
		$alert = "Return Code: " . $_FILES["file"]["error"];
		 echo '<script>parent.callback("文件格式错误!"); </script>';
	} else {
		$dataPath = "../data/" . $_FILES["file"]["name"];
		move_uploaded_file($_FILES["file"]["tmp_name"], $dataPath);
		$data = new Spreadsheet_Excel_Reader();
		$data->setOutputEncoding('UTF-8');
		$data->read($dataPath);
		$rows = $data->sheets[0]['numRows'];
		echo 'rows:'.$rows;
          $succNum=0;
          $str='';
          scanDevices($data);
          
          print_r($format_err);
          if(sizeof($format_err)>0){
     
          	$str='</br>字段格式错误行号：'.implode("|",$format_err);
          }
          if(sizeof($repeat_arr)>0){
          	$str='</br>文件内重复d_esn：'.implode("|",$repeat_arr);
          }
          if(sizeof($format_err)>0 or sizeof($repeat_arr)>0){
          	echo  $str;
          	echo '<script>parent.callback("',$str.'"); </script>';
          	return;
          }
          
		for ($i = 2; $i < $rows+1; $i++) {
			$d_esn = $data->sheets[0]['cells'][$i][1];
		//	echo 'd_esn:'.$d_esn;
			
			$imsi = $data->sheets[0]['cells'][$i][2];
			
			$MDN = $data->sheets[0]['cells'][$i][3];
			
			$registerKey = $data->sheets[0]['cells'][$i][4];
			
			$nickName = $data->sheets[0]['cells'][$i][5];
			
			$licenseNumber = $data->sheets[0]['cells'][$i][6];
			
			$ModelNumID = $data->sheets[0]['cells'][$i][7];
			
			$depID = $data->sheets[0]['cells'][$i][8];
			
			$check=checkDevice($d_esn);
			echo 'check:'.$check;
			if ($check == 200) {
				if(addVehicle($d_esn, $MDN, $imsi, $registerKey, $nickName, $ModelNumID, $licenseNumber,$depID)==200){
					$succNum++;
				}
				else{
					$dup[]=$i;
				}
				
			}
			else{
				$dup[]=$i;
			}
             
		}
		
		$str='车辆总数：'.($rows-1).'</br>'.'成功数：'.$succNum.'</br>'.'失败数：'.($rows-1-$succNum).'</br>'.'失败行：'.implode("|",$dup);
	 	echo $str;
			
		//    echo 'ttttt</br>';
		 //   echo '<script>alert('.$rows.'); </script>';
		 
		 
		 echo '<script>parent.callback("',$str.'"); </script>';
	}

	}
	else{
		 echo '<script>parent.callback("文件格式错误!"); </script>';
	}



function checkDevice($d_esn) {
	mysql_select_db("provision_obd");
	$sql = "select  count(*) as num  from  Devices  where   d_esn='$d_esn' ";
	echo '</br>'.$sql;
	$checkResult = mysql_query($sql);
	$checkRows = mysql_num_rows($checkResult);
	$num = 0;
	if ($checkRows > 0) {
		$row = mysql_fetch_array($checkResult);
		$num = $row['num'];
	}
	if ($num > 0) {
		return 1002;
	} else
		return 200;
}

function addVehicle($d_esn, $MDN, $imsi, $rk, $nickName, $ModelNumID, $licenseNumber,$depID) {
	mysql_select_db("IOV_demo");
	$sql = array ();
	$vin = '';
	$tmp = "', '$nickName', 1, '$ModelNumID','-1')";
	$tmp1 = "')";
	$sql[] = "INSERT INTO provision_obd.Devices (deviceID, d_esn,MDN, acctID, userID,status,activationDate,ratePlan,registerKey,imsi,depID) VALUES('$d_esn','$d_esn','$MDN', 'obd_demo', '-1','2', '','1','$rk','$imsi',$depID)";
	$sql[] = "insert into VehicleInfo(v_vin,licenseNumber) values('','$licenseNumber')";
	$sql[] = "insert into Devices_MT(deviceID,vin, nickName, oilType, ModelNumID,userID)" . " values('$d_esn','";
	$sql[] = "insert into VehicleInsurance(vin) values('";
	$sql[] = "insert into `obd_demo`.`LocationStatus`(deviceID,latitude,longitude,baidu_latitude,baidu_longitude,address_num) values('$d_esn','31.243639','121.508418','31.243639','121.508418','还未定位过')";
	mysql_query('START TRANSACTION');
	for ($i = 0; $i < count($sql); $i++) {
		echo $sql[$i].'</br>';
		if ($i == 2) {
			$sql[$i] .= $vin;
			$sql[$i] .= $tmp;
		}
		if ($i == 3) {
			$sql[$i] .= $vin;
			$sql[$i] .= $tmp1;
		}
		echo $sql[$i] . '</br>';
		if (!mysql_query($sql[$i])) {
			$err = mysql_error();
			mysql_query('ROLLBACK');
			return 1001;
		}
		if ($i == 1) {
			$vin = mysql_insert_id();
		}
	}
	mysql_query('COMMIT');
	return 200;

}

function scanDevices($data){
	$esns=array();
	global $format_err;
	$rows = $data->sheets[0]['numRows'];
	for ($i = 2; $i < $rows+1; $i++) {
			$d_esn = $data->sheets[0]['cells'][$i][1];
			if( strlen($d_esn)<1 or strlen($d_esn)>17){
				$format_err[]=$i;
				continue;
			}
			$esns[]=$d_esn;
			$imsi = $data->sheets[0]['cells'][$i][2];
			if( strlen($imsi)<1 or strlen($imsi)>16){
				$format_err[]=$i;
				continue;
			}
			$MDN = $data->sheets[0]['cells'][$i][3];
			if( strlen($MDN)<1 or strlen($MDN)>13){
				$format_err[]=$i;
				continue;
			}
			$registerKey = $data->sheets[0]['cells'][$i][4];
			if( strlen($registerKey)<1 or strlen($registerKey)>15){
				$format_err[]=$i;
				continue;
			}
			$nickName = $data->sheets[0]['cells'][$i][5];
			if( strlen($nickName)<1 or strlen($nickName)>15){
				$format_err[]=$i;
				continue;
			}
			$licenseNumber = $data->sheets[0]['cells'][$i][6];
			if( strlen($licenseNumber)<1 or strlen($licenseNumber)>10){
				$format_err[]=$i;
				continue;
			}
			$ModelNumID = $data->sheets[0]['cells'][$i][7];
			if( strlen($ModelNumID)<1 or strlen($ModelNumID)>10){
				$format_err[]=$i;
				continue;
			}
			$depID = $data->sheets[0]['cells'][$i][8];
			if( strlen($depID)<1 or strlen($depID)>5){
				$format_err[]=$i;
				continue;
			}
			fetchRepeatMemberInArray($esns);
		   
		}
}


function fetchRepeatMemberInArray($array) { 
    	global $repeat_arr;
    $unique_arr = array_unique ( $array ); 
    
    $repeat_arr = array_diff_assoc ( $array, $unique_arr ); 
    return $repeat_arr; 
} 


//addVehicle('test777', '15800892321', 'imsi77', 'registerKey1', 'nickName', '300000', 'ahaaha');
?>

