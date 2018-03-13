<?php include '../lib/Session.php'; 
Session::init();
?>
<?php include '../config/config.php'; ?>
<?php include '../lib/Database.php'; ?>
<?php include '../helpers/format.php'; ?>
<?php 
$db = new Database(); 
$fm = new Format();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Login</title>
    <link rel="stylesheet" type="text/css" href="css/stylelogin.css" media="screen" />
</head>
<body>
<div class="container">
	<section id="content">

		<?php
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				$username = $fm->validation($_POST['username']);
				$password = $fm->validation($_POST['password']);	
				$username = mysqli_real_escape_string($db->link, $username);
				$password = mysqli_real_escape_string($db->link, $password);
			$query = "SELECT * FROM tbl_user WHERE username = '$username' AND password = md5('$password')";
			$result = $db->select($query);	
			if ($result != false) {
				$value = mysqli_fetch_array($result);
				$row = mysqli_num_rows($result);
			if ($row > 0) {
					Session::set('login',true);
					Session::set('username',$value['username']);
					Session::set('userId',$value['id']);
					header('location:index.php');
				}else{
				echo "<span style='color:red; font-size=18px;'>No Match Found !!</span>";

				}	
			}else{
				echo "<span style='color:red; font-size=18px;'>Username or Password Not Matched !!</span>";
			}}

		?>
		<form action="login.php" method="post">
			<h1>Admin Login</h1>
			<div>
				<input type="text" placeholder="Username" required="" name="username"/>
			</div>
			<div>
				<input type="password" placeholder="Password" required="" name="password"/>
			</div>
			<div>
				<input type="submit" value="Log in" />
	
			</div>
		</form><!-- form -->
		<div class="button">
			<a href="../index.php">SD Blog</a>
		</div><!-- button -->
	</section><!-- content -->
</div><!-- container -->
</body>
</html>
