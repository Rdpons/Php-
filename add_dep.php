<?php
    include 'conn.php';

    if(isset($_POST['add'])){
        $depName = $_POST['depName'];
        $depHead = $_POST['depHead'];
        $depTelNo = $_POST['depTelNo'];


        $sql = "INSERT INTO Departments (depName, depHead, depTelNo) VALUES ('$depName', '$depHead', '$depTelNo')";

        if($conn->query($sql)){
            $_SESSION['success'] = "ADDED SUCCESSFULLY";
        }
        else{
            $_SESSION['error'] = "ERROR OCCURED";
        }
        header('location:dep_management.php');
    }
?>
<html>
    <head>
        <body>
            <h2 align = "center">ADD DEPARTMENT</h2>
            <form method = "post" align = "center">
                <label>Department Name: </label>
                <input type = "text" name = "depName">
                <br><br>
                <label>Department Head: </label>
                <input type = "text" name = "depHead">
                <br><br>
                <label>Department Tel No: </label>
                <input type = "text" name = "depTelNo">
                <br><br>
                <button type = "submit" name = "add">SUBMIT</button>
            </form>
        </body>
    </head>
</html>