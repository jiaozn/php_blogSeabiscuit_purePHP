<div id="index-content">
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
	$sql="select com_id,com_content,com_user,com_createtime from comment where com_artid=? order by com_createtime desc";
	$stmt=$mysqli->prepare($sql);
	$stmt->bind_param('i',$blog);
	$stmt->bind_result($com_id,$com_content,$com_user,$com_createtime);
	$stmt->execute();
	$i=0;
	while($stmt->fetch()){
		$comment[$i]['com_id']=$com_id;
		$comment[$i]['com_content']=$com_content;
		$comment[$i]['com_user']=$com_user;
		$comment[$i]['com_createtime']=$com_createtime;
		$i++;
	}
	$stmt->free_result();
	$stmt->close();
//E获取评论

//S增加热度
	$sql="update article set art_hot=art_hot+1 where art_id='$blog'";
	$row=$mysqli->query($sql);
//E增加热度


				
			//S开始显示内容
			
			?><div id="singlearticle">
						<div id="singlearticletags">
							<?php 
									for($j=0;$j<sizeof($tag['tag_id']);$j++){
										printf('<a href="tag.php?tag=%s" rel="nofollow">%s</a>',$tag['tag_id'][$j],$tag['tag_title'][$j]);
									}
							?>
						</div>
								<h2>
										<?php echo $art_title;?>
								</h2>
								<div id="singlearticleinfo">
										<span>
										分类：
										<a href="category.php?category=<?php echo $art_categoryid;?>">
											<?php echo $cat_title;?>
										</a>
										</span>
										<span>
											文章热度：<?php echo $art_hot;?>
										</span>	
										<span>
											创建时间：<?php echo $art_createtime;?>
										</span>	
										<span>
											评论数：<?php echo $i;?>
										</span>
								</div>
								<div id="singlearticlecontent">
									<?php echo $art_content;?>
								</div>
				</div>
				<div id="beforecom">发表评论</div>
				<div id="acompostpart">
					<div id="result"></div>
							<div id="acom1line">
									昵称：<div class="" contentEditable="true" id="editor-author">路人甲</div>
							</div>
							<div id="editor-hidden"><?php echo $blog;?></div>
						<div class="jiaoEditor">
							<div class="toolbar">
								<div class="tool-icon" draggable="true" id="bebold">
									<div class="fa fa-bold"></div>
								</div>
								<div class="tool-icon" draggable="true" id="beitalic">
									<div class="fa fa-italic"></div>
								</div>
								<div class="tool-icon" draggable="true">
									<div class="fa fa-image"></div>
								</div>
							</div>
							<div class="editor-field" contentEditable="true" id="editor-content"></div>
						</div>
						<div id="sub" draggable="true"><i class="fa fa-paper-plane-o fa-fw"></i>马上吐槽！</div>
				</div>
				<div>
					<?php
					for($j=0;$j<$i;$j++){
						printf('<div class="onechacom"><span class="acid"><i class="fa fa-comment-o fa-fw"></i></span>%s 说：%s<div class="acreplyinfo"><i class="fa fa-clock-o fa-fw"></i>%s</div></div>',$comment[$j]['com_user'],$comment[$j]['com_content'],$comment[$j]['com_createtime']);
					}
					?>
				</div>
</div>						
		
<script type="text/javascript">
		window.onload=function(){
				document.getElementById("bebold").onclick=function(){
					document.execCommand("bold");
				};
				document.getElementById("beitalic").onclick=function(){
					document.execCommand("italic");
				};
				document.getElementById("sub").onclick=function(){
							var xmlhttp;
							if (window.XMLHttpRequest)
							{
								xmlhttp=new XMLHttpRequest();
							}
							else
							{
								xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
							}
							 xmlhttp.open("POST","com-rec.php",true); 
							 xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
							 // alert("name="+document.getElementById("editor-author").innerHTML+
							 // "&content="+document.getElementById("editor-content").innerHTML+
							 // "&pid="+document.getElementById("editor-hidden").innerHTML);
							 xmlhttp.send("name="+document.getElementById("editor-author").innerHTML+
							 "&content="+document.getElementById("editor-content").innerHTML+
							 "&pid="+document.getElementById("editor-hidden").innerHTML); 
							xmlhttp.onreadystatechange=function()
								{
									if (xmlhttp.readyState==4 && xmlhttp.status==200)
									{
										document.getElementById("result").innerHTML=xmlhttp.responseText;
									}
								};
				};
			};
</script>