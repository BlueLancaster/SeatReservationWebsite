<?php

require("check_admin_login.php");
require("connectDB.php");

if(!empty($_POST["seatNO"]))
{
    $sql = "Select * From seat WHERE NO = ?";
    $stmt = mysqli_stmt_init($db_link);
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, 's', $_POST["seatNO"]);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);

    if (mysqli_num_rows($result)==0)
    {
        echo "F";
    }
    else
    {
        $item = mysqli_fetch_assoc($result);
        echo "S,{$item["having_socket"]},{$item["having_computer"]},{$item["having_lamp"]}";
    }

}
else
{
    header('location: seat_management.php');
}

