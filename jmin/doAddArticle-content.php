	<!--0.功能
				需要数据库-->
	<?php

			date_default_timezone_set('prc');
		require_once("dbcon.php");
	if(!defined('jiaosys')) { 
exit('<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
			<h1 class="page-header">禁止访问</h1></div>'); 
}
	if(!isset($_SESSION['vip']) || $_SESSION['vip']!='javaj'){
		exit('<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
			<h1 class="page-header">请登录<a href="jmin.php">登录</a></h1></div>');
	}
		$art_content=isset($_POST["content"])?$_POST['content']:'这是忘记写正文了么...';
		$art_title=isset($_POST["art_title"])?$_POST['art_title']:'一定是题目往写了...';
		$art_categoryid=isset($_POST["art_categoryid"])?$_POST['art_categoryid']:0;
		$art_createtime=date('Y-m-d H:i:s',time());
		$art_tags=trim($_POST['art_tags']);
		//S文章插入
		$sql="insert into article(art_title,art_content,art_categoryid,art_createtime) values(?,?,?,?)";
		$stmt=$mysqli->prepare($sql);
		$stmt->bind_param("ssis", $art_title, $art_content,$art_categoryid,$art_createtime);
		$stmt->execute();
		$newart_id=$stmt->insert_id;
		$stmt->close();
		//E文章插入
		
		//S分类处理
		$sql="update category set cat_artnum=cat_artnum+1 where cat_id=?";
		$stmt=$mysqli->prepare($sql);
		$stmt->bind_param("i", $art_categoryid);
		$stmt->execute();
		$stmt->close();
		//E分类处理
		
		//Stag处理
		if($art_tags!=null && strlen($art_tags)!=0){
			$tags_array=explode(",",$art_tags);
			$tagg_id;
			foreach($tags_array as $tag){
				$sql="select tag_id from tag where tag_title='$tag'";
				$tagrow=$mysqli->query($sql)->fetch_row();
				if($tagrow[0]==0){
					$sql2="insert into tag(tag_title,tag_artnum) values(?,1)";
					$stmt=$mysqli->prepare($sql2);
					$stmt->bind_param('s',$tag);
					$stmt->execute();
					$tagg_id=$stmt->insert_id;
					$stmt->close();
				}else{
					$tagg_id=$tagrow[0];
					$sql2="update tag set tag_artnum=tag_artnum+1 where tag_id=?";
					$stmt=$mysqli->prepare($sql2);
					$stmt->bind_param('s',$tagg_id);
					$stmt->execute();
					$stmt->close();
				}
				var_dump($tagg_id);
				$sql3="insert into article_tag_access(atc_artid,atc_tagid) values(?,?)";
				$stmt=$mysqli->prepare($sql3);
				$stmt->bind_param('ii',$newart_id,$tagg_id);
				$stmt->execute();
				$stmt->close();
			}
		}
		//Etag处理
		echo '<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
			<h1 class="page-header">新增成功！'.$newart_id.'</h1></div>';
		
	
	?>
	
	
