<?php
/**
 * Created by PhpStorm.
 * User: pcsaini
 * Date: 12-11-2017
 * Time: 06:02 PM
 */

session_start();
include "db.php";
if (!isset($_SESSION['adminSession'])) {
    header("Location: login.php");
}

$account_no = $_GET['account'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Transactions of <?php echo $account_no; ?></title>

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

<div class="container">
    <h3 class="text-center">Welcome to Admin</h3>
    <div class="row">
        <div class="col-lg-12" id="accounts">
            <div class="panel panel-primary">
                <div class="panel-heading">Transactions of <?php echo $account_no; ?></div>
                <div class="panel-body">
                    <table class="table table-bordered table-responsive">
                        <thead>
                        <tr>
                            <th>Date & Time</th>
                            <th>Statement</th>
                            <th>Transaction Type</th>
                            <th>Amount</th>
                            <th>Current Balance</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $trans_query = "SELECT * FROM `transactions` WHERE account_no = '$account_no' ORDER BY created_at DESC";
                        $trans_result = mysqli_query($DBcon,$trans_query);
                        if(mysqli_num_rows($trans_result) != 0){
                            while ($rowTrans = mysqli_fetch_assoc($trans_result)){?>
                                <tr>
                                    <td><?php echo $rowTrans['created_at']?></td>
                                    <td>
                                        <?php
                                        if ($rowTrans['transaction_type'] == 'DEBIT'){
                                            echo 'TRANSFER To '.$rowTrans['trans_account'].' UPI/SBI/'.$rowTrans['transaction_id'].' '.$rowTrans['remarks'];
                                        }else{
                                            echo 'TRANSFER By '.$rowTrans['trans_account'].' UPI/SBI/'.$rowTrans['transaction_id'].' '.$rowTrans['remarks'];
                                        }
                                        ?>
                                    </td>
                                    <td><?php echo $rowTrans['transaction_type']?></td>
                                    <td><?php echo $rowTrans['amount']?></td>
                                    <td><?php echo $rowTrans['balance']?></td>
                                </tr>
                            <?php }
                        }else{
                            echo 'No Transaction';
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
