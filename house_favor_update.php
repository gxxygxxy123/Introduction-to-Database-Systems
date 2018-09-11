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
		$user = $_GET['user'];
        $house = $_GET['house'];
		$sql = "SELECT * FROM favorite WHERE user_id = ? AND favorite.favorite_id = '$house' ";
		$stmt = $dbConnection->prepare($sql);
		$stmt->bind_param('s', $user);
		$stmt->execute();
		$result = $stmt->get_result();
		#$result = mysqli_query($dbConnection,$sql);
		if(mysqli_num_rows($result) >= 1){
			echo '已在我的最愛內';
			echo '<meta http-equiv=REFRESH CONTENT=1;url=home.php?search=0>';
		}
		else{
			$sql = "INSERT into favorite (user_id, favorite_id) values ('$user', '$house')";
			if(mysqli_query($dbConnection,$sql)){
					echo '加入我的最愛成功!';
					echo '<meta http-equiv=REFRESH CONTENT=1;url=home.php?search=0>';
			}
			else{
					echo '加入我的最愛失敗!';
					echo '<meta http-equiv=REFRESH CONTENT=1;url=home.php?search=0>';
			}
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