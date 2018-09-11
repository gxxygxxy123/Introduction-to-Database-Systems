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
	echo '<a href="house_manage_add.php">新增</a><br><br>';
	#echo '<a href="house_manage_edit.php">編輯</a><br><br>';
	if($_SESSION['username'] != null){
		$username = $_SESSION['username'];
        $sql = "SELECT DISTINCT house.id, house.name, house.price, IFNULL(locatype.loca, 'Unknown'), house.time, people.name FROM (((house INNER JOIN people ON house.owner_id = people.id)LEFT JOIN information ON information.house_id = house.id)LEFT JOIN locatype ON house.location = locatype.id) WHERE people.account = ? ";
		$stmt = $dbConnection->prepare($sql);
		$stmt->bind_param('s', $username);
		$stmt->execute();
		$result = $stmt->get_result();
        #$result = mysqli_query($dbConnection,$sql);
		if(@mysqli_num_rows($result) < 1){
			echo "您尚未擁有任何房子";
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
				<th>name</th>
				<th>price</th>
				<th>location</th>
				<th>time</th>
				<th>owner</th>
				<th>information</th>
				<th>option</th>
			<?php
			while($row = mysqli_fetch_row($result)){
			?>
			
				<tr>
					<td><?php echo $row[0] ?></td>
					<td><?php echo $row[1] ?></td>
					<td><?php echo $row[2] ?></td>
					<td><?php echo $row[3] ?></td>
					<td><?php echo $row[4] ?></td>
					<td><?php echo $row[5] ?></td>
					<td>
						<?php 
							$sql2 = "SELECT infotype.info FROM (((house INNER JOIN information ON information.house_id = house.id)INNER JOIN people ON house.owner_id = people.id)INNER JOIN infotype ON information.information = infotype.id) WHERE people.account = ? AND house.id = '$row[0]' ";
							$stmt2 = $dbConnection->prepare($sql2);
							$stmt2->bind_param('s', $username);
							$stmt2->execute();
							$result2 = $stmt2->get_result();
							while($row2 = @mysqli_fetch_row($result2)){
								echo $row2[0];
								echo '<br>';
							}
						?>
					</td>
					<td>
						<a href="house_manage_edit.php?house=<?php echo $row[0] ?>&name=<?php echo $row[1]?>&price=<?php echo $row[2]?>&location=<?php echo $row[3]?>&time=<?php echo $row[4]?>">edit</a>
						<a href="house_manage_delete.php?house=<?php echo $row[0] ?>">delete</a>
					</td>
					<!--echo "姓名：$row[4] 帳號：$row[2] Email：$row[5]<br>";-->
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