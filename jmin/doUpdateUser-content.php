<?php
	if(!defined('jiaosys')) { 
exit('<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
			<h1 class="page-header">禁止访问</h1></div>'); 
}
	if(!isset($_SESSION['vip']) || $_SESSION['vip']!='javaj'){
		exit('<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
			<h1 class="page-header">请登录<a href="jmin.php">登录</a></h1></div>');
	}
		
		
		if(!isset($_POST["uid1"])){
					exit('<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
					<h1 class="page-header">没有获取到$uid1!</h1></div>'); 
				}
		$uid=$_POST["uid1"];
		$uname=$_POST["uname1"];
		$upassword1=$_POST["upassword1"];
		$upassword21=$_POST["upassword21"];
			//S更新用户
				$sql="update admin_user set uname=?,password=?,password2=? where uid=?";
				$stmt=$mysqli->prepare($sql);
				$stmt->bind_param('sssi',$uname,$upassword1,$upassword21,$uid);
				$stmt->execute();
				$stmt->free_result();
				$stmt->close();
			//E更新用户	
		
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
					<h1 class="page-header"><span class="glyphicon glyphicon-user"> 用户管理</h1>
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
				<td><a href="updateUser.php?uid=<?php echo $avalue['uid'];?>"><span class="glyphicon glyphicon-edit"></span>  修改</a>
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
			  <strong>成功！</strong> 更新用户<?php echo $_POST["uname1"];?>
			</div>
</div>