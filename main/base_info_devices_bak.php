
<?php include("session.php"); ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>设备管理</title>
	<link rel="stylesheet" type="text/css" href="../themes/default/easyui.css">
	<link rel="stylesheet" type="text/css" href="../themes/icon.css">
	<link rel="stylesheet" type="text/css" href="../demo.css">
	<script type="text/javascript" src="../jquery.min.js"></script>
	<script type="text/javascript" src="../jquery.easyui.min.js"></script>
</head>
<body>	
	
    <div  style="overflow:auto;padding:0px;">
		<div  style = "width:250px;float:left;right-margin:10px">
			     <div id="p" class="easyui-panel" title="部门"  style="width:230px;height:500px;">	
                     
                     <ul class="easyui-tree"   
                         url="../service/add_department.php?defDep=<?php echo  $userVo->depID ?>"   
                         data-options="animate:true,onlyLeafCheck:true"  
                         id="depID">
                    
                    </ul>
                     
			    </div>
			</div>
			
			
            <table id="device"  style="width:1200px;height:500px" data-options="
                                    rownumbers:true,
                                    singleSelect:true,
                                    autoRowHeight:false,
                                    pagination:true,
                                    pageSize:10">
            <thead>
            	<tr>
                    <th data-options="field:'name',width:350">名称</th>
                	<th data-options="field:'parentName',width:165,align:'right'">父机构名称</th>
                    <th data-options="field:'tel',width:180,align:'right'">联系电话</th>
                    <th data-options="field:'address',width:180,align:'right'">地址</th>
            <!--		<th data-options="field:'lon',width:170,align:'right'">经度</th>
                    <th data-options="field:'lat',width:170,align:'right'">纬度</th>   -->
                    <th data-options="field:'operation',width:80,align:'right'">操作 </th>      
                </tr>
            </thead>
        </table>
        
        <div id ="tb" style="height:auto">
            <input type="button" value="添加部门" onclick="add_departments()">
        </div>	
	</div>	







		<script>
		//初始为根节点，从页面参数传入
	    var depID = '<?php echo  $userVo->depID ?>';
		var nodeId = depID;
		
		var traceWin1 = null;
		var traceWin = null;
		
		var timer1;
		var timer2;
		function ifAddWindowClosed() {
			if (traceWin1.closed == true) { 				
				$('#custMan').datagrid({   
					 url:'../service/departmentsManage.php?vin='+nodeId
				});
				
				window.clearInterval(timer1)
			}
		}
		
		//当编辑窗口打开后对编辑的窗体进行监控，若关闭则刷新相应的数据
		function ifEditWindowClosed(){
			if (traceWin.closed == true) { 				
				$('#custMan').datagrid({   
					 url:'../service/departmentsManage.php?vin='+nodeId
				});
				
				window.clearInterval(timer2)
			}
		}
		
		
		function add_departments(){			
			
			//判断该窗口(NewWindow)是否已经存在，如果已经存在，则先关闭窗口，然后再打开新窗口
			if(traceWin1){
				if(!traceWin1.closed)
					traceWin1.close();
			}
			
			traceWin1=window.open('addDepartments.html','增加部门','height=400, width=700, top=200,left=500');
			
			timer1=window.setInterval("ifAddWindowClosed()",500);
			
		}
		
		function edit_department(id,name,parentId,parentName){
			
			if(traceWin){
				if(!traceWin.closed)
					traceWin.close();
			}
			
			traceWin=window.open('editdepartment.html?id='+
									encodeURI(encodeURI(id))+'&parentName='+
									encodeURI(encodeURI(parentName))+'&parentId='+
									encodeURI(encodeURI(parentId))+'&name='+
									encodeURI(encodeURI(name)),
				'修改部门信息',
				'height=400, width=450,top=200,left=500,toolbar=no, menubar=no,scrollbars=no,resizable=yes,location=yes, status=no');
		
			timer2=window.setInterval("ifEditWindowClosed()",500);
		}
		
		

		function delete_department(id){
			
			var r=confirm("确认删除该部门吗？");
			
			if (r==true){
			
			   $.get("../service/delete_department.php",
				  {vin:id},
				  function(data,status){
					    var rows = eval(data);		
							
						if(rows != "200"){						
							alert("删除失败！");
							return;
						}else{
							$('#custMan').datagrid({   
								 url:'../service/departmentsManage.php?vin='+nodeId
							});
							
							alert("删除成功!");
						}
					  
				  });
				
			}
		   
		}
		
		$('#custMan').datagrid({
			toolbar: '#tb'
		});
		
		$('#custMan').datagrid({   
			 url:'../service/departmentsManage.php?vin='+depID
		}); 
		
		
		$('#depID').tree({
			onClick: function(node){		
				nodeId=node.id;
				$('#custMan').datagrid({   
					url:'../service/departmentsManage.php?vin='+node.id
				});
			}
		});
		
		/*function fresh(){
				
			$('#custMan').datagrid({   
				 url:'../service/departmentsManage.php?vin='+depID
			}); 
			
			$('#depID').tree({   
				 url:'../service/administration.php?defDep=<?php echo  $userVo->depID ?>'
			}); 
		}*/
		

		
		
		</script>
		
		
		<script>
		function getData(){
			var rows = [];
			/*for(var i=1; i<=800; i++){
				var amount = Math.floor(Math.random()*1000);
				var price = Math.floor(Math.random()*1000);
				rows.push({
					inv: 'Inv No '+i,
					date: $.fn.datebox.defaults.formatter(new Date()),
					name: 'Name '+i,
					amount: amount,
					price: price,
					cost: amount*price,
					note: 'Note '+i
				});
			}*/
			return rows;
		}
		
		function pagerFilter(data){
			if (typeof data.length == 'number' && typeof data.splice == 'function'){	// is array
				data = {
					total: data.length,
					rows: data
				}
			}
			var custMan = $(this);
			var opts = custMan.datagrid('options');
			var pager = custMan.datagrid('getPager');
			pager.pagination({
				onSelectPage:function(pageNum, pageSize){
					opts.pageNumber = pageNum;
					opts.pageSize = pageSize;
					pager.pagination('refresh',{
						pageNumber:pageNum,
						pageSize:pageSize
					});
					custMan.datagrid('loadData',data);
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
		
		$(function(){
			$('#custMan').datagrid({loadFilter:pagerFilter}).datagrid('loadData', getData());
		});
	</script>
		
</body>
</html>
	
	