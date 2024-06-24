<?php

require("check_normal_login.php");
require("connectDB.php");

if(!empty($_POST["reservationNO"]))
{
    $sql1 = "Select * From reservation WHERE NO = ? AND user_account = ?";
    $stmt = mysqli_stmt_init($db_link);
    mysqli_stmt_prepare($stmt, $sql1);
    mysqli_stmt_bind_param($stmt, 'ss', $_POST["reservationNO"],$_SESSION["account"]);
    mysqli_stmt_execute($stmt);
    $result1 = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);


    if(mysqli_num_rows($result1)>0)
    {
        $item1 = mysqli_fetch_assoc($result1);

        $sql2 = "UPDATE reservation SET status = 'canceled' WHERE NO = ? AND user_account = ?";
        $stmt = mysqli_stmt_init($db_link);
        mysqli_stmt_prepare($stmt, $sql2);
        mysqli_stmt_bind_param($stmt, 'ss', $_POST["reservationNO"],$_SESSION["account"]);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        include("send_email_module.php");
        $sql3 = "Select name, email From user WHERE account = \"{$_SESSION["account"]}\"";
        $result3 = mysqli_query($db_link, $sql3);
        $item2 = mysqli_fetch_row($result3);
        $name = "DearUser";
        $user_email = $item2[1];

        $msg = "Date:{$item1["date"]}\n Period:{$item1["period"]}\n Seat:{$item1["seat_NO"]}\n";
        send_email($user_email, $name, "You have canceled the seat reservation", $msg);



        echo "S,".$item1["date"].",".$item1["period"].",".$item1["seat_NO"].",";
    }
    else
    {
        //The record is not existed
        echo "F";
    }
}
else
{
    header('location: record.php');
}
