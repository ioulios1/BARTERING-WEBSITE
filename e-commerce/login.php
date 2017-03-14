<?php session_start(); ?>

<!DOCTYPE html>
<html>
    <head>
      <title>Bartering</title>

      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link href="css/bootstrap.css" rel="stylesheet">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
      <script src="https://npmcdn.com/tether@1.2.4/dist/js/tether.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/js/bootstrap.min.js" integrity="sha384-BLiI7JTZm+JWlgKa0M0kGRpJbF2J8q+qreVrKBC47e3K6BW78kGLrCkeRX6I9RoK" crossorigin="anonymous"></script>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/css/bootstrap.min.css" integrity="sha384-AysaV+vQoT3kOAXZkl02PThvDr8HYKPZhNT5h/CXfBThSRXQ6jW5DO2ekP5ViFdi" crossorigin="anonymous">
      <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css?family=Open+Sans|Roboto" rel="stylesheet">
      <link href="style.css" rel="stylesheet">
  </head>
<html>
<body>
<!--Δημιουργία φόρμας εισαγωγής στοιχείων-->
<div class="container">
    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            <h1 class="text-center login-title">Sign in</h1>
            <div class="account-wall">
                <i class="fa fa-user-circle profile-img" aria-hidden="true" style="font-size:100px;float:center;"></i>
                <form class="form-signin" action="" method="post">
                      <input type="text" class="form-control" placeholder="Username" required autofocus name="username">
                      <input type="password" class="form-control" placeholder="Password" required name="password">
                      <button class="btn btn-lg btn-primary btn-block" type="submit">Eίσοδος</button>
                      <label class="checkbox pull-left">
                          <a href="index.php" style="font-size:12px;">Επιστροφή</a>
                      </label>
                </form>
</body>
</html>

<?php

include 'db_connection.php';

$form_user = $_POST['username'];
$form_pass = $_POST['password'];

if(isset($form_user) && isset($form_pass))
{
      $sql = "SELECT u_id,username,password,status FROM users WHERE username='$form_user' and password='$form_pass'";
      $result = $connection->query($sql);

      if ($result->num_rows > 0) {

          while($row = $result->fetch_assoc()) {

              if($row["status"]==1){

                //o xristis uparxei ara kanei login
                $_SESSION['user_id'] = $row['u_id'];
                $_SESSION['username'] = $_POST['username'];
                $_SESSION['status'] = 1;
                header('Location: index.php');
              }
          }
      } else {
          echo '<br><div class="alert alert-danger">Λάθος όνομα χρήστη ή κωδικός πρόσβασης.</div>';
      }
}
$connection->close();

?>
