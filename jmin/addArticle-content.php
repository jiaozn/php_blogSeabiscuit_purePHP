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
?>
		 <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
			<h1 class="page-header"><span class="glyphicon glyphicon-plus-sign"></span> 新增日志</h1>
				<div id="content row placeholders">
					<div class="panel panel-default">
						<div class="panel-heading">
						  <h3 class="panel-title">编辑</h3>
						</div>
						<div class="panel-body">
						  <form action="doAddArticle.php" method="post">
								<div class="oneline">
									<div class="input-group">
										<span class="input-group-addon" id="basic-addon1" >标题</span>
										<input type="text" name="art_title" class="form-control">
									</div>
								</div>
								
								
								<!-- 加载编辑器的容器 -->
								<script id="container" name="content" type="text/plain"></script>
								<div class="oneline">分类：<select name="art_categoryid" class="inli">
																<?php
																foreach($cat_array as $cat){
																	printf("<option value='%d'>%s(%s)</option>",$cat['cat_id'],$cat['cat_title'],$cat['cat_artnum']);
																}
																?>
															</select>
								</div>
								<div class="input-group">
										<span class="input-group-addon" id="basic-addon1" >关键字</span>
										<input type="text" name="art_tags" class="form-control">
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








