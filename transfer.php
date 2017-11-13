<?php
/**
 * Created by PhpStorm.
 * User: pcsaini
 * Date: 06-11-2017
 * Time: 11:32 AM
 */

session_start();
include_once 'admin/db.php';

if (!isset($_SESSION['userSession'])) {
    header("Location: login.php");
}

$query = mysqli_query($DBcon, "SELECT * FROM account WHERE id=" . $_SESSION['userSession']);
$userRow = mysqli_fetch_array($query);

if (isset($_POST['transfer'])) {
    $send_account = $_POST['account_no'];
    $amount = $_POST['amount'];
    $remarks = $_POST['remarks'];

    $account_no = $userRow['account_no'];
    $user_current_balance = $userRow['current_balance'];

    $account_query = "SELECT account_no FROM account WHERE account_no = '$send_account'";
    $acc_result = mysqli_query($DBcon, $account_query);
     if ( @@ROWCOUNT==0){
        $msg = "<div class='alert alert-danger'>
                <span class='glyphicon glyphicon-info-sign'></span> &nbsp; Account Does not exist
                        </div>"; 

     }
     elseif ($user_current_balance > $amount)
     {
        $rec_query = "SELECT * FROM account WHERE account_no = '$send_account'";
        $rec_result = mysqli_query($DBcon, $rec_query);
        if ($rec_result) {
            $rec_account = mysqli_fetch_array($rec_result);
            $rec_account_no = $rec_account['account_no'];
            $rec_current_balance = $rec_account['current_balance'];

            $user_current_balance = $user_current_balance - $amount;

            $rec_current_balance = $rec_current_balance + $amount;
            if (mysqli_query($DBcon, "UPDATE account SET current_balance = '$rec_current_balance' WHERE account_no = '$rec_account_no'") && mysqli_query($DBcon, "UPDATE account SET current_balance = '$user_current_balance' WHERE account_no = '$account_no'")) {
                $transaction_id = rand(11111, 99999);
                $send_query = "INSERT INTO transactions (account_no,transaction_id,transaction_type,amount,balance,trans_account,remarks) VALUES ('$account_no','$transaction_id','DEBIT','$amount','$user_current_balance','$rec_account_no','$remarks')";
                $to_query = "INSERT INTO transactions (account_no,transaction_id,transaction_type,amount,balance,trans_account,remarks) VALUES ('$rec_account_no','$transaction_id','CREDIT','$amount','$rec_current_balance','$account_no','$remarks')";
                if (mysqli_query($DBcon, $send_query) && mysqli_query($DBcon, $to_query)) {
                    echo "<script>
                            alert('Transaction Success');
                            window.location.href = 'transfer.php'
                        </script>";
                } else {
                    $msg = "<div class='alert alert-danger'>
                            <span class='glyphicon glyphicon-info-sign'></span> &nbsp; Transaction Error - 2
                        </div>";
                }
            } else {
                $msg = "<div class='alert alert-danger'>
                        <span class='glyphicon glyphicon-info-sign'></span> &nbsp; Transaction Error - 1
                    </div>";
            }

        } else {
            $msg = "<div class='alert alert-danger'>
                    <span class='glyphicon glyphicon-info-sign'></span> &nbsp; Account Not Registered!
                </div>";
        }
    } else{
        $msg = "<div class='alert alert-danger'>
                    <span class='glyphicon glyphicon-info-sign'></span> &nbsp; You Does Not have Sufficient Amount!
                </div>";
    }



}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Welcome - <?php echo $userRow['name']; ?> on Banking MIS</title>

    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link rel="stylesheet" href="css/style.css" type="text/css"/>
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
                <li><a href="index.php">Your Account</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#"><span class="glyphicon glyphicon-user"></span>&nbsp; <?php echo $userRow['name']; ?></a>
                </li>
                <li><a href="logout.php?logout"><span class="glyphicon glyphicon-log-out"></span>&nbsp; Logout</a></li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>

<div class="container">
    <h3 class="text-center">Welcome - <?php echo $userRow['name']; ?></h3>
    <div class="row">
        <div class="col-lg-3" id="detail">
            <div class="panel panel-primary">
                <div class="panel-heading">Your Account</div>
                <div class="panel-body">
                    <div class="avatar">
                        <img src="img/avatar.png">
                    </div>
                    <div class="details">
                        <p><b>Name : </b><?php echo $userRow['name']; ?></p>
                        <p><b>Account Number : </b><?php echo $userRow['account_no']; ?></p>
                        <p><b>Account Type :</b>
                            <?php
                            $account_type = $userRow['type_of_accout_id'];
                            if ($account_type == 1) {
                                echo 'Saving';
                            } else {
                                echo 'Current';
                            }
                            ?>
                        </p>
                        <p><b>Current Balance:</b> <?php echo $userRow['current_balance']; ?> /-</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-9">
            <div class="panel panel-primary">
                <div class="panel-heading">Transfer Money</div>
                <div class="panel-body">

                    <?php
                    if (isset($msg)) {
                        echo $msg;
                    }
                    ?>

                    <form method="post" action="transfer.php">
                        <div class="form-group">
                            <label for="account_no">Account No</label>
                            <input type="number" class="form-control" id="account_no" name="account_no">
                        </div>
                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <input type="number" class="form-control" id="amount" name="amount">
                        </div>
                        <div class="form-group">
                            <label for="remark">Remarks</label>
                            <textarea type="text" class="form-control" id="remark" name="remarks"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary" name="transfer">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>