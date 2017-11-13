<?php
session_start();
if (isset($_SESSION['userSession']) != "") {
    header("Location: index.php");
}
require_once 'admin/db.php';

if (isset($_POST['btn-signup'])) {

    $name = strip_tags($_POST['name']);
    $account_no = strip_tags($_POST['account_no']);
    $account_type = strip_tags($_POST['account_type']);
    $branch_id = strip_tags($_POST['branch_id']);
    $password = strip_tags($_POST['password']);

    $name = mysqli_real_escape_string($DBcon, $name);
    $account_no = mysqli_real_escape_string($DBcon, $account_no);
    $branch_id = mysqli_real_escape_string($DBcon, $branch_id);
    $password = mysqli_real_escape_string($DBcon, $password);
    $account_type = mysqli_real_escape_string($DBcon, $account_type);

    $password = md5($password); // this function works only in PHP 5.5 or latest version

    $check_account_no = mysqli_query($DBcon, "SELECT account_no FROM account WHERE account_no ='$account_no'");
    $count = mysqli_num_rows($check_account_no);

    if ($count == 0) {

        $query = "INSERT INTO account(name,account_no,type_of_accout_id,branch_id,current_balance,password) VALUES('$name','$account_no','$account_type','$branch_id','1000','$password')";

        if (mysqli_query($DBcon, $query)) {
            $transaction_id = rand(11111, 99999);
            $add_money = "INSERT INTO transactions (account_no,transaction_id,transaction_type,amount,balance,trans_account,remarks) VALUES ('$account_no','$transaction_id','CREDIT','1000','1000','','Add Money')";
            if (mysqli_query($DBcon, $add_money)) {
                $id = mysqli_insert_id($DBcon);
                $_SESSION['userSession'] = $id;
                header("Location: index.php");
            } else {
                $msg = "<div class='alert alert-danger'>
      <span class='glyphicon glyphicon-info-sign'></span> &nbsp; Problem in Add Money !
     </div>";
            }

        } else {
            $msg = "<div class='alert alert-danger'>
                        <span class='glyphicon glyphicon-info-sign'></span> &nbsp; error while registering !
                    </div>";
        }

    } else {
        $msg = "<div class='alert alert-danger'>
                    <span class='glyphicon glyphicon-info-sign'></span> &nbsp; Sorry Account already taken !
                </div>";
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Banking MIS - Register</title>
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link rel="stylesheet" href="css/style.css" type="text/css"/>

</head>
<body>

<div class="signin-form">

    <div class="container">


        <form class="form-signin" method="post" id="register-form">

            <h2 class="form-signin-heading">Sign Up</h2>
            <hr/>

            <?php
            if (isset($msg)) {
                echo $msg;
            }
            ?>

            <div class="form-group">
                <input type="text" class="form-control" placeholder="Full Name" name="name" required/>
            </div>

            <div class="form-group">
                <input type="number" class="form-control" placeholder="Account No" name="account_no" required/>
                <span id="check-e"></span>
            </div>

            <div class="form-group">
                <select name="account_type" class="form-control" required>
                    <option disabled selected>Select Account Type</option>
                    <option value="1">Saving</option>
                    <option value="2">Current</option>
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

            <div class="form-group">
                <input type="password" class="form-control" placeholder="Password" name="password" required/>
            </div>

            <hr/>

            <div class="form-group">
                <button type="submit" class="btn btn-success" name="btn-signup">
                    <span class="glyphicon glyphicon-log-in"></span> &nbsp; Create Account
                </button>
            </div>

            Already Registered <a href="index.php">Log In Here</a>

        </form>

    </div>

</div>

</body>
</html>