<?php
    include 'conn.php';

    $departments = [];
    $depsql = "SELECT depCode, depName FROM departments";
    $depResult = $conn->query($depsql);
    if ($depResult) {
        while ($row = $depResult->fetch_assoc()) {
            $departments[] = $row;
        }
    }

    $id =  $_GET['edit'];

    $sql = "SELECT * FROM Employees WHERE empID = '$id'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();


    if(isset($_POST['update'])){
        $empID = $_POST['empID'];
        $empFName = $_POST['empFName'];
        $empLName= $_POST['empLName'];
        $depCode = $_POST['depCode'];
        $empRPH = $_POST['empRPH'];

        $sql = "UPDATE Employees SET empFName = '$empFName', empLName = '$empLName', depCode = '$depCode', empRPH = '$empRPH' WHERE empID = '$id'";

        if($conn->query($sql)){
            $_SESSION['success'] = "UPDATED SUCCESSFULLY";

        }
        else{
            $_SESSION['error'] = "ERROR OCCURED";
        }
        header('location:emp_management.php');
    }
?>

            <form method = "post">
                <label>EMPLOYEE ID: </label>
                <input type = "text" name = "empID" value = "<?=$row['empID'];?>" readonly>
                <br><br>
                <label>FIRST NAME: </label>
                <input type = "text" name = "empFName" value = "<?=$row['empFName'];?>">
                <br><br>
                <label>LAST NAME: </label>
                <input type = "text" name = "empLName" value = "<?=$row['empLName'];?>">
                <br><br>
                <label>DEPARTMENT: </label>
                <select name = "depCode">
                <?php
                    foreach ($departments as $department):
                ?>
                    <option value = "<?php echo $department['depCode'];?>"> <?php echo $department['depName'];?></option>
                <?php endforeach; ?>
                </select><br><br>
                <label>RATE PER HOUR: </label>
                <input type = "text" name = "empRPH" value = "<?=$row['empRPH'];?>">
                <br><br>
                <button type = "submit" name = "update">SUBMIT</button>
            </form>