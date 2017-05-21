	<?php
	session_start();
	date_default_timezone_set('prc');
	require_once("dbcon.php");
	
	$uname=isset($_POST['uname'])?$_POST['uname']:'';
	$password=isset($_POST['upassword'])?$_POST['upassword']:'';
	$password2=isset($_POST['upassword2'])?$_POST['upassword2']:'';
	
	
	
	if ($_SERVER['REMOTE_ADDR']) {//判断SERVER里面有没有ip，因为用户访问的时候会自动给你网这里面存入一个ip
			$from = $_SERVER['REMOTE_ADDR'];
			} elseif (getenv("REMOTE_ADDR")) {//如果没有去系统变量里面取一次 getenv()取系统变量的方法名字
			$from = getenv("REMOTE_ADDR");
			} elseif (getenv("HTTP_CLIENT_IP")) {//如果还没有在去系统变量里取下客户端的ip
			$from = getenv("HTTP_CLIENT_IP");
			} else {
			$from = "unknown";
			}
	$time=date('Y-m-d H:i:s',time());
	$sql="select count(log_createtime) from login_failure where failure_from='$from' and '$time'-log_createtime<360";
	$failrow=$mysqli->query($sql)->fetch_row();
	$failnum=$failrow[0];
	if($failnum>3){
		exit('你是黑客么兄弟...');
	}else{
		$sql="select count(uid) from admin_user where uname=? and password=? and password2=?";
		$stmt=$mysqli->prepare($sql);
		$stmt->bind_param('sss',$uname,$password,$password2);
				$stmt->execute();
				$stmt->bind_result($unum);
				$stmt->fetch();
				$stmt->free_result();
				$stmt->close();
				if($unum<1){
					if($uname!=''){
					echo ('<div class="warning">用户名或密码错误</div>');
					$sql="insert into login_failure(failure_from,log_createtime) values('$from','$time')";
					$failrow=$mysqli->query($sql);
					}
				}else{
					$_SESSION['vip']='javaj';
					echo "欢迎登录！<a href='addArticle.php'>管理</a>";
				}
	}
	$sql="insert into login_failure(failure_from,failure_createtime) values ('$from','$time')";
	$mysqli->query($sql);
	

?>
<!DOCTYPE HTML>
<html lang="en-US">

<head>
    <meta charset="UTF-8">
    <title>后台管理</title>
	<link rel="stylesheet" href="ueditor/jmin.css" type="text/css" >
</head>
<body>
<div id="loginbar">
<form action="jmin.php" method="post">
<div class="oneline">	姓名：<input type="text" name="uname" ></div>
	<div class="oneline">密码：<input type="password" name="upassword" > </div>
	<div class="oneline">口令：<input type="text" name="upassword2" ></div>
	<div class="oneline"><input type="submit" value="登录" ></div>
	
</form>
</div>
</body>
</html>	
