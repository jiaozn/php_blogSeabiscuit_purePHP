	<!--0.功能
				需要数据库-->
	<?php
		require_once("dbcon.php");
	?>
	
	
	<!--1.头部-->
	<?php
		require_once("header.php");
	?>
	<div id="wrap">
	

	<!--3.首页内容-->
	<?php
		require("category-content.php");
	?>
	<!--2.边栏-->
	<?php
		require("sidebar.php");
	?>
	</div>
	<!--4.尾部-->
	<?php
		require("footer.php");
	?>