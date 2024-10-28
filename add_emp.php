<?php
    include 'conn.php';

    $deparments = [];
    $sql = "SELECT depCode, depName FROM Departments";
    $result = $conn->query($sql);
    if($result){
        while($row = $result->fetch_assoc()){
            $deparments[] = $row;
        }
    }

    if(isset($_POST['add'])){
        $empFName = $_POST['empFName'];
        $empLName = $_POST['empLName'];
        $empRPH = $_POST['empRPH'];
        $depCode = $_POST['depCode'];

        $sql = "INSERT INTO Employees (empFName, empLName, empRPH, depCode) VALUES ('$empFName', '$empLName', '$empRPH', '$depCode')";

        if($conn->query($sql)){
            $_SESSION['success'] = "ADDED EMPLOYEE SUCCESSFULLY";
        }
        else{
            $_SESSION['success'] = "ERROR OCCURED";
        }
        header('location:emp_management.php');
    }
?>
<html>
    <head>
        <body>
            <h2>ADD EMPLOYEES</h2>
            <form method = "post">
                <label>FIRST NAME: </label>
                <input type = "text" name = "empFName">
                <br><br>
                <label>LAST NAME: </label>
                <input type = "text" name = "empLName">
                <br><br>
                <label>DEPARTMENT: </label>
                <select name = "depCode">
                <?php
                    foreach ($deparments as $department):
                ?>
                    <option value = "<?php echo $department['depCode'];?>"> <?php echo $department['depName'];?></option>
                <?php endforeach; ?>
                </select><br><br>
                <label>RATE PER HOUR: </label>
                <input type = "text" name = "empRPH">
                <br><br>
                <button type = "submit" name = "add">SUBMIT</button>
            </form>
        </body>
    </head>
</html>