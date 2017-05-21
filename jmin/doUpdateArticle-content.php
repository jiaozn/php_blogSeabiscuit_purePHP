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
		if(!isset($_POST["art_id"])){
			exit('<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
			<h1 class="page-header">没有获取到$art_id!</h1></div>'); 
		}
		$art_id=$_POST["art_id"];
		$art_content=isset($_POST["content"])?$_POST['content']:'这是忘记写正文了么...';
		$art_title=isset($_POST["art_title"])?$_POST['art_title']:'一定是题目往写了...';
		$art_categoryid=isset($_POST["art_categoryid"])?$_POST['art_categoryid']:0;
		$art_updatetime=date('Y-m-d H:i:s',time());
		$art_tags=trim($_POST['art_tags']);
		
		$old_art_categoryid=isset($_POST["old_art_categoryid"])?$_POST['old_art_categoryid']:0;
		$old_art_tagtitles=isset($_POST["old_art_tagtitlearray"])?$_POST['old_art_tagtitlearray']:0;
		$old_art_tagtitlearray=explode(',',$old_art_tagtitles);
		//S文章更新
		$sql="update article set art_title=?,art_content=?,art_categoryid=?,art_updatetime=? where art_id=?";
		$stmt=$mysqli->prepare($sql);
		$stmt->bind_param("ssisi", $art_title, $art_content,$art_categoryid,$art_updatetime,$art_id);
		$stmt->execute();
		$stmt->close();
		//E文章插入
		
		//S分类处理
		if($old_art_categoryid!=$art_categoryid){
			//S新分类文章数增1
		$sql="update category set cat_artnum=cat_artnum+1 where cat_id=?";
		$stmt=$mysqli->prepare($sql);
		$stmt->bind_param("i", $art_categoryid);
		$stmt->execute();
		$stmt->close();
			//E新分类文章数增1
			//S旧分类文章数减1
			$sql="update category set cat_artnum=cat_artnum-1 where cat_id=?";
			$stmt=$mysqli->prepare($sql);
			$stmt->bind_param("i", $old_art_categoryid);
			$stmt->execute();
			$stmt->close();
			//E旧分类文章数减1
		}
		//E分类处理
		
		//Stag处理
	
		
		if($art_tags!=null && strlen($art_tags)!=0){
			$tags_array=explode(",",$art_tags);
			$tagsadd_array=array_diff($tags_array,$old_art_tagtitlearray);//这是新增的tag
			$tagssub_array=array_diff($old_art_tagtitlearray,$tags_array);//这是减少的tag
			$tagg_id;
			foreach($tagsadd_array as $tag){//这个循环处理新增的tag
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
				$sql3="insert into article_tag_access(atc_artid,atc_tagid) values(?,?)";
				$stmt=$mysqli->prepare($sql3);
				$stmt->bind_param('ii',$art_id,$tagg_id);
				$stmt->execute();
				$stmt->close();
			}
			foreach($tagssub_array as $tag){//这个循环处理删除的tag
				$sql="select tag_id from tag where tag_title='$tag'";
				$tagrow=$mysqli->query($sql)->fetch_row();//这个tagid肯定是存在的
					$tagg_id=$tagrow[0];
					$sql2="update tag set tag_artnum=tag_artnum-1 where tag_id=?";
					$stmt=$mysqli->prepare($sql2);
					$stmt->bind_param('s',$tagg_id);
					$stmt->execute();
					$stmt->close();
				$sql3="delete from article_tag_access where atc_artid=? and atc_tagid=?";
				$stmt=$mysqli->prepare($sql3);
				$stmt->bind_param('ii',$art_id,$tagg_id);
				$stmt->execute();
				$stmt->close();
			}
		}
		//Etag处理
		echo "更新成功！".$art_id;

	
	?>
	
			</h1></div>
