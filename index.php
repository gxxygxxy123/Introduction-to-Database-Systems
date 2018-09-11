<?php   
@session_start();
# remove all session variables   
session_unset();   
# destroy the session    
session_destroy();
$_SESSION['Admin']=false;
?> 
 
<!DOCTYPE html> 
<html> 
<head>
</head>
<body> 
<div align="center">
	<img src="index_pic.png" alt="picture"><br>
	<form action="connect.php" method="post">   
	帳號:<input type="text" name="username"><br>
	<br>
	密碼:<input type="password" name="password"><br><br>
	<input type="submit" name="button" value="登入"> 
	</form>
	<br>
	還沒有帳號？<a href="register.php">註冊</a><br>
</div>
</body> 
</html> 