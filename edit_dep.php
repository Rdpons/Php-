<?php
    include 'conn.php';

    $id = $_GET['edit'];

    $sql = "SELECT * FROM Departments WHERE depCode = '$id'";

    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    if(isset($_POST['update'])){
        $depCode = $_POST['depCode'];
        $depName = $_POST['depName'];
        $depHead = $_POST['depHead'];
        $depTelNo = $_POST['depTelNo'];

        $sql = "UPDATE Departments SET depName = '$depName', depHead = '$depHead', depTelNo = '$depTelNo' WHERE depCode = '$id'";

        if($conn->query($sql)){
            $_SESSION['success'] = "UPDATED SUCCESSFULLY";
        }
        else{
            $_SESSION['error'] = "ERROR OCCURED";
        }
        header('location:dep_management.php');
    }
    
?>
<h2>UPDATE DEPARTMENT</h2>
        <form method = "post">
            <label>Department Code: </label>
            <input type = "number" name = "depName" value = "<?=$row['depCode'];?>" readonly>
            <br><br>
            <label>Department Name: </label>
            <input type = "text" name = "depName" value = "<?=$row['depName'];?>">
            <br><br>
            <label>Department Head: </label>
            <input type = "text" name = "depHead" value = "<?=$row['depHead'];?>">
            <br><br>
            <label>Department Tel No: </label>
            <input type = "text" name = "depTelNo" value = "<?=$row['depTelNo'];?>">
            <br><br>
            <button type = "submit" name = "update">UPDATE</button>
        </form>