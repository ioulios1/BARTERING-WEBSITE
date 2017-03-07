<!DOCTYPE html>
<html>
    <head>
      <title>Bartering</title>

      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">

      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">


      <!-- Bootstrap core CSS -->
      <link href="css/bootstrap.css" rel="stylesheet">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
      <script src="https://npmcdn.com/tether@1.2.4/dist/js/tether.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/js/bootstrap.min.js" integrity="sha384-BLiI7JTZm+JWlgKa0M0kGRpJbF2J8q+qreVrKBC47e3K6BW78kGLrCkeRX6I9RoK" crossorigin="anonymous"></script>

      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/css/bootstrap.min.css" integrity="sha384-AysaV+vQoT3kOAXZkl02PThvDr8HYKPZhNT5h/CXfBThSRXQ6jW5DO2ekP5ViFdi" crossorigin="anonymous">


      <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css?family=Open+Sans|Roboto" rel="stylesheet">
     <!-- Custom styles for this template -->
      <link href="style.css" rel="stylesheet">

  </head>

<html>
<body>

<div class="container">
    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            <h1 class="text-center login-title">Εγγραφή</h1>
            <div class="account-wall">

                <form class="form-signin" method="post" action="">
                <input type="text" name="user" class="form-control" placeholder="Username" required autofocus>
                <input type="password" name="pass" class="form-control" placeholder="Password" required>
                <input type="text" name="email" class="form-control" placeholder="Email" required autofocus>
                <input type="text" name="fname" class="form-control" placeholder="Όνομα" required autofocus>
                <input type="text" name="lname" class="form-control" placeholder="Επώνυμο" required autofocus>
                <input type="text" name="addr" class="form-control" placeholder="Διεύθυνση" required>
                <input type="text" name="p_code" class="form-control" placeholder="Ταχυδρομικός Κώδικας" required autofocus>
                <input type="text" name="city" class="form-control" placeholder="Πόλη" required autofocus>

                <button class="btn btn-lg btn-success btn-block" type="submit">Eγγραφή</button>
                <label class="checkbox pull-left">
                    <a href="index.php" style="font-size:12px;">Επιστροφή</a>
                </label>

                </form>
            </div>
      </div>
    </div>
</div>

</body>
</html>

<?php

include 'db_connection.php';

//efoson ola ta pedia einai required apo tin html kiolas, to mono pou
//arkei einai na eleg3w ean exei stalei to ena mesw tis post formas.
if(isset($_POST["user"]))
{

  $user = mysql_escape_string($_POST['user']);
  $pass = mysql_escape_string($_POST['pass']);
  $email = mysql_escape_string($_POST['email']);
  $fname = mysql_escape_string($_POST['fname']);
  $lname = mysql_escape_string($_POST['lname']);
  $addr = mysql_escape_string($_POST['addr']);
  $p_code = mysql_escape_string($_POST['p_code']);
  $city = mysql_escape_string($_POST['city']);

  $insert = "INSERT INTO users (u_id, username, password, email, fname, sname, address, zipcode, city, status) VALUES (NULL, '$user', '$pass', '$email', '$fname', '$lname', '$addr', '$p_code', '$city', '0')";
  if (mysqli_query($connection, $insert)) {
    echo '<div style="float:center;padding-left:37%;">'.'Η εγγραφή ολοκληρώθηκε επιτυχώς'.'</div>';
  }
  else {
      echo '<div style="float:center;padding-left:37%;">'."Προσπαθήστε ξανά: " . $sql . "<br>" . mysqli_error($connection).'</div>';
  }

  mysqli_close($connection);
}


 ?>
