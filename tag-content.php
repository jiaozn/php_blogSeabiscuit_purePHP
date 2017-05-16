<h1>index-content</h1>
<?php
//S取关键字名字
	$tag=$_GET['tag'];
	$sql="select tag_id,tag_title,tag_artnum from tag where tag_id=?";
	$stmt=$mysqli->prepare($sql);
	$stmt->bind_param('i',$tag);
	$stmt->execute();
	$stmt->bind_result($tag_id,$g_tag_title,$tag_artnum);
	$stmt->fetch();
	$stmt->free_result();
	$stmt->close();
//E取关键字名字

//S计算本页应该展示文章数
	$artsum=$tag_artnum;
	if($artsum==0){
		echo "还没有数据哦";
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
				$sql="select a.art_id,a.art_title,a.art_content,a.art_categoryid,b.cat_title,a.art_hot,a.art_createtime 
				from article as a left join category as b on a.art_categoryid=b.cat_id 
				where a.art_id in (select atc_artid from article_tag_access where atc_tagid='$tag_id')
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
				
				
				$mysqli->close();
				//var_dump($a_array);
				
				printf("<div>当前关键字->%s</div>",$g_tag_title); 
			//S开始显示内容
			foreach($a_array as $akey=>$avalue){
			?>
				<h2>
					<a href="single.php?blog=<?php echo $avalue['art_id'];?>" rel="<?php echo $avalue['art_title'];?>">
						<?php echo $avalue['art_title'];?>
					</a>
				</h2>
				<p>
					<?php echo $avalue['art_content'];?>
				</p>
				分类：
				<a href="category.php?category=<?php echo $avalue['art_categoryid'];?>">
					<?php echo $avalue['cat_title'];?>
				</a>
				<span>
					文章热度：<?php echo $avalue['art_hot'];?>
				</span>	
				<span>
					创建时间：<?php echo $avalue['art_createtime'];?>
				</span>	
				<span>
					评论数：<?php echo $avalue['acnum'];?>
				</span>
				<?php 
					for($j=0;$j<sizeof($avalue['tag']['tag_id']);$j++){
						printf('<a href="tag.php?tag=%s" rel="nofollow">%s</a>',$avalue['tag']['tag_id'][$j],$avalue['tag']['tag_title'][$j]);
						echo "|";
					}
				?>
			<?php
			}


			if($pagenow==1){
				echo '<hr>
				<span class="grey">首页</span>';
				//printf('<a href="tag.php?tag=%d&pagenow=%d" rel="nofollow">首页</a>',$tag_id,1);
			}else{
				printf('<span class="normal"><a href="tag.php?tag=%d&pagenow=%d" rel="nofollow">首页</a></span>',$tag_id,1);
			}
			for($j=1;$j<=$pagesum;$j++){
				printf('<a href="tag.php?tag=%d&pagenow=%d" rel="tag-page%d">%d</a>',$tag_id,$j,$j,$j);
			}
}
?>