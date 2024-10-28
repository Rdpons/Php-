<?php
include 'conn.php';

$employee = null;
$attendanceRecords = [];
$totalHours = 0;
$salary = 0;
$ratePerHour = 0;

if (isset($_POST['searchByID'])) {
    $empID = $_POST['empID'];

    $empSql = "SELECT e.empID, e.empFName, e.empLName, e.empRPH, d.depName
                FROM employees e
                JOIN departments d ON e.depCode = d.depCode
                WHERE e.empID = '$empID'";
    $empResult = $conn->query($empSql);

    if ($empResult->num_rows > 0) {
        $employee = $empResult->fetch_assoc();
        $ratePerHour = $employee['empRPH'];

        $attSql = "SELECT attRn, attDate, attTimeIn, attTimeOut, empID FROM attendance WHERE empID = '$empID'";
        $attResult = $conn->query($attSql);

        if ($attResult) {
            while ($row = $attResult->fetch_assoc()) {
                $attendanceRecords[] = $row;

                $timeIn = new DateTime($row['attTimeIn']);
                $timeOut = new DateTime($row['attTimeOut']);
                $interval = $timeIn->diff($timeOut);
                $hoursWorked = $interval->h + ($interval->i / 60);
                $totalHours += $hoursWorked;
            }
            $salary = $totalHours * $ratePerHour;
        }
    } else {
        echo "<script>alert('Employee ID does not exist!'); window.location.href='attendance_monitoring.php';</script>";
    }
}

if (isset($_POST['searchByDate'])) {
    $dateFrom = $_POST['dateFrom'];
    $dateTo = $_POST['dateTo'];

    $attSql = "SELECT attRn, attDate, attTimeIn, attTimeOut, empID FROM attendance WHERE attDate BETWEEN '$dateFrom' AND '$dateTo'";
    $attResult = $conn->query($attSql);

    if ($attResult) {
        while ($row = $attResult->fetch_assoc()) {
            $attendanceRecords[] = $row;

            $timeIn = new DateTime($row['attTimeIn']);
            $timeOut = new DateTime($row['attTimeOut']);
            $interval = $timeIn->diff($timeOut);
            $hoursWorked = $interval->h + ($interval->i / 60);
            $totalHours += $hoursWorked;
        }
    }
}
?>

<html>
<head>
    <title>Attendance Monitoring</title>
</head>
<body>
    <div align="center">
        <a href="index.html">Back to Menu</a>
    </div>
    <br>

    <form method="POST" style="text-align: center;">
        <label>Employee ID: </label>
        <input type="text" name="empID">
        <input type="submit" name="searchByID" value="Search by ID"><br><br>

        <label>Date From: </label>
        <input type="date" name="dateFrom">
        <label>Date To: </label>
        <input type="date" name="dateTo">
        <input type="submit" name="searchByDate" value="Search By Date">
    </form>
    <br>

    <?php if ($employee): ?>
        <div align="center">
            <p>Name: <?= $employee['empFName'] . ' ' . $employee['empLName'] ?></p>
            <p>Department: <?= $employee['depName'] ?></p>
        </div>
    <?php endif; ?>

    <h3 align="center">Attendance Records</h3>

    <table border="1" align="center">
        <tr>
            <th>Record ID</th>
            <th>Employee ID</th>
            <th>Date</th>
            <th>Time In</th>
            <th>Time Out</th>
            <th>Total Hours</th>
        </tr>
        <?php foreach ($attendanceRecords as $record): ?>
            <?php 
                $timeIn = new DateTime($record['attTimeIn']);
                $timeOut = new DateTime($record['attTimeOut']);
                $interval = $timeIn->diff($timeOut);
                $hoursWorked = $interval->h + ($interval->i / 60);
            ?>
            <tr>
                <td><?= $record['attRn'] ?></td>
                <td><?= $record['empID'] ?></td>
                <td><?= $record['attDate'] ?></td>
                <td><?= $record['attTimeIn'] ?></td>
                <td><?= $record['attTimeOut'] ?></td>
                <td><?= number_format($hoursWorked, 2) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <br>

    <div align="center">
        <p>Date Generated: <?= date('Y-m-d') ?></p>
        <p>Total Hours: <?= number_format($totalHours, 2) ?></p>
    </div>

    <?php if ($employee): ?>
        <div align="center">
            <p>Rate Per Hour: <?= number_format($ratePerHour, 2) ?></p>
            <p>Salary: <?= number_format($salary, 2) ?></p>
        </div>
    <?php endif; ?>
</body>
</html>