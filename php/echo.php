<?php

require "DBconn.php";

// Creating a database named userDB
$dbsql = "CREATE DATABASE userDB";

    if (mysqli_query($conn, $dbsql))
        echo "Database created successfully with the name userDB";
    else
        echo "Error creating database: " . mysqli_error($conn);

// Creating connection
$conn = mysqli_connect($servername, $username, $password,"userDB");

// Checking connection
if (!$conn)
    die("Connection failed: " . mysqli_connect_error());

// sql to create table
$tabsql = "CREATE TABLE Users (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(30) NOT NULL,
    mail VARCHAR(30) NOT NULL,
    Opwd VARCHAR(50) NOT NULL,
    dob DATE DEFAULT CURRENT_TIMESTAMP NOT NULL,
    age INT(3) UNSIGNED NOT NULL,
    mobile VARCHAR(10) NOT NULL
    )";
    
    if (mysqli_query($conn, $tabsql))
        echo "Table Users created successfully";
    else
        echo "Error creating table: " . mysqli_error($conn);

    //Using Prepared Statements
    $sql = "INSERT INTO Users (firstname, mail, Opwd ,dob ,age ,mobile) VALUES (?, ?, ? ,?, ?, ?)";

    if($stmt = mysqli_prepare($conn,$sql))
    {
        mysqli_stmt_bind_param($stmt,"ssssis",$name,$email,$pass1,$dob,$age,$mobile);
        $name = mysqli_real_escape_string($conn,$_POST['Uname']);
        $email = mysqli_real_escape_string($conn,$_POST['Uemail']);
        $pass1 = mysqli_real_escape_string($conn,$_POST['Opwd']);
        $dob = mysqli_real_escape_string($conn,$_POST['dob']);
        $age = mysqli_real_escape_string($conn,$_POST['age']);
        $mobile = mysqli_real_escape_string($conn,$_POST['contact']);

        if(mysqli_stmt_execute($stmt))
            echo "New record created successfully";
        else
            echo "Could not execute Query : $sql " . mysqli_error($conn);
    }
    else
    {
        echo "Couldn't create Query $sql " . mysqli_error($conn);
    }
    mysqli_stmt_close($stmt);

// closing connection
mysqli_close($conn);
?>