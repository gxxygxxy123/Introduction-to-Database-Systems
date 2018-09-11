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
		$username = $_SESSION['username'];
		include("mysql_connect.php");
		$name = $_POST['name'];
		$price = $_POST['price'];
		$location = $_POST["location"];
		$time = $_POST['time'];
		#$information_array = $_POST["information"];
		$information_array = !empty($_POST["information"]) ? $_POST["information"] : array();
		$sql = "SELECT * FROM people where account = '$username' ";
		#$stmt = $dbConnection->prepare($sql);
		#$stmt->bind_param('s', $username);
		#$stmt->execute();
		#$result = $stmt->get_result();
		$result = mysqli_query($dbConnection,$sql);
		$row = @mysqli_fetch_row($result);
		$peopleid = $row[0];
		$err = 0;
		if($name == null){
			$err = 1;
			echo 'name不能為空<br>';
			#echo '<meta http-equiv=REFRESH CONTENT=1;url=house_manage_add.php>';
		}
		if(!is_numeric($price)){
			$err = 1;
			echo 'price不能為空或包含字元<br>';
			#echo '<meta http-equiv=REFRESH CONTENT=1;url=house_manage_add.php>';
		}
		#if($location == null){
		#	$err = 1;
		#	echo 'location不能為空<br>';
		#	echo '<meta http-equiv=REFRESH CONTENT=1;url=house_manage_add.php>';
		#}
		if($time == null){
			$err = 1;
			echo 'time不得為空<br>';
			#echo '<meta http-equiv=REFRESH CONTENT=1;url=house_manage_add.php>';
		}
		if($err == 1){
			echo '<meta http-equiv=REFRESH CONTENT=1;url=house_manage_add.php>';
		}
		$id = 0;
		if($err == 0){
			$flag = 1;
			#$sql = "insert into house(name,price,location,time,owner_id) values ('$name', '$price', '$location', '$time','$peopleid')";
			$sql = "SELECT id, loca FROM locatype";
			$result = mysqli_query($dbConnection,$sql);
			#while($row = @mysqli_fetch_row($result)){
			#	if($row[0] == $location){
			#		$loca = $row[1];
			#		break;
			#	}
			#}
			$sql = "insert into house(name,price,location,time,owner_id) values (?,?,?,?,?)";
			$stmt = $dbConnection->prepare($sql);
			$stmt->bind_param("ssiss",$name,$price,$location,$time,$peopleid);
			$stmt->execute();
			$result = $stmt->get_result();
			if(!mysqli_query($dbConnection,$sql))
				$flag = 0;
			$id = mysqli_insert_id($dbConnection);
			foreach($information_array as $info){
				$sql2 = "insert into information(information,house_id) values ('$info','$id')";
				if(!mysqli_query($dbConnection,$sql2))
					$flag = 0;
			}
			#if($flag == 1)
			#	echo '新增成功!';
			#elseif($flag == 0)
			#	echo '新增失敗!';
			echo '新增房屋!';
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