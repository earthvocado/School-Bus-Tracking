<?php
$server = 'localhost';
$username = 'root';
$password = 'bus12345';
$dbname = 'busdata';
$connection = mysqli_connect($server, $username, $password, $dbname);
mysqli_set_charset($connection,'utf8mb4');
?>