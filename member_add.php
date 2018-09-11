<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
</head>
<body>
<div align="center">
	<?php
	if($_SESSION['username'] != null && $_SESSION['Admin'] == true){
	?>
		<a href="member_manage.php">返回</a><br><br>
		<h1>新增使用者：</h1>
		<form action="member_add_finish.php" method="post" >
		使用者身分：<select name="identity">
　					<option value="2">一般使用者</option>
　					<option value="1">管理員</option>
					</select><br><br>
		使用者帳號：<input type="text" name="account" ><br><br>
		使用者密碼：<input type="password" name="password" ><br><br>
		名字：<input type="text" name="name" > <br><br>
		Email：<input type="text" name="email" > <br><br>
		<input type="submit" value="確定" >
		</form>
	<?php
	}
	else{
		echo '您無權限觀看此頁面!';
        echo '<meta http-equiv=REFRESH CONTENT=2;url=index.php>';
	}
	?>
</div>
</body>
</html>