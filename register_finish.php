<?php   
session_start();     
session_unset();     
session_destroy();
?> 

<!DOCTYPE html>
<html>
<head>
</head>
<body>
<div align="center">
	<?php
	include("mysql_connect.php");
	$account = $_POST['account'];
	$password = $_POST['password'];
	$password_2 = $_POST['password_2'];
	$name = $_POST['name'];
	$email = $_POST['email'];
	$sql = "SELECT * FROM people where account = ?";
	$stmt = $dbConnection->prepare($sql);
	$stmt->bind_param('s', $account);
	$stmt->execute();
	$result = $stmt->get_result();
	#$result = mysqli_query($dbConnection,$sql);
	$row = @mysqli_fetch_row($result);
	if($account == null || strstr($account,' ')){
		echo '帳號不得為空或包含空格';
		echo '<meta http-equiv=REFRESH CONTENT=1;url=register.php>';
	}
	elseif($row[2] == $account){
		echo '帳號已被註冊';
		echo '<meta http-equiv=REFRESH CONTENT=1;url=register.php>';
	}

	elseif($password == null || $password_2 == null || strstr($password,' ') || strstr($password_2,' ')){
		echo "密碼不得為空或包含空格";
		echo '<meta http-equiv=REFRESH CONTENT=1;url=register.php>';
	}
	elseif($name == null){
		echo "名字不得為空";
		echo '<meta http-equiv=REFRESH CONTENT=1;url=register.php>';
	}
	elseif (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
		echo("Email格式錯誤");
		echo '<meta http-equiv=REFRESH CONTENT=1;url=register.php>';
	}
	else if($password != $password_2){
		echo "密碼確認錯誤";
		echo '<meta http-equiv=REFRESH CONTENT=1;url=register.php>';
	}
	else{
		$password = hash("sha256",$password);
		$sql = "insert into people(level,account, password, name, email) values ('normal', '$account', '$password', '$name', '$email')";
		if(mysqli_query($dbConnection,$sql)){
        echo '註冊成功!';
        echo '<meta http-equiv=REFRESH CONTENT=1;url=index.php>';
		}
		else{
			echo "註冊失敗";
			echo '<meta http-equiv=REFRESH CONTENT=1;url=register.php>';
		}
	}
	?>
</div>
</body>
</html>