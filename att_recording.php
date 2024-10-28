<?php
    include 'conn.php';

    if(isset($_GET['cancel'])){
        $id = $_GET['cancel'];


        $sql = "UPDATE Attendance SET attStat = 'Cancelled' WHERE attRN = '$id'";

        if($conn->query($sql)){
            $_SESSION['success'] = "CANCELLED SUCCESSFULLY";
        }
        else{
            $_SESSION['error'] = "INVALID ACTION";
        }
    }
    
?>
<html>
    <head>
        <body>
            <div align = "center">
                <a href = "attendance.php">Record Attendance Here | </a>
                <a href = "index.php">Back to Menu</a>
            </div>
            <br>
            <table border = "1" align = "center">
                <th>RECORD #</th>
                <th>EMPLOYEE ID</th>
                <th>DATE/TIME IN</th>
                <th>DATE/TIME OUT</th>
                <th>STATUS</th>
                <th>ACTION</th>
                <?php
                    $sql = "SELECT * FROM Attendance ORDER BY attRN ASC";

                    $result = $conn->query($sql);
                    if($result->num_rows > 0){
                        while($row = $result->fetch_assoc()){
                ?>
                
                <tr>
                    <td><?=$row['attRN'];?></td>
                    <td><?=$row['empID'];?></td>
                    <td><?=$row['attDate'];?>&nbsp;<?=$row['attTimeIn'];?></td>
                    <td><?=$row['attDate'];?>&nbsp;<?=$row['attTimeOut'];?></td>
                    <td><?=$row['attStat'];?></td>
                    <td><a href = "cancel_att.php?cancel=<?=$row['attRN'];?>">Cancel</button></td>
                </tr>
               
                <?php
                    }
                }
                ?>
            </table>
        </body>
    </head>
</html>