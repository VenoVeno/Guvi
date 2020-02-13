<?php

require "DBconn.php";

// Creating connection
$conn = mysqli_connect($servername, $username, $password,"userDB");

// Checking connection
if (!$conn)
    die("Connection failed: " . mysqli_connect_error());

//Prepared Statement
$sql = "UPDATE Users SET Opwd = ? WHERE firstname = ? AND Opwd = ?";

    if($stmt = mysqli_prepare($conn,$sql))
    {
        mysqli_stmt_bind_param($stmt,"sss",$npass,$name,$opass);
        $npass = mysqli_real_escape_string($conn,$_POST['Newpass']);
        $name = mysqli_real_escape_string($conn,$_POST['Uname']);
        $opass = mysqli_real_escape_string($conn,$_POST['Oldpass']);

        if(mysqli_stmt_execute($stmt))
            echo "<script>console.log('Password Updated successfully')</script>";
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