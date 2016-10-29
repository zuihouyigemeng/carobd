<?php
include '../DBConnection.php';
require_once '../log4php/Logger.php';
require_once '../common/AES.php';
Logger :: configure('../log4php.properties');
$logger = Logger :: getRootLogger();

$depID = isset ($_REQUEST['depID']) ? $_REQUEST['depID'] : null;

$opType = isset ($_REQUEST['opType']) ? $_REQUEST['opType'] : null;

$userID = isset ($_REQUEST['userID']) ? $_REQUEST['userID'] : null;

$username = isset ($_REQUEST['username']) ? $_REQUEST['username'] : null;

$email = isset ($_REQUEST['email']) ? $_REQUEST['email'] : null;

$smsNum = isset ($_REQUEST['smsNum']) ? $_REQUEST['smsNum'] : null;

$roleId = isset ($_REQUEST['roleId']) ? $_REQUEST['roleId'] : null;

//echo $depID;

//list
if ($opType == 1 or $opType == '1') {
	mysql_select_db("IOV_demo");
	//$query = "select ua.userID,ua.email,ua.username,ua.smsNum,ua.fullname,role.name as roleName,role.id as roleId,oo.name as depName from  Users_Admin  ua,Opm_User_Role our,Opm_Role role,Opm_Organ oo  where ua.userID=our.userID and our.roleId=role.id and our.organId=$depID and our.organId=oo.id";
	$query = "select ua.userID,ua.email,ua.username,ua.smsNum,ua.fullname,role.name as roleName,role.id as roleId, oo.name as depName". 
		" from  Users_Admin  ua,".
		" Opm_User_Role ou,".
		" Opm_Role role,".
		" Customers oo  ".
		" where ua.userID=ou.userID and ou.roleId=role.id and ua.organId=$depID and ua.organId=oo.id and ua.iscustomer=1";

	$logger->debug("----------------sql:------" . $query);
	//echo $query;
	$result = mysql_query($query);
	$numRows = mysql_num_rows($result);
	$ret = array ();
	$data = array ();
	$ret['total'] = $numRows;
	if ($numRows > 0) {
		while ($row = mysql_fetch_object($result)) {
					$data[]=$row;
		}
		mysql_free_result($result);
	}

	$ret['rows'] = $data;

	echo json_encode($ret);
}

//delete user
if ($opType == 2 or $opType == '2') {
	mysql_select_db("IOV_demo");
	$sql = array ();
	$sql[]="delete from Users_Admin where userID='$userID'";
	$sql[]="delete from Opm_User_Role where userID='$userID'";
	mysql_query('START TRANSACTION');
		mysql_select_db("IOV_demo");
		for ($i = 0; $i < count($sql); $i++) {
			$logger->debug("----------------sql:------" . $sql[$i]);
			if (!mysql_query($sql[$i])) {
				$err = mysql_error();
				mysql_query('ROLLBACK');
				echo 1001;
				return;
			}
		}
		mysql_query('COMMIT');
		echo 200;
}

//add user
////http://180.166.124.142:9983/obd_web_dev/service/users_c.php?opType=3&depID=1071&username=test01&smsNum=133&email=123&roleId=5
if ($opType ==3 or $opType == '3') {
	mysql_select_db("IOV_demo");
	$checkUnameSql = "select count(*) as num from Users_Admin  where username='$username' ";	//检查重名
	$logger->debug("----------------sql:------" . $checkUnameSql);
		$checkResult = mysql_query($checkUnameSql);
		$checkRows = mysql_num_rows($checkResult);
		$num = 0;
		if ($checkRows > 0) {
			$row = mysql_fetch_array($checkResult);
			$num = $row['num'];
		}
		if ($num > 0) {
			echo 1002;	//检查重名
			return ;
		}
	$passw = encrypt2(substr($smsNum, -6),0);	
	
	$sql="INSERT INTO Users_Admin (`username`, `password`, `acctID`, `dealerID`, `language`, `smsNum`,  `fullname`, `email`,`isCustomer`,`organId`) VALUES ('$username', '$passw', 'IOV_demo', 0, 'cn', '$smsNum', '', '$email',1,$depID)";
	$logger->debug("----------------sql:------" . $sql);
	if (!mysql_query($sql)) {
			echo 1001;	//插入失败
			return ;
		} else {
			$userID = mysql_insert_id();
		}
	$sql="insert into Opm_User_Role  (userID,roleId,organId) values ('$userID','$roleId',0)";
	$logger->debug("----------------sql:------" . $sql);
	if (!mysql_query($sql)) {
			echo 1001;
		} else {
			echo 200;
		}
}

//update user
if ($opType ==4 or $opType == '4') {
	mysql_select_db("IOV_demo");
	
	$checkUnameSql = "select count(*) as num from Users_Admin  where username='$username' and userID <> '$userID'  ";
	$logger->debug("----------------sql:------" . $checkUnameSql);
		$checkResult = mysql_query($checkUnameSql);
		$checkRows = mysql_num_rows($checkResult);
		$num = 0;
		if ($checkRows > 0) {
			$row = mysql_fetch_array($checkResult);
			$num = $row['userID'];
		}
		if ($num > 0) {
			echo 1002;
			return ;
		}
	$sql = array ();
	$sql[]="update  Users_Admin set userName='$username',email='$email',smsNum='$smsNum'  where userID='$userID'";
	$sql[]="update  Opm_User_Role set roleId='$roleId',organId='$depID' where userID='$userID'";
	mysql_query('START TRANSACTION');
		mysql_select_db("IOV_demo");
		for ($i = 0; $i < count($sql); $i++) {
			$logger->debug("----------------sql:------" . $sql[$i]);
			if (!mysql_query($sql[$i])) {
				$err = mysql_error();
				mysql_query('ROLLBACK');
				echo 1001;
			}
		}
		mysql_query('COMMIT');
		echo 200;
}

function encrypt2($str,$opt){
//		return $str;
		$aes = new AES(true);// 把加密后的字符串按十六进制进行存储
		$key = "anydata_lbs_aes_key";// 密钥
		$keys = $aes->makeKey($key);
		$returnStr = "111111";
		//0:加密 1：解密
		if($opt==0){
			$returnStr = $aes->encryptString($str, $keys);				//加密
		}else{
			$returnStr = $aes->decryptString($str, $keys);				//解密
		}
		return $returnStr;
}


?>