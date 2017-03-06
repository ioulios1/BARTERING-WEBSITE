<?php
session_start();
$_SESSION['login'] = 0; // Destroying All Session
header("Location: index.php"); // Redirecting To Home Page
?>