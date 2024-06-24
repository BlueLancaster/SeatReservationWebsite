<?php
session_start();
if(!isset($_SESSION["account"]))
{
    header('location: login.php');
}
else if($_SESSION["role"]=="admin")
{
    header('location: home_for_admin.php');
}