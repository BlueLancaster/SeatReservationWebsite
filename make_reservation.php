<?php
require("check_normal_login.php");
require("connectDB.php");


//echo $_POST["seat"]."<br>".$_POST["date"]."<br>".$_POST["period"];

if(!(empty($_POST["seat"])||empty($_POST["date"])||empty($_POST["period"])))
{
    // check the one who want to reserve the seat doesn't reserve other seat at same period and the seat is not reserved by other person
    $sql1 = "Select * From reservation WHERE user_account = ? AND date = ? AND period = ? AND status = \"reserved\" ";
    $stmt = mysqli_stmt_init($db_link);
    mysqli_stmt_prepare($stmt, $sql1);
    mysqli_stmt_bind_param($stmt, 'sss', $_SESSION["account"], $_POST["date"], $_POST["period"]);
    mysqli_stmt_execute($stmt);
    $result1 = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);


    $sql2 = "Select * From reservation WHERE seat_NO = ? AND date = ? AND period = ? AND status = \"reserved\" ";
    $stmt = mysqli_stmt_init($db_link);
    mysqli_stmt_prepare($stmt, $sql2);
    mysqli_stmt_bind_param($stmt, 'sss', $_POST["seat"], $_POST["date"], $_POST["period"]);
    mysqli_stmt_execute($stmt);
    $result2 = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);

    $sql3 = "SELECT * FROM management WHERE seat_NO = ? AND unavailable_date = ?";
    $stmt = mysqli_stmt_init($db_link);
    mysqli_stmt_prepare($stmt, $sql3);
    mysqli_stmt_bind_param($stmt, 'ss', $_POST["seat"], $_POST["date"]);
    mysqli_stmt_execute($stmt);
    $result3 = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);


    if(mysqli_num_rows($result1)>0)
    {
        mysqli_close($db_link);
        header('location: reservation.php?msg=failed1');
    }
    else if(mysqli_num_rows($result2)>0)
    {
        mysqli_close($db_link);
        header('location: reservation.php?msg=failed2');
    }
    else if(mysqli_num_rows($result3)>0)
    {
        mysqli_close($db_link);
        header('location: reservation.php?msg=failed3');
    }
    else
    {
        $sql = "INSERT INTO reservation(user_account,seat_NO,date,period,status) VALUES (?,?,?,?,\"reserved\")";
        $stmt = mysqli_stmt_init($db_link);
        mysqli_stmt_prepare($stmt, $sql);
        mysqli_stmt_bind_param($stmt, 'ssss', $_SESSION["account"], $_POST["seat"], $_POST["date"], $_POST["period"]);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);


        include("send_email_module.php");
        $sql4 = "Select name, email From user WHERE account = \"{$_SESSION["account"]}\"";
        $result4 = mysqli_query($db_link, $sql4);
        $item = mysqli_fetch_row($result4);
        $name = "DearUser";
        $user_email = $item[1];

        $msg = "Date:{$_POST["date"]}\n Period:{$_POST["period"]}\n Seat:{$_POST["seat"]}\n";
        send_email($user_email, $name, "Your seat reservation is done", $msg);

        mysqli_close($db_link);

        header('location: reservation.php?msg=success');
    }

}
else
{
    header('location: reservation.php?msg=failed0');
}


