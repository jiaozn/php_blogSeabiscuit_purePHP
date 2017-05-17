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
		echo "吐槽成功！";
		echo $author.$content.$pid;
			$mysqli->close();
	?>
