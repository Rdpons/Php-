<?php
    include 'conn.php';
?>
<html>
    <head>
        <body>
            <div align = "center">
                <a href = "add_dep.php">Add Deparment Here | </a>
                <a href = "index.php">Back to Menu</a>
            </div>
            <br>
            <table border = "1" align = "center">
                <th>DEPARTMENT CODE</th>
                <th>DEPARTMENT NAME</th>
                <th>DEPARTMENT HEAD</th>
                <th>DEPARTMENT TEL NO</th>
                <th>ACTIONS</th>
                <?php
                    $sql = "SELECT * FROM Departments ORDER BY depCode ASC";

                    $result = $conn->query($sql);

                    if($result->num_rows > 0 ){
                        while($row = $result->fetch_assoc()){
                ?>
                <tr>
                    <td><?=$row['depCode']?></td>
                    <td><?=$row['depName']?></td>
                    <td><?=$row['depHead']?></td>
                    <td><?=$row['depTelNo']?></td>
                    <td>
                        <a href = "edit_dep.php?edit=<?=$row['depCode'];?>">EDIT</a>
                        <a href = "del_dep.php?delete=<?=$row['depCode'];?>">DELETE</a>
                    </td>
                </tr>
                <?php
                    }
                }
                ?>
            </table>
        </body>
    </head>
</html>