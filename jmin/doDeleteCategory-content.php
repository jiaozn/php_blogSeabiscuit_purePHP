	<!--0.功能
				需要数据库-->
				<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
			<h1 class="page-header">
	<?php
				date_default_timezone_set('prc');
		if(!defined('jiaosys')) { 
exit('<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
			<h1 class="page-header">禁止访问</h1></div>'); 
}
	if(!isset($_SESSION['vip']) || $_SESSION['vip']!='javaj'){
		exit('<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
			<h1 class="page-header">请登录<a href="jmin.php">登录</a></h1></div>');
	}
		require_once("dbcon.php");
		if(!isset($_GET["cat_id"])){
			exit('<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
			<h1 class="page-header">没有获取到$cat_id!</h1></div>'); 
		}
		$cat_id=$_GET["cat_id"];
		
		if($cat_id==1){
			exit('默认分类不能删除！');
		}
		//S更新属于这个cat的所有文章为默认分类及catid=1
		$sql="update article set art_categoryid=1 where art_categoryid=?";
		$stmt=$mysqli->prepare($sql);
		$stmt->bind_param("i", $cat_id);
		$stmt->execute();
		$stmt->close();
		//E更新属于这个cat的所有文章为默认分类及catid=1
		
		//S删除该cat
		$sql="delete from category where cat_id=?";
		$stmt=$mysqli->prepare($sql);
		$stmt->bind_param("i", $cat_id);
		$stmt->execute();
		$stmt->close();
		//E删除该cat
		
		echo "删除成功！".$cat_id;
		
	
	?>
	
	</h1></div>
