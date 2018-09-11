<?php
session_start();
include("mysql_connect.php");
//session_unset();
//session_destroy();
?>

<!DOCTYPE html>
<html>
<head>
</head>
<body>
<div align="center">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<?php
	include("mysql_connect.php");
	echo '<a href="logout.php">登出</a>  <br><br>';
	echo '<a href="home.php?search=0">首頁</a><br><br>';
	echo '<a href="add_information.php">新增information</a><br><br>';
	if($_SESSION['username'] != null && $_SESSION['Admin'] == true){
		$username = $_SESSION['username'];
        $sql = "SELECT id, info FROM infotype";
		$result = mysqli_query($dbConnection,$sql);
		if(@mysqli_num_rows($result) < 1){
			echo "您尚未擁有任何information";
		}
		else{
			?>
			<style>
				table, th, td {
					border: 1px solid black;
					border-collapse: collapse;
				}
			</style>
			<table style="width:100%">
				<th>id</th>
				<th>information</th>
			<?php
			while($row = mysqli_fetch_row($result)){
			?>
				<tr>
					<td><?php echo $row[0] ?></td>
					<td><?php echo $row[1] ?></td>
					<td>
						<a href="delete_information.php?id=<?php echo $row[0] ?>">delete</a>
					</td>
				</tr>
			<?php
			}
			?>
			</table>
			<?php
		}
	}
	else{
        echo '您無權限觀看此頁面!';
        echo '<meta http-equiv=REFRESH CONTENT=2;url=index.php>';
	}
	?>
</div>
</body>
</html>