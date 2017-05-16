<h1>index-content</h1>
<?php
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

//S获取评论
	$sql="select com_id,com_content,com_user,com_createtime from comment where com_artid=?";
	$stmt=$mysqli->prepare($sql);
	$stmt->bind_param('i',$blog);
	$stmt->bind_result($com_id,$com_content,$com_user,$com_createtime);
	$stmt->execute();
	$i=0;
	while($stmt->fetch()){
		$comment[i]['com_id']=$com_id;
		$comment[i]['com_content']=$com_content;
		$comment[i]['com_user']=$com_user;
		$comment[i]['com_createtime']=$com_createtime;
		$i++;
	}
	$stmt->free_result();
	$stmt->close();
//E获取评论


			$mysqli->close();
				
				
			//S开始显示内容
			
			?>
				<h2>
					<a href="single.php?blog=<?php echo $art_id;?>" rel="<?php echo $art_title;?>">
						<?php echo $art_title;?>
					</a>
				</h2>
				<p>
					<?php echo $art_content;?>
				</p>
				分类：
				<a href="category.php?category=<?php echo $art_categoryid;?>">
					<?php echo $cat_title;?>
				</a>
				<span>
					文章热度：<?php echo $art_hot;?>
				</span>	
				<span>
					创建时间：<?php echo $art_createtime;?>
				</span>	
				<span>
					评论数：<?php echo $i;?>
				</span>
				<?php 
					for($j=0;$j<sizeof($tag['tag_id']);$j++){
						printf('<a href="tag.php?tag=%s" rel="nofollow">%s</a>',$tag['tag_id'][$j],$tag['tag_title'][$j]);
						echo "|";
					}
				?>
