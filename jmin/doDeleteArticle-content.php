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
		if(!isset($_GET["blog"])){
			exit('<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
			<h1 class="page-header">没有获取到$art_id!</h1></div>'); 
		}
		$art_id=$_GET["blog"];
		$deltagarr;
			//S获取文章分类id
		$sql="select art_categoryid from article where art_id=?";
		$stmt=$mysqli->prepare($sql);
		$stmt->bind_param("i", $art_id);
		$stmt->execute();
		$stmt->bind_result($art_categoryid);
		$stmt->fetch();
		$stmt->free_result();
		$stmt->close();
			//E获取文章分类id
			//S获取文章tagid
		$sql="select atc_tagid from article_tag_access where atc_artid=?";
		$stmt=$mysqli->prepare($sql);
		$stmt->bind_param("i", $art_id);
		$stmt->execute();
		$stmt->bind_result($atc_tagid);
		$i=0;
		while($stmt->fetch()){
			$deltagarr[$i]=$atc_tagid;
		}
		$stmt->free_result();
		$stmt->close();
			//E获取文章tagid

			
		//S文章删除
		$sql="delete from article where art_id=?";
		$stmt=$mysqli->prepare($sql);
		$stmt->bind_param("i",$art_id);
		$stmt->execute();
		$stmt->close();
		//E文章删除
		
		//S分类处理
			//S分类文章数减1
			$sql="update category set cat_artnum=cat_artnum-1 where cat_id=?";
			$stmt=$mysqli->prepare($sql);
			$stmt->bind_param("i", $art_categoryid);
			$stmt->execute();
			$stmt->close();
			//E分类文章数减1
		//E分类处理
		
		//Stag处理
		foreach($deltagarr as $deltagid){
				$sql2="update tag set tag_artnum=tag_artnum-1 where tag_id=?";
					$stmt=$mysqli->prepare($sql2);
					$stmt->bind_param('i',$deltagid);
					$stmt->execute();
					$stmt->close();
				$sql3="delete from article_tag_access where atc_artid=? and atc_tagid=?";
				$stmt=$mysqli->prepare($sql3);
				$stmt->bind_param('ii',$art_id,$deltagid);
				$stmt->execute();
				$stmt->close();
		}
		//Etag处理
		echo "删除成功！".$art_id;
		
	
	?>
	
	</h1></div>
