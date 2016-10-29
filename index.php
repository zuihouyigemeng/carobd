<?php 
include_once'DBConnection.php';
include_once ('./common/AES.php');
ob_start();
session_start();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><HTML 
xmlns="http://www.w3.org/1999/xhtml"><HEAD id="Head1">
<META content="text/html; charset=utf-8" http-equiv="Content-Type">
<META content="IE=edge" http-equiv="X-UA-Compatible"><TITLE>登录 - 贝尔加
</TITLE><LINK rel="SHORTCUT ICON" href="../img/u12580/login/4sfavicon.ico"><LINK 
rel="stylesheet" type="text/css" href="tmp/main.css">
<STYLE type="text/css">
    body{
        background-color:#f0f0f0;
        padding-top:71px;
    }
    #top{
        width:100%;
        height:71px;
        line-height:71px;
        background:url(img/obd/login/top_bg.png) repeat-x;
        position: fixed;
        top:0;
        left:0;
        z-index: 99999;
    }
    #top .classes{
        width:960px;
        height:71px;
        /*border-bottom:#0aa1ff 2px solid;*/
    }
    #top .classes .menu{
        float:right;
        display:block;
        text-decoration:none;
        /*width:93px;
        height:37px;
        line-height:37px;
        background:url(img/obd/login/anniu.png) no-repeat;
        background-position:0px 0px;
        color:#666666;
        text-align:center;
        font-size:14px;
        margin:35px 15px 0px 0px;*/
	
	    font-size:16px;
        color:#ffffff;
        margin-left:25px;
    }
    #top .classes .select{
        /*background-position:-93px 0px;
        color:#ffffff;*/
	    font-weight:bold;
        font-size:18px;
    }
    #top .logo{
        /*width:202px;*/
        /*height:49px;*/
        /*margin-top:16px;*/
    }
    #top .at{
        display:block;
        width:250px;
        height:49px;
        line-height:49px;
        font-size:19px;
        margin-top:16px;
    }
    #main{
        width:960px;
        position: relative;
    }
    #main .divitem{
        position:absolute;
        float:left;
        margin-left:32px;
    }
    #main .bannerimage{
        border:#cbcbcb 1px solid;
    }
    #main .loginpanel{
        width:318px;
        height:341px;
        border:#cbcbcb 1px solid;
        background-color:#ffffff;
    }
    #main .sign_focus,.sign_href{
        width:50%;
        height:35px;
        line-height:35px;
        font-size:14px;
        text-align:center;
    }
    #main .sign_focus{
        background-color:#ffffff;
        color:#000000;
    }
    #main .sign_href{
        background-color:#000000;
        color:#ffffff;
        border:#cbcbcb solid;
        border-width:0px 0px 1px 1px;
        cursor:pointer;
    }
    #main .signput,.pwdput{
        width:205px;
        height:27px;
        line-height:23px;
        border:#ceced0 1px solid;
        padding:3px 0px 0px 26px;
        position:absolute;
        /*z-index:-200px;*/
        float:left;
    }
    #main .loginpanel .signput{
        width:225px;
        height:25px;
        line-height:25px;
        background:#ffffff url(img/icon_name_bg.png) no-repeat;
        background-position:left;
        position:absolute;
    }
    #main .pwdput{
        width:225px;
        height:25px;
        line-height:25px;
        background:#ffffff url(img/icon_pwd_bg.png) no-repeat;
        background-position:left;
        position:absolute;
    }
    #main .loginpanel .tab{
        /*margin-left:30px;*/
    }
    #main .loginpanel .visablecode{
        /*width:180px;
        height:25px;
        line-height:25px;*/
    
        width:160px;
        height:27px;
        line-height:23px;
        background:#ffffff url(img/icon_visibled_bg.png) no-repeat;
        background-position:left;
        padding:3px 0px 0px 26px;
        border:#ceced0 1px solid;
        position:absolute;
        /*z-index:-200px;*/
        float:left;
    }
    #main .loginpanel .divverifyStyle
    {
       /*width:65px;
       height:29px;
       line-height:29px;
       cursor:pointer;
       text-align:center;
       font-size:14px;
       font-family:Arial;
       background-color: #1dacea;
       border: #1dacea 1px solid;*/
   
       width:65px;
       height:29px;
       line-height:29px;
       cursor:pointer;
       text-align:center;
       font-size:14px;
       font-family:Arial;
       background-color: #1dacea;
       border: #1dacea 1px solid;
       position:absolute;
       float:left;
       margin-left:190px;
    }
    #main .btnLogin,.btnReg{
        display:block;
        text-decoration:none;
        width:117px;
        height:34px;
        line-height:34px;
        text-align:center;
        background:url(img/obd/login/anniu.png) no-repeat;
        font-size:16px;
        color:#ffffff;
    }
    #main .btnLogin{
        background-position:0px -37px;
        float:left;
        margin-left:30px;
    }
    #main .btnLogin:hover{
        background-position:0px -71px;
    }
    #main .btnReg{
        background-position:-117px -37px;
        float:right;
        margin-right:30px;
    }
    #main .btnReg:hover{
        background-position:-117px -71px;
    }
    #main .point_mark{
        display:block;
        text-decoration:none;
        width:10px;
        height:10px;
        background:url(img/obd/login/point.png);
        background-position:-10px 0px;
        float:left;
        z-index:100;
        /*position:absolute;*/
        left:50px;
        bottom:20px;
        margin-left:10px;
    }
    #main .on{
        background-position:0px 0px;
    }
    #main .autotab{
        position:absolute;
        /*z-index:200px;*/
        float:left;
        width:80px;
        height:27px;
        line-height:27px;
        margin:5px 0px 0px 28px;
        color: #c2c2c2;
        cursor:text;
    }

    #show{
        width:960px;
    }
    #show .top{
        width:794px;
        height:32px;
        background:url(img/obd/login/showbanner.png) no-repeat;
    }
    #show .content{
        width:794px;
        background-color:#ffffff;
        border:#cbcbcb solid;
        border-width:0px 1px 1px 1px;
    }
    #show .sidebox{
        width:160px;
        height: 356px;
        background-color:#ffffff;
        border:#cbcbcb 1px solid;
    }
    #show .boxd{
        display:block;
        width:99%;
        height:1px;
        background:url(img/obd/login/boxd.png) repeat-x;
    }
    #footer{
        width:100%;
        height:40px;
        line-height:40px;
        text-align:center;
    }
    #footer #f_copyright{
        font-family:arial;
        color:#a6a6a6;
    }
    #app-downloads {
        width: 960px;
    }
    #app-downloads .left, #app-downloads .right {
        float: left;
        width: 50%;
        position: relative;
        padding-top: 15px;
    }
    #app-downloads .left .android{
        position: relative;
        left: -4px;
        top: 0;
    }
    #app-downloads .right .ios{
        position: relative;
        left: 4px;
        top: 0;
    }
    #app-downloads .panel {
        height: 161px;
        width: 472px;
        background-image: url("./img/rcx_panel.jpg");
    }
    .clear {
        clear: both;
    }

    #app-downloads .p-l, #app-downloads .p-r {
        float: left;
    }
    #app-downloads .p-l {
        width: 290px;
    }
    #app-downloads .p-r {
        width: 182px;
        padding-top: 20px;
    }
    #app-downloads h3.title {
        font-size: 1.5em;
        line-height: 3em;
    }
    #app-downloads h3.title, #app-downloads p {
        margin: 0 20px 0 20px;
    }
    #app-downloads p {
        line-height: 2em;
    }
    a.btn-rcx-download {
        display: block;
        width: 154px;
        height: 34px;
        cursor: pointer;
        background-image: url("./img/rcx_btn_download.png");
    }
    a.btn-rcx-download:hover {
        background-position: 0 -34px;
    }
    a.img-wrap img {
        width : 121px;
        height: 121px;
        transition: all 0.3s;
        -webkit-transition: all 0.3s;
        -moz-transition: all 0.3s;
        -ms-transition: all 0.3s;
        -o-transition: all 0.3s;
    }
    a.img-wrap {
        cursor: pointer;
    }
    a.img-wrap:hover img{
        transform: scale(1.2);
        -webkit-transform: scale(1.2);
        -moz-transform: scale(1.2);
        -ms-transform: scale(1.2);
        -o-transform: scale(1.2);
        zoom: 1;
    }

    #topView {
        position:relative;
        left:0;
        top:0;
    }

    #bannerBackgrounds {
        position: absolute;
        left:0;
        top:0;
        z-index: -1;
        width: 100%;
        height: 360px; 
    }

    #main {
        position: relative;
        z-index: 9999;
        height: 360px;
    }

    #ad-player {
        width: 100%;
        height: 360px;
        position: absolute;
        left: 0;
        top: 0;
        z-index: 0;
    }
    #ad-player .ad-view {
        overflow: hidden;
        width: 100%;
        height: 100%;
        position: relative;
    }
    #ad-player .ad-view ul {
        list-style: none;
    }
    #ad-player .ad-view ul, #ad-player .ad-view li {
        margin: 0;
        padding: 0;
    }
    #ad-player .ad-item .banner-back {
        height: 360px;
        width: 100%;
        text-align: center;
    }
    #ad-player .ad-item .banner-back .banner-inner {
        height: 360px;
        width: 100%;
        margin: 0 auto;
    }
    #ad-player .ads-wrap {
        position: relative;
        transition: all 1s cubic-bezier(0, 0, 0.1, 1.0);
        -webkit-transition: all 1s cubic-bezier(0, 0, 0.1, 1.0);
        -moz-transition: all 1s cubic-bezier(0, 0, 0.1, 1.0);
        -ms-transition: all 1s cubic-bezier(0, 0, 0.1, 1.0);
        -o-transition: all 1s cubic-bezier(0, 0, 0.1, 1.0);
    }
    
    .test{
		color: rgb(102, 102, 102);
		display: block;
		font-size: 12px;
		font-style: normal;
		font-variant: normal;
		font-weight: normal;
		height: 40px;
		line-height: 40px;
		margin-bottom: 0px;
		margin-left: 0px;
		margin-right: 0px;
		margin-top: 0px;
		padding-bottom: 0px;
		padding-left: 0px;
		padding-right: 0px;
		padding-top: 0px;
		text-align: center;
		width: 1592px;
}
</STYLE>
<script language="JavaScript"> 
 if (window != top) 
 top.location.href = location.href; 
</script> 
<META name="GENERATOR" content="MSHTML 9.00.8112.16545"></HEAD>
<BODY onload="checkOpType()">

<?php 

    $uname ="";
	$passw = "";
    $op="";
	if(isset($_REQUEST["op"]))
	{
		$op=$_REQUEST["op"];
	}
	if($op=="cuslogin" or $op=="deplogin"){	
		if(isset($_POST['Hit_UserName']))
		{
			$uname = $_POST['Hit_UserName'];
			$passw = $_POST['Hit_PassWord'];
			if(isset($_POST['ckbSaveAccount'])){
			   $ckbSaveAccount = $_POST['ckbSaveAccount'];
			   if($ckbSaveAccount == 'on'){
			   setcookie('name',$uname,time()+3600);
			   setcookie('rememberAccount',$ckbSaveAccount,time()+3600);
			   }else{
			   setcookie('name',$uname,time()-3600);
			   setcookie('rememberAccount',$ckbSaveAccount,time()-3600);
			   }
			   }
			   
			   if(isset($_POST['ckbSavePwd'])){
			   $ckbSavePwd = $_POST['ckbSavePwd'];
			   if($ckbSavePwd == 'on'){
			   setcookie('password',$passw,time()+3600);
			   setcookie('rememberPass',$ckbSavePwd,time()+3600);
			   }else{
			   setcookie('password',$passw,time()-3600);
			   setcookie('rememberPass',$ckbSavePwd,time()-3600);
			   }
			   }			
			$passw = encrypt2($passw,0);	
		}	
			
	     $isCustomer=0;
	     if($op=="cuslogin"){
	     	$isCustomer=1;
	     }
	    mysql_select_db("IOV_demo");
//	    $mysql = "SELECT Users_Admin.username,Opm_User_Role.organId as depID,Users_Admin.userID,Opm_Organ.name,Opm_Organ.orderFlag,Users_Admin.smsNum,Users_Admin.email from Users_Admin,Opm_User_Role,Opm_Role,Opm_Organ where  Opm_Role.id=Opm_User_Role.roleID and Opm_User_Role.organId=Opm_Organ.id and  Users_Admin.userID=Opm_User_Role.userID and Opm_Role.type=12  and  Users_Admin.username='$uname' and Users_Admin.password='$passw'";
	     $mysql="SELECT  Users_Admin.username,Users_Admin.organId as depID,Users_Admin.userID,Users_Admin.smsNum,Users_Admin.email from Users_Admin where Users_Admin.username='$uname' and Users_Admin.password='$passw' and Users_Admin.isCustomer =$isCustomer";
		$result=mysql_query($mysql);
	  	$rownums=mysql_num_rows($result);
		$err = mysql_error ();
		if ($err) {
	    echo "query error" . $err;
	    
	   } 
	     else if($rownums>0) 
	   {
	   	 $userVo = mysql_fetch_object($result);
	   	 $userVo->passw=$_POST['Hit_PassWord'];
	   	 $data = array ();
	   	 $mysql="SELECT  res.name as resourceName  FROM   obd_Resource res,Opm_User_Role  our,  Opm_Role_Resource orr    where   our.roleId=orr.roleId   and  orr.resourceId= res.id  and  our.userID='".$userVo->userID."'";
		 $result=mysql_query($mysql);
	     $rownums=mysql_num_rows($result);
	     if($rownums>0) {
	     	while ($row = mysql_fetch_object($result)) {
			$data[] = $row->resourceName;
		}
	     }
		if($rownums>0){
			$flag=0;
			$userVo->resource=$data;
		}
		else{
			$flag=2;
		}
	     
	   }
	   else{
	   	  $flag=1;
	   }
	   $_SESSION["op"]=$op;
	   if($flag==0){
	   	$_SESSION["userVo"]=$userVo;
	   	$_SESSION["flag"]='0';
//	   	mysql_select_db("IOV_demo");
//	    $mysql = "SELECT Users_Admin.username,Opm_User_Role.organId as depID,Users_Admin.userID,Opm_Organ.name,Opm_Organ.orderFlag,Users_Admin.smsNum,Users_Admin.email from Users_Admin,Opm_User_Role,Opm_Role,Opm_Organ where  Opm_Role.id=Opm_User_Role.roleID and Opm_User_Role.organId=Opm_Organ.id and  Users_Admin.userID=Opm_User_Role.userID and Opm_Role.type=12  and  Users_Admin.username='$uname' and Users_Admin.password='$passw'";
//		$result=mysql_query($mysql);
//    	$rows = mysql_fetch_array($result);
    	
    	$time = date('y-m-d H:i:s',time());
    	$ip = $_SERVER["REMOTE_ADDR"];
	    $sql = "insert into Loginfo (UserID,Loginfo_type,LogIn_Time,LogOut_Time,Loginfo_IP) values ($userVo->userID,0,'$time','','$ip')";
        mysql_query($sql);
		$key = mysql_insert_id();
        $_SESSION["userKey"]=$key;
    	session_commit();  	
        header("Location: ./main/home.php");
        exit;
	   }
	   else {
	   		$_SESSION["flag"]=$flag;
	   		session_commit();
	   		header("Location: index.php");
	   }
	
	}
	
	

?>





<FORM id="form1" method="post" name="form1" action="index.php?op=deplogin">
<DIV><INPUT id="__VIEWSTATE" name="__VIEWSTATE" value="/wEPDwULLTEzNDY1Mjc1NDVkGAEFHl9fQ29udHJvbHNSZXF1aXJlUG9zdEJhY2tLZXlfXxYCBQ5ja2JTYXZlQWNjb3VudAUKY2tiU2F2ZVB3ZEcyz/HtipKX8rA8tfoK4VT25NpG" 
type="hidden"></DIV>
<DIV align="center">
<DIV id="top">
<TABLE class="classes" border="0" cellSpacing="0" cellPadding="0">
  <TBODY>
  <TR>
    <TD height="91"  style="text-align:left;"><IMG class="logo" align="middle" alt="logo" src="img/logo_shenzhen.png"></TD>
 <!--   <TD  valign='bottom'> <A href="javascript:void(0);" align="bottom">首页</A> |
    <A  href="javascript:void(0);" align="bottom">在线帮助</A> |
    <A href="#" align="bottom">产品介绍</A>
    </TD> -->
  </TR>
  </TBODY>
  </TABLE>
</DIV>
    
<DIV style="width: 100%; overflow-x: hidden; overflow-y: auto;" id="dvScroll">
<DIV id="topView">
<DIV id="ad-player">
<DIV class="ad-view">
<DIV style="top: 0px;" class="ads-wrap">
<UL>
<!--  <LI class="ad-item">
  <DIV style="background: rgb(69, 148, 223);" class="banner-back">
  <DIV style='background: url("img/banner01.png") top;' 
  class="banner-inner"></DIV></DIV></LI>
  
  <LI class="ad-item">
  <DIV style="background: rgb(69, 148, 223);" class="banner-back">
  <DIV style='background: url("img/banner02.png") top;' 
  class="banner-inner"></DIV></DIV></LI>  -->
  
  <LI class="ad-item">
  <DIV style="background: rgb(69, 148, 223);" class="banner-back">
  <DIV style='background: url("img/banner03.png") top;' 
  class="banner-inner"></DIV></DIV></LI>
 </UL></DIV></DIV></DIV>
  
<TABLE id="main" border="0" cellSpacing="0" cellPadding="0">
  <TBODY>
  <TR>
    <TD height="350" width="660" align="left">
      <TABLE style='background: url("img/obd/login/banner01.jpg") no-repeat; display: none;' 
      id="dvcontent" class="bannerimage" border="0" width="99%" height="98%">
        <TBODY>
        <TR>
          <TD height="100%" vAlign="bottom" width="100%"><SPAN style="width: 100%; margin-bottom: 20px; filter: alpha(Opacity=80); z-index: 1; opacity: 0.5; -moz-opacity: 0.5;" 
            id="barTitle"></SPAN></TD></TR></TBODY></TABLE></TD>
    <TD align="right">
      <DIV class="loginpanel">
      <TABLE border="0" cellSpacing="0" cellPadding="0" width="100%">
        <TBODY>
        <TR>
          <TD id="td_login1" class="sign_focus" onclick="muside(1)">公司帐号</TD>
          <TD id="td_login2" class="sign_href" 
        onclick="muside(2)">客户账号</TD></TR></TBODY></TABLE>
      <TABLE border="0" cellSpacing="0" cellPadding="0" width="100%">
        <TBODY>
        <TR>
          <TD height="10"></TD></TR>
        <TR>
          <TD height="35" align="left">
            <DIV class="divitem"><INPUT id="Hit_UserName" class="signput" name="Hit_UserName" 
            maxLength="20" type="text"  placeholder="用户名"  style="height:30px; value="" >
          <!--   <LABEL id="lblNameTip" 
            class="autotab">用户名</LABEL>  -->
            
            </DIV></TD></TR>
        <TR>
          <TD height="5"></TD>
        </TR>
        
        <TR >
          <TD height="35" align="left">
            <DIV class="divitem"  ><INPUT id="txtPwd" class="pwdput"  placeholder="密码" type="password" style="height:30px;"><INPUT 
            style="display: none;" id="Hit_PassWord" class="inputBorder" name="Hit_PassWord" 
            maxLength="20" type="text"  value="" >
         <!--   <LABEL id="lblPwdTip" class="autotab">密   码</LABEL>  -->
            </DIV></TD>
        </TR>
        
        <TR>
          <TD height="5"></TD></TR>
        <TR>
          <TD height="35" align="left">
            <DIV class="divitem"><INPUT id="txtVerify" class="visablecode" 
            title="验证码不区分大小写"   placeholder="验证码" name="txtVerify" maxLength="4" type="text">
          <!--   <LABEL id="lblVerifyTip" class="autotab">验证码</LABEL>  -->
            <DIV class="divverifyStyle"><SPAN style="color: rgb(255, 255, 255); font-size: 16px;" 
            id="divverify"></SPAN></DIV></DIV></TD></TR>
        <TR>
          <TD height="15"></TD></TR>
        <TR>
          <TD height="35" align="center">
            <TABLE border="0" cellSpacing="0" cellPadding="0" width="260">
              <TBODY>
              <tr>
              <?php 
	          if($_SESSION["flag"]==1)
	            echo "<span style='font-size:9.0pt;mso-bidi-font-size:12.0pt;color:#AE0000'>用户名或密码不正确</span>";
	             else if($_SESSION["flag"]==2)
	            echo "<span style='font-size:9.0pt;mso-bidi-font-size:12.0pt;color:#AE0000'>用户无权限</span>";
	         ?>
             </TR>   
                       
                       </TBODY></TABLE></TD></TR>
        <TR  style="width: 225px;" >
          <TD height="35"  style="text-align:center" ><A class="btnLogin"  style="margin-left:100px;" href="javascript:chkUserName();">登 
            录</A></TD></TR>
        <TR>
          <TD height="10"></TD></TR>
        <TR>
          <TD height="20" align="left"><SPAN 
            style="margin-left: 30px;">系统版本：[V1.0.7.03 Build 20150302]<LABEL id="version4s"></LABEL></SPAN></TD></TR></TBODY></TABLE></DIV></TD></TR></TBODY></TABLE></DIV>
<DIV style="width: 100%; height: 5px;"></DIV>
<TABLE id="show" border="0" cellSpacing="0" cellPadding="0">
  <TBODY>
  <TR>
    <TD width="800" align="left">
      <TABLE class="top" border="0" cellSpacing="0" cellPadding="0">
        <TBODY>
        <TR>
          <TD width="105" align="center"><STRONG style="color: rgb(78, 78, 78); font-size: 14px;">平台特色</STRONG></TD>
          <TD width="105" align="center"><STRONG 
            style="font-size: 14px;">相关资讯</STRONG></TD>
          <TD>&nbsp;</TD></TR></TBODY></TABLE>
      <TABLE class="content" border="0" cellSpacing="0" cellPadding="0">
        <TBODY>
        <TR>
          <TD height="6" width="100%" colSpan="3">&nbsp;</TD></TR>
        <TR>
          <TD width="30%">
            <TABLE border="0" cellSpacing="0" cellPadding="0" width="100%">
              <TBODY>
              <TR>
                <TD align="center"><IMG src="tmp/so1.png"></TD></TR>
              <TR>
                <TD height="30" align="center"><STRONG>全方位安全保障</STRONG></TD></TR>
              <TR>
                <TD align="center">故障报警、防盗报警、<BR>                              
                                        一键救援、安全出行</TD></TR></TBODY></TABLE></TD>
          <TD width="30%">
            <TABLE border="0" cellSpacing="0" cellPadding="0" width="100%">
              <TBODY>
              <TR>
                <TD align="center"><IMG src="tmp/so2.png"></TD></TR>
              <TR>
                <TD height="30" align="center"><STRONG>移动互联汽车生活</STRONG></TD></TR>
              <TR>
                <TD align="center">保养攻略、车生活资讯、周边服务<BR>                         
                                             轻松一点、体验精彩车生活</TD></TR></TBODY></TABLE></TD>
          <TD width="40%">
            <TABLE border="0" cellSpacing="0" cellPadding="0" width="100%">
              <TBODY>
              <TR>
                <TD align="center"><IMG src="tmp/so3.png"></TD></TR>
              <TR>
                <TD height="30" 
              align="center"><STRONG>车主、4S沟通零距离</STRONG></TD></TR>
              <TR>
                <TD align="center">保养、年检、续保，到期提醒、服务预约、<BR>                     
                                                 
            问题反馈，促销活动，第一时间让您掌握</TD></TR></TBODY></TABLE></TD></TR>
        <TR>
          <TD height="15" width="100%" colSpan="3" align="center"><SPAN class="boxd"></SPAN></TD></TR>
        <TR>
          <TD width="30%">
            <TABLE border="0" cellSpacing="0" cellPadding="0" width="100%">
              <TBODY>
              <TR>
                <TD align="center"><IMG src="tmp/so4.png"></TD></TR>
              <TR>
                <TD height="30" align="center"><STRONG>养车用车智能化</STRONG></TD></TR>
              <TR>
                <TD align="center">故障报警、防盗报警、<BR>                              
                                        一键救援、安全出行</TD></TR></TBODY></TABLE></TD>
          <TD width="30%">
            <TABLE border="0" cellSpacing="0" cellPadding="0" width="100%">
              <TBODY>
              <TR>
                <TD align="center"><IMG src="tmp/so5.png"></TD></TR>
              <TR>
                <TD height="30" 
              align="center"><STRONG>融合、开放、价值、共赢</STRONG></TD></TR>
              <TR>
                <TD align="center">保养攻略、车生活资讯、周边服务<BR>                         
                                             轻松一点、体验精彩车生活</TD></TR></TBODY></TABLE></TD>
          <TD width="40%">
            <TABLE border="0" cellSpacing="0" cellPadding="0" width="100%">
              <TBODY>
              <TR>
                <TD align="center"><IMG src="tmp/so6.png"></TD></TR>
              <TR>
                <TD height="30" align="center"><STRONG>车联网大数据挖掘</STRONG></TD></TR>
              <TR>
                <TD align="center">保养、年检、续保，到期提醒、服务预约、<BR>                     
                                                 
            问题反馈，促销活动，第一时间让您掌握</TD></TR></TBODY></TABLE></TD>
        <TR>
          <TD height="6" width="100%" 
colSpan="3">&nbsp;</TD></TR></TBODY></TABLE></TD>
    <TD align="right">
      <TABLE class="sidebox" border="0" cellSpacing="0" cellPadding="0">
        <TBODY>
        <TR>
          <TD style="font-weight: bold;" height="32" vAlign="middle" align="center">微信公众号</TD></TR>
        <TR>
          <TD height="158" align="center"><IMG alt="贝尔加" src="tmp/getqrcode1.bmp" 
            width="138" height="138"></TD></TR>
        <TR>
          <TD style="padding-right: 15px; padding-left: 15px;" 
            vAlign="top">面向4S店及车主OBD应用的车联网云服务解决方案，关注贝尔加微信服务号就可以体验了。              
                                  </TD></TR></TBODY></TABLE></TD></TR></TBODY></TABLE>
<DIV id="app-downloads">
<DIV class="clear"></DIV>
<DIV class="left">
<DIV class="panel android">
<DIV class="p-l">
<H3 class="title">Android版</H3>
<P>在安智市场搜索"贝尔加"下载</P>
<P>贝尔加安卓版</P><A class="btn-rcx-download" href="#"></A></DIV>
<DIV class="p-r"><A class="img-wrap" href="javascript:void(0);"><IMG alt="android" 
src="tmp/android_down1.png"></A></DIV></DIV></DIV>
<DIV class="right">
<DIV class="panel ios">
<DIV class="p-l">
<H3 class="title">iPhone版</H3>
<P>iPhone在AppStore搜索"贝尔加" 下载</P>
<P>贝尔加iOS版</P><A class="btn-rcx-download" href="#"></A></DIV>
<DIV class="p-r"><A class="img-wrap" href="javascript:void(0);"><IMG alt="ios" 
src="tmp/ios_down1.png"></A></DIV></DIV></DIV>
<DIV class="clear"></DIV></DIV>
<DIV id="footer" class="test"><SPAN id="f_copyright">©</SPAN> Copyright 2010-2014
<!-- anydata.com 
<A style="padding-right: 3px; padding-left: 3px;" href="www.dzzcgs.com/">-关于我们</A>  -->
</DIV></DIV></DIV><INPUT id="cmd" name="cmd" type="hidden"><INPUT 
id="hidverify" name="hidverify" type="hidden"><INPUT id="hidMac" name="hidMac" 
type="hidden"><INPUT id="saveCookie" name="saveCookie" type="hidden"><INPUT id="hid_DeviceLogin" 
name="hid_DeviceLogin" type="hidden"><INPUT id="refBack" name="refBack" value="Login4S.aspx" 
type="hidden"><INPUT id="Hidden1" name="Hidden1" value="0" type="hidden"><INPUT 
id="hid_bodyh" name="hid_bodyh" type="hidden"><INPUT id="hid_IsCustom" name="hid_IsCustom" 
type="hidden"><!-- 是否定制客户 --><INPUT id="hid_PageStyle" name="hid_PageStyle" 
type="hidden"><!-- 页面样式 --><INPUT id="hid_LoginHide" name="hid_LoginHide" type="hidden"><!-- 隐藏版块 --><INPUT 
id="hid_OperHoldID" name="hid_OperHoldID" type="hidden"><!-- 云平台用户ID --></FORM>
<SCRIPT language="javascript" type="text/javascript" src="tmp/jquery-1.4-min.js"></SCRIPT>

<SCRIPT language="javascript" type="text/javascript">
        
        
       function checkOpType(){
       	var op= '<?php echo  $_SESSION["op"] ?>';
       	if(op=='cuslogin')
        	muside(2);
        	else
        	muside(1);
        }
       
        
    function chkUserName() {
        var tipName = "用户名";
        if ($("#td_login2").attr("className") == "sign_focus") {
            tipName = "设备识别号";
            $("#hid_DeviceLogin").val("1");
        } else {
            $("#hid_DeviceLogin").val("0");
        }
        document.getElementById("Hit_PassWord").value = document.getElementById("txtPwd").value;
        if (document.getElementById("Hit_UserName").value == "") {
            alert(tipName + "不能为空，请输入" + tipName + "!");
            document.getElementById("Hit_UserName").focus();
        } else {
            if (document.getElementById("Hit_PassWord").value == "") {
                alert("密码不能为空，请输入密码!");
                document.getElementById("Hit_PassWord").focus();
            } else {
        
            	
                if (document.getElementById("txtVerify").value == document.getElementById("hidverify").value) {
                    var saveAccountCookie = "";
//                    if (document.getElementById("ckbSaveAccount").checked) {
//                        saveAccountCookie += "1";
//                    } else {
//                        saveAccountCookie += "0";
//                    }
//                    saveAccountCookie += ",";
//                    if (document.getElementById("ckbSavePwd").checked) {
//                        saveAccountCookie += "1";
//                    } else {
//                        saveAccountCookie += "0";
//                    }
                    document.getElementById("saveCookie").value = saveAccountCookie;
                    $("#hid_bodyh").val($(window).height());
                    document.getElementById("cmd").value = "login";
                    document.form1.submit();
                } else {
                    alert("请输入有效的验证码！");
                }
            }
        }
    }
    function muside(cmd) {
        if (cmd == 1) {
            $("#td_login1").attr("className", "sign_focus");
            $("#td_login2").attr("className", "sign_href");
            $("#spIdTitle").html("用户名：");
            $("#form1").attr("action","index.php?op=deplogin");
        } else {
            $("#td_login1").attr("className", "sign_href");
            $("#td_login2").attr("className", "sign_focus");
            $("#spIdTitle").html("设备识别号：");
            $("#form1").attr("action","index.php?op=cuslogin");
        }
    }
    document.onkeydown = function () {
        if (event.keyCode == 13) {
            chkUserName();
        }
    }
    document.getElementById("Hit_UserName").focus();
    document.getElementById("txtPwd").value = document.getElementById("Hit_PassWord").value;
    if (document.getElementById("txtPwd").value.length > 0) {
        document.getElementById("ckbSavePwd").checked = true;
    }
    $("#lblNameTip").click(function () {
        $("#lblNameTip").hide();
        $("#Hit_UserName").focus();
    });
    $("#Hit_UserName").keyup(function () {
        $("#lblNameTip").hide();
    });
    $("#Hit_UserName").focus(function () {
        $("#lblNameTip").hide();
    });
    $("#Hit_UserName").blur(function () {
        if ($.trim($("#Hit_UserName").val()).length == 0) {
            $("#lblNameTip").show();
        }
    });
    $("#lblPwdTip").click(function () {
        $("#lblPwdTip").hide();
        $("#txtPwd").focus();
    });
    $("#txtPwd").focus(function () {
        $("#lblPwdTip").hide();
    });
    $("#txtPwd").blur(function () {
        if ($.trim($("#txtPwd").val()).length == 0) {
            $("#lblPwdTip").show();
        }
    });
    $("#lblVerifyTip").click(function () {
        $("#lblVerifyTip").hide();
        $("#txtVerify").focus();
    });
    $("#txtVerify").focus(function () {
        $("#lblVerifyTip").hide();
    });
    $("#txtVerify").blur(function () {
        if ($.trim($("#txtVerify").val()).length == 0) {
            $("#lblVerifyTip").show();
        }
    });
    if ($("#Hit_UserName").val().length > 0) {
        $("#lblNameTip").hide();
    }
    if ($("#txtPwd").val().length > 0) {
        $("#lblPwdTip").hide();
    }
    if ($("#txtVerify").val().length > 0) {
        $("#lblVerifyTip").hide();
    }

    //为了让顶部固定，再说，这个登陆页，顶部需要固定么？除了制作内部系统之类的“框架”，千万别乱用js做自适应布局，注释掉!
    //function mysize() {
    //    $("#dvScroll").height($(window).height() - 71);
    //}

    //$(window).resize(function () {
    //    mysize();
    //});

    //mysize();

    function checkBrowser() {
        var Sys = {};
        var ua = navigator.userAgent.toLowerCase();
        var s;
        (s = ua.match(/msie ([\d.]+)/)) ? Sys.ie = s[1] :
        (s = ua.match(/firefox\/([\d.]+)/)) ? Sys.firefox = s[1] :
        (s = ua.match(/chrome\/([\d.]+)/)) ? Sys.chrome = s[1] :
        (s = ua.match(/opera.([\d.]+)/)) ? Sys.opera = s[1] :
        (s = ua.match(/version\/([\d.]+).*safari/)) ? Sys.safari = s[1] : 0;
        var vis = "";
        if (Sys.ie) vis = 'IE-' + Sys.ie;
        if (Sys.firefox) vis = 'Firefox-' + Sys.firefox;
        if (Sys.chrome) vis = 'Chrome-' + Sys.chrome;
        if (Sys.opera) vis = 'Opera-' + Sys.opera;
        if (Sys.safari) vis = 'Safari-' + Sys.safari;
        return vis;
    }
    function RandomNum(num) {
        var listChar = "0,1,2,3,4,5,6,7,8,9";
        var arrayChar = listChar.split(',');
        listChar = "";
        for (var i = 0; i < num; i += 1) {
            var mr = Math.random();
            mr = Math.round(9 * mr);
            listChar = listChar + arrayChar[mr];
        }
        return listChar;
    }
    function refearVisibleCode() {
        var varverify = RandomNum(4);
        document.getElementById("divverify").innerHTML = varverify;
        document.getElementById("hidverify").value = varverify;
    }
    refearVisibleCode();
    document.getElementById("divverify").onclick = function () {
        refearVisibleCode();
    }
    //var pad = 1, lastPad = 1;
    //function purduce() {
    //    var baseUrl = "http://wshare.u12580.com/img/4s12580/login/banner0";
    //    $("#bannerBackgrounds").css("background", "#fff top center url('" + baseUrl + pad.toString() + ".jpg')");
    //    if (pad < 3) {
    //        pad += 1;
    //    } else {
    //        pad = 1;
    //    }
    //    setTimeout(purduce, 3000);
    //    //    $("#img_banner" + lastPad).hide();
    //    //    $("#img_banner" + pad).fadeIn("slow");
    //    //    lastPad = pad;
    //    //    if(pad<3){
    //    //        pad+=1;
    //    //    }else{
    //    //        pad=1;
    //    //    }
    //    //    setTimeout("purduce()", 3000);
    //}
    //purduce();
    var pad = 0;
    function autoPlay() {
        pad = (pad + 1) % [].slice.call($(".ads-wrap li.ad-item"), 0).length;
        $(".ads-wrap").css({
            "top": "-" + pad * $(".ads-wrap li.ad-item").height() + "px"
        });
        setTimeout(autoPlay, 4000);
    }
    setTimeout(autoPlay, 4000);
</SCRIPT>
</BODY>
<?php 
 
//加密，解密处理；
function encrypt2($str,$opt){
//		return $str;
		$aes = new AES(true);// 把加密后的字符串按十六进制进行存储
		$key = "anydata_lbs_aes_key";// 密钥
		$keys = $aes->makeKey($key);
		$returnStr = "111111";
		//0:加密 1：解密
		if($opt==0){
			$returnStr = $aes->encryptString($str, $keys);				//加密
		}else{
			$returnStr = $aes->decryptString($str, $keys);				//解密
		}
		return $returnStr;
}
?>

</HTML>
