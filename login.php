<?php
/**
 * Created by PhpStorm.
 * User: pcsaini
 * Date: 06-11-2017
 * Time: 11:32 AM
 */
session_start();
require_once 'admin/db.php';

if (isset($_SESSION['userSession'])!="") {
    header("Location: index.php");
    exit;
}

if (isset($_POST['btn-login'])) {

    $account_no = strip_tags($_POST['account_no']);
    $password = strip_tags($_POST['password']);

    $account_no = mysqli_real_escape_string($DBcon,$account_no);
    $password = mysqli_real_escape_string($DBcon,$password);

    $password = md5($password);

    $query = "SELECT * FROM account WHERE account_no='$account_no' AND password = '$password'";
    if($result = mysqli_query($DBcon,$query)){
        $rowcount=mysqli_num_rows($result);
        if ($rowcount == 1) {
            $row = mysqli_fetch_array($result);
            $_SESSION['userSession'] = $row['id'];
            header("Location: index.php");
        } else {
            $msg = "<div class='alert alert-danger'>
     <span class='glyphicon glyphicon-info-sign'></span> &nbsp; Invalid Username or Password !
    </div>";
        }
    }else{
        $msg = "<div class='alert alert-danger'>
     <span class='glyphicon glyphicon-info-sign'></span> &nbsp; Some Database error !
    </div>";
    }

}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Banking MIS - Login</title>
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link rel="stylesheet" href="css/style.css" type="text/css" />
</head>
<body>

<div class="signin-form">

    <div class="container">


        <form class="form-signin" method="post" id="login-form">

            <h2 class="form-signin-heading">Sign In.</h2><hr />

            <?php
            if(isset($msg)){
                echo $msg;
            }
            ?>

            <div class="form-group">
                <input type="number" class="form-control" placeholder="Account No" name="account_no" required />
                <span id="check-e"></span>
            </div>

            <div class="form-group">
                <input type="password" class="form-control" placeholder="Password" name="password" required />
            </div>

            <hr />

            <div class="form-group">
                <button type="submit" class="btn btn-success" name="btn-login" id="btn-login">
                    <span class="glyphicon glyphicon-log-in"></span> &nbsp; Sign In
                </button>
            </div>

            Not Registered <a href="register.php">Sign Up Here</a>


        </form>

    </div>

</div>

</body>
</html>