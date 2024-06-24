<?php
require("check_admin_login.php");
require("connectDB.php");

if(!(empty($_POST["seat"])||empty($_POST["date"])))
{
    $sql1 = "SELECT * FROM management WHERE seat_NO = ? AND unavailable_date = ?";
    $stmt = mysqli_stmt_init($db_link);
    mysqli_stmt_prepare($stmt, $sql1);
    mysqli_stmt_bind_param($stmt, 'ss',  $_POST["seat"], $_POST["date"]);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);

    if (mysqli_num_rows($result)==0)
    {
        $sql2 = "Insert INTO management(admin_account, seat_NO, unavailable_date) VALUES(?, ?, ?)";
        $stmt = mysqli_stmt_init($db_link);
        mysqli_stmt_prepare($stmt, $sql2);
        mysqli_stmt_bind_param($stmt, 'sss', $_SESSION["account"], $_POST["seat"], $_POST["date"]);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        header('location: reservation_management.php?msg=success');
    }
    else
    {
        header('location: reservation_management.php?msg=failed1');
    }
}
else
{
    header('location: reservation_management.php?msg=failed0');
}