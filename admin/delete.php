<?php
include 'db.php';
if(isset($_GET['account'])){
    $account  = $_GET['account'];
    $query = "DELETE FROM account WHERE account_no = '$account'";
    $result = mysqli_query($DBcon,$query);
    if ($result){
        header("Location:index.php?success");
    }else{
        header("Location:index.php?success");
    }
}

if(isset($_GET['branch'])){
    $branch_id  = $_GET['branch'];
    $emp = "DELETE FROM staff WHERE branch_id = '$branch_id'";
    $emp_result = $result = mysqli_query($DBcon,$emp);
    $query = "DELETE FROM branch WHERE branch_id = '$branch_id'";
    $result = mysqli_query($DBcon,$query);
    if ($result && $emp_result){
        header("Location:branch.php?success");
    }else{
        header("Location:branch.php?error");
    }
}

if(isset($_GET['emp'])){
    $emp_id = $_GET['emp'];
    $branch_id = $_GET['branch_id'];
    $query = "DELETE FROM staff WHERE emp_id = '$emp_id'";
    $result = mysqli_query($DBcon,$query);
    if ($result){
        header("Location:staff.php?branch=$branch_id&success");
    }else{
        header("Location:staff.php?branch=$branch_id&error");
    }
}