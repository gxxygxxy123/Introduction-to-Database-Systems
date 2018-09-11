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
	//將session清空
	unset($_SESSION['username']);
	unset($_SESSION['Admin']);
	echo '登出中......';
	echo '<meta http-equiv=REFRESH CONTENT=1;url=index.php>';
	?>
</div>
</body>
</html>
