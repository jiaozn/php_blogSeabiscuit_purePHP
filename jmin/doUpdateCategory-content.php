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
	
		if(!isset($_POST["ucat_id"])){
					exit('<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
					<h1 class="page-header">没有获取到$ucat_id!</h1></div>'); 
				}
				//S更新分类
				$ucat_id=$_POST["ucat_id"];
				$ucat_title=$_POST["ucat_title"];
				$sql="update category set cat_title=? where cat_id=?";
				$stmt=$mysqli->prepare($sql);
				$stmt->bind_param('si',$ucat_title,$ucat_id);
				$stmt->execute();
				$stmt->close();
				//E更新分类
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
					<h1 class="page-header"><span class="glyphicon glyphicon-list"></span> 分类管理</h1>
					 <div class="panel panel-default">
						<div class="panel-heading">
						  <h3 class="panel-title">分类列表</h3>
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
				<td><a href="updateCategory.php?cat_id=<?php echo $avalue['cat_id'];?>"><span class="glyphicon glyphicon-edit"></span> 修改</a>
						<a href="deleteCategory.php?cat_id=<?php echo $avalue['cat_id'];?>"><span class="glyphicon glyphicon-trash"></span> 删除</a>
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
			<div class="alert alert-success alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>成功！</strong> 更新分类<?php echo $ucat_title;?>
			</div>
</div>