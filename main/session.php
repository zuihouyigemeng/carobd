<?php 
ob_start();
session_start();
  if(!isset($_SESSION["userVo"])||$_SESSION["userVo"]==null)
	{
		header("Location: ../index.php");
	    	ob_end_flush();
	}
	else{
		$userVo=$_SESSION["userVo"];
	}	
   
?>
