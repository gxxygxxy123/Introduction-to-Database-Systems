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
		<a href="location.php">返回</a><br><br>
		<h1>新增location：</h1>
		<form action="add_location_finish.php" method="post" >
		location：<input type="text" name="location" ><br><br>
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