<?php
	if(!defined('jiaosys')) { 
exit('<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
			<h1 class="page-header">禁止访问</h1></div>'); 
}
	if(!isset($_SESSION['vip']) || $_SESSION['vip']!='javaj'){
		exit('<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
			<h1 class="page-header">请登录<a href="jmin.php">登录</a></h1></div>');
	}
?>
		 <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
				<div class="jumbotron">
				  <h1>Command me!</h1>
				  <p>仰天大笑出门去，我辈岂是蓬蒿人</p>
				</div>
			 
		 </div>








