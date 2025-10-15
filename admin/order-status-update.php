<?php
include('includes/dbconnection.php');

if (isset($_POST['order_id']) && isset($_POST['status'])) {
    $order_id = intval($_POST['order_id']);
    $status = $_POST['status'];

    $stmt = $con->prepare("UPDATE tblorders SET status=?, updated_at=NOW() WHERE id=?");
    $stmt->bind_param("si", $status, $order_id);
    $stmt->execute();

    header("Location: manage-orders.php");
    exit;
} else {
    echo "<script>alert('Thiếu dữ liệu cập nhật'); window.location='manage-orders.php';</script>";
}
