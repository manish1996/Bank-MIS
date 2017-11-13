<?php
/**
 * Created by PhpStorm.
 * User: pcsaini
 * Date: 12-11-2017
 * Time: 06:09 PM
 */

session_start();

if (!isset($_SESSION['adminSession'])) {
    header("Location: login.php");
}

if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['adminSession']);
    header("Location: login.php");
}