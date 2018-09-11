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
        $house = $_GET['house'];
		$sql = "DELETE FROM house WHERE id = ? ";
		$stmt = $dbConnection->prepare($sql);
		$stmt->bind_param('i', $house);
		$stmt->execute();
		$result = $stmt->get_result();
		mysqli_query($dbConnection,$sql);
		echo '從我的房子刪除完成!';
		echo '<meta http-equiv=REFRESH CONTENT=1;url=house_manage.php>';
	}
	else{
        echo '您無權限觀看此頁面!';
        echo '<meta http-equiv=REFRESH CONTENT=1;url=index.php>';
	}
?>
</div>
</body>
</html>