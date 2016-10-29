<?php	?>
<title>css与星星</title>
<style type="text/css">
.box{width:120px; height:80px; position:relative; overflow:hidden;}
.m{width:75px; height:74px;  background:url(../img/btn_4s_normal.png);}
.m1{top:0px; background-position:0px top;}
.m2{top:16px; background-position:-25px top;}
.m3{top:32px; background-position:-25px top;}
.m4{top:48px; background-position:-25px top;}
.m5{top:64px; background-position:1px top;}
.m1:hover{ background:url(../img/btn_4s_focused.png) repeat-y; overflow:hidden;}
.m2:hover{ height:32px; top:0; background-position:-50px top;}
.m3:hover{ height:48px; top:0; background-position:-50px top;}
.m4:hover{ height:64px; top:0; background-position:-50px top;}
.m5:hover{ height:80px; top:0; background-position:-50px top;}
</style>
<body>
<div >
<?php 	
	echo date('Y-m-d');
?>
<a href="#" class="m m1">aaa
</a>
</div>
</body>
<?php ?>