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
	?>
	<a href="house_manage.php">取消</a><br><br>
	<h1>新增房子：</h1>
	<form action="house_manage_add_finish.php" method="post">
		house name：<input type="text" name="name" ><br><br>
		house price：<input type="text" name="price" ><br><br>
		house location：
		<?php
			$sql = "SELECT id, loca FROM locatype";
			$result = mysqli_query($dbConnection,$sql);
			?>
			<select name="location">
			<?php
			while($row = @mysqli_fetch_row($result)){
				?>
				<option value=<?php echo $row[0]?>><?php echo $row[1] ?></option>
				<?php
			}
			?>
			</select><br><br>
			<?php
		?>
		house time：<input type="date" name="time" > <br><br>
		house information：
		<?php
			$sql2 = "SELECT id, info FROM infotype";
			$result2 = mysqli_query($dbConnection,$sql2);
			?>
			<?php
			while($row2 = @mysqli_fetch_row($result2)){
				?>
				<input type="checkbox" name="information[]" value=<?php echo $row2[0]?> ><?php echo $row2[1]?><br>
				<?php
			}
		?>
		<!--<input type="checkbox" name="information[]" value="laundry facilities" checked>laundry facilities<br>
		<input type="checkbox" name="information[]" value="wifi" checked>wifi<br>
		<input type="checkbox" name="information[]" value="lockers" checked>lockers<br>
		<input type="checkbox" name="information[]" value="kitchen" checked>kitchen<br>
		<input type="checkbox" name="information[]" value="elevator" checked>elevator<br>
		<input type="checkbox" name="information[]" value="no smoking" checked>no smoking<br>
		<input type="checkbox" name="information[]" value="television" checked>television<br>
		<input type="checkbox" name="information[]" value="breakfast" checked>breakfast<br>
		<input type="checkbox" name="information[]" value="toiletries provided" checked>toiletries provided<br>
		<input type="checkbox" name="information[]" value="shuttle service" checked>shuttle service<br>
		-->
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