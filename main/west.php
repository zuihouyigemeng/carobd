
<?php include("session.php"); ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Complex Layout - jQuery EasyUI Demo</title>
	<link rel="stylesheet" type="text/css" href="../themes/default/easyui.css">
	<link rel="stylesheet" type="text/css" href="../themes/icon.css">
	<link rel="stylesheet" type="text/css" href="../demo.css">
	<script type="text/javascript" src="../jquery.min.js"></script>
	<script type="text/javascript" src="../jquery.easyui.min.js"></script>
</head>
<body  >	
	<!-- 	<div class="easyui-accordion" data-options="fit:true,border:false">
				<div title="Title1" style="padding:10px;">
					content1
				</div>
				<div title="Title2" data-options="selected:true" style="padding:10px;">
					content2
				</div>
				<div title="Title3" style="padding:10px">
					content3
				</div>
			</div>   -->
			
		
		<div class="easyui-tabs" style="width:250px;height:200px" id='tt1'>	
         <?php 
	          if($_SESSION["op"]=="deplogin")
	          {
	       ?>
	         <div title="部门"  style="overflow:auto;padding:10px;">
			<ul class="easyui-tree"   url="../service/departments.php?defDep=<?php echo  $userVo->depID ?>" data-options="animate:true,checkbox:true,onlyLeafCheck:true"  id="depID">
				
			</ul>
		</div>
	         <?php 
	          }
	       ?>

		
		<div title="车系"  style="overflow:auto;padding:10px;">
				
			<ul class="easyui-tree"   url="../service/vehicleNumber.php?defDep=<?php echo  $userVo->depID ?>" data-options="animate:true,checkbox:true,cascadeCheck:true"  id="v_modelID">
				
			</ul>
		</div>

		<div title="客户"  style="overflow:auto;padding:10px;">
				
			<ul class="easyui-tree"   
			 <?php 
	          if($_SESSION["op"]=="deplogin")
	          
	        ?>
			url="../service/customer.php?defDep=-1" 
			<?php 
	          else 
	       ?>
			 url="../service/customer.php?defDep=<?php echo  $userVo->depID ?>" 	 
			data-options="animate:true,checkbox:true,onlyLeafCheck:true"  id="v_cusID">
				
			</ul>
		</div>

		</div>
		
		
	 <div style="padding:0px">
        <table id="dg" class="easyui-datagrid" title="" style="width:250px;height:300px"
        data-options="rownumbers:true,singleSelect:false,selectOnCheck:false,checkOnSelect:false,pagination:true,toolbar:toolbar">
	<!--		data-options="rownumbers:true,singleSelect:false,pagination:true,url:'../service/vehicles.php',method:'get',toolbar:toolbar">   -->
		<thead>
			<tr>
				<th data-options="field:'ck',checkbox:true"></th>
				<th data-options="field:'licenseNumber',width:90",>车牌号</th>
			    <th data-options="field:'d_esn',width:80,hidden:false">D_ESN</th>
				<th data-options="field:'address_num',width:80,hidden:true">地址</th>
				<th data-options="field:'latitude',width:50,hidden:true">latitude</th>
				<th data-options="field:'longitude',width:50,hidden:true">longitude</th>
				<th data-options="field:'time',width:100,hidden:true">时间</th>
				<th data-options="field:'vin',width:50,hidden:true">vin</th>
				<th data-options="field:'deviceID',width:100,hidden:true">deviceID</th>
				<th data-options="field:'heading',width:100,hidden:true">heading</th>
				<th data-options="field:'ign',width:100,hidden:true">ign</th>
			</tr>
		</thead>
	</table>
              
	           </div>
<!-- 	<div id="p" class="easyui-panel" title="车辆列表" style="width:250px;height:420px;padding:0px;">
			<table id="dg" title="" style="width:250px;height:400px"
			data-options="rownumbers:true,singleSelect:true,pagination:true,url:'datagrid_data1.json',method:'get'">
		<thead>
			<tr>
				<th data-options="field:'itemid',width:80">Item ID</th>
				<th data-options="field:'productid',width:100">Product</th>
			</tr>
		</thead>
	</table>
	</div>   -->
	<script type="text/javascript">
//	$('#depID').tree({
//			onBeforeExpand: function(node){
//				depID1=node.id;
//				alert(depID1);
//				
//				$('#depID').tree({   
//				 url:'../service/departments.php?id='+depID1
//						 }
//			);  
//				
//			}
//		});
	//	$(function(){
	//		var pager = $('#dg').datagrid().datagrid('getPager');	// get the pager of datagrid
	//
	//	})
		function doSearch(value,name){
		//	alert('You input: ' + name+"="+value);
		//	alert('../service/vehicles.php?depID='+depID+'&'+name+"="+value);
			$('#dg').datagrid({   
				 url:'../service/vehicles.php?depID='+depID+'&'+name+"="+value
						 }
			);  
		}
		
		$(function (){ 
			$('#v_list_filter').find('a:first').addClass('l-btn-selected'); 
			$('#v_list_filter').find('a').click(function () { 
			$('#v_list_filter').find('a').removeClass('l-btn-selected'); 
			$(this).addClass('l-btn-selected'); 
			}) 
			}) 
			
			var toolbar = [{
			text:'跟踪',
			iconCls:'icon-trace',
			handler:function(){
			var selectRows=$('#dg').datagrid('getSelections');
			if(selectRows.length==0){
				alert("请单击车辆进行选择（最多8辆）！");
				return;
			}
			var deviceArr=new Array();
			for ( var i=0 ; i < selectRows.length ; ++i ){
				deviceArr.push(selectRows[i].deviceID);
			}
			
			var tmp=deviceArr.join(",");
			 //alert(tmp);
			
				window.open("trace.php?deviceID="+tmp,"_blank");
				}
		},{
			text:'回放',
			iconCls:'icon-playback',
			handler:function(){
				var selectRows=$('#dg').datagrid('getSelections');
			if(selectRows.length==0){
				alert("请单击车辆进行选择（最多1辆）！");
				return;
			}
			
			top.openPlayBack(selectRows[0].deviceID,selectRows[0].licenseNumber);
			
			}
		},'-',{
			text:'告警',
			iconCls:'icon-alerts',
			handler:function(){
			var selectRows=$('#dg').datagrid('getSelections');
			if(selectRows.length==0){
				alert("请单击车辆进行选择（最多1辆）！");
				return;
			}
			var vin=selectRows[0].vin;
			top.openAlert(vin);
			
			}
		}];
		
		
		$('#dg').datagrid({
			onCheckAll: function(rows){
			//	alert(rows[0].d_esn);
				top.checkAll(rows);
			}
		
		});
		
		
		$('#dg').datagrid({
			onCheck: function(rowIndex,rowData){
				top.onCheck(rowData);
			}
		
		});
		
		
		$('#dg').datagrid({
			onUncheck: function(rowIndex,rowData){
				top.onUncheck(rowData);
			}
		
		});
		
		$('#dg').datagrid({
			onUncheckAll: function(rows){
			//	alert(rows[0].d_esn);
				top.onUncheckAll(rows);
			}
		
		});
	
		
		$('#dg').datagrid({
		onDblClickRow: function(rowIndex, rowData){
			//	alert("DbClick row "+rowData.d_esn);
				top.vehicleClick(rowData);
			//	$("#myid", top.document).;
			//	alert($("#updkbi", top.document).attr("value"));
		}
	   });
		
		
		function getSelected(){
			var row = $('#dg').datagrid('getSelected');
			if (row){
				$.messager.alert('Info', row.itemid+":"+row.productid+":"+row.attr1);
			}
		}
		function getSelections(){
			var ss = [];
			var rows = $('#dg').datagrid('getSelections');
			for(var i=0; i<rows.length; i++){
				var row = rows[i];
				ss.push('<span>'+row.itemid+":"+row.productid+":"+row.attr1+'</span>');
			}
			$.messager.alert('Info', ss.join('<br/>'));
		}
		//初始为根节点，从页面参数传入
		var depID='<?php echo  $userVo->depID ?>';
		var status=2;
		$('#depID').tree({
			onDblClick: function(node){
				depID=node.id;
				
		//		$('#dg').datagrid({
		//			queryParams: {
		//				depID: node.id
		//			}
		//		});
		
		var tab = $('#tt').tabs('getSelected');
        var index = $('#tt').tabs('getTabIndex',tab);
        if(index==1){
        	   $('#tt').tabs('select',0);
        }
        else if(index==0){
        	$('#v_list_filter').find('a').removeClass('l-btn-selected');
			$('#v_list_filter').find('a:first').addClass('l-btn-selected'); 
        	$('#dg').datagrid({loadFilter:pagerFilter}).datagrid({   
				 url:'../service/vehicles.php?depID='+depID+"&ign="+2
						 }
			);  
        }


		//		$('#dg').datagrid('load', {depID: node.id});
		//		$('#dg').datagrid('reload');    
			}
		});
		
		
		function getStatusVehicles(sta){
			//alert(sta);
			status=sta;
			$('#dg').datagrid({loadFilter:pagerFilter}).datagrid({   
				 url:'../service/vehicles.php?depID='+depID+"&ign="+status
						 }
			);  
		}
		
		
		$('#tt1').tabs({
			onSelect: function(title,index){
                 alert(title);
				
			  }
			});
		
		
		$(document).ready(function(){
		//	var node = $('#depID').tree('find', 1070);
		//	$('#depID').tree('select', node.target);
			});

		
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
		
		


		
		
	</script>
		</body>
</html>