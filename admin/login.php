<?php
/**
 * Created by PhpStorm.
 * User: pcsaini
 * Date: 06-11-2017
 * Time: 11:32 AM
 */
session_start();
require_once 'db.php';

if (isset($_SESSION['adminSession']) != "") {
    header("Location: index.php");
    exit;
}

if (isset($_POST['btn-login'])) {

    $username = strip_tags($_POST['username']);
    $password = strip_tags($_POST['password']);

    $account_no = mysqli_real_escape_string($DBcon, $account_no);
    $password = mysqli_real_escape_string($DBcon, $password);

    if ($username == 'admin' && $password == 'admin') {
        $_SESSION['adminSession'] = 'admin';
        header("Location: index.php");
    } else {
        $msg = "<div class='alert alert-danger'>
     <span class='glyphicon glyphicon-info-sign'></span> &nbUsername and Password Don't Match !
    </div>";
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Banking MIS - Login</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link rel="stylesheet" href="../css/style.css" type="text/css"/>
</head>
<body>

<div class="signin-form">

    <div class="container">


        <form class="form-signin" method="post" id="login-form">

            <h2 class="form-signin-heading">Sign In.</h2>
            <hr/>

            <?php
            if (isset($msg)) {
                echo $msg;
            }
            ?>

            <div class="form-group">
                <input type="text" class="form-control" placeholder="Username" name="username" required/>
                <span id="check-e"></span>
            </div>

            <div class="form-group">
                <input type="password" class="form-control" placeholder="Password" name="password" required/>
            </div>

            <hr/>

            <div class="form-group">
                <button type="submit" class="btn btn-success" name="btn-login" id="btn-login">
                    <span class="glyphicon glyphicon-log-in"></span> &nbsp; Sign In
                </button>
            </div>

        </form>

    </div>

</div>

</body>
</html>