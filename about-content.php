<h1>about-content</h1>
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
							printf ("<div>id=%d,用户%s说：%s,%s<a href='#' onclick='acomreply(%d)' rel='nofollow'>回复</a>", $row[0], $row[1],$row[2],$row[4],$row[0]);
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
			$numperpage=10;
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
				printf('<div>id=%d,name=%s 说：%s发表时间%s<a href="#" onclick="acomreply(%d)" rel="nofollow">回复</a>',$acom_id,$acom_user,$acom_content,$acom_createtime,$acom_id);
									getChildren($acom_id);
				printf('</div>');
				$i++;
			}
				$mysqli->close();
	}
?>
<hr>	
			<div class="" contentEditable="true" id="editor-author">
				路人甲
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
			<div class="editor-field" contentEditable="true" id="editor-content">
				内容输入框
			</div>
		</div>
		<div id="sub" draggable="true">提交</div>
		<div id="result"></div>
		
		
<script type="text/javascript">
		function acomreply(pid){
			document.getElementById("editor-hidden").innerHTML=pid;
			//alert(pid);
		}
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
							 alert("name="+document.getElementById("editor-author").innerHTML+
							 "&content="+document.getElementById("editor-content").innerHTML+
							 "&pid="+document.getElementById("editor-hidden").innerHTML);
							 xmlhttp.send("name="+document.getElementById("editor-author").innerHTML+
							 "&content="+document.getElementById("editor-content").innerHTML+
							 "&pid="+document.getElementById("editor-hidden").innerHTML
							 ); 
							xmlhttp.onreadystatechange=function()
								{
									if (xmlhttp.readyState==4 && xmlhttp.status==200)
									{
										document.getElementById("result").innerHTML=xmlhttp.responseText;
									}
								}
							//xmlhttp.open("POST","http://localhost/test.php",true);
							//xmlhttp.send();
				};
			};
</script>