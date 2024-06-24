<?php
require("check_admin_login.php");
require("connectDB.php");
if(!(empty($_POST["seatNO"])))
{
    $sql = "SELECT * FROM management WHERE seat_NO = ? ORDER BY unavailable_date DESC";
    $stmt = mysqli_stmt_init($db_link);
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, 's',  $_POST["seatNO"]);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);


    $data = array();
    while ($row_result = mysqli_fetch_assoc($result))
    {
       $data[] = $row_result;
    }

    echo json_encode($data);


}
else
{
    header('location: reservation_management.php');
}

