<?php
    include 'conn.php';

    $id = $_GET['delete'];

    $sql = "DELETE FROM Employees WHERE empID = '$id'";

    if($conn->query($sql)){
        $_SESSION['success'] = "DELETED SUCCESSFULLY";
    }
    else{
        $_SESSION['error']= "ERROR OCCURED";
    }

    header('location:emp_management.php');
?>