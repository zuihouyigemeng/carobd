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
    <style>
		.pagination .pagination-num{width:4em;}
	</style>
</head>
<body >	
<!-- <?php print_r ( $_SESSION);?> -->
      
	 <div style="width:1150px;height:500px">
        <table id="dg" title="" style="width:1150px;height:500px">
		<thead>
			<tr>
				<th data-options="field:'licenseNumber',width:120">车牌号</th>
				<th data-options="field:'customer',width:90">客户名称</th>
				<th data-options="field:'modelName',width:80">车型</th>
			    <th data-options="field:'d_esn',width:100,hidden:false">终端号</th>
				<th data-options="field:'createTime',width:160,hidden:false">报警时间</th>
				<th data-options="field:'title',width:100,hidden:false">报警类型</th>
				<th data-options="field:'cancelFlag',width:60,hidden:false">解除状态</th>
				<th data-options="field:'cancelTime',width:60,hidden:false">解除时间</th>
				<th data-options="field:'address',width:240,hidden:false">位置信息</th>
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
	var  dateOfToday;
/*
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
		alert ("新告警数量："+number);
	}
	*/
	function search(startDate){
		 glob_startDate=startDate;
		 //glob_stopDate=stopDate;
		/* url='../service/alert.php?sqlType=0&date='+glob_startDate+'&userId='+glob_userId;
	//	 alert(url);
		 $('#dg').datagrid({loadFilter:pagerFilter}).datagrid({   
			 url:url
					 }
		 );*/
		 
		 setAlertNew(startDate);

	  }
	

	
	function fresh(){
		glob_userId = <?php echo $_SESSION["userVo"]->userID; ?>;	//146;	//"zhangjf"
		//search("2014-09-10");      
		dateOfToday = '<?php echo date('Y-m-d');?>' ;
	 //   dateOfToday = '2014-09-01' ;
		//alert(dateOfToday);
		search(dateOfToday);
	}

    $(document).ready(function(){
    	fresh();//datagrid-cell-rownumber
		
    });
	

    function setAlertNew(date){
		var pageURL = '../service/alert.php?sqlType=0&date='+date+'&userId='+glob_userId;
					  //"../service/alert.php?sqlType=0&date="+date;
		var alertNum = $('#alertNmu', parent.document).html();//未读警告条数
		var saveCurrPage = new Array();
		$('#dg').datagrid({  
		
			url:pageURL, 
			
			singleSelect:false,//是否单选
		
			pagination:true,//分页控件 
			
			selectOnCheck:true,
			
			checkOnSelect:true, 
		
			rownumbers:true,//行号
			
			toolbar: [{
				text:'处理',
				iconCls:'icon-playback',
				handler:function(){
					var selectRows=$("#dg").datagrid('getChecked');					
					if(selectRows.length < 1){
						alert("请选择要处理的车辆！");
						return;
					}
					
					var url1='../service/alert.php';//?sqlType=10&recordId='+glob_recordId+'&userId='+glob_userId;
					for(var i=0;i<selectRows.length;i++){
						
						var selectRow = selectRows[i];
						
						var alertTitle = $.trim(selectRow.title);//报警类型
						var deviceID = selectRow.deviceID;//
						
						glob_recordId=selectRow.recordId;
						$.ajax({				
							type:"GET",
							url: url1,
							data: 'sqlType=10&recordId='+glob_recordId+'&userId='+glob_userId+'&alertTitle='+alertTitle+'&deviceID='+deviceID,
							async:false,
							success:function(result,status){
								if (status=="success"){
									if(i == selectRows.length-1) {
										fresh();
									}
								}else {
									alert("网络问题");
								}
							}
						});	
					}
				}	
					/*var selectRow=$('#dg').datagrid('getSelected');
					
					//console.log(selectRow);
					
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
							//	alert (result);
								//search("2014-09-10");
								fresh();
							}else {
								alert ("网络问题");
							}
							
					});
				}*/
			},{
				text:'刷新',
				iconCls:'icon-playback',
				handler:function(){
					fresh();
				}
				
			}/*,{
				text:'告警数',
				iconCls:'icon-playback',
				handler:function(){
					parent.hasNewAlerts(onResponse);
				}
				
			}*/],
			onLoadSuccess: function(data) {
				var total = $('#dg').datagrid('getData').total;
				var grid = $('#dg');  
				var option = grid.datagrid('getPager').data("pagination").options;  
				var curr = option.pageNumber;//当前页  
				var page = option.pageSize;//每页条数 
						
				var countPage = 0;
				
				if(alertNum % page  == 0){
					countPage = alertNum/page;
				}else{
					countPage = Math.floor(alertNum/page) + 1;
				}
				
				
				var lastAlertNum = alertNum % page;
				var lastAlertNum1 = lastAlertNum;
				
				var i = 0,j = 0;
				
				//count - total//剩下的条数
                $("div[class$='-licenseNumber'").each(function(){ 
					var val = $.trim($(this).text());
					
					if(val != "车牌号" && curr < countPage && saveCurrPage.indexOf(curr) < 0){
						//$(this).html("<span style='color:red'>"+val+"</span>");
						$(this).parent().parent().css({"color":"#C3522F"})
						i++;
						if(alertNum - total > 0 && curr == Math.ceil(total/page)){
							
							var num = total % page == 0 ? 10 : total % page;
							console.info(i+"-->"+num+"=num");
							if(i >= num) saveCurrPage.push(curr);
						}else{
							if(i >= page) saveCurrPage.push(curr);
						}
					}else if(val != "车牌号" 
							&& curr == countPage 
							&& saveCurrPage.indexOf(curr) < 0
							&& lastAlertNum1 > 0){
						//$(this).html("<span style='color:red'>"+val+"</span>");
						$(this).parent().parent().css({"color":"#C3522F"})
						lastAlertNum1--;
						j++;
						//console.log(Math.ceil(total/page));
						if(alertNum - total > 0 && curr == Math.ceil(total/page)){
							var num = total % page == 0 ? 10 : total % page;
							//console.log(num);
							if(j >= num) saveCurrPage.push(curr);
						}else{
							if(j >= lastAlertNum) saveCurrPage.push(curr);
						}

					}
					
				});
				$('#histAlertNum', parent.document).val(alertNum - total);		
            } 
		});
		
		//设置分页控件  
		var p = $('#dg').datagrid('getPager');  
		
		$(p).pagination({  
		
			pageSize: 10,//每页显示的记录条数，默认为10  
		
			pageList: [10,20,50,100],//可以设置每页记录条数的列表  
		
			beforePageText: '第',//页数文本框前显示的汉字  
		
			afterPageText: '页 共 {pages} 页',  
		
			displayMsg: '当前显示 {from} - {to} 条记录   共 {total} 条记录'
		
		});
		
	 }
	</script>
		</body>
</html>