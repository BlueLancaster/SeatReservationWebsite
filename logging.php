<?php

if(!(empty($_POST["account"])||empty($_POST["password"])))
{
    include("connectDB.php");

    $account = $_POST["account"];
    $password = $_POST["password"];

    $sql = "SELECT * From User where account = ?";
    $stmt = mysqli_stmt_init($db_link);
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, 's', $account);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $item = mysqli_fetch_assoc($result);

    if(!empty($item))
    {
        if (password_verify($password, $item["password"]))
        {
            session_start();
            $_SESSION["account"] = $item["account"];
            $_SESSION["role"] = $item["role"];
            mysqli_stmt_close($stmt);
            mysqli_close($db_link);
            if ($_SESSION["role"] == "normal")
                header('location: home_for_normal.php');
            else if ($_SESSION["role"] == "admin")
                header('location: home_for_admin.php');

        }
        else
        {
            //PASSWORD is wrong
            header('location: login.php?error=1');
        }

    }
    else
    {
        // account is not existed
        header('location: login.php?error=2');
    }

    mysqli_stmt_close($stmt);
    mysqli_close($db_link);

}
else
{
    header('location: login.php');
}