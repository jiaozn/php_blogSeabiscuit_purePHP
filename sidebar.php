<div id="sidebar">
			<div class='sidebarpart' id="searchremove">
					<div class='sidebartitle'></div>
					<div class='sidebarcontent' id='sidebarsearch'>
						<form action="search.php" method="post">
							<input type="text" name="key" id="searchtext">
							<input type="submit" value="搜索" id="searchsub"></input>
						</form>
					</div>
			</div>
			<div class='sidebarpart' id="searchremove2" onclick="stopBubble(event)">
					<div class='sidebartitle'></div>
					<div class='sidebarcontent' id='sidebarsearch2'>
						<form action="search.php" method="post">
							<input type="text" name="key" id="searchtext2">
							<input type="submit" value="搜索" id="searchsub2"></input>
						</form>
					</div>
			</div>
<?php
	//S获取日志分类列表
	echo "<div class='sidebarpart'>
					<div class='sidebartitle'><i class='fa fa-square fa-fw'></i>日志分类</div>
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
				<div class='sidebartitle'><i class='fa fa-square fa-fw'></i>关键字</div>
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
			<div class='sidebartitle'><i class='fa fa-square fa-fw'></i>评论列表</div>
			<div class='sidebarcontent'>";
	$sql="select com_content,com_user,com_artid,art_title from comment left join article on com_artid=art_id order by com_createtime desc limit 0,5";
	$result=$mysqli->query($sql);
	while ($row = $result->fetch_row()) {
        printf ("<div class='sidebaronecomment'><i class='fa fa-bullhorn fa-w'></i>%s在<a href='single.php?blog=%s'>%s</a>中说：<div class='sidebaroccontent'>%s</div></div>", $row[1], $row[2],$row[3],$row[0]);
    }
	$result->close();
	echo "</div>
	</div>";
	//E获取评论列表
		
?>
</div>