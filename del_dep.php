<?php
    include 'conn.php';

    $id = $_GET['delete'];

    $sql = "DELETE FROM Departments WHERE depCode = '$id'";

    if($conn->query($sql)){
        $_SESSION['success'] = "DELETED SUCCESSFULLY";
    }
    else{
        $_SESSION['error'] = "ERROR OCCURED";
    }

    header('location:dep_management.php')
?>