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
		include("mysql_connect.php");
		$identity = $_POST['identity'];
		if($identity == "1"){
			$identity = "admin";
		}
		elseif($identity == "2"){
			$identity = "normal";
		}
		$account = $_POST['account'];
		$password = $_POST['password'];
		$name = $_POST['name'];
		$email = $_POST['email'];
		$sql = "SELECT * FROM people where account = ?";
		$stmt = $dbConnection->prepare($sql);
		$stmt->bind_param('s', $account);
		$stmt->execute();
		$result = $stmt->get_result();
		#$result = mysqli_query($dbConnection,$sql);
		if($account == null || strstr($account,' ')){
			echo '帳號不得為空或包含空格';
			echo '<meta http-equiv=REFRESH CONTENT=1;url=member_add.php>';
		}
		elseif(@mysqli_num_rows($result) >= 1){
			echo '帳號已被註冊';
			echo '<meta http-equiv=REFRESH CONTENT=1;url=member_add.php>';
		}
		elseif($password == null || strstr($password,' ')){
			echo "密碼不得為空或包含空格";
			echo '<meta http-equiv=REFRESH CONTENT=1;url=member_add.php>';
		}
		elseif($name == null){
			echo "名字不得為空";
			echo '<meta http-equiv=REFRESH CONTENT=1;url=member_add.php>';
		}
		elseif (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
			echo("Email格式錯誤");
			echo '<meta http-equiv=REFRESH CONTENT=1;url=member_add.php>';
		}
		else{
			$password = hash("sha256",$password);
			$sql = "INSERT into people(level,account, password, name, email) values ('$identity', '$account', '$password', '$name', '$email')";
			if(mysqli_query($dbConnection,$sql)){
				echo '會員新增成功!';
				echo '<meta http-equiv=REFRESH CONTENT=1;url=member_manage.php>';
			}
			else{
				echo "會員新增失敗";
				echo '<meta http-equiv=REFRESH CONTENT=1;url=member_manage.php>';
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