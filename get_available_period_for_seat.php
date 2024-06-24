<?php
require("check_normal_login.php");
require("connectDB.php");


// first check the seat isn't set to unavailable by admin and second check the seat is reserved by others

if(!(empty($_POST["seatNO"])||empty($_POST["date"])))
{
    $seatNO=$_POST["seatNO"];
    $date=$_POST["date"];

    $sql1 = "Select * From management WHERE seat_NO = ? AND unavailable_date = ? ";
    $stmt = mysqli_stmt_init($db_link);
    mysqli_stmt_prepare($stmt, $sql1);
    mysqli_stmt_bind_param($stmt, 'ss', $seatNO, $date);
    mysqli_stmt_execute($stmt);
    $result1 = mysqli_stmt_get_result($stmt);
    $item = mysqli_fetch_assoc($result1);
    $str = "";


    if(mysqli_num_rows($result1)>0)
    {
        $str = $str."F";
    }
    else
    {
        $sql2 = "Select period From reservation WHERE seat_NO = ? AND date = ? ";
        $stmt = mysqli_stmt_init($db_link);
        mysqli_stmt_prepare($stmt, $sql2);
        mysqli_stmt_bind_param($stmt, 'ss', $seatNO, $date);
        mysqli_stmt_execute($stmt);
        $result2 = mysqli_stmt_get_result($stmt);
        $str = "S,";

        while ($row_result = mysqli_fetch_row($result2))
        {
            $str = $str."$row_result[0],";
        }

    }

//$text="".$var1.",".$var2.",".$var3.",".$var4.",".$var5."";
    echo $str;
}
else
{
    header('location: reservation.php');
}

