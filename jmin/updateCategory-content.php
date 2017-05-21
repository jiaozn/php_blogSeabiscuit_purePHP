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
	
				if(!isset($_GET["cat_id"])){
					exit('<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
					<h1 class="page-header">没有获取到$cat_id!</h1></div>'); 
				}
				
				$ucat_id=$_GET["cat_id"];
				$sql="select cat_title from category where cat_id=?";
				$stmt=$mysqli->prepare($sql);
				$stmt->bind_param('i',$ucat_id);
				$stmt->execute();
				$stmt->bind_result($cat_title);
				$stmt->fetch();
				$ucat['cat_id']=$ucat_id;
				$ucat['cat_title']=$cat_title;
				/* close statement */
				$stmt->free_result();
				$stmt->close();
	//S取分类	
				$sql="select cat_id,cat_title,cat_artnum from category";
				$stmt=$mysqli->prepare($sql);
				$stmt->execute();
				$stmt->bind_result($cat_id, $cat_title,$cat_artnum);
				$i=0;
				while ($stmt->fetch()) {
				$a_array[$i]['cat_id']=$cat_id;
				$a_array[$i]['cat_title']=$cat_title;
				$a_array[$i]['cat_artnum']=$cat_artnum;
				$i++;
				}
				/* close statement */
				$stmt->free_result();
				$stmt->close();
	//E取分类	
	
				echo '
				<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
					<h1 class="page-header">分类管理</h1>
					 <div class="panel panel-default">
						<div class="panel-heading">
						  <h3 class="panel-title">Panel title</h3>
						</div>
						<div class="panel-body">
						   <div class="table-responsive">
							<table class="table table-striped">
							  <thead>
								<tr>
									<th>ID</th>
									<th>分类</th>
									<th>文章数</th>
									<th>操作</th>
								</tr>
							  </thead>
							  <tbody>';
			//S开始显示内容
			foreach($a_array as $akey=>$avalue){
			?>
	
		<tr>
				<td><?php echo $avalue['cat_id'];?></td>
				<td><?php echo $avalue['cat_title'];?></td>
				<td><?php echo $avalue['cat_artnum']?></td>
				<td><a href="<?php echo $avalue['cat_id'];?>">修改</a>
						<a href="<?php echo $avalue['cat_id'];?>">删除</a>
				</td>
		</tr>
			<?php
			}

			echo '
								</tbody>
							</table>
						  </div>
						</div>
					  </div>';
?>
			<div class="panel panel-primary">
			  <div class="panel-heading">修改分类</div>
			  <div class="panel-body">
					<form action="doUpdateCategory.php" method="post">
						<input type="hidden" name="ucat_id" value="<?php echo $ucat['cat_id'];?>">
						<div class="input-group">
						  <span class="input-group-addon" id="basic-addon1">分类名称</span>
						  <input type="text" name="ucat_title" class="form-control" placeholder="Categoryname" aria-describedby="basic-addon1" value="<?php echo $ucat['cat_title'];?>">
						</div>
						<input type="submit" value="提交">
					</form>
			  </div>
			</div>
	</h1></div>
</div>