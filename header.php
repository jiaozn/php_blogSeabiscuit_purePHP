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
	<link rel="stylesheet" href="style.css" type="text/css" media="screen and (min-device-width:900px)" >
	<link rel="stylesheet" href="stylesm.css" type="text/css" media="screen and (max-device-width:900px)" >
	<link href="fa/css/font-awesome.min.css" rel="stylesheet" />
	<link id="favicon" href="favicon.ico" rel="icon" type="image/x-icon" />
    <title>奔腾年代博客</title>  
</head>
<body onclick="hMS()">
	<div class="redback" id="hdr">
		<div id="title">
			<a href="index.php" rel="index">
					<h1>奔腾年代</h1>
			</a>
		</div>
		<div id="smenu">
					<i class="fa fa-bars fa-2x fa-fw" onclick="smenu(event)"></i>
					<i class="fa fa-search fa-2x fa-fw" onclick="ssearch(event)"></i>
		</div>
		<div id="nav">
					<ul>
						<li>
								<a href="index.php" >
								<div class="navmain">博客</div>
								<div class="navsub">BLOG</div>
								</a>
						</li>
						
						<li>
								<a href="about.php">
								<div class="navmain">留言</div>
								<div class="navsub">ABOUT</div>
								</a>
						</li>
						
					</ul>
		</div>
		<div id="nav2">
					<ul>
						<li>
								<a href="index.php" >
								<div class="navmain2">博客</div>
								<div class="navsub2">BLOG</div>
								</a>
						</li>
						
						<li>
								<a href="about.php">
								<div class="navmain2">留言</div>
								<div class="navsub2">ABOUT</div>
								</a>
						</li>
						
					</ul>
		</div>
	</div>
	
