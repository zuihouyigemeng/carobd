
<?php 
ob_start();
session_start();
  if(!isset($_SESSION["userVo"])||$_SESSION["userVo"]==null)
	{
		header("Location: ../login.php");
	    	ob_end_flush();
	}
	
		$userVo=$_SESSION["userVo"];
		echo  $userVo->depID;

   if($_GET['action'] == "logout"){
    unset($_SESSION['userVo']);
    header("Location: ../login.php");
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
<body onload="addPanel()" class="easyui-layout"  id="cc">
		<div data-options="region:'north'" style="height:67px;background: url('../img/bg.jpg');background-repeat: repeat;" >
		<div  align="right" style="height:20px;margin-right:10px; color:#ffffff">
        <span style="vertical-align: middle;">欢迎您,<?php echo($userVo->username); ?> !</span>
        <span  style="vertical-align: middle"> <a href="#" style="color:#ffffff" onclick="userSet()">|设置|</a></span> 
        <span  style="vertical-align: middle"> <a href="#" style="color:#ffffff" onclick="logout()">退出</a></span> 
		</div>
		<div style="height:40px;" id="buttDiv">
		<div align="right">
		<a href="javascript:void(0)" class="easyui-linkbutton"  plain="true"    data-options="iconCls:'icon-large-picture',size:'large',iconAlign:'left' " id='4s_btn' onclick="addPanel(this)"></a>
        <a href="#" class="easyui-linkbutton" plain="true"  data-options="iconCls:'icon-large-clipart',size:'large',iconAlign:'left'" id='obd_btn' onclick="btn_obd(this)"></a>
        <a href="#" class="easyui-linkbutton"  plain="true"   data-options="iconCls:'icon-large-shapes',size:'large',iconAlign:'left'" onclick="btn_acct(this)"></a>
        <a href="#" class="easyui-linkbutton" plain="true" group="a" data-options="iconCls:'icon-large-smartart',size:'large',iconAlign:'left'" onclick="btn_manage(this)"></a>
        <a href="#" class="easyui-linkbutton" plain="true" group="a" data-options="iconCls:'icon-large-clipart',size:'large',iconAlign:'left'"></a>
        <a href="#" class="easyui-linkbutton"  plain="true" group="a" data-options="iconCls:'icon-large-shapes',size:'large',iconAlign:'left'"  onclick="other()"></a>
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
			$("#4s_btn").addClass('l-btn-selected'); 
			$('#buttDiv').find('a').linkbutton("enable"); 
			$("#4s_btn").linkbutton("disable"); 

	//	     alert("tttt");
	//		$("#cc").panel({region:'center',href:'D:\workspace_new1\easyUI\demo\layout\flex\index.html'});  
	//		$("#cc").panel('refresh'); 
	
		//	$('#cc').layout('remove','west');
		//	$('#cc').layout('remove','east');
		
			hiddenPanel('west');
			hiddenPanel('east');
			
		//	$('#test').src="http://114.80.200.25/obd_4s1/index.php?user=zhangjf&pass=1111111111";
			$('#test').attr("src","http://114.80.200.25/obd_4s1/index.php?user=zhangjf&pass=1111111111");  
	//		$('#tt').tabs('add',{
	//			title: '4S管理',
	//			content: '<div style="padding:0px;width:100%;height:100% "><iframe  frameborder="0"  src="http://114.80.200.25/obd_4s1/index.php?user=zhangjf&pass=1111111111" style="width:100%;height:100%;"/></div>',
	//			closable: true
	//		});
	 //     $("#4s_btn").attr("style", "background: #fafafa");//
		}

		
		function btn_manage(obj){
			$('#buttDiv').find('a').linkbutton("enable"); 
			hiddenPanel('east');
			hiddenPanel('west');
			$('#test').attr("src","http://114.80.200.25/obd_4s1/manager.html?user=zhangjf&pass=1111111111");
			$(obj).linkbutton("disable");
		}
		
		
		function btn_acct(){
			hiddenPanel('east');
			hiddenPanel('west');
			$('#test').attr("src","http://114.80.200.25/OBD_acct1/login.php?op=login&name=root&passw=root_zxc!@#"); 
			$('#buttDiv').find('a').linkbutton("enable"); 
			$(obj).linkbutton("disable");
		}
		function btn_obd(obj){
            $('#buttDiv').find('a').linkbutton("enable"); 
			showPanel('west');
			hiddenPanel('east');
			$('#test').attr("src","vehicleView.html"); 
			$('#idwest').attr("src","west.php"); 
			$(obj).linkbutton("disable");
		}
		
		function other(){
			alert("other!");
			$("#conterid").find("iframe")[0].contentWindow.btn();
		}
		
		function vehicleClick(lat,lon,licenseNumber,address_num,time,vin,deviceID){
			$("#conterid").find("iframe")[0].contentWindow.vehicleClick(lat,lon,licenseNumber,address_num,time,vin,deviceID);
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
		
		

	</script>
</body>
</html>