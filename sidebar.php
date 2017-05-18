<div id="sidebar">
<?php
	//S获取日志分类列表
	echo "<div class='sidebarpart'>
					<div class='sidebartitle'>▉日志分类</div>
					<div class='sidebarcontent' id='sidebarcategory'>";
	$sql="select cat_id,cat_title,cat_artnum from category ";
	$result=$mysqli->query($sql);
	while ($row = $result->fetch_row()) {
        printf ("<a href='category.php?category=%s'>%s(%s)</a>", $row[0], $row[1],$row[2]);
    }
	$result->close();
	echo "</div>
	</div>";
	//E获取日志分类列表
	
	//S获取关键字列表
	echo "<div class='sidebarpart'>
				<div class='sidebartitle'>▉关键字</div>
				<div class='sidebarcontent' id='sidebartag'>";
	$sql="select tag_id,tag_title,tag_artnum from tag order by tag_artnum desc";
	$result=$mysqli->query($sql);
	while ($row = $result->fetch_row()) {
        printf ("<a href='tag.php?tag=%s'>%s(%s)</a>", $row[0], $row[1],$row[2]);
    }
	$result->close();
	echo "</div>
	</div>";
	//E获取关键字列表
	
	//S获取评论列表
	echo "<div class='sidebarpart'>
			<div class='sidebartitle'>▉评论列表</div>
			<div class='sidebarcontent'>";
	$sql="select com_content,com_user,com_artid,art_title from comment left join article on com_artid=art_id order by com_createtime desc limit 0,5";
	$result=$mysqli->query($sql);
	while ($row = $result->fetch_row()) {
        printf ("%s在<a href='single.php?blog=%s'>%s</a>中说：%s", $row[1], $row[2],$row[3],$row[0]);
    }
	$result->close();
	echo "</div>
	</div>";
	//E获取评论列表
?>
</div>