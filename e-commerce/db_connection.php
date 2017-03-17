<?php
$connection = mysqli_connect('localhost', 'username', 'password', 'database');
mysqli_set_charset($connection, 'utf8');
if (!$connection) {
    die('Could not connect: ' . mysqli_error($connection));
}
?>
