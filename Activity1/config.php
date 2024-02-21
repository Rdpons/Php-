<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "activity1";

$link = mysqli_connect($host, $username, $password, $database);

if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}
?>