<?php
	if(!defined('jiaosys')) { 
exit('<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
			<h1 class="page-header">禁止访问</h1></div>'); 
}
	if(!isset($_SESSION['vip']) || $_SESSION['vip']!='javaj'){
		exit('<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
			<h1 class="page-header">请登录<a href="jmin.php">登录</a></h1></div>');
	}
	$sql="select cat_id,cat_title,cat_artnum from category";
				$stmt=$mysqli->prepare($sql);
				$stmt->execute();
				$stmt->bind_result($cat_id,$cat_title,$cat_artnum);
				$cat=0;
				while ($stmt->fetch()) {
				$cat_array[$cat]['cat_id']=$cat_id;
				$cat_array[$cat]['cat_title']=$cat_title;
				$cat_array[$cat]['cat_artnum']=$cat_artnum;
				$cat++;
				}
				$stmt->free_result();
				$stmt->close();
	//S获取文章内容
	$blog=$_GET['blog'];
	$sql="select * from article where art_id=?";
	$stmt=$mysqli->prepare($sql);
	$stmt->bind_param('i',$blog);
	$stmt->execute();
	$stmt->bind_result($art_id,$art_title,$art_content,$art_categoryid,$art_hot,$art_createtime,$art_updatetime);
	$stmt->fetch();
	$stmt->free_result();
	$stmt->close();
//E获取文章内容	

//S获取关键字
	$sql="select group_concat(atc_tagid),group_concat(tag_title),group_concat(tag_artnum) from article_tag_access left join tag on atc_tagid=tag_id where atc_artid=?";
	$stmt=$mysqli->prepare($sql);
	$stmt->bind_param('i',$blog);
	$stmt->execute();
	$stmt->bind_result($act_tagid_array,$tag_title_array,$tag_artnum_array);
	$stmt->fetch();
	$tag['tag_id']=explode(',',$act_tagid_array);
	$tag['tag_title']=explode(',',$tag_title_array);
	$tag['tag_artnum']=explode(',',$tag_artnum_array);
	$stmt->free_result();
	$stmt->close();
//E获取关键字

//S获取分类
	$sql="select cat_title from category where cat_id='$art_categoryid'";
	$row=$mysqli->query($sql)->fetch_row();
	$cat_title=$row[0];
//S获取分类			
				
				
?>
		 <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
			<h1 class="page-header">修改日志</h1>
				<div id="content row placeholders">
					<div class="panel panel-default">
						<div class="panel-heading">
						  <h3 class="panel-title">Panel title</h3>
						</div>
						<div class="panel-body">
						  <form action="doUpdateArticle.php" method="post">
								<input type="hidden" name="art_id" value="<?php echo $art_id;?>">
								<input type="hidden" name="old_art_categoryid" value="<?php echo $art_categoryid;?>">
								<input type="hidden" name="old_art_tagtitlearray" value="<?php echo $tag_title_array;?>">
								<div class="oneline">
									<div class="input-group">
										<span class="input-group-addon" id="basic-addon1" >标题</span>
										<input type="text" name="art_title" class="form-control" value="<?php echo $art_title;?>">
									</div>
								</div>
								
								
								<!-- 加载编辑器的容器 -->
								<script id="container" name="content" type="text/plain"><?php echo $art_content;?></script>
								<div class="oneline">分类：<select name="art_categoryid" class="inli">
																<?php
																foreach($cat_array as $cat){
																	if($cat['cat_id']==$art_categoryid){
																		printf("<option value='%d' selected='selected'>%s(%s)</option>",$cat['cat_id'],$cat['cat_title'],$cat['cat_artnum']);
																	}else{
																		printf("<option value='%d'>%s(%s)</option>",$cat['cat_id'],$cat['cat_title'],$cat['cat_artnum']);
																	}
																	
																}
																?>
															</select>
								</div>
								<div class="input-group">
										<span class="input-group-addon" id="basic-addon1" >关键字</span>
										<input type="text" name="art_tags" class="form-control" value="<?php echo $tag_title_array;?>">
								</div>
								<div class="oneline"><input type="submit" value="发布" class="inli"></div>
							</form>
						</div>
					 </div>
					 
					 
					
					<!-- 配置文件 -->
					<script type="text/javascript" src="ueditor/ueditor.config.js"></script>
					<!-- 编辑器源码文件 -->
					<script type="text/javascript" src="ueditor/ueditor.all.js"></script>
					<!-- 实例化编辑器 -->
					<script type="text/javascript">
						var editor = UE.getEditor('container');
					</script>
				</div>
			 
		 </div>








