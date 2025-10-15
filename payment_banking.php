<?php
session_start();
include('includes/dbconnection.php');

if (!isset($_GET['order_id']) || !is_numeric($_GET['order_id'])) {
    header("Location: index.php");
    exit;
}

$order_id = intval($_GET['order_id']);
$user_id = isset($_SESSION['bpmsuid']) ? intval($_SESSION['bpmsuid']) : 0;

// Lấy thông tin đơn hàng
$stmt = $con->prepare("
    SELECT o.*, u.FirstName, u.email 
    FROM tblorders o
    JOIN tbluser u ON o.user_id = u.id
    WHERE o.id = ? AND o.user_id = ?
");
$stmt->bind_param("ii", $order_id, $user_id);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();

if (!$order) {
    echo "<h3 style='color:red; text-align:center; margin-top:50px;'>Order not found!</h3>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Bank Transfer Payment</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body {
    background-color: #f8f9fa;
}
.container {
    max-width: 750px;
    background: #fff;
    padding: 30px;
    margin-top: 60px;
    border-radius: 10px;
    box-shadow: 0px 3px 8px rgba(0,0,0,0.1);
}
h3 {
    text-align: center;
    color: #2b2b2b;
}
.bank-info {
    background: #f1f3f5;
    border-radius: 8px;
    padding: 15px;
    margin: 20px 0;
}
.bank-info ul {
    list-style-type: none;
    padding-left: 0;
}
.bank-info li {
    margin-bottom: 6px;
}
.order-summary {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 8px;
}
.btn-custom {
    display: inline-block;
    width: 48%;
}
</style>
</head>
<body>
<div class="container">
    <h3>🏦 Bank Transfer Payment</h3>
    <hr>

    <p>Dear <strong><?= htmlspecialchars($order['FirstName']); ?></strong>,</p>
    <p>Your order has been successfully placed with the following details:</p>

    <div class="order-summary mb-3">
        <p><strong>Order ID:</strong> #<?= $order['id']; ?></p>
        <p><strong>Total:</strong> $<?= number_format($order['total'], 2); ?></p>
        <p><strong>Shipping Address:</strong> <?= htmlspecialchars($order['shipping_address']); ?></p>
        <p><strong>Status:</strong> <span class="badge bg-warning text-dark"><?= ucfirst($order['status']); ?></span></p>
    </div>

    <h5>📢 Please transfer the total amount to the account below:</h5>

    <div class="bank-info">
        <ul>
            <li><strong>Bank Name:</strong> Vietcombank</li>
            <li><strong>Account Number:</strong> 0123456789</li>
            <li><strong>Account Holder:</strong> Beauty Shop Co., Ltd</li>
            <li><strong>Transfer Content:</strong> "PAY ORDER #<?= $order['id']; ?> - <?= strtoupper($order['FirstName']); ?>"</li>
            <li><strong>Amount:</strong> $<?= number_format($order['total'], 2); ?></li>
        </ul>
    </div>

    <p>Once you have made the transfer, please contact our support team or upload your payment proof in the “My Orders” section.  
    We will verify the payment and process your order as soon as possible. ❤️</p>

    <div class="d-flex justify-content-between mt-4">
        <a href="index.php" class="btn btn-secondary btn-custom">🏠 Back to Home</a>
        <a href="order-details.php?order_id=<?= $order['id']; ?>" class="btn btn-success btn-custom">📄 View Order</a>
    </div>
</div>
</body>
</html>
