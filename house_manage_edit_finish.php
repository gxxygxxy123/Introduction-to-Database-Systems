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
	if($_SESSION['username'] != null){
		include("mysql_connect.php");
		$username = $_SESSION['username'];
		$house = $_GET['house'];
		$name = $_POST['name'];
		$price = $_POST['price'];
		$location = $_POST['location'];
		$time = $_POST['time'];
		#$information_array = $_POST["information"];
		$information_array = !empty($_POST["information"]) ? $_POST["information"] : array();
		$err = 0;
		if($name == null){
			$err = 1;
			echo 'name不能為空<br>';
		}
		if(!is_numeric($price)){
			$err = 1;
			echo 'price不能為空或包含字元<br>';
		}
		if($time == null){
			$err = 1;
			echo 'time不得為空<br>';
		}
		if($err == 1){
			echo '<meta http-equiv=REFRESH CONTENT=1;url=house_manage.php>';
		}
		if($err == 0){
			$sql = "UPDATE house SET name=?, price=?, location=?, time=? WHERE id = ? ";
			$stmt = $dbConnection->prepare($sql);
			$stmt->bind_param("siisi",$name,$price,$location,$time,$house);
			$stmt->execute();
			$result = $stmt->get_result();
			mysqli_query($dbConnection,$sql);
			#$row = @mysql_fetch_row($result);
			$sql = "DELETE FROM information WHERE house_id = ? ";
			$stmt = $dbConnection->prepare($sql);
			$stmt->bind_param('i',$house);
			$stmt->execute();
			$result = $stmt->get_result();
			mysqli_query($dbConnection,$sql);
			foreach($information_array as $info){
				$sql = "INSERT INTO information(information, house_id) values (?, ?) ";
				$stmt = $dbConnection->prepare($sql);
				$stmt->bind_param("ii",$info,$house);
				$stmt->execute();
				$result = $stmt->get_result();
				mysqli_query($dbConnection,$sql);
			}
			echo '修改完成!';
			echo '<meta http-equiv=REFRESH CONTENT=2;url=house_manage.php>';
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