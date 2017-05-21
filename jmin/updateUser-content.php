<?php
	if(!defined('jiaosys')) { 
exit('<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
			<h1 class="page-header">禁止访问</h1></div>'); 
}
	if(!isset($_SESSION['vip']) || $_SESSION['vip']!='javaj'){
		exit('<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
			<h1 class="page-header">请登录<a href="jmin.php">登录</a></h1></div>');
	}
		
		
		if(!isset($_GET["uid"])){
					exit('<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
					<h1 class="page-header">没有获取到$uid!</h1></div>'); 
				}
		$uid=$_GET["uid"];
			//S取用户
				$sql="select uid,uname,password,password2 from admin_user where uid=?";
				$stmt=$mysqli->prepare($sql);
				$stmt->bind_param('i',$uid);
				$stmt->bind_result($uid1, $uname1,$password1,$password21);
				$stmt->execute();
				$stmt->fetch();
				$uuser['uid']=$uid1;
				$uuser['uname']=$uname1;
				$uuser['password']=$password1;
				$uuser['password2']=$password21;
				
				/* close statement */
				$stmt->free_result();
				$stmt->close();
			//E取用户	
		
	//S取分类	
				$sql="select uid,uname,password,password2 from admin_user";
				$stmt=$mysqli->prepare($sql);
				$stmt->execute();
				$stmt->bind_result($uid, $uname,$password,$password2);
				$i=0;
				while ($stmt->fetch()) {
				$a_array[$i]['uid']=$uid;
				$a_array[$i]['uname']=$uname;
				$a_array[$i]['password']=$password;
				$a_array[$i]['password2']=$password2;
				$i++;
				}
				/* close statement */
				$stmt->free_result();
				$stmt->close();
	//E取分类	
	
				echo '
				<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
					<h1 class="page-header">用户管理</h1>
					 <div class="panel panel-default">
						<div class="panel-heading">
						  <h3 class="panel-title">用户列表</h3>
						</div>
						<div class="panel-body">
						   <div class="table-responsive">
							<table class="table table-striped">
							  <thead>
								<tr>
									<th>ID</th>
									<th>用户名</th>
									<th>密码1</th>
									<th>密码2</th>
									<th>操作</th>
								</tr>
							  </thead>
							  <tbody>';
			//S开始显示内容
			foreach($a_array as $akey=>$avalue){
			?>
	
		<tr>
				<td><?php echo $avalue['uid'];?></td>
				<td><?php echo $avalue['uname'];?></td>
				<td><?php echo $avalue['password']?></td>
				<td><?php echo $avalue['password2']?></td>
				<td><a href="<?php echo $avalue['uid'];?>">修改</a>
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
			  <div class="panel-heading">更新用户</div>
			  <div class="panel-body">
					<form action="doUpdateUser.php" method="post">
						<input type="hidden" name="uid1" value="<?php echo $uuser['uid'];?>">
						<div class="input-group">
						  <span class="input-group-addon" id="basic-addon1">用户名</span>
						  <input type="text" name="uname1" class="form-control" placeholder="用户名" aria-describedby="basic-addon1" value="<?php echo $uuser['uname'];?>">
						</div>
						<div class="input-group">
						  <span class="input-group-addon" id="basic-addon1">密码</span>
						  <input type="text" name="upassword1" class="form-control" placeholder="密码1" aria-describedby="basic-addon1" value="<?php echo $uuser['password'];?>">
						</div>
						<div class="input-group">
						  <span class="input-group-addon" id="basic-addon1">密码2</span>
						  <input type="text" name="upassword21" class="form-control" placeholder="密码2" aria-describedby="basic-addon1" value="<?php echo $uuser['password2'];?>">
						</div>
						<input type="submit" value="提交">
					</form>
			  </div>
			</div>
</div>