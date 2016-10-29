<?php include("session.php"); ?>
<?php 
	//print_r($_SESSION);
	$userId = $_SESSION["userVo"]->userID;
	$depId = $_SESSION["userVo"]->depID;

?>
<!DOCTYPE html>
<html>

<head>
<meta charset="UTF-8">
<title>告警</title>
<link rel="stylesheet" type="text/css"
	href="../themes/default/easyui.css">
<link rel="stylesheet" type="text/css" href="../themes/icon.css">
<link rel="stylesheet" type="text/css" href="../demo.css">
<script type="text/javascript" src="../jquery.min.js"></script>
<script type="text/javascript" src="../jquery.easyui.min.js"></script>
</head>

<body >

	<div class="easyui-tabs" style="width: 1250px; height: 630px" id="tt1"> 
	<div title="最新告警" style="padding: 0px"  id='div0'>
			<iframe id="alertView_new" frameborder="0" src="alertView_new.php"
					style="width: 100%; height: 99%;"></iframe>
	</div>
    <div title="历史告警" style="padding: 0px"  id='div1'>
			<iframe id="alertView_hist"  frameborder="0" src="alertView_hist.php"
					style="width: 100%; height: 99%;"></iframe>


	<script type="text/javascript">
	var glob_userId =0;
	
	var tabIndex=0;	
	$('#tt1').tabs({
		onSelect: function(title,index){
        	 if(tabIndex!=index){
        		 //top.tjTab(index);
        		 tabIndex=index;
        	 }
        	
			
		  }
	});

	function hasNewAlerts(onResponse){
		glob_userId = 146;		// "zhangjf"
		url='../service/alert.php?sqlType=11&userId='+glob_userId;
		//url='../service/alert.php?sqlType=11&userId=<?php echo $userId; ?>&depId=<?php echo $depId;?>';
		alert(url);

		$.get(url, {				
			},function(numberOfAlerts,status){	
				//alert (jsonStr);
				//alert (status);
				if (status=="success") {		 
		 			//alert (numberOfAlerts);
		 			
		 			onResponse(numberOfAlerts);		 			
				}else {
					alert ("网络问题");
				}
				
		});		
	};
	</script>
</body>
</html>
<?php ?>