	<?php
		date_default_timezone_set('prc');
	
	//S为了计算页面加载时间-结束位于footer
		$start = microtime();
	//S为了计算页面加载时间-结束位于footer
	
	//S来访记录

	if ($_SERVER['REMOTE_ADDR']) {//判断SERVER里面有没有ip，因为用户访问的时候会自动给你网这里面存入一个ip
			$from = $_SERVER['REMOTE_ADDR'];
			} elseif (getenv("REMOTE_ADDR")) {//如果没有去系统变量里面取一次 getenv()取系统变量的方法名字
			$from = getenv("REMOTE_ADDR");
			} elseif (getenv("HTTP_CLIENT_IP")) {//如果还没有在去系统变量里取下客户端的ip
			$from = getenv("HTTP_CLIENT_IP");
			} else {
			$from = "unknown";
			}
	$to='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	$time=date('Y-m-d H:i:s',time());
	$sql="insert into log(log_from,log_to,log_createtime) values ('$from','$to','$time')";
	$mysqli->query($sql);
	//E来访记录
	?>
<!DOCTYPE html>
<html>  
<head>  
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />  
    <meta name="keywords"           content="" />  
    <meta name="description"        content="" />
    <title>奔腾年代博客</title>  
</head>
<body>
	<h1><a href="index.php">奔腾年代</a></h1>


	<hr>