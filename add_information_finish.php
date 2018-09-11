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
		$information = $_POST['information'];
			$sql = "INSERT into infotype(info) values ('$information')";
			if(mysqli_query($dbConnection,$sql)){
				echo 'information新增成功!';
				echo '<meta http-equiv=REFRESH CONTENT=1;url=information.php>';
			}
			else{
				echo "information新增失敗";
				echo '<meta http-equiv=REFRESH CONTENT=1;url=information.php>';
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