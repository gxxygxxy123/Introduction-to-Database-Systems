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
	include("mysql_connect.php");
	if($_SESSION['username'] != null){
        $id = $_GET['id'];
		$sql = "DELETE FROM favorite WHERE id = '$id' ";
		if(mysqli_query($dbConnection,$sql)){
			echo '從我的最愛刪除成功';
			echo '<meta http-equiv=REFRESH CONTENT=1;url=house_favor.php>';
		}
		else{
			echo '從我的最愛刪除失敗';
			echo '<meta http-equiv=REFRESH CONTENT=1;url=house_favor.php>';
		}
	}
	else{
        echo '您無權限觀看此頁面!';
        echo '<meta http-equiv=REFRESH CONTENT=1;url=index.php>';
	}
?>
</div>
</body>
</html>