	<!--0.功能
				需要数据库-->
	<?php
		require_once("dbcon.php");
	?>
	<?php
		date_default_timezone_set('prc');
		$author=isset($_POST["name"])?$_POST['name']:'路人甲';
		$content=isset($_POST["content"])?$_POST['content']:'无以言表...';
		$pid=isset($_POST["pid"])?$_POST["pid"]:0;
		$time=date('Y-m-d H:i:s',time());
		$sql="insert into about_comment (acom_user,acom_content,acom_toid,acom_createtime) values (?,?,?,?)";
		$stmt=$mysqli->prepare($sql);
		$stmt->bind_param('ssis',$author,$content,$pid,$time);
		$stmt->execute();
		echo "<i class='fa fa-user-circle-o fa-fw'></i> <span class='nacau'>".$author."</span>吐槽成功！".
		"<i class='fa fa-commenting-o fa-fw'></i><span class='nacct'>".$content."</span><div id='resultrefresh'>——你需要...<a href='javascript:location.reload();' rel='nofollow'><i class='fa fa-refresh fa-fw'></i>刷新</a>页面查看效果...<div>";
			$mysqli->close();
	?>
