<?php
$servername = "localhost";
$username = "root";
$password = "";

// Creating connection
$conn = mysqli_connect($servername, $username, $password);

// Checking connection
if (!$conn)
    die("Connection failed: " . mysqli_connect_error());

?>