<?php
    include 'conn.php';

    $employee = null;
    if(isset($_POST['search'])){
        $empID = $_POST['empID'];

        $sql = "SELECT * FROM Employees WHERE empID = '$empID'";
        $result = $conn->query($sql);

        if($result->num_rows > 0){
            $employee = $result->fetch_assoc();
        }
        else{
            $_SESSION['error'] = "NO SUCH EMPLOYEE EXISTED";
            header('location:attendance.php');
            exit();
        }
    }

    if(isset($_POST['attendance'])){
        $empID = $_POST['empID'];
        $attDate = $_POST['attDate'];
        $attTimeIn = $_POST['attTimeIn'];
        $attTimeOut = $_POST['attTimeOut'];
        $attStat = $_POST['attStat'];
        
        
        $sql = "INSERT INTO Attendance (empID, attDate, attTimeIn, attTimeOut, attStat) VALUES ('$empID' , '$attDate', '$attTimeIn', '$attTimeOut', '$attStat')";

        if($conn->query($sql)){
            $_SESSION['success'] = "ATTENDANCE MARKED!";
        }
        else{
            $_SESSION['error'] = "INVALID ATTENDANCE!";
        }
        header('location:att_recording.php');
    }
?>
<html>
    <head>
        <body>
            <?php if (!$employee): ?>
            <h2 align = "center">RECORD ATTENDANCE</h2>
            <form method = "post">
                <input type = "text" name = "empID" required placeholder = "Search by Empployee ID..">
                <button type = "submit" name = "search">SEARCH</button> 
            </form>
            <?php endif; ?>
            <?php if($employee):?>
                <form method  = "post">
                    <label>EMPLOYEE ID: </label>
                    <input type = "number" name = "empID" value = "<?=$employee['empID'];?>" readonly>
                    <br><br>
                    <label>FIRST NAME: </label>
                    <input type = "text" name = "empFName" value = "<?=$employee['empFName'];?>" readonly>
                    <br><br>
                    <label>LAST NAME: </label>
                    <input type = "text" name = "empLName" value = "<?=$employee['empLName'];?>" readonly>
                    <br><br>
                    <label>DATE: </label>
                    <input type = "date" name = "attDate">
                    <br><br>
                    <label>TIME IN: </label>
                    <input type = "time" name = "attTimeIn">
                    <br><br>
                    <label>TIME OUT: </label>
                    <input type = "time" name = "attTimeOut">
                    <br><br>
                    <label>STATUS: </label>
                    <input type = "text" name = "attStat" value = "Present" readonly>
                    <br><br>
                    <button type = "submit" name = "attendance">ATTENDANCE </button>
                </form>
            <?php endif; ?>
        </body>
    </head>
</html>