<?php
include 'connection.php';

$user_id = $_SESSION['user_id'];
$orderReportNo = $_POST['orderReportNo'];
$_SESSION['orderReportNo'] = $orderReportNo;
$_SESSION['orderReport'] = 'on';
$_SESSION['accountOrders'] = 'on';
$mysqli->close();
echo '<script type="text/JavaScript"> history.back();</script>';
?>