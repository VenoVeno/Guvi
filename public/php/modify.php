<?php

require "DBconn.php";

// // Creating connection
// $conn = mysqli_connect($servername, $username, $password,"userDB");

// Checking connection
if (!$conn)
    die("Connection failed: " . mysqli_connect_error());

//Prepared Statement
$sql = "UPDATE Users SET dob = ? , age = ? , mobile = ? WHERE firstname = ?";

    if($stmt = mysqli_prepare($conn,$sql))
    {
        mysqli_stmt_bind_param($stmt,"siss",$dob,$age,$mobile,$name);
        $dob = mysqli_real_escape_string($conn,$_POST['dob']);
        $age = mysqli_real_escape_string($conn,$_POST['age']);
        $mobile = mysqli_real_escape_string($conn,$_POST['contact']);
        $name = mysqli_real_escape_string($conn,$_POST['Uname']);

        if(mysqli_stmt_execute($stmt))
            echo "<script>console.log('New record Updated successfully')</script>";
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