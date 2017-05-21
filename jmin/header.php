<?php 
session_start();
define('jiaosys', TRUE);
//S为了计算页面加载时间-结束位于footer
		$start = microtime();
	//S为了计算页面加载时间-结束位于footer?>

<!DOCTYPE HTML>
<html lang="en-US">

<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title>后台管理</title>
	<link rel="icon" href="../favicon.ico">
	<!--<link rel="stylesheet" href="jmin.css" type="text/css" > -->
	<!-- Bootstrap core CSS -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="bootstrap/assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="bootstrap/dashboard.css" rel="stylesheet">
	<style type="text/css">
		#utime{
			display:inline-block;
			position:fixed;
			z-index:10000;
			top:1.5em;
			color:#999;
			left:15em;
		}
	</style>
 
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
 <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="overview.php"> <span class="glyphicon glyphicon-knight"></span> 奔腾年代-后台管理</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="../index.php" target="_blank"><span class="glyphicon glyphicon-home"></span> 前台首页</a></li>
            <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> 退出登录</a></li>
          </ul>
        </div>
      </div>
    </nav>