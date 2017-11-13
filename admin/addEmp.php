<?php
session_start();
if (!isset($_SESSION['adminSession'])) {
    header("Location: login.php");
}
require_once 'db.php';

if (isset($_POST['btn-signup'])) {

    $emp_name = strip_tags($_POST['emp_name']);
    $emp_designation = strip_tags($_POST['emp_designation']);
    $branch_id = strip_tags($_POST['branch_id']);

    $emp_name = mysqli_real_escape_string($DBcon, $emp_name);
    $branch_name = mysqli_real_escape_string($DBcon, $emp_designation);
    $branch_id = mysqli_real_escape_string($DBcon, $branch_id);

    $check_emp = mysqli_query($DBcon, "SELECT emp_id FROM staff WHERE emp_name ='$emp_name' AND emp_designation = '$emp_designation' AND branch_id='$branch_id'");
    $count = mysqli_num_rows($check_emp);

    if ($count == 0) {

        $query = "INSERT INTO staff (emp_name,emp_designation,branch_id) VALUES('$emp_name','$emp_designation','$branch_id')";

        if (mysqli_query($DBcon, $query)) {
            $msg = "<div class='alert alert-success'>
                    <span class='glyphicon glyphicon-info-sign'></span> &nbsp; Employee Added !
                    </div>";
        } else {
            $msg = "<div class='alert alert-danger'>
                    <span class='glyphicon glyphicon-info-sign'></span> &nbsp; error while adding Employee !
                    </div>";
        }
    } else {
        $msg = "<div class='alert alert-danger'>
                    <span class='glyphicon glyphicon-info-sign'></span> &nbsp; Sorry Employee already taken !
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

            <h2 class="form-signin-heading">Add Employee</h2>
            <hr/>

            <?php
            if (isset($msg)) {
                echo $msg;
            }
            ?>

            <div class="form-group">
                <input type="text" class="form-control" placeholder="Employee Name" name="emp_name" required/>
            </div>

            <div class="form-group">
                <select type="text" class="form-control" name="emp_designation" required>
                    <option disabled selected>Select Employee Designation</option>
                    <option value="Manager">Manager</option>
                    <option value="Collector">Collector</option>
                    <option value="Casher">Casher</option>
                </select>
            </div>

            <div class="form-group">
                <select name="branch_id" class="form-control" required>
                    <option disabled selected>Select Branch</option>
                    <?php
                    $branch_query = "SELECT * FROM `branch`";
                    $branch_result = mysqli_query($DBcon, $branch_query);
                    if (mysqli_num_rows($branch_result) > 0){
                        while ($branch = mysqli_fetch_assoc($branch_result)){
                            echo '<option value="'.$branch['branch_id'].'">'.$branch['branch_name'].'</option>';
                        }
                    }
                    ?>
                </select>
            </div>

            <hr/>

            <div class="form-group">
                <button type="submit" class="btn btn-success" name="btn-signup">
                    <span class="glyphicon glyphicon-log-in"></span> &nbsp; Add Employee
                </button>
            </div>
        </form>

    </div>

</div>

</body>
</html>