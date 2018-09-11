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
        $id = $_GET['id'];
        //更新資料庫資料語法
        $sql = "DELETE FROM people WHERE id=$id";
        if(mysqli_query($dbConnection,$sql)){
                echo '刪除會員成功!';
                echo '<meta http-equiv=REFRESH CONTENT=1;url=member_manage.php>';
        }
        else{
                echo '刪除會員失敗!';
                echo '<meta http-equiv=REFRESH CONTENT=1;url=member_manage.php>';
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