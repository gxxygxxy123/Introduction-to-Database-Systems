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
	if($_SESSION['username'] != null && $_SESSION['Admin'] == true){
        $house = $_GET['house'];#house.id
		$sql = "DELETE FROM house WHERE id = ?";
		$stmt = $dbConnection->prepare($sql);
		$stmt->bind_param('i', $house);
		$stmt->execute();
		$result = $stmt->get_result();
		mysqli_query($dbConnection,$sql);
		echo '已刪除房子!';
		echo '<meta http-equiv=REFRESH CONTENT=1;url=home.php?search=0>';
	}
	else{
        echo '您無權限觀看此頁面!';
        echo '<meta http-equiv=REFRESH CONTENT=1;url=index.php>';
	}
?>
</div>
</body>
</html>