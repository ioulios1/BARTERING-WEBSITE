<!DOCTYPE html>
<html>
<head>
	<title>Administration Page</title>
	<meta charset="UTF-8">
	<link rel="shortcut icon" href="images/admin.png">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<style>
		body { background-color:#819FF7; }
	</style>
</head>
<body>

<form name="moderator_login_form" method="post" action="">
	<div class="container"> 
		<div id="loginbox" style="margin-top:12%" class="mainbox col-md-4 col-md-offset-4 col-sm-8 col-sm-offset-2">  
			<div class="panel panel-info">
				<div class="panel-heading">
					<div class="panel-title">Διαχείριση</div>
				</div>     
				<center><img src="images/admin.png" height="100" width="100"></center>
				<div style="padding-top:30px" class="panel-body">
					<div style="margin-bottom: 25px" class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
						<input id="login-username" type="text" class="form-control" name="username" placeholder="Όνομα χρήστη" required autofocus>                                        
					</div>
					<div style="margin-bottom: 25px" class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
						<input id="login-password" type="password" class="form-control" name="password" placeholder="Κωδικός πρόσβασης" required>
					</div>								
					<button type="submit" class="btn btn-primary btn-lg btn-block">Σύνδεση</button>


<?php
include '../db_connection.php';
if (!isset($_POST['username'])) exit;
session_start();

$username = $_POST['username'];
$password = $_POST['password'];

$user = mysqli_query($connection, "SELECT * FROM moderators WHERE username = '$username' AND password = '$password'");

if (!mysqli_num_rows($user)) { 
	echo '<br><div class="alert alert-danger">Λάθος όνομα χρήστη ή κωδικός πρόσβασης.</div>';
}
else {
	$_SESSION['moderator'] = $_POST['username'];
    $_SESSION['login'] = 1;
	header("Location: moderator.php");
}

mysqli_close($connection);
?>

				</div>
			</div>
		</div>
	</div>
</form>

</body>
</html>