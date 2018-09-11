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
		<a href="information.php">返回</a><br><br>
		<h1>新增information：</h1>
		<form action="add_information_finish.php" method="post" >
		information：<input type="text" name="information" ><br><br>
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