<?php
require("check_admin_login.php");
require("connectDB.php");



if(!(empty($_POST["managementNO"])||empty($_POST["seatNO"])))
{
    $sql1 = "Select * From management WHERE NO = ? AND seat_NO = ?";
    $stmt = mysqli_stmt_init($db_link);
    mysqli_stmt_prepare($stmt, $sql1);
    mysqli_stmt_bind_param($stmt, 'ss', $_POST["managementNO"],$_POST["seatNO"]);
    mysqli_stmt_execute($stmt);
    $result1 = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);

    if (mysqli_num_rows($result1)>0)
    {
        $sql2 = "DELETE From management WHERE NO = ? AND seat_NO = ?";
        $stmt = mysqli_stmt_init($db_link);
        mysqli_stmt_prepare($stmt, $sql2);
        mysqli_stmt_bind_param($stmt, 'ss', $_POST["managementNO"],$_POST["seatNO"]);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        $item = mysqli_fetch_assoc($result1);
        echo "S,{$item["unavailable_date"]},{$_POST["seatNO"]}";
    }
    else
    {
        echo "F";
    }

}
else
{
    header('location: reservation_management.php');
}