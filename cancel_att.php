<?php
    include 'conn.php';
    $attRN = $_GET['cancel'];

    if(isset($_GET['cancel'])){
        $attRN = $_GET['cancel'];

        $sql = "UPDATE Attendance SET attStat = 'Cancelled' WHERE attRN = '$attRN'";

        if($conn->query($sql)){
            $_SESSION['success'] = "CANCELLED ATTENDANCE";
        }
        else{
            $_SESSION['error'] = "INVALID ACTION";
        }
        header('location:att_recording.php');
    }
?>