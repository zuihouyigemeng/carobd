<?php
include '../DBConnection.php';
include '../../zend_obd/Maintain.php';

	
class OperatLandmark {
	
	/**查询某部门下所有的地标*/
	public function getLandmarkByDepartmentId($departmentId){
		mysql_select_db("IOV_demo");
			
		$sql = "select a.id,a.longitude,a.latitude,a.landmarkName,a.departmentId,a.address,b.`name` from `Landmark` a, `Opm_Organ` b where a.departmentId=b.id and a.departmentId='$departmentId'";
		
		$ret = array ();
		$data = array ();
		$result = mysql_query($sql);
		$checkRows = mysql_num_rows($result);
		if ($checkRows > 0) {
			while ($row = mysql_fetch_object($result)) {
				$data[] = $row;
				$row->operation = '<a href="javascript:void(0);" onclick="delete_landmark('.$row->id.',\''.$row->landmarkName.'\')">删除</a>|<a href="javascript:void(0);" onclick="edit_landmark('.$row->id.',\''.$row->landmarkName.'\',\''.$row->longitude.'\',\''.$row->latitude.'\',\''.$row->departmentId.'\',\''.$row->name.'\',\''.$row->address.'\')">编辑</a>';
			}
			mysql_free_result($result);
		}
		$ret["data"] = $data;
		return $ret;
		
	}
	
	//插入地标注信息
	public function addLandmark($landmarkName,$lng,$lat,$departmentId,$address){
		$ret = array ();
		  mysql_select_db("IOV_demo");
		  $sql = "SELECT id from Landmark where departmentId='$departmentId' and landmarkName='$landmarkName'";
			$result = mysql_query($sql);
			$checkRows = mysql_num_rows($result);
		    if($checkRows>0){
		    	$ret["resultCode"] = '1002';
				$ret["resultMsg"] = "landmark exist";
				return $ret;
		    }
		
			$sql = "insert into Landmark(landmarkName,longitude,latitude,departmentId,address) VALUES ('$landmarkName','$lng','$lat','$departmentId','$address')";
			if (!mysql_query($sql)) {				
				$ret["resultCode"] = '1001';
				$ret["resultMsg"] = "sys error!";
				return $ret;
			} else {
				$ret["resultCode"] = '200';
				$ret["resultMsg"] = "success";
				return $ret;
			}	
	}
	
	
	//修改地标 信息
	public function updateLandmark($id,$landmarkName,$lng,$lat,$departmentId,$address){
		$ret = array ();
		mysql_select_db("IOV_demo");
		$sql = "SELECT id from Landmark where departmentId='$departmentId' and landmarkName='$landmarkName' and id!='$id'";//修改成其它标注名称的时候，若存在，则不能修改
		$result = mysql_query($sql);
		$checkRows = mysql_num_rows($result);
		if($checkRows>0){
			$ret["resultCode"] = '1002';
			$ret["resultMsg"] = "landmark exist";
			return $ret;
		}

		$sql = "update Landmark set landmarkName='$landmarkName',longitude='$lng',latitude='$lat',departmentId='$departmentId',address='$address' where id = $id";
		if (!mysql_query($sql)) {
			$ret["resultCode"] = '1001';
			$ret["resultMsg"] = "sys error!";
			return $ret;
		} else {
			$ret["resultCode"] = '200';
			$ret["resultMsg"] = "success";
			return $ret;
		}	
	}
	
	
	//根据id删除地标信息
	public function deleteLandMarkById($id){
		mysql_select_db("IOV_demo");
		$ret = array ();

		$sql = "DELETE FROM Landmark WHERE id=$id";
		if (!mysql_query($sql)) {
			$ret["resultCode"] = '1001';
			$ret["resultMsg"] = "sys error!";
			return $ret;
		} else {
						
			$ret["resultCode"] = '200';
			$ret["resultMsg"] = "success";
			return $ret;
		}
	}
	
}
	
?>