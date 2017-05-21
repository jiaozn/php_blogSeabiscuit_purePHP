<div id="index-content">
<?php
//S取关键字名字
	$key=$_POST['key'];
	$keyw='%'.$key.'%';
				$sql="select count(art_id) 
				from article left join category on art_categoryid=cat_id 
				where art_content or art_title like ? 
				or art_categoryid in (select cat_id from category where cat_title like ?) 
				or art_id in (select atc_artid from article_tag_access where atc_tagid in (select tag_id from tag where tag_title like ?))";
	$stmt=$mysqli->prepare($sql);
	$stmt->bind_param('sss',$keyw,$keyw,$keyw);
	$stmt->execute();
	$stmt->bind_result($artsum);
	$stmt->fetch();
	$stmt->free_result();
	$stmt->close();
//E取关键字名字

//S计算本页应该展示文章数
	if($artsum==0){
		echo "没有搜到相关内容呢";
	}else{
				if(isset($_GET["pagenow"])){
					$pagenow=$_GET["pagenow"];
				}else{
					$pagenow=1;
				}
				$numperpage=5;
				$pagesum=ceil($artsum/$numperpage);
				$fromnum=5*($pagenow-1);
			//E计算本页应该展示文章数	
				
			//S向正文数组中添加文章内容	

				$sql="select art_id,art_title,art_content,art_categoryid,cat_title,art_hot,art_createtime 
				from article left join category on art_categoryid=cat_id 
				where art_content or art_title like ? 
				or art_categoryid in (select cat_id from category where cat_title like ?) 
				or art_id in (select atc_artid from article_tag_access where atc_tagid in (select tag_id from tag where tag_title like ?))";
				$stmt=$mysqli->prepare($sql);
				$stmt->bind_param('sss',$keyw,$keyw,$keyw);
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
				
				
				
				printf("<div class='whereami'><i class='fa fa-search fa-fw'></i>当前搜索->%s</div>",$key); 
			//S开始显示内容
			foreach($a_array as $akey=>$avalue){
			?>
				<div class="onearticle">
				<div class="onearticletitle">
					<a href="single.php?blog=<?php echo $avalue['art_id'];?>" rel="<?php echo $avalue['art_title'];?>">
						<h2><?php echo $avalue['art_title'];?></h2>
					</a>
				</div>
			<div class="onearticledown">
				<div class="onearticleright">
							<div class="onearticlecontent">	
									<p>
										<?php echo mb_strimwidth(strip_tags($avalue['art_content']), 0, 280,".....",'utf-8');?>
									</p>
							</div>
							<div class="onearticleinfo">
									
									<span><i class='fa fa-folder-open-o fa-fw'></i>分类：
									<a href="category.php?category=<?php echo $avalue['art_categoryid'];?>">
										<?php echo $avalue['cat_title'];?>
									</a>
									</span>
									<span>
										<i class='fa fa-thermometer-half fa-fw'></i>文章热度：<?php echo $avalue['art_hot'].'℃';?>
									</span>	
									<span>
										<i class='fa fa-comments-o fa-fw'></i>评论数：<?php echo $avalue['acnum'];?>
									</span>
									<span>
										<i class='fa fa-clock-o fa-fw'></i>创建时间：<?php echo $avalue['art_createtime'];?>
									</span>	
							</div>
				</div>
				<!--onearticleright-->
				<div class="onearticletags">
				<?php 
					for($j=0;$j<sizeof($avalue['tag']['tag_id']);$j++){
						printf('<a href="tag.php?tag=%s" rel="nofollow">%s</a>',$avalue['tag']['tag_id'][$j],$avalue['tag']['tag_title'][$j]);
					}
				?>
				</div>
			</div>
			<!--onearticledown-->
		</div>
		<!--onearticle-->
			<?php
			}

			echo "<div id='pagenation'>";
			if($pagenow==1){
				
			}else{
				printf('<span class="normal"><a href="index.php?pagenow=%d">首页</a></span>',1);
			}
			for($j=1;$j<=$pagesum;$j++){
				if($j==$pagenow){
					printf('<a href="index.php?pagenow=%d" rel="page%d" id="apagenow">%d</a>',$j,$j,$j);
				}else{
					printf('<a href="index.php?pagenow=%d" rel="page%d">%d</a>',$j,$j,$j);
				}
			}
			echo "</div>";
	}
?>
</div>