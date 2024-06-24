<?php
$db_link =mysqli_connect("localhost","root",4234);

if (!$db_link)
    echo "connecting DB failed!";
else
{
    $selected_DB = mysqli_select_db($db_link, "seatreservationdatabase");
    if (!$selected_DB)
        echo "failed in selecting db";
//    else
//    {
//        mysqli_query($db_link,"UPDATE user Set password = '".password_hash("4234",PASSWORD_DEFAULT)."' where account = 'asd42' ");
//        $result = mysqli_query($db_link,"SELECT password From User where account = 'asd42' ");
//        $item = mysqli_fetch_assoc($result);
//        if (empty($item))
//            echo 4234;
//        else
//            echo $item["password"];

//        $sql = "SELECT NO From Seat WHERE NO = '50'";
//        $result = mysqli_query($db_link, $sql);
//
//        if (mysqli_num_rows($result)<1)
//            echo "not exist";
//        else
//        {
//            echo "exist";
//            while ($row_result = mysqli_fetch_row($result))
//            {
//                echo $row_result[0];
//            }
//        }
//
//
//    }
}
