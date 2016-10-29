<?php 

include_once '../DBConnection.php';
ob_start();
session_start();
  if(!isset($_SESSION["userVo"])||$_SESSION["userVo"]==null)
	{
		header("Location: ../index.php");
	    	ob_end_flush();
	}
	
		$userVo=$_SESSION["userVo"];
	//	echo  $userVo->passw;
	
	$resource=$userVo->resource;
	$key = $_SESSION["userKey"];
	$action="";
	
	if(isset($_GET['action'])){
		$action=$_GET['action'];
	}
	
   if($action!=null and $action == "logout"){
    unset($_SESSION['userVo']);
    
    mysql_select_db("IOV_demo");
    	
	  	$time = date('y-m-d h:i:s',time());
    	
	    $sql = "UPDATE Loginfo SET LogOut_Time = '$time' WHERE ID = '$key'";
        if (!mysql_query($sql)) {
				$ret["resultCode"] = '1001';
				$ret["resultMsg"] = "sys error!";
				
			} else {
				$ret["resultCode"] = '200';
				$ret["resultMsg"] = "success";
				
				
			}
			
    header("Location: ../index.php");
	  ob_end_flush();
}
  $rownums=1;
  $userID=$userVo->userID;
  mysql_select_db("IOV_demo");
  $sql = "select id from  Loginfo where UserID='$userID'";
  $result=mysql_query($sql);
  $rownums=mysql_num_rows($result);
		
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>贝尔加</title>
	<link rel="stylesheet" type="text/css" href="../themes/default/easyui.css">
	<link rel="stylesheet" type="text/css" href="../themes/icon.css">
	<link rel="stylesheet" type="text/css" href="../demo.css">
	<script type="text/javascript" src="../jquery.min.js"></script>
	<script type="text/javascript" src="../jquery.easyui.min.js"></script>
	<SCRIPT type="text/javascript" src="../jquery.layout.js"></SCRIPT>
    <SCRIPT type="text/javascript" src="../jquery.layout.extend.js"></SCRIPT>
    <style>
		.panel-fit, .panel-fit body{overflow-x:auto !important;min-width:1150px !important;}
		.alert{text-decoration:none;color:#000000;cursor:pointer;}
	    .alert:hover{ color:#4976A4;}
		
		.alert span{color:#f00; font-weight:bold;}
		.alert:hover span{color:#B2A471; font-weight:bold;}	
	</style>
</head>
<body

<?php if((in_array('车辆监控' , $resource))){ ?>
onload="btn_obd()" 
 <?php }  else ?>

<?php if((in_array('4s管理' , $resource))){ ?>
onload="4s_btn()" 
 <?php }  else ?>

 <?php if((in_array('系统管理' , $resource))){ ?>
onload="btn_manage()" 
 <?php }  else ?>
 
 
 <?php if((in_array('后台管理' , $resource))){ ?>
onload="btn_acct()" 
 <?php }  else ?>
 
 <?php if((in_array('基础信息管理' , $resource))){ ?>
onload="other()" 
 <?php }  else ?>
 
 <?php if((in_array('统计报表' , $resource))){ ?>
onload="btn_tj()" 
 <?php }  ?>
 
 <?php if((in_array('预设信息管理' , $resource))){ ?>
onload="btn_predefine()" 
 <?php }  ?>
 
class="easyui-layout"  id="cc">
<?php include("userSet.html"); ?> 
<?php include("alertView.html"); ?>

<!--	<div data-options="region:'north'"  style="height:95px;background-color:#3a3a3a;">   -->
<div data-options="region:'north'" style="overflow:hidden;min-width:1150px;height:75px;width:100%;background-color:#3a3a3a;border:0px;">
    <table  border="0" cellSpacing="0" cellPadding="0" style="border-spacing: 0px;">
        <tbody>
            <tr>
                <td align="center" width="350px" valign='bottom' height="65px">
                    <img  alt="logo" src="../img/logo_shenzhen1.png"/>
                </td>
                <td align="center" width="30px" valign='bottom' height="65px">
                    <img  alt="logo"    src="../img/user.png"/>
                </td>
                <td align="left" width="150px" height="65px" style="color:#ffffff;" valign='bottom'>
                    <nobr>欢迎您, <span style="color:#108be9"><?php echo($userVo->username); ?> </span>!|
                    <a href="#"  style="color:#ffffff" onclick="userSet('<?php echo($userVo->userID); ?>')">设置|</a> 
                    <a href="#" style="color:#ffffff"  onclick="logout()">退出</a></nobr>
                </td>
                <td align="right" width="1500px" height="65px" valign='bottom'>
                    <nobr>
                         <img  id='obd_btn' 
                         	   onclick="btn_obd()" 
                               style="height:65px;<?php if(!(in_array('车辆监控' , $resource))){ ?>   display:none  <?php } ?>" 
                               alt="车辆监控" 
                               src="../img/btn_monitor_normal.png"/>
                         <img  id='bus_btn' 
                         	   onclick="btn_manage()" 
                               style="height:65px;<?php if(!(in_array('系统管理' , $resource))){ ?>   display:none  <?php } ?>" 
                               alt="系统管理" 
                               src="../img/btn_business_normal.png"/>
                         <img  id='set_btn'  
                         	   onclick="btn_acct()"  
                               style="height:65px;<?php if(!(in_array('后台管理' , $resource))){ ?>   display:none  <?php } ?>" 
                               alt="后台管理" 
                               src="../img/btn_set_normal.png"/>
                         <img  id='other_btn' onclick="other()" 
                         	   style="height:65px;<?php if(!(in_array('基础信息管理' , $resource))){ ?>   display:none  <?php } ?>" 
                               alt="基础信息管理" 
                               src="../img/btn_baseInfo_normal.png"/>
                         <img  id='tj_btn' 
                         	   onclick="btn_tj()"
                               style="height:65px;<?php if(!(in_array('统计报表' , $resource))){ ?>   display:none  <?php } ?>" 
                               alt="统计报表" 
                               src="../img/btn_report_normal.png"/>
                         <img  id='predefine_btn' 
                         	   onclick="btn_predefine()" 
                               style="height:65px;<?php if(!(in_array('预设信息管理' , $resource))){ ?>   display:none  <?php } ?>" 
                               alt="预设信息管理" 
                               src="../img/btn_predefine_normal.png"/>
                         <img  id='4s_btn' 
                         	   class='4s_btn' 
                               onclick="addPanel(this)" 
                               style="height:65px;<?php if(!(in_array('4s管理' , $resource))){ ?>   display:none  <?php } ?>" 
                               alt="部门和车辆" 
                               src="../img/btn_dep_normal.png"/>
                   </nobr>
                </td>
            </tr>
        </tbody>
    </table>
    
</div>

<div data-options="region:'south',split:false" style="height:27px;">
    <table width="100%">
        <tr width="100%" style="color:#000000">
            <td width="50%" align="left">
           
                <span >您好！你是第 <?php echo($rownums); ?> 次登录本平台系统版本：[V1.0.4.02 Build 20141113] <input id="histAlertNum" type="hidden" value=""/></span>
            </td>
            <td align="right" valign="bottom" width="40%">
				 <?php 
                      if($_SESSION["op"]=="deplogin")
                      { 
                    ?>
                <span>
                    <img  id='alert_btn'  
                          onclick="alert1()"  
                          alt="告警" 
                          src="../img/alert.gif" 
                          style="vertical-align:middle"/>
                          <a href="javascript:;" onClick="alert1()" class="alert" >最新告警数:&nbsp;<span id='alertNmu'>0</span></a>
                </span>
                <?php
                	}
                ?>
                      
            </td>
            <td width="10%"></td>
        </tr>
    </table>      
</div>

		<div data-options="region:'east',split:false"  style="width:200px;"   >
			<ul class="easyui-tree" data-options="method:'get',animate:true,dnd:true"></ul>
		</div>
		<div data-options="region:'west',split:false"  style="width:300px"  id='west'>
	     <iframe  id="idwest"  frameborder="0"  src="west.html" style="width:100%;height:99%;"></iframe>
		</div>
			
	
	
		<div data-options="region:'center',iconCls:'icon-ok'" id="conterid" style="overflow: hidden;">
	    <iframe  id="test" name='vehicle'  frameborder="0"  src="" style="width:100%;height:99.8%;"></iframe>
        </div>
		   
		   
		    

	<script type="text/javascript">
	timename=setInterval("hasNewAlerts();",10000); 
	
	function alert1(){	
		//if($("#alertView_new").attr("src") == ""){
		$("#alertView_new").attr("src","alertView_new.php");
		$("#alertView_hist").attr("src","alertView_hist.php");
		//}

		//$("#alertView_hist").attr("src","alertView_hist.php");
		$('#alertDlg').dialog('open');
	}
	var btnStatus=1;
	
	function logout(){
		if(confirm('确定要退出管理系统吗？')){
	//	window.close(); 
	    window.location.href="home.php?action=logout"; 
		return true;
		}else{
			return false;
		}
	}
	
	$(function (){ 
		$('#buttdiv').find('a').click(function () { 
			$('#buttdiv').find('a').removeClass('l-btn-selected'); 
			$(this).addClass('l-btn-selected'); 
		}); 
	});
	
	function hiddenPanel(region){
		$('#cc').layout('hidden',region);
	}
	function showPanel(region){
		$('#cc').layout('show',region);
	}
	function hiddenAll(){
		$('#cc').layout('hidden','west');
		$('#cc').layout('hidden','east');
		$('#cc').layout('hidden','north');
		$('#cc').layout('hidden','south');
		$('#cc').layout('hidden','east');
		$('#cc').layout('hidden','south');
	}
	function showAll(){
		$('#cc').layout('show','west');
		$('#cc').layout('show','east');
		$('#cc').layout('show','north');
		$('#cc').layout('show','south');
	}
	
	
		var index = 0;
		function addPanel(){
			recoveryImg();
			btnStatus=0;
			$('#4s_btn').attr("src","../img/btn_dep_pressed.png"); 
		//	alert("http://180.166.124.142:9983/obd_4s1/index.php?user=<?php echo($userVo->username); ?>&pass=<?php echo  $userVo->passw ?>");
			hiddenPanel('east');
			hiddenPanel('west');
    //        $('#4s_btn').attr("src","../img/btn_business_focused.png");
	//		$('#test').attr("src","http://180.166.124.142:9983/obd_4s1/index.php?user=<?php echo($userVo->username); ?>&pass=<?php echo  $userVo->passw ?>");  
			$('#test').attr("src","base_info_vehicle.html");  
	
		}

         function btn_obd(){
         	recoveryImg();
			btnStatus=1;
			$('#obd_btn').attr("src","../img/btn_monitor_pressed.png");     
			showPanel('west');
			hiddenPanel('east');
			url="vehicleView.html?mapType=1";
			$('#test').attr("src",url); 
			$('#idwest').attr("src","west.html"); 
		}
		
		function btn_manage(){
			recoveryImg();
			btnStatus=2;
			$('#bus_btn').attr("src","../img/btn_business_pressed.png"); 
		//	alert("vichelUphold.php?user=<?php echo  $userVo->username ?>&pass=<?php echo  $userVo->passw ?>");
			hiddenPanel('east');
			hiddenPanel('west');
			
			$('#test').attr("src","vichelUphold.php?user=<?php echo  $userVo->username ?>&pass=<?php echo  $userVo->passw ?>");
			
			/*$('#test').attr("src",
				"http://180.166.124.142:9983/obd_4s1/manager.html?
					user=<?php echo  $userVo->username ?>&pass=<?php echo  $userVo->passw ?>");*/
		}
		
		
		
		function btn_acct(){
			recoveryImg();
			btnStatus=3;
			$('#set_btn').attr("src","../img/btn_set_pressed.png"); 
			hiddenPanel('east');
			hiddenPanel('west');
			$('#test').attr("src","http://180.166.124.142:9983/OBD_acct1/login.php?op=login&name=<?php echo  $userVo->username ?>&passw=<?php echo  $userVo->passw ?>"); 
			$('#buttdiv').find('a').linkbutton("enable"); 
		//	$(obj).linkbutton("disable");
		}
		
		
		function other(){
			recoveryImg();
			btnStatus=4;
			$('#other_btn').attr("src","../img/btn_baseInfo_pressed.png"); 
			
			hiddenPanel('east');
			hiddenPanel('west');
			$('#test').attr("src","base_infor_main.html");
			
		//	$('#test').attr("src","customerManagement.php"); 
		//	traceWin1=window.open('customerManagement.php');

		}
		
		
		function btn_tj(){
			recoveryImg();
			btnStatus=5;
			$('#tj_btn').attr("src","../img/btn_report_pressed.png"); 
			hiddenPanel('west');		
	//		$('#idwest').attr("src","west_0.html"); 
		    $('#test').attr("src","tj_main.html");
		//alert("pppp");
		//$('#tj').dialog('open');
		}
		
		
		function btn_predefine(){
		   recoveryImg();
			btnStatus=6;
			$('#predefine_btn').attr("src","../img/btn_predefine_pressed.png"); 
			hiddenPanel('east');
			hiddenPanel('west');
			$('#test').attr("src","predefine_infor_main.html");
		}
		
		function vehicleClick(rowData){
			$("#conterid").find("iframe")[0].contentWindow.vehicleClick(rowData);
		}
		
		function checkAll(rows){
			$("#conterid").find("iframe")[0].contentWindow.checkAll(rows);
		}
		
		function onUncheckAll(rows){
			$("#conterid").find("iframe")[0].contentWindow.onUncheckAll(rows);
		}
		
		function  onCheck(rowData){
			$("#conterid").find("iframe")[0].contentWindow.onCheck(rowData);
		}
		
        function  onUncheck(rowData){
        	$("#conterid").find("iframe")[0].contentWindow.onUncheck(rowData);
		}
		
		var westStatus=1;
		function  westSwitch(){
			if(westStatus==1){
				$('#cc').layout('hidden','west');
				westStatus=0;
			}
			else{
				$('#cc').layout('show','west');
				westStatus=1;
			}
		}
		
		
 var scrollFunc=function(e){ 
   e=e || window.event; 
   if(e.wheelDelta && event.ctrlKey){//IE/Opera/Chrome 
    event.returnValue=false;
   }else if(e.detail){//Firefox 
    event.returnValue=false; 
   } 
  }  
  
  
  if(document.addEventListener){ 
  document.addEventListener('DOMMouseScroll',scrollFunc,false); 
  }
  window.onmousewheel=document.onmousewheel=scrollFunc;//IE/Opera/Chrome/Safari 
		
		
$('#4s_btn').hover(function(){ 
	if(btnStatus!=0)
	$('#4s_btn').attr("src","../img/btn_dep_focused.png");
}
)

$('#4s_btn').mouseout(function(){ 
	if(btnStatus!=0)
$('#4s_btn').attr("src","../img/btn_dep_normal.png");
}
)



$('#obd_btn').hover(function(){ 
	if(btnStatus !=1)
	$('#obd_btn').attr("src","../img/btn_monitor_focused.png");
}
)

$('#obd_btn').mouseout(function(){ 
if(btnStatus !=1)
$('#obd_btn').attr("src","../img/btn_monitor_normal.png");
}
)

$('#bus_btn').hover(function(){ 
	if(btnStatus !=2)
	$('#bus_btn').attr("src","../img/btn_business_focused.png");
}
)

$('#bus_btn').mouseout(function(){ 
	if(btnStatus !=2)
$('#bus_btn').attr("src","../img/btn_business_normal.png");
}
)

$('#set_btn').hover(function(){ 
	if(btnStatus !=3)
	$('#set_btn').attr("src","../img/btn_set_focused.png");
}
)

$('#set_btn').mouseout(function(){ 
	if(btnStatus !=3)
$('#set_btn').attr("src","../img/btn_set_normal.png");
}
)

$('#other_btn').hover(function(){ 
	if(btnStatus !=4)
	$('#other_btn').attr("src","../img/btn_baseInfo_focused.png");
}
)

$('#other_btn').mouseout(function(){ 
	if(btnStatus !=4)
$('#other_btn').attr("src","../img/btn_baseInfo_normal.png");
}
)

$('#tj_btn').hover(function(){ 
	if(btnStatus !=5)
	$('#tj_btn').attr("src","../img/btn_report_focused.png");
}
)

$('#tj_btn').mouseout(function(){ 
	if(btnStatus !=5)
$('#tj_btn').attr("src","../img/btn_report_normal.png");
}
)


$('#predefine_btn').hover(function(){ 
	if(btnStatus !=6)
	$('#predefine_btn').attr("src","../img/btn_predefine_focused.png");
}
)

$('#predefine_btn').mouseout(function(){ 
	if(btnStatus !=6)
$('#predefine_btn').attr("src","../img/btn_predefine_normal.png");
}
)

function recoveryImg(){
	if(btnStatus==0)
	$('#4s_btn').attr("src","../img/btn_dep_normal.png");
	if(btnStatus==1)
	$('#obd_btn').attr("src","../img/btn_monitor_normal.png");
	if(btnStatus==2)
	$('#bus_btn').attr("src","../img/btn_business_normal.png");
	if(btnStatus==3)
	$('#set_btn').attr("src","../img/btn_set_normal.png");
	if(btnStatus==4)
	$('#other_btn').attr("src","../img/btn_baseInfo_normal.png");
	if(btnStatus==5)
	$('#tj_btn').attr("src","../img/btn_report_normal.png");
	if(btnStatus==6)
	$('#predefine_btn').attr("src","../img/btn_predefine_normal.png");
}


function  openAlert(vin){
	$("#conterid").find("iframe")[0].contentWindow.alerts(vin);
}

function  openPlayBack(deviceID,licenseNum){
	$("#conterid").find("iframe")[0].contentWindow.history(deviceID,licenseNum);
}

function trace(temp){
	$("#conterid").find("iframe")[0].contentWindow.trace(temp);
}

function userSet(userID){
//	alert("userSet!" +userID);
	$('#dlgUserSet').dialog('open');
}


function mapSwitch(value){
$('#test').attr("src","vehicleView.html?mapType="+value); 
}

function dailySearch(deviceArr,startdate,stopDate) {
			$("#conterid").find("iframe")[0].contentWindow.dailySearch(deviceArr,startdate,stopDate);
		}
	
function tjTab(tabIndex){
				$('#idwest').attr("src","west_"+tabIndex+".html"); 		    
		}
		
function speedSearch(deviceArr,startdate,stopDate,speed){
	$("#conterid").find("iframe")[0].contentWindow.speedSearch(deviceArr,startdate,stopDate,speed);
}

function resoveledAlertSearch(deviceArr, startdate, stopDate,comValues){
			$("#conterid").find("iframe")[0].contentWindow.resoveledAlertSearch(deviceArr,startdate,stopDate,comValues);
		}

		

	</script>
</body>
</html>
