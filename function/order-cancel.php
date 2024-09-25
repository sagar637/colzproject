<?php
include 'connection.php';

$user_id = $_SESSION['user_id'];
$orderReportNo = $_SESSION['orderReportNo'];

$orderUpdate = "UPDATE `order` SET `status`='refund' WHERE `order_set`='$orderReportNo';";
$orderUpdateResult = $mysqli->query($orderUpdate);

$_SESSION['accountOrders'] = 'on';
$mysqli->close();
echo '<script type="text/JavaScript"> history.back();</script>';
?>