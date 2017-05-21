<?php
	if(!defined('jiaosys')) { 
exit('<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
			<h1 class="page-header">禁止访问</h1></div>'); 
}
	if(!isset($_SESSION['vip']) || $_SESSION['vip']!='javaj'){
		exit('<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
			<h1 class="page-header">请登录<a href="jmin.php">登录</a></h1></div>');
	}
	require_once("sidebar.php");
	//S计算本页应该展示文章数
	$sql="select count(`failure_id`) from login_failure";
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
				$sql="select failure_id,failure_from,log_createtime from login_failure order by failure_id desc limit ?,?";
				$stmt=$mysqli->prepare($sql);
				$stmt->bind_param('ii',$fromnum,$numperpage);
				$stmt->execute();
				$stmt->bind_result($failure_id, $failure_from,$log_createtime);
				$i=0;
				while ($stmt->fetch()) {
				$a_array[$i]['failure_id']=$failure_id;
				$a_array[$i]['failure_from']=$failure_from;
				$a_array[$i]['log_createtime']=$log_createtime;
				$i++;
				}
				/* close statement */
				$stmt->free_result();
				$stmt->close();
	//E取分类	
	
				echo '
				<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
					<h1 class="page-header">告警登录['.$artsum.']</h1>
					 <div class="panel panel-default">
						<div class="panel-heading">
						  <h3 class="panel-title">异常登录</h3>
						</div>
						<div class="panel-body">
						   <div class="table-responsive">
							<table class="table table-striped">
							  <thead>
								<tr>
									<th>ID</th>
									<th>用户ip</th>
									<th>来访时间</th>
								</tr>
							  </thead>
							  <tbody>';
			//S开始显示内容
			foreach($a_array as $akey=>$avalue){
			?>
	
		<tr>
				<td><?php echo $avalue['failure_id'];?></td>
				<td><?php echo $avalue['failure_from'];?></td>
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
							  <a href="listFailure.php?pagenow=%d" aria-label="Previous">
								<span aria-hidden="true">&laquo;首页</span>
							  </a>
							</li>',1);
			}else{
					printf('<li>
							  <a href="listFailure.php?pagenow=%d" aria-label="Previous">
								<span aria-hidden="true">&laquo;首页</span>
							  </a>
							</li>',1);
			}
			for($j=1;$j<=$pagesum;$j++){
				if($j==$pagenow){
					printf('<li class="active"><a href="listFailure.php?pagenow=%d" rel="page%d" id="apagenow">%d</a></li>',$j,$j,$j);
				}else{
					printf('<li><a href="listFailure.php?pagenow=%d" rel="page%d" >%d</a></li>',$j,$j,$j);
				}
			}
			echo "  </ul>
</nav>";
}
?>

</div>