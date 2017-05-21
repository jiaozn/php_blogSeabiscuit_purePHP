<div id="index-content">
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
<div class='whereami'><i class='fa fa-folder-open-o'></i> 关于我
</div>
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