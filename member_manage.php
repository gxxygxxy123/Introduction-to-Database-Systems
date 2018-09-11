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
	echo '<a href="logout.php">登出</a><br><br>';
	echo '<a href="home.php?search=0">首頁</a><br><br>';
	if($_SESSION['username'] != null && $_SESSION['Admin'] == true){
		$username = $_SESSION['username'];
		echo'<a href="member_add.php">新增使用者</a><br>';
		$sql = "SELECT * FROM people where account = ? ";
		$stmt = $dbConnection->prepare($sql);
		$stmt->bind_param('s', $username);
		$stmt->execute();
		$result = $stmt->get_result();
        #$result = mysqli_query($dbConnection,$sql);
		while($row = mysqli_fetch_row($result)){
			?>
			姓名：<?php echo $row[4] ?><br>
			帳號：<?php echo $row[2] ?><br>
			Email：<?php echo $row[5] ?><br>
			<?php
		}
		?>
		<style>
			table, th, td {
				border: 1px solid black;
				border-collapse: collapse;
			}
		</style>
		<table style="width:100%">
			<th>id</th>
			<th>姓名</th>
			<th>帳號</th>
			<th>Email</th>
			<th>身分</th>
		<?php
        $sql = "SELECT * FROM people where account != ?";
		$stmt = $dbConnection->prepare($sql);
		$stmt->bind_param('s', $username);
		$stmt->execute();
		$result = $stmt->get_result();
        #$result = mysqli_query($dbConnection,$sql);
		while($row = mysqli_fetch_row($result)){
		?>
			<tr>
				<td><?php echo $row[0] ?></td>
				<td><?php echo $row[4] ?></td>
				<td><?php echo $row[2] ?></td>
				<td><?php echo $row[5] ?></td>
				<td><?php echo $row[1] ?></td>
				<td>
				<?php 
				if($row[1] != 'admin'){
				?>	<a href="member_update.php?id=<?php echo$row[0]?>">升級為管理員</a>
				<?php }
				if($row[1] == 'admin'){
					echo '已經是管理員了';
				}
				?>
				</td>
				<td><a href="member_delete.php?id=<?php echo$row[0]?>">刪除</a></td>
			</tr>
		
		<?php
        }
		?>
		</table>
		<?php
	}
	else
	{
        echo '您無權限觀看此頁面!';
        echo '<meta http-equiv=REFRESH CONTENT=2;url=index.php>';
	}
	?>
</div>
</body>
</html>