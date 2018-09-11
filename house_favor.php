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
	if($_SESSION['username'] != null){
		echo '<a href="logout.php">登出</a>  <br><br>';
		echo '<a href="home.php?search=0">首頁</a><br><br>';
		$username = $_SESSION['username'];
		$sql = "SELECT id from people WHERE account = ? ";
		$stmt = $dbConnection->prepare($sql);
		$stmt->bind_param('s', $username);
		$stmt->execute();
		$result = $stmt->get_result();
		#$result = mysqli_query($dbConnection,$sql);
		$row = mysqli_fetch_row($result);
		$id = $row[0];
		$sql = "SELECT DISTINCT house.id, house.name, house.price, IFNULL(locatype.loca, 'Unknown'), house.time, people.name, favorite.id FROM ((((favorite INNER JOIN house ON favorite.favorite_id = house.id)LEFT JOIN information ON house.id = information.house_id)INNER JOIN people ON house.owner_id = people.id)LEFT JOIN locatype ON house.location = locatype.id) WHERE  favorite.user_id = '$id' ";
        $result = mysqli_query($dbConnection,$sql);
		if(@mysqli_num_rows($result) < 1){
			echo "您尚未有我的最愛";
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
							$sql2 = "SELECT infotype.info FROM ((((favorite INNER JOIN house ON favorite.favorite_id = house.id)INNER JOIN information ON house.id = information.house_id)INNER JOIN people ON house.owner_id = people.id)INNER JOIN infotype ON information.information = infotype.id) WHERE favorite.user_id = '$id' AND house.id = '$row[0]' ";
							$result2 = mysqli_query($dbConnection,$sql2);
							while($row2 = @mysqli_fetch_row($result2)){
								echo $row2[0];
								echo '<br>';
							}
						?>
					</td>
					<td><a href="house_favor_delete.php?id=<?php echo $row[6] ?>">delete</a></td>
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