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
$username = $_POST['username'];
$password = $_POST['password'];
$passwordh = hash("sha256",$password);
$sql = "SELECT * FROM people WHERE account = ?";
$stmt = $dbConnection->prepare($sql);
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();
$row = mysqli_fetch_row($result);
if($username == null || strstr($username,' ')){
		echo '帳號不得為空或包含空格';
		echo '<meta http-equiv=REFRESH CONTENT=1;url=index.php>';
}
elseif($password == null || strstr($password,' ')){
		echo "密碼不得為空或包含空格";
		echo '<meta http-equiv=REFRESH CONTENT=1;url=index.php>';
}
elseif(mysqli_num_rows($result) < 1){
	echo '無此帳號';
	echo '<meta http-equiv=REFRESH CONTENT=1;url=index.php>';
}
elseif($row[1] == 'admin' && $row[2] == $username && $row[3] == $passwordh){
        $_SESSION['username'] = $username;
		$_SESSION['Admin'] = true;
        echo '管理員登入成功!';
        echo '<meta http-equiv=REFRESH CONTENT=1;url=home.php?search=0>';
}
elseif($row[1] == 'normal' && $row[2] == $username && $row[3] == $passwordh){
        $_SESSION['username'] = $username;
		$_SESSION['Admin'] = false;
        echo '一般使用者登入成功!';
        echo '<meta http-equiv=REFRESH CONTENT=1;url=home.php?search=0>';
}
else{
        echo '密碼錯誤!';
        echo '<meta http-equiv=REFRESH CONTENT=1;url=index.php>';
}
?>
</div>
</body>
</html>