<?php

//Connection to DB (creation)
require "DBconn.php";

// // Creating connection
// $conn = mysqli_connect($servername, $username, $password,"userDB");

// Checking connection
if (!$conn)
    die("Connection failed: " . mysqli_connect_error());

//Using Prepared Statemnts
$sql  = "SELECT firstname,mail,Opwd,dob,age,mobile FROM Users WHERE firstname = ?";

    if($stmt = mysqli_prepare($conn,$sql))
    {
        mysqli_stmt_bind_param($stmt,"s",$name);
        $name = mysqli_real_escape_string($conn,$_POST['Uname']);

        if(mysqli_stmt_execute($stmt))
        {
            mysqli_stmt_bind_result($stmt,$firstname,$mail,$Opwd,$dob,$age,$mobile);
            mysqli_stmt_fetch($stmt);
            echo "<div class=\"form-group\">";
            echo "<label for=\"Opwd\">Name</label>";
            echo "<input type=\"text\" class =\"form-control\" id=\"Uname\" placeholder=\"Enter password\" value = " . $firstname . " disabled required>";
            echo "</div>";
            echo "<div class=\"form-group\">";
            echo "<label for=\"Opwd\">Mail</label>";
            echo "<input type=\"mail\" class =\"form-control\" id=\"Uemail\" value = " . $mail . " disabled>";
            echo "</div>";
            echo "<div class=\"form-group\">";
            echo "<input type=\"hidden\" class =\"form-control\"  id=\"Opwd\" value = " . $Opwd . " disabled>";
            echo "</div>";
            echo "<div class=\"form-group\">";
            echo "<label for=\"Opwd\">Date of Birth</label>";
            echo "<input type=\"date\" class =\"form-control\" id=\"DOB\" value = " . $dob . " required>";
            echo "</div>";
            echo "<div class=\"form-group\">";
            echo "<label for=\"Opwd\">Age</label>";
            echo "<input type=\"number\" class =\"form-control\" id=\"Uage\" value = " . $age . " disabled>";
            echo "</div>";
            echo "<div class=\"form-group\">";
            echo "<label for=\"Opwd\">Mobile Number</label>";
            echo "<input type=\"number\" class =\"form-control\" id=\"Unum\" value = " . $mobile . " required>";     
            echo "</div>";
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