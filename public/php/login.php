<?php

//Connection to DB (creation)
require "DBconn.php";

// // Creating connection
// $conn = mysqli_connect($servername, $username, $password,"userDB");

// Checking connection
if (!$conn)
    die("Connection failed: " . mysqli_connect_error());
else
    echo "prob here";

//Using Prepared Statemnts
$sql  = "SELECT firstname,mail,Opwd FROM Users WHERE firstname = ? OR mail = ?";

    if($stmt = mysqli_prepare($conn,$sql))
    {
        mysqli_stmt_bind_param($stmt,"ss",$email_name,$email_name);
        $email_name = mysqli_real_escape_string($conn,$_POST['Uemail_name']);
        $passw = mysqli_real_escape_string($conn,$_POST['Upwd']);
     
        if(mysqli_stmt_execute($stmt))
        {
            mysqli_stmt_bind_result($stmt,$Uname,$Uemail,$Upass);
            mysqli_stmt_fetch($stmt);
            if($email_name == $Uname || $email_name == $Uemail)
                echo "Name match Success";
        }
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