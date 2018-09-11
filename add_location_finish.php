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
		$location = $_POST['location'];
			$sql = "INSERT into locatype(loca) values ('$location')";
			if(mysqli_query($dbConnection,$sql)){
				echo 'location新增成功!';
				echo '<meta http-equiv=REFRESH CONTENT=1;url=location.php>';
			}
			else{
				echo "location新增失敗";
				echo '<meta http-equiv=REFRESH CONTENT=1;url=location.php>';
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