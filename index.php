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
                <li><a href="transfer.php">Transfer Money</a></li>
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
                                if($account_type == 1){
                                    echo 'Saving';
                                }else{
                                    echo 'Current';
                                }
                            ?>
                        </p>
                        <p><b>Branch : </b>
                        <?php
                        $branch_id = $userRow['branch_id'];
                        $branch_query = "SELECT * FROM `branch` WHERE branch_id = '$branch_id'";
                        $branch_result = mysqli_query($DBcon,$branch_query);
                        $branch = mysqli_fetch_assoc($branch_result);
                        echo $branch['branch_name'];
                        ?>
                        </p>
                        <p><b>Current Balance:</b> <?php echo $userRow['current_balance']; ?> /-</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-9" id="transactions">
            <div class="panel panel-primary">
                <div class="panel-heading">Transactions</div>
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
                        $account_no = $userRow['account_no'];
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