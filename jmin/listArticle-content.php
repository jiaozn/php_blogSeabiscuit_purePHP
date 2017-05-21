<?php
	if(!defined('jiaosys')) { 
exit('<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
			<h1 class="page-header">禁止访问</h1></div>'); 
}
	if(!isset($_SESSION['vip']) || $_SESSION['vip']!='javaj'){
		exit('<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
			<h1 class="page-header">请登录<a href="jmin.php">登录</a></h1></div>');
	}
	require_once("sidebar.php");
	
	//S计算本页应该展示文章数
	$sql="select count(`art_id`) from article";
	$row=$mysqli->query($sql)->fetch_row();
	$artsum=$row[0];
	if($artsum==0){
		echo "还没有数据哦";
	}else{
				if(isset($_GET["pagenow"])){
					$pagenow=$_GET["pagenow"];
				}else{
					$pagenow=1;
				}
				$numperpage=10;
				$pagesum=ceil($artsum/$numperpage);
				$fromnum=5*($pagenow-1);
			//E计算本页应该展示文章数	
				
			//S向正文数组中添加文章内容	
				$sql="select a.art_id,a.art_title,a.art_content,a.art_categoryid,b.cat_title,a.art_hot,a.art_createtime 
				from article as a left join category as b on a.art_categoryid=b.cat_id 
				order by a.art_createtime desc 
				limit ?,? ";
				$stmt=$mysqli->prepare($sql);
				$stmt->bind_param('ii',$fromnum,$numperpage);
				$stmt->execute();
				$stmt->bind_result($art_id, $art_title,$art_content,$art_categoryid,$cat_title,$art_hot,$art_createtime);
				$i=0;
				while ($stmt->fetch()) {
				$a_array[$i]['art_id']=$art_id;
				$a_array[$i]['art_title']=$art_title;
				$a_array[$i]['art_content']=$art_content;
				$a_array[$i]['art_categoryid']=$art_categoryid;
				$a_array[$i]['cat_title']=$cat_title;
				$a_array[$i]['art_hot']=$art_hot;
				$a_array[$i]['art_createtime']=$art_createtime;
				$i++;
					//printf ($out, $art_id, $art_title,$art_content,$cat_title,$art_hot,$art_createtime);
				}
				/* close statement */
				$stmt->free_result();
				$stmt->close();
			//E向正文数组中添加文章内容		
				
			//S向正文数组中添加关键字	
				$sql2="select group_concat(tag_id),group_concat(tag_title),group_concat(tag_artnum) from tag where tag_id in 
				(select atc_tagid from article_tag_access where atc_artid=?)";
				for($j=0;$j<$i;$j++){
					$stmt2=$mysqli->prepare($sql2);
					$stmt2->bind_param('i',$a_array[$j]['art_id']);
					$stmt2->execute();
					$stmt2->bind_result($tag_id,$tag_title,$tag_artnum);
					while($stmt2->fetch()){
						$a_array[$j]['tag']['tag_id']=explode(',',$tag_id);
						$a_array[$j]['tag']['tag_title']=explode(',',$tag_title);
						$a_array[$j]['tag']['tag_artnum']=explode(',',$tag_artnum);
						//var_dump($a_array[$j]['tag']);
					}
					$stmt2->free_result();
					$stmt2->close();
				}
			//E向正文数组中添加关键字	

				
			//S向正文数组中添加评论
				$sql_com4a="select count(`com_id`) from comment where com_artid=?";
				for($j=0;$j<$i;$j++){
					$stmt2=$mysqli->prepare($sql_com4a);
					$stmt2->bind_param('i',$a_array[$j]['art_id']);
					$stmt2->execute();
					$stmt2->bind_result($acnum);
					while($stmt2->fetch()){
						$a_array[$j]['acnum']=$acnum;
					}
					$stmt2->free_result();
					$stmt2->close();
				}
			//E向正文数组中添加评论
				echo '
				<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
					<h1 class="page-header"><span class="glyphicon glyphicon-book"></span> 日志管理</h1>
					 <div class="panel panel-default">
						<div class="panel-heading">
						  <h3 class="panel-title">日志列表</h3>
						</div>
						<div class="panel-body">
						   <div class="table-responsive">
							<table class="table table-striped">
							  <thead>
								<tr>
									<th>ID</th>
									<th>标题</th>
									<th>正文</th>
									<th>分类</th>
									<th>热度</th>
									<th>评论数</th>
									<th>创建时间</th>
									<th>标签</th>
									<th>操作</th>
								</tr>
							  </thead>
							  <tbody>';
			//S开始显示内容
			foreach($a_array as $akey=>$avalue){
			?>
	
		<tr>
				<td><?php echo $avalue['art_id'];?></td>
				<td><?php echo $avalue['art_title'];?></td>
				<td><?php echo mb_strimwidth(strip_tags($avalue['art_content']), 0, 10,".....",'utf-8');?></td>
				<td><?php echo $avalue['art_categoryid'];?>：<?php echo $avalue['cat_title'];?></td>
				<td><?php echo $avalue['art_hot']?></td>
				<td><?php echo $avalue['acnum'];?></td>
				<td><?php echo $avalue['art_createtime'];?></td>
				<td><?php for($j=0;$j<sizeof($avalue['tag']['tag_id']);$j++){
						printf('<a href="tag.php?tag=%s" rel="nofollow">%s</a>',$avalue['tag']['tag_id'][$j],$avalue['tag']['tag_title'][$j]);
						}?>
				</td>
				<td>
						<a href="updateArticle.php?blog=<?php echo $avalue['art_id'];?>"><span class="glyphicon glyphicon-edit"></span> 修改</a>&nbsp;&nbsp;&nbsp;&nbsp;
						<a href="doDeleteArticle.php?blog=<?php echo $avalue['art_id'];?>"><span class="glyphicon glyphicon-trash"></span> 删除</a>
				</td>
		</tr>
			<?php
			}

			echo '
								</tbody>
							</table>
						  </div>
						</div>
					  </div>
			<nav aria-label="Page navigation">
				<ul class="pagination">';
			if($pagenow==1){
				printf('<li class="disabled">
							  <a href="listArticle.php?pagenow=%d" aria-label="Previous">
								<span aria-hidden="true">&laquo;首页</span>
							  </a>
							</li>',1);
			}else{
					printf('<li>
							  <a href="listArticle.php?pagenow=%d" aria-label="Previous">
								<span aria-hidden="true">&laquo;首页</span>
							  </a>
							</li>',1);
			}
			for($j=1;$j<=$pagesum;$j++){
				if($j==$pagenow){
					printf('<li class="active"><a href="listArticle.php?pagenow=%d" rel="page%d" id="apagenow">%d</a></li>',$j,$j,$j);
				}else{
					printf('<li><a href="listArticle.php?pagenow=%d" rel="page%d" >%d</a></li>',$j,$j,$j);
				}
			}
			echo "  </ul>
</nav>";
}
?>

</div>