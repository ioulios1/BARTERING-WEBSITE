<?php
$connection = mysqli_connect('localhost', 'anakt190', 'anakt190', 'anakt190');
mysqli_set_charset($connection, 'utf8');
if (!$connection) {
    die('Could not connect: ' . mysqli_error($connection));
}
?>