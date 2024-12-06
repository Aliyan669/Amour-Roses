<?php

$localserver = 'localhost';
$username = 'root';
$password = '';
$database = 'amour_roses';

$conn = mysqli_connect($localserver, $username, $password, $database);
if ($conn->connect_error)
    die("Connection Failed")

?>