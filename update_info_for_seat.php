<?php

require("check_admin_login.php");
require("connectDB.php");

echo $_POST["seat"].gettype($_POST["seat"])."<br>";
echo $_POST["having_socket"].gettype($_POST["having_socket"])."<br>";
echo $_POST["having_computer"].empty($_POST["having_computer"])."<br>";
echo $_POST["having_lamp"].empty($_POST["having_lamp"])."<br>";


if(isset($_POST["seat"])&&isset($_POST["having_socket"])&&isset($_POST["having_computer"])&&isset($_POST["having_lamp"]))
{
    $sql1 = "Select * From seat WHERE NO = ?";
    $stmt = mysqli_stmt_init($db_link);
    mysqli_stmt_prepare($stmt, $sql1);
    mysqli_stmt_bind_param($stmt, 's',$_POST["seat"]);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);

    if (mysqli_num_rows($result)==0)
    {
        header('location: seat_management.php?msg=failed1');
    }
    else
    {
        $sql2 = "UPDATE seat SET having_socket = ?, having_computer = ?, having_lamp = ? WHERE NO = ?";
        $stmt = mysqli_stmt_init($db_link);
        mysqli_stmt_prepare($stmt, $sql2);
        mysqli_stmt_bind_param($stmt, 'ssss', $_POST["having_socket"], $_POST["having_computer"], $_POST["having_lamp"],$_POST["seat"]);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        header('location: seat_management.php?msg=success');
    }

}
else
{
    header('location: seat_management.php?msg=failed0');
}