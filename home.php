<?php
@session_start();
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
		$username = $_SESSION['username'];
		$sql = "SELECT id from people WHERE account = ? ";
		$stmt = $dbConnection->prepare($sql);
		$stmt->bind_param('s', $username);
		$stmt->execute();
		$result = $stmt->get_result();
		#$result = mysqli_query($dbConnection,$sql);
		$row = @mysqli_fetch_row($result);
		$id = $row[0];
		$search = $_GET['search'];
		$order = !empty($_GET['order']) ? $_GET['order'] : null;
		?>
		<a href="logout.php">登出</a><br><br>
		<a href="house_manage.php">房屋管理</a><br><br>
		<a href="house_favor.php?id=<?php echo $id ?>">我的最愛</a><br><br>
		<?php
		if($_SESSION['Admin'] == true){
			echo '<a href="member_manage.php">會員管理</a><br><br>';
			echo '<a href="information.php">管理information</a><br><br>';
			echo '<a href="location.php">管理location</a><br><br>';
		}
		if($search == 0){
			$information_array = array();
			$sql = "SELECT DISTINCT house.id, house.name, house.price, IFNULL(locatype.loca, 'Unknown'), house.time, people.name FROM (((house INNER JOIN people ON house.owner_id = people.id)LEFT JOIN information ON information.house_id = house.id)LEFT JOIN locatype ON house.location = locatype.id) ";
		}
		else if($search == 1){
			$search_id = $_GET['id'];
			$search_name = $_GET['name'];
			$search_price = $_GET['price'];
			$search_location = $_GET['location'];
			$search_time = $_GET['time'];
			$search_owner = $_GET['owner'];
			$information_array = !empty($_GET['information']) ? $_GET['information'] : array();
			if($search_price == 0)
				$sql = "SELECT DISTINCT house.id, house.name, house.price, IFNULL(locatype.loca, 'Unknown'), house.time, people.name FROM (((house INNER JOIN people ON house.owner_id = people.id)LEFT JOIN information ON information.house_id = house.id)LEFT JOIN locatype ON house.location = locatype.id) WHERE house.id LIKE '%$search_id%' AND house.name LIKE '%$search_name%' AND locatype.loca LIKE '%$search_location%' AND house.time LIKE '%$search_time%' AND people.name LIKE '%$search_owner%' ";
			elseif($search_price == 1)
				$sql = "SELECT DISTINCT house.id, house.name, house.price, IFNULL(locatype.loca, 'Unknown'), house.time, people.name FROM (((house INNER JOIN people ON house.owner_id = people.id)LEFT JOIN information ON information.house_id = house.id)LEFT JOIN locatype ON house.location = locatype.id) WHERE house.id LIKE '%$search_id%' AND house.name LIKE '%$search_name%' AND locatype.loca LIKE '%$search_location%' AND house.time LIKE '%$search_time%' AND people.name LIKE '%$search_owner%' AND house.price BETWEEN 0 AND 500 ";
			elseif($search_price == 2)
				$sql = "SELECT DISTINCT house.id, house.name, house.price, IFNULL(locatype.loca, 'Unknown'), house.time, people.name FROM (((house INNER JOIN people ON house.owner_id = people.id)LEFT JOIN information ON information.house_id = house.id)LEFT JOIN locatype ON house.location = locatype.id) WHERE house.id LIKE '%$search_id%' AND house.name LIKE '%$search_name%' AND locatype.loca LIKE '%$search_location%' AND house.time LIKE '%$search_time%' AND people.name LIKE '%$search_owner%' AND house.price BETWEEN 501 AND 1000 ";
			elseif($search_price == 3)
				$sql = "SELECT DISTINCT house.id, house.name, house.price, IFNULL(locatype.loca, 'Unknown'), house.time, people.name FROM (((house INNER JOIN people ON house.owner_id = people.id)LEFT JOIN information ON information.house_id = house.id)LEFT JOIN locatype ON house.location = locatype.id) WHERE house.id LIKE '%$search_id%' AND house.name LIKE '%$search_name%' AND locatype.loca LIKE '%$search_location%' AND house.time LIKE '%$search_time%' AND people.name LIKE '%$search_owner%' AND house.price BETWEEN 1001 AND 1500 ";
			elseif($search_price == 4)
				$sql = "SELECT DISTINCT house.id, house.name, house.price, IFNULL(locatype.loca, 'Unknown'), house.time, people.name FROM (((house INNER JOIN people ON house.owner_id = people.id)LEFT JOIN information ON information.house_id = house.id)LEFT JOIN locatype ON house.location = locatype.id) WHERE house.id LIKE '%$search_id%' AND house.name LIKE '%$search_name%' AND locatype.loca LIKE '%$search_location%' AND house.time LIKE '%$search_time%' AND people.name LIKE '%$search_owner%' AND house.price >= 1501 ";
		}
		if($order == 1)
			$sql.= "order by price desc";
		elseif($order == 2)
			$sql.= "order by price asc";
		elseif($order == 3)
			$sql.= "order by time desc";
		elseif($order == 4)
			$sql.= "order by time asc";
		$result = mysqli_query($dbConnection,$sql);
		?>
		<form action="home.php?search=1" method="get">
			<input type="hidden" name="search" value=1>
			<?php
			if($search == 0){
			?>
				<input type="text" name="id" placeholder="ID">
				<input type="text" name="name" placeholder="Name">
				<select name="price">
					<option value=0 selected>Price</option>
					<option value=1>0~500</option>
					<option value=2>501~1000</option>
					<option value=3>1001~1500</option>
					<option value=4>1501~</option>
				</select>
				<input type="text" name="location" placeholder="Location">
				<input type="text" name="time" placeholder="Time">
				<input type="text" name="owner" placeholder="Owner"><br>
				<?php
					$sql2 = "SELECT id, info FROM infotype";
					$result2 = mysqli_query($dbConnection,$sql2);
					while($row2 = @mysqli_fetch_row($result2)){
						$tmp1 = $row2[0];
						$tmp2 = $row2[1];
						?>
						<input type="checkbox" name="information[]" value=<?php echo $tmp1?> ><?php echo $tmp2?>
						<?php
					}
				?>
				<!--
				<input type="checkbox" name="information[]" value="laundry facilities" >laundry facilities
				<input type="checkbox" name="information[]" value="wifi" >wifi
				<input type="checkbox" name="information[]" value="lockers" >lockers
				<input type="checkbox" name="information[]" value="kitchen" >kitchen
				<input type="checkbox" name="information[]" value="elevator" >elevator
				<input type="checkbox" name="information[]" value="no smoking" >no smoking
				<input type="checkbox" name="information[]" value="television" >television
				<input type="checkbox" name="information[]" value="breakfast" >breakfast
				<input type="checkbox" name="information[]" value="toiletries provided" >toiletries provided
				<input type="checkbox" name="information[]" value="shuttle service" >shuttle service
				-->
				<input type="submit" value="search" >
			<?php
			}
			else if($search == 1){
			?>
				<input type="text" name="id" placeholder="ID" value=<?php echo $search_id?>>
				<input type="text" name="name" placeholder="Name" value=<?php echo $search_name?> >
				<select name="price">
						<option value=0 <?php if($search_price == 0)echo 'selected' ?> >Price</option>
						<option value=1 <?php if($search_price == 1)echo 'selected' ?> >0~500</option>
						<option value=2 <?php if($search_price == 2)echo 'selected' ?> >501~1000</option>
						<option value=3 <?php if($search_price == 3)echo 'selected' ?> >1001~1500</option>
						<option value=4 <?php if($search_price == 4)echo 'selected' ?> >1501~</option>
						<!--switch($search_price){
							case 0:
								echo '<option value=0 selected>Price</option>';
								echo '<option value=1>0~500</option>';
								echo '<option value=2>501~1000</option>';
								echo '<option value=3>1001~1500</option>';
								echo '<option value=4>1501~</option>';
								break;
							case 1:
								echo '<option value=0>Price</option>';
								echo '<option value=1 selected>0~500</option>';
								echo '<option value=2>501~1000</option>';
								echo '<option value=3>1001~1500</option>';
								echo '<option value=4>1501~</option>';
								break;
							case 2:
								echo '<option value=0>Price</option>';
								echo '<option value=1>0~500</option>';
								echo '<option value=2 selected>501~1000</option>';
								echo '<option value=3>1001~1500</option>';
								echo '<option value=4>1501~</option>';
								break;
							case 3:
								echo '<option value=0>Price</option>';
								echo '<option value=1>0~500</option>';
								echo '<option value=2>501~1000</option>';
								echo '<option value=3 selected>1001~1500</option>';
								echo '<option value=4>1501~</option>';
								break;
							case 4:
								echo '<option value=0>Price</option>';
								echo '<option value=1>0~500</option>';
								echo '<option value=2>501~1000</option>';
								echo '<option value=3>1001~1500</option>';
								echo '<option value=4 selected>1501~</option>';
								break;
						}
						-->
				</select>
				<input type="text"  name="location" placeholder="Location" value=<?php echo $search_location?>>
				<input type="text" name="time" placeholder="Time" value=<?php echo $search_time?>>
				<input type="text" name="owner" placeholder="Owner" value=<?php echo $search_owner?>><br>
				<?php
				
					$sql2 = "SELECT id, info FROM infotype";
					$result2 = mysqli_query($dbConnection,$sql2);
					while($row2 = @mysqli_fetch_row($result2)){
						$tmp1 = $row2[0];
						$tmp2 = $row2[1];
						#echo '<input type="checkbox" name="information[]" value='$tmp1' checked>'$tmp2' ';
						if(@in_array($tmp1, $information_array)){
							?>
							<input type="checkbox" name="information[]" value=<?php echo $tmp1?> checked><?php echo $tmp2?>
							<?php
						}
						else{
							?>
							<input type="checkbox" name="information[]" value=<?php echo $tmp1?> ><?php echo $tmp2?>
							<?php
						}
					}
				/*
				if(@in_array("laundry facilities", $information_array))
					echo '<input type="checkbox" name="information[]" value="laundry facilities" checked>laundry facilities';
				else
					echo '<input type="checkbox" name="information[]" value="laundry facilities" >laundry facilities';
				if(@in_array("wifi", $information_array))
					echo '<input type="checkbox" name="information[]" value="wifi" checked>wifi';
				else
					echo '<input type="checkbox" name="information[]" value="wifi" >wifi';
				if(@in_array("lockers", $information_array))
					echo '<input type="checkbox" name="information[]" value="lockers" checked>lockers';
				else
					echo '<input type="checkbox" name="information[]" value="lockers" >lockers';
				if(@in_array("kitchen", $information_array))
					echo '<input type="checkbox" name="information[]" value="kitchen" checked>kitchen';
				else
					echo '<input type="checkbox" name="information[]" value="kitchen" >kitchen';
				if(@in_array("elevator", $information_array))
					echo '<input type="checkbox" name="information[]" value="elevator" checked>elevator';
				else
					echo '<input type="checkbox" name="information[]" value="elevator" >elevator';
				if(@in_array("no smoking", $information_array))
					echo '<input type="checkbox" name="information[]" value="no smoking" checked>no smoking';
				else
					echo '<input type="checkbox" name="information[]" value="no smoking" >no smoking';
				if(@in_array("television", $information_array))
					echo '<input type="checkbox" name="information[]" value="television" checked>television';
				else
					echo '<input type="checkbox" name="information[]" value="television" >television';
				if(@in_array("breakfast", $information_array))
					echo '<input type="checkbox" name="information[]" value="breakfast" checked>breakfast';
				else
					echo '<input type="checkbox" name="information[]" value="breakfast" >breakfast';
				if(@in_array("toiletries provided", $information_array))
					echo '<input type="checkbox" name="information[]" value="toiletries provided" checked>toiletries provided';
				else
					echo '<input type="checkbox" name="information[]" value="toiletries provided" >toiletries provided';
				if(@in_array("shuttle service", $information_array))
					echo '<input type="checkbox" name="information[]" value="shuttle service" checked>shuttle service';
				else
					echo '<input type="checkbox" name="information[]" value="shuttle service" >shuttle service';
				?>
				*/
				?>
				<input type="submit" value="search" >
			<?php
			}
			?>
		</form>
		<style>
			table, th, td {
				border: 1px solid black;
				border-collapse: collapse;
			}
		</style>
		<table style="width:100%">
			<th>ID</th>
			<th>Name</th>
			<th>
				<a href="<?php echo $_SERVER['REQUEST_URI'];?>&&order=1" >▲</a>
				Price
				<a href="<?php echo $_SERVER['REQUEST_URI'];?>&&order=2" >▼</a>
			</th>
			<th>Location</th>
			<th>
				<a href="<?php echo $_SERVER['REQUEST_URI'];?>&&order=3" >▲</a>
				Time
				<a href="<?php echo $_SERVER['REQUEST_URI'];?>&&order=4" >▼</a>
			</th>
			<th>Owner</th>
			<th>Information</th>
			<th>Option</th>
		<?php
        while($row = @mysqli_fetch_row($result)){
			$items = array();
			$sql2 = "SELECT infotype.id, infotype.info FROM ((house INNER JOIN information ON information.house_id = house.id )INNER JOIN infotype ON information.information = infotype.id )WHERE house.id = '$row[0]' ";
			#$sql2 = "SELECT information.information FROM house INNER JOIN information ON information.house_id = house.id WHERE house.id = '$row[0]' ";
			$result2 = mysqli_query($dbConnection,$sql2);
				$flag = 1;
				while(($row2 = @mysqli_fetch_row($result2))){
						array_push($items, $row2[0]);
				}
					foreach($information_array as $info){
						if(!@in_array($info, $items)){
							$flag = 0;
						}
					}
				
				if($flag == 0){
					continue;
				}
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
						
						foreach($items as $it){
							$sql3 = "SELECT info FROM infotype WHERE id = '$it' ";
							$result3 = mysqli_query($dbConnection,$sql3);
							$row3 = @mysqli_fetch_row($result3);
							echo $row3[0];
							echo '<br>';
						}
					?>
				</td>
				<td>
					<?php
					$sqlfavor = "SELECT * FROM favorite WHERE user_id = '$id' AND favorite.favorite_id = '$row[0]' ";
					$resultfavor = mysqli_query($dbConnection,$sqlfavor);
					if(mysqli_num_rows($resultfavor) >= 1){
						echo '已在我的最愛內';
					}
					else{?>
						<a href="house_favor_update.php?user=<?php echo $id ?>&house=<?php echo $row[0] ?>">favorite</a>   <?php
					}?>
					<br>
					<?php 
					if($_SESSION['Admin'] == true){
						?>
						<a href="home_delete.php?house=<?php echo $row[0] ?>">delete</a>
						<?php
					}
					?>
				</td>
			</tr>
		<?php
        }
		?>
		</table>
		<?php
	}
	else{
        echo '您無權限觀看此頁面!';
        echo '<meta http-equiv=REFRESH CONTENT=2;url=index.php>';
	}
	?>
</div>
</body>
</html>