<?php
require("connectDB.php");
session_start();

if(!(empty($_POST["name"])||empty($_POST["email"])))
{
    $stmt = mysqli_stmt_init($db_link);
    if (empty($_POST["password"]))
    {
        $sql = "UPDATE User SET name = ?, email = ? where account = ?";
        mysqli_stmt_prepare($stmt, $sql);
        mysqli_stmt_bind_param($stmt, 'sss', $_POST["name"], $_POST["email"], $_SESSION["account"]);
    }else
    {
        $sql = "UPDATE User SET password = ?, name = ?, email = ? where account = ?";
        $hashed_password = password_hash($_POST["password"], PASSWORD_DEFAULT);
        mysqli_stmt_prepare($stmt, $sql);
        mysqli_stmt_bind_param($stmt, 'ssss', $hashed_password,$_POST["name"], $_POST["email"], $_SESSION["account"]);
    }



    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    mysqli_close($db_link);

    header('location: profile.php?msg=success');
}
else
{
    header('location: profile.php?msg=failed');
}