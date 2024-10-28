<?php
    include 'conn.php';
?>
<html>
    <head>
        <body>
            <div align = "center">
                <a href = "add_emp.php">Add an Employees Here | </a> 
                <a href = "index.php">Back to Menu</a>
            </div>
            <br>
            <div>
                <table border = "1" align = "center">
                    <th>EMPLOYEE ID</th>
                    <th>DEPARTMENT</th>
                    <th>FIRST NAME</th>
                    <th>LAST NAME</th>
                    <th>RATE PER HOUR</th>
                    <th>ACTIONS</th>
                    <?php
                        $sql = "SELECT * FROM Employees LEFT JOIN Departments ON Employees.DepCode = Departments.DepCode ORDER BY empID ASC";

                        $result = $conn->query($sql);
                        if($result->num_rows > 0){
                            while($row = $result->fetch_assoc()){
                    ?>
                    <tr>
                        <td><?=$row['empID'];?></td>
                        <td><?=$row['depCode'];?></td>
                        <td><?=$row['empFName'];?></td>
                        <td><?=$row['empLName'];?></td>
                        <td><?=$row['empRPH'];?></td>
                        <td>
                            <a href = "edit_emp.php?edit=<?=$row['empID'];?>">EDIT</a>
                            <a href = "del_emp.php?delete=<?=$row['empID'];?>">DELETE</a>
                        </td>
                    </tr>
                    <?php
                        }
                    }
                    ?>
                </table>
            </div>
        </body>
    </head>
</html>