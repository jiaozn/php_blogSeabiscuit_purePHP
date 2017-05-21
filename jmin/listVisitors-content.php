<?php
	if(!defined('jiaosys')) { 
exit('<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
			<h1 class="page-header">禁止访问</h1></div>'); 
}
	if(!isset($_SESSION['vip']) || $_SESSION['vip']!='javaj'){
		exit('<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
			<h1 class="page-header">请登录<a href="jmin.php">登录</a></h1></div>');
	}
	//S计算本页应该展示文章数
	$sql="select count(`log_id`) from log";
	$row=$mysqli->query($sql)->fetch_row();
	$artsum=$row[0];
	if($artsum==0){
		echo "还没有数据哦";
	}else{
				if(isset($_GET["pagenow"])){
					$pagenow=$_GET["pagenow"];
				}else{
					$pagenow=1;
				}
				$numperpage=10;
				$pagesum=ceil($artsum/$numperpage);
				$fromnum=5*($pagenow-1);
			//E计算本页应该展示文章数	
	
	//S取分类	
				$sql="select log_id,log_from,log_to,log_createtime from log order by log_id desc limit ?,?";
				$stmt=$mysqli->prepare($sql);
				$stmt->bind_param('ii',$fromnum,$numperpage);
				$stmt->execute();
				$stmt->bind_result($log_id, $log_from,$log_to,$log_createtime);
				$i=0;
				while ($stmt->fetch()) {
				$a_array[$i]['log_id']=$log_id;
				$a_array[$i]['log_from']=$log_from;
				$a_array[$i]['log_to']=$log_to;
				$a_array[$i]['log_createtime']=$log_createtime;
				$i++;
				}
				/* close statement */
				$stmt->free_result();
				$stmt->close();
	//E取分类	
	
				echo '
				<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
					<h1 class="page-header"><span class="glyphicon glyphicon-log-in"></span> 来访管理['.$artsum.']</h1>
					 <div class="panel panel-default">
						<div class="panel-heading">
						  <h3 class="panel-title">来访日志</h3>
						</div>
						<div class="panel-body">
						   <div class="table-responsive">
							<table class="table table-striped">
							  <thead>
								<tr>
									<th>ID</th>
									<th>用户ip</th>
									<th>访问地址</th>
									<th>来访时间</th>
								</tr>
							  </thead>
							  <tbody>';
			//S开始显示内容
			foreach($a_array as $akey=>$avalue){
			?>
	
		<tr>
				<td><?php echo $avalue['log_id'];?></td>
				<td><?php echo $avalue['log_from'];?></td>
				<td><?php echo $avalue['log_to']?></td>
				<td><?php echo $avalue['log_createtime']?></td>
		</tr>
			<?php
			}

			echo '
								</tbody>
							</table>
						  </div>
						</div>
					  </div>
					  <nav aria-label="Page navigation">
				<ul class="pagination">';
	if($pagenow==1){
				printf('<li class="disabled">
							  <a href="listVisitors.php?pagenow=%d" aria-label="Previous">
								<span aria-hidden="true">&laquo;首页</span>
							  </a>
							</li>',1);
			}else{
					printf('<li>
							  <a href="listVisitors.php?pagenow=%d" aria-label="Previous">
								<span aria-hidden="true">&laquo;首页</span>
							  </a>
							</li>',1);
			}
			for($j=1;$j<=$pagesum;$j++){
				if($j==$pagenow){
					printf('<li class="active"><a href="listVisitors.php?pagenow=%d" rel="page%d" id="apagenow">%d</a></li>',$j,$j,$j);
				}else{
					printf('<li><a href="listVisitors.php?pagenow=%d" rel="page%d" >%d</a></li>',$j,$j,$j);
				}
			}
			echo "  </ul>
</nav>";
}
?>

</div>