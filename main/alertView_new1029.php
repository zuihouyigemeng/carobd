<?php include("session.php"); ?>
<?php ?>
<html>
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="../themes/default/easyui.css">
	<link rel="stylesheet" type="text/css" href="../themes/icon.css">
	<link rel="stylesheet" type="text/css" href="../demo.css">
	<script src="http://s1.bdstatic.com/r/www/cache/ecom/esl/1-6-10/esl.js"></script>
	<script type="text/javascript" src="../jquery.min.js"></script>
	<script type="text/javascript" src="../jquery.easyui.min.js"></script>
</head>
<body >	
<!-- <?php print_r ( $_SESSION);?> -->
      
	 <div style="width:1200px;height:500px">
        <table id="dg" class="easyui-datagrid" title="" style="width:1150px;height:500px"
        data-options="rownumbers:true,singleSelect:true,selectOnCheck:false,checkOnSelect:false,pagination:true,toolbar:toolbar">
		<thead>
			<tr>
				<th data-options="field:'licenseNumber',width:120">车牌号</th>
				<th data-options="field:'customer',width:90">客户名称</th>
				<th data-options="field:'modelName',width:80">车型</th>
			    <th data-options="field:'d_esn',width:150,hidden:false">终端号</th>
				<th data-options="field:'createTime',width:180,hidden:false">报警时间</th>
				<th data-options="field:'title',width:120,hidden:false">报警类型</th>
				<th data-options="field:'cancelFlag',width:80,hidden:false">解除状态</th>
				<th data-options="field:'cancelTime',width:80,hidden:false">解除时间</th>
				<th data-options="field:'address',width:200,hidden:false">位置信息</th>
				<th data-options="field:'recordId',width:0,hidden:true">recordId</th>
			</tr>
		</thead>
	</table>
	</div>
              
	<script type="text/javascript">
	var  glob_startDate;
	var  glob_stopDate;
	var  glob_recordId;
	var  glob_userId;

	function pagerFilter(data){
		if (typeof data.length == 'number' && typeof data.splice == 'function'){	// is array
			data = {
				total: data.length,
				rows: data
			}
		}
		var dg = $(this);
		var opts = dg.datagrid('options');
		var pager = dg.datagrid('getPager');
		pager.pagination({
			onSelectPage:function(pageNum, pageSize){
				opts.pageNumber = pageNum;
				opts.pageSize = pageSize;
				pager.pagination('refresh',{
					pageNumber:pageNum,
					pageSize:pageSize
				});
				dg.datagrid('loadData',data);
			}
		});
		if (!data.originalRows){
			data.originalRows = (data.rows);
		}
		var start = (opts.pageNumber-1)*parseInt(opts.pageSize);
		var end = start + parseInt(opts.pageSize);
		data.rows = (data.originalRows.slice(start, end));
		return data;
	}
	
	var toolbar = [{
		text:'处理',
		iconCls:'icon-playback',
		handler:function(){
			var selectRow=$('#dg').datagrid('getSelected');
			if(selectRow==null){
				alert("请单击进行选择（最多1条记录）！");
				return;
			}
			//alert(selectRow.deviceID);
			glob_recordId=selectRow.recordId;
			url='../service/alert.php?sqlType=10&recordId='+glob_recordId + '&userId='+glob_userId;
		//	alert(url);
	
			$.get(url, {				
				},function(result,status){	
					//alert (jsonStr);
					//alert (status);
					if (status=="success") {		 
			 			alert (result);
			 			//search("2014-09-10");
			 			refresh();
					}else {
						alert ("网络问题");
					}
					
			});
		}
	},{
		text:'刷新',
		iconCls:'icon-playback',
		handler:function(){
			refresh();
		}
		
	},{
		text:'告警数',
		iconCls:'icon-playback',
		handler:function(){
			parent.hasNewAlerts(onResponse);
		}
		
	}		
	];	
	
	function onResponse(number){
		alert ("新告警数量："+number	);
	}
	
	function search(startDate){
		 glob_startDate=startDate;
		 //glob_stopDate=stopDate;
		 url='../service/alert.php?sqlType=0&date='+glob_startDate+'&userId='+glob_userId;
	//	 alert(url);
		 $('#dg').datagrid({loadFilter:pagerFilter}).datagrid({   
			 url:url
					 }
		 );
	  }

	function refresh(){
		glob_userId = <?php echo $_SESSION[userVo]->userID; ?>;	//146;	//"zhangjf"
		//search("2014-09-10");      
		dateOfToday = '<?php echo date('Y-m-d');?>' ;
		//alert(dateOfToday);
		search (dateOfToday);
	}
	 
    $(document).ready(function(){
    	refresh(); 
    	
    });
      	  
	</script>
		</body>
</html>
<?php
?>