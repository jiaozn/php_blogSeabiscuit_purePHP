<div id="index-content">

			<div id="singlearticle">
						<div id="singlearticletags">
<a>"自以为是闭门造车 总想做得扎克伯格"</a>
						</div>
								<h2>
										关于我
								</h2>
								
								<div id="singlearticleinfo">
										<span>Posted on By <a rel="nofollow">奔腾年代</a> @ 2017.5.21</span>
								</div>
								<div id="singlearticlecontent">
									<div class="t1">一、兴趣</div>
									<div class="t2">1.1 编程</div>
									<p class="abinfo">刚学编程啃知识点的时候遇到过这种描述：

									“大家以后遇到新的框架、语言，看个一天就基本会用了”。
									那时候对这种能力羡慕的不要不要的，直淌哈喇子。现在自己终于也能做到了，想想才觉得自己好幸福啊~</p>

									<p class="abinfo">我的编程知识都是自学的。这意味着

									不是系统学习、科班出身，知识体系估计有遗漏。
									我的自学经验，相信能给很多自学编程中的人带来帮助。</p>
									<div class="t2">1.2 Photoshop</div>
									<p class="abinfo">曾经也是一直getting ing ing...，苦于自知没有got it.

									现在不算精通，能算入门吧。没专门进行ps创作，有些做过的练习舍不得删，挂到了网上。<a href="http://myladyjava.lofter.com/" target="_blank">奔腾年代Lofter</a></p>

									<div class="t2">1.3 拳击</div>
									<p class="abinfo">喜欢以下这几个关键词:</p>
									<ul class="abul">
									<li>《洛奇》（史泰龙）</li>
									<li>《拳王阿里》（威尔史密斯）</li>
									<li>拳王泰森</li>
									</ul>
									<p class="abinfo">我对拳击只是欣赏。</p>

									<p class="abinfo">拳击不是打架斗殴，是一项对身体素质、格斗技巧、训练要求都十分严苛，不是谁都能玩儿的高逼格运动。
									《洛奇》《拳王阿里》都是我常常翻出来看看，给自己打气的励志电影；拳王泰森则是我认为难得一遇的世纪拳击手，
									他的比赛视频是最具有观赏性的，没有之一。（我只对拳击本身作评价，对拳王本人的生活、经历并不很清楚）</p>

									<div class="t2">1.4 电影</div>
									<p class="abinfo">以前我会给喜欢的电影打分、影评、推荐，希望其他人能省下看“烂片”的时间，多看一些“好电影”。

									自己喜欢的美剧、英剧、国产电视剧，都想找到超级高清的资源永久保存到硬盘里^_^……</p>

									<div class="t2">1.5 动漫</div>
									<p class="abinfo">看过的不多，《火影忍者》就不错。它成功的引起了我对学习日语的兴趣</p>

									<div class="t2">1.6 游戏（曾经）</div>
									<p class="abinfo">怀念为主，现在不玩了。但看到dota/lol精彩视频的时候，内心仍然会激昂澎湃拍手叫好</p>

									<div class="t1">二、联系方式</div>
									<div>
										<p class="abinfo">QQ：644511346</p>
										<p class="abinfo">邮箱：<a href="mailto:644511346@qq.com">644511346@qq.com</a></p>
										<p class="abinfo">地址：中国@泰山</p>
									</div>
									<div class="t1">三、打赏</div>
									<p class="abinfo">我的很多日志，尤其是经验分享的内容，都是记录了自己“爬坑”，让以后的人能“少走弯路”，写的时候真的感觉自己蛮无私的，
									有时候内心还会有点舍不得哈哈。你能喜欢的话我很高兴，我也不排斥通过捐助的方式支持我。</p>
									<div class="abimg"><div><i class="fa fa-hand-o-down fa-fw"></i> 微信付款给奔腾年代</div>
									<img src="weixin.png" alt="微信付款给奔腾年代"/></div>
								</div>
			</div>		

<?php
	$sql="select count(`acom_id`) from about_comment where acom_toid=0";
	$row=$mysqli->query($sql)->fetch_row();
	$comsum=$row[0];
	function getChildren($acom_id){
				$mysqli= @new mysqli("127.0.0.1", "root", "root", "jjn", 3306);
				if ($mysqli->connect_errno) {
					echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
				}
				$mysqli->set_charset('utf8');
				$sql="select count(acom_id) from about_comment where acom_toid='$acom_id'";
				$resultt=$mysqli->query($sql);
					$row = $resultt->fetch_row();
						$artsum=$row[0];
					$resultt->close();
				

				if($artsum!=0){
					$sql="select * from about_comment where acom_toid='$acom_id' order by acom_createtime asc";
					if ($result = $mysqli->query($sql)) {
						while ($row = $result->fetch_row()) {
							printf ("<div class='oneacom'><i class='fa fa-comment-o fa-fw'></i>%s说：%s<div class='acreplyinfo'><i class='fa fa-clock-o fa-fw'></i>%s<div onclick='acomreply(%d,%s)' class='acreply'>回复<i class='fa fa-reply fa-fw'></i></div></div>", $row[1],$row[2],$row[4],$row[0],'"'.$row[1].'"');
							getChildren($row[0]);
							printf("</div>");
						}
						$result->close();
					}
				}
				$mysqli->close();
	}
	if($comsum==0){
		echo "还没有数据哦";
	}else{
			if(isset($_GET["pagenow"])){
							$pagenow=$_GET["pagenow"];
						}else{
							$pagenow=1;
						}
			$numperpage=5;
			$pagesum=ceil($comsum/$numperpage);
			$fromnum=5*($pagenow-1);
?>
<div id="beforecom">发表评论(<?php echo $comsum?>)</div>
<?php
			
			$sql="select * from about_comment where acom_toid=0 order by acom_createtime desc limit ?,?";
			$stmt=$mysqli->prepare($sql);
			$stmt->bind_param('ii',$fromnum,$numperpage);
			$stmt->execute();
			$stmt->bind_result($acom_id,$acom_user,$acom_content,$acom_toid,$acom_createtime);
			$i=0;
			while ($stmt->fetch()) {
				$ac_array[$i]['acom_id']=$acom_id;
				$ac_array[$i]['acom_user']=$acom_user;
				$ac_array[$i]['acom_content']=$acom_content;
				$ac_array[$i]['acom_toid']=$acom_toid;
				$ac_array[$i]['acom_createtime']=$acom_createtime;
				printf('<div class="onechacom"><span class="acid"><i class="fa fa-comment-o fa-fw"></i></span>%s 说：%s<div class="acreplyinfo"><i class="fa fa-clock-o fa-fw"></i>%s<div onclick="acomreply(%s,%s)" class="acreply">回复<i class="fa fa-reply fa-fw"></i></div></div>',$acom_user,$acom_content,$acom_createtime,$acom_id,"'".$acom_user."'");
									getChildren($acom_id);
				printf('</div>');
				$i++;
			}
	}
?>
					
	<div id="acompostpart">
	<div id="result"></div>
			<div id="acom1line">
					昵称：
					<div class="" contentEditable="true" id="editor-author">路人甲</div>
			</div>
			<div id="editor-hidden">
			</div>
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
</div>		
		
<script type="text/javascript">
		function acomreply(pid,uname){
			document.getElementById("editor-hidden").innerHTML=pid;
			document.getElementById("acompostpart").scrollIntoView(true);
		};
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
							 xmlhttp.open("POST","acom-rec.php",true); 
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
							//xmlhttp.open("POST","http://localhost/test.php",true);
							//xmlhttp.send();
				};
			};
</script>