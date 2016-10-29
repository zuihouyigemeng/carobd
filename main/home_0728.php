
<?php 
ob_start();
session_start();
  if(!isset($_SESSION["userVo"])||$_SESSION["userVo"]==null)
	{
		header("Location: ../index.php");
	    	ob_end_flush();
	}
	
		$userVo=$_SESSION["userVo"];
		echo  $userVo->passw;

   if($_GET['action'] == "logout"){
    unset($_SESSION['userVo']);
    header("Location: ../index.php");
	  ob_end_flush();
}
   
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>车随行</title>
	<link rel="stylesheet" type="text/css" href="../themes/default/easyui.css">
	<link rel="stylesheet" type="text/css" href="../themes/icon.css">
	<link rel="stylesheet" type="text/css" href="../demo.css">
	<script type="text/javascript" src="../jquery.min.js"></script>
	<script type="text/javascript" src="../jquery.easyui.min.js"></script>
	<SCRIPT type="text/javascript" src="../jquery.layout.js"></SCRIPT>
    <SCRIPT type="text/javascript" src="../jquery.layout.extend.js"></SCRIPT>
      
</head>
<body onload="btn_obd()" class="easyui-layout"  id="cc">
<?php include("userSet.html"); ?> 
	<div data-options="region:'north'"  style="height:72px;background-color:#3a3a3a;">
	<TABLE  border="0" cellSpacing="0" cellPadding="0">
    <TBODY>
    <TR >
    <TD align="center" width="350px"><IMG  alt="logo" src="../img/logo1.png"/></TD>
    <TD align="center" width="30px" valign='bottom'><IMG  alt="logo"    src="../img/user.png"/></TD>
    <td align="left" width="300px" style="color:#ffffff; padding-top:45px;">欢迎您, <span style="color:#108be9"><?php echo($userVo->username); ?> </span>!|<a href="#"  style="color:#ffffff" onclick="userSet('<?php echo($userVo->userID); ?>')">设置|</a> <a href="#" style="color:#ffffff"  onclick="logout()">退出</a></td>
    <TD align="right" style="padding-top:0px;" width="800px" >
       <IMG  id='4s_btn' class='4s_btn' onclick="addPanel(this)" style="height:65px;" alt="4s管理" src="../img/btn_4s_normal.png"/>
         <IMG  id='obd_btn' onclick="btn_obd()" style="height:65px;" alt="车辆监控" src="../img/btn_monitor_normal.png"/>
         <IMG   id='bus_btn' onclick="btn_manage(this)" style="height:65px;" alt="系统管理" src="../img/btn_business_normal.png"/>
         <IMG   id='set_btn'  onclick="btn_acct()"  style="height:65px;" alt="后台管理" src="../img/btn_set_normal.png"/>
         <IMG   id='other_btn' onclick="other()" style="height:65px;" alt="其他" src="../img/btn_more_normal.png"/>
    </TD>
    </TR></TBODY></TABLE>
       </div>
        </div>
		</div>
		<div data-options="region:'south',split:false" style="height:25px;">
		<table width="100%">
		<tr width="100%" style="color:#000000"><td width="50%" align="left"><span >您好！你是第 10 次登录本平台系统版本：[V1.0.0 Build 20140709]</span></td><td align="right" width="50%"><span >上级客户：车随行，联系人：IVAN，联系电话：021-50804828</span></td></tr>
		</table>
		</div>
		<div data-options="region:'east',split:false"  style="width:200px;"   >
			<ul class="easyui-tree" data-options="url:'tree_data1.json',method:'get',animate:true,dnd:true"></ul>
		</div>
		<div data-options="region:'west',split:false"  style="width:300px"  id='west'>
	     <iframe  id="idwest"  frameborder="0"  src="" style="width:100%;height:99%;"></iframe>
		</div>
			
	
	
		<div data-options="region:'center',iconCls:'icon-ok'" id="conterid" >
	    <iframe  id="test"  frameborder="0"  src="" style="width:100%;height:100%;"></iframe>
        </div>
		   
		   
		    

	<script type="text/javascript">
	
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
		$('#buttDiv').find('a').click(function () { 
		$('#buttDiv').find('a').removeClass('l-btn-selected'); 
		$(this).addClass('l-btn-selected'); 
		}) 
		}) 
	
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
			alert("http://180.166.124.142:9983/obd_4s1/index.php?user=<?php echo($userVo->username); ?>&pass=<?php echo  $userVo->passw ?>");
			recoveryImg();
			hiddenPanel('east');
			hiddenPanel('west');
    //        $('#4s_btn').attr("src","../img/btn_business_focused.png");
			$('#test').attr("src","http://180.166.124.142:9983/obd_4s1/index.php?user=<?php echo($userVo->username); ?>&pass=<?php echo  $userVo->passw ?>");  
	
		}

		
		function btn_manage(obj){
			alert("http://180.166.124.142:9983/obd_4s1/manager.html?user=<?php echo  $userVo->username ?>&pass=<?php echo  $userVo->passw ?>");
			$('#buttDiv').find('a').linkbutton("enable"); 
			hiddenPanel('east');
			hiddenPanel('west');
			$('#test').attr("src","http://180.166.124.142:9983/obd_4s1/manager.html?user=<?php echo  $userVo->username ?>&pass=<?php echo  $userVo->passw ?>");
			$(obj).linkbutton("disable");
		}
		
		
		function btn_acct(){
			alert("acct!");
			hiddenPanel('east');
			hiddenPanel('west');
			$('#test').attr("src","http://180.166.124.142:9983/OBD_acct1/login.php?op=login&name=<?php echo  $userVo->username ?>&passw=<?php echo  $userVo->passw ?>"); 
			$('#buttDiv').find('a').linkbutton("enable"); 
		//	$(obj).linkbutton("disable");
		}
		function btn_obd(){
			$("#obd_btn").addClass('l-btn-selected'); 
            $('#buttDiv').find('a').linkbutton("enable"); 
			showPanel('west');
			hiddenPanel('east');
			$('#test').attr("src","vehicleView.html"); 
			$('#idwest').attr("src","west.php"); 
			$("#obd_btn").linkbutton("disable");
		}
		
		function other(){
			alert("other!");
			$("#conterid").find("iframe")[0].contentWindow.btn();
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
	$('#4s_btn').attr("src","../img/btn_4s_focused.png");
}
)

$('#4s_btn').mouseout(function(){ 
$('#4s_btn').attr("src","../img/btn_4s_normal.png");
}
)



		$('#obd_btn').hover(function(){ 
	$('#obd_btn').attr("src","../img/btn_monitor_focused.png");
}
)

$('#obd_btn').mouseout(function(){ 
$('#obd_btn').attr("src","../img/btn_monitor_normal.png");
}
)

$('#bus_btn').hover(function(){ 
	$('#bus_btn').attr("src","../img/btn_business_focused.png");
}
)

$('#bus_btn').mouseout(function(){ 
$('#bus_btn').attr("src","../img/btn_business_normal.png");
}
)

$('#set_btn').hover(function(){ 
	$('#set_btn').attr("src","../img/btn_set_focused.png");
}
)

$('#set_btn').mouseout(function(){ 
$('#set_btn').attr("src","../img/btn_set_normal.png");
}
)

$('#other_btn').hover(function(){ 
	$('#other_btn').attr("src","../img/btn_more_focused.png");
}
)

$('#other_btn').mouseout(function(){ 
$('#other_btn').attr("src","../img/btn_more_normal.png");
}
)

function recoveryImg(){
	$('#4s_btn').attr("src","../img/btn_4s_normal.png");
	$('#obd_btn').attr("src","../img/btn_monitor_normal.png");
	$('#bus_btn').attr("src","../img/btn_business_normal.png");
	$('#set_btn').attr("src","../img/btn_set_normal.png");
	$('#other_btn').attr("src","../img/btn_more_normal.png");
}


function  openAlert(vin){
	$("#conterid").find("iframe")[0].contentWindow.alerts(vin);
}

function  openPlayBack(deviceID,licenseNum){
	$("#conterid").find("iframe")[0].contentWindow.history(deviceID,licenseNum);
}

function userSet(userID){
	alert("userSet!" +userID);
	$('#dlgUserSet').dialog('open');
}

		

	</script>
</body>
</html>