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

$branch = $_GET['branch'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Transactions of <?php echo $branch; ?></title>

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
                <div class="panel-heading">Staff of <?php echo $branch; ?></div>
                <div class="panel-body">
                    <?php
                    if (isset($_GET['error'])) {
                        echo "<div class='alert alert-danger'>
                    <span class='glyphicon glyphicon-info-sign'></span> &nbsp; Error !
                    </div>";
                    }
                    if (isset($_GET['success'])){
                        echo "<div class='alert alert-success'>
                    <span class='glyphicon glyphicon-info-sign'></span> &nbsp; Successfully Delete !
                    </div>";
                    }
                    ?>
                    <div class="col-lg-12 text-right"><a class="btn btn-primary" href="addEmp.php">Add Employee</a></div>
                    </br></br>
                    <table class="table table-bordered table-responsive">
                        <thead>
                        <tr>
                            <th>Sr .No</th>
                            <th>Employee Name</th>
                            <th>Employee Designation</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $staff_query = "SELECT * FROM `staff` WHERE branch_id = '$branch'";
                        $staff_result = mysqli_query($DBcon,$staff_query);
                        if(mysqli_num_rows($staff_result) != 0){
                            $num = 0;
                            while ($staff = mysqli_fetch_assoc($staff_result)){
                                $num++; ?>
                                <tr>
                                    <td><?php echo $num ?></td>
                                    <td><?php echo $staff['emp_name']?></td>
                                    <td><?php echo $staff['emp_designation']?></td>
                                    <td>
                                        <a class="btn btn-danger" href="delete.php?emp=<?php echo $staff['emp_id'] ?>&branch_id=<?php echo $branch; ?>">Delete</a>
                                    </td>
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
