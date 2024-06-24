<?php
session_start();
if(!isset($_SESSION["account"]))
{
    header('location: login.php');
}
else if($_SESSION["role"]=="normal")
{
    header('location: home_for_normal.php');
}