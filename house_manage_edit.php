<?php
session_start();
include("mysql_connect.php");
?>
<!DOCTYPE html>
<html>
<head>
</head>
<body>
<div align="center">
	<?php
	if($_SESSION['username'] != null){
		$house_id = $_GET['house'];
		$name = $_GET['name'];
		$price = $_GET['price'];
		$location = $_GET['location'];
		$time = $_GET['time'];
	?>
		<a href="house_manage.php?">取消</a><br><br>
		<h1>編輯房屋：</h1>
		<form action="house_manage_edit_finish.php?house=<?php echo $house_id ?>" method="post" >
		name：<input type="text" name="name" value="<?php echo $name?>" ><br><br>
		price：<input type="text" name="price" value="<?php echo $price?>"><br><br>
		location：
		
		<?php
			$sql = "SELECT id, loca FROM locatype";
			$result = mysqli_query($dbConnection,$sql);
			?>
			<select name="location">
			<?php
			while($row = @mysqli_fetch_row($result)){
				?>
				<option value=<?php echo $row[0]?> ><?php echo $row[1]?></option>
				<?php
			}
			?>
			</select><br><br>
			<?php
		?>
		time：<input type="date" name="time" value="<?php echo $time?>"> <br><br>
		information：
		<?php
			$sql2 = "SELECT id, info FROM infotype";
			$result2 = mysqli_query($dbConnection,$sql2);
			?>
			<?php
			while($row2 = @mysqli_fetch_row($result2)){
				?>
				<input type="checkbox" name="information[]" value=<?php echo $row2[0]?> checked><?php echo $row2[1]?><br>
				<?php
			}
		?>
		<!--
		<input type="checkbox" name="information[]" value="laundry_facilities" checked>laundry facilities<br>
		<input type="checkbox" name="information[]" value="wifi" checked>wifi<br>
		<input type="checkbox" name="information[]" value="lockers" checked>lockers<br>
		<input type="checkbox" name="information[]" value="kitchen" checked>kitchen<br>
		<input type="checkbox" name="information[]" value="elevator" checked>elevator<br>
		<input type="checkbox" name="information[]" value="no_smoking" checked>no smoking<br>
		<input type="checkbox" name="information[]" value="television" checked>television<br>
		<input type="checkbox" name="information[]" value="breakfast" checked>breakfast<br>
		<input type="checkbox" name="information[]" value="toiletries_provided" checked>toiletries provided<br>
		<input type="checkbox" name="information[]" value="shuttle_service" checked>shuttle service<br>
		-->
		<!--information：<input type="text" name="information" > <br><br> -->
		<input type="submit" value="確定" >
		</form>
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