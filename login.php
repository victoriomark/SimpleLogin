<?php
global $conn;
session_start();

include "Connect.php"; // Assuming this file includes your database connection details

if(isset($_POST['UserName']) && isset($_POST['password'])){
    function Validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $UserName = Validate($_POST['UserName']);
    $Password = Validate($_POST['password']);

    if(empty($UserName)){
        header("Location: index.php?error=User Name is required");
        exit();
    } else if(empty($Password)){ // Note: You're checking for 'Password' but you have 'password' in your HTML form
        header("Location: index.php? error=Password is required");
        exit();
    }

    $Sql = "SELECT * FROM users  WHERE User_Name='$UserName' AND password='$Password' ";

    $result = mysqli_query($conn, $Sql);
    if(mysqli_num_rows($result) === 1){
        $row = mysqli_fetch_assoc($result);
        if (($row['User_Name'] === $UserName && $row['password'] === $Password)){
            echo "logged In"; // This line is for debugging purposes, consider removing it
            $_SESSION['User_Name'] = $row['User_Name'];
            $_SESSION['name'] = $row['name'];
            $_SESSION['id'] = $row['id'];
            header('Location: Home.php');
            exit();
        } else {
            header('Location: index.php?error=Incorrect UserName or Password');
            exit();
        }
    } else {
        header('Location: index.php');
        exit();
    }
}
?>
