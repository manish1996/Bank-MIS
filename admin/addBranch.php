<?php
session_start();
if (!isset($_SESSION['adminSession'])) {
    header("Location: login.php");
}
require_once 'db.php';

if (isset($_POST['btn-signup'])) {

    $branch_code = strip_tags($_POST['branch_code']);
    $branch_name = strip_tags($_POST['branch_name']);

    $branch_code = mysqli_real_escape_string($DBcon, $branch_code);
    $branch_name = mysqli_real_escape_string($DBcon, $branch_name);

    $check_branch = mysqli_query($DBcon, "SELECT branch_code FROM branch WHERE branch_code ='$branch_code'");
    $count = mysqli_num_rows($check_branch);

    if ($count == 0) {

        $query = "INSERT INTO branch (branch_name,branch_code) VALUES('$branch_name','$branch_code')";

        if (mysqli_query($DBcon, $query)) {
            $msg = "<div class='alert alert-success'>
                    <span class='glyphicon glyphicon-info-sign'></span> &nbsp; Added Branch !
                    </div>";
        } else {
            $msg = "<div class='alert alert-danger'>
                    <span class='glyphicon glyphicon-info-sign'></span> &nbsp; error while adding Branch !
                    </div>";
        }
    } else {
        $msg = "<div class='alert alert-danger'>
                    <span class='glyphicon glyphicon-info-sign'></span> &nbsp; Sorry Branch already taken !
                </div>";
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Banking MIS - Add Account</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link rel="stylesheet" href="../css/style.css" type="text/css"/>

</head>
<body>
<nav class="navbar navbar-default">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Banking MIS</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li><a href="index.php">Accounts</a></li>
                <li><a href="addAccount.php">Add Accounts</a></li>
                <li><a href="branch.php">Branch</a></li>
                <li><a href="addBranch.php">Add Branch</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#"><span class="glyphicon glyphicon-user"></span>&nbsp; Admin</a>
                </li>
                <li><a href="logout.php?logout"><span class="glyphicon glyphicon-log-out"></span>&nbsp; Logout</a></li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>
<div class="signin-form">

    <div class="container">


        <form class="form-signin" method="post" id="register-form">

            <h2 class="form-signin-heading">Add Account</h2>
            <hr/>

            <?php
            if (isset($msg)) {
                echo $msg;
            }
            ?>

            <div class="form-group">
                <input type="text" class="form-control" placeholder="Branch Code" name="branch_code" required/>
            </div>

            <div class="form-group">
                <input type="text" class="form-control" placeholder="Branch Name" name="branch_name" required/>
            </div>

            <hr/>

            <div class="form-group">
                <button type="submit" class="btn btn-success" name="btn-signup">
                    <span class="glyphicon glyphicon-log-in"></span> &nbsp; Add Branch
                </button>
            </div>
        </form>

    </div>

</div>

</body>
</html>