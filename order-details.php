<?php
session_start();
include('includes/dbconnection.php');

/* ================= AUTH ================= */
$user_id = isset($_SESSION['bpmsuid']) ? intval($_SESSION['bpmsuid']) : 0;
if ($user_id === 0) {
    header("Location: login.php");
    exit;
}

/* ================= GET ORDER ID ================= */
$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
if ($order_id === 0) {
    die("Invalid order ID");
}

/* ================= ORDER INFO ================= */
$stmt_order = $con->prepare("
    SELECT * 
    FROM tblorders 
    WHERE id = ? AND user_id = ?
");
$stmt_order->bind_param("ii", $order_id, $user_id);
$stmt_order->execute();
$order = $stmt_order->get_result()->fetch_assoc();

if (!$order) {
    die("Order not found or access denied.");
}

/* ================= ORDER ITEMS ================= */
$stmt_items = $con->prepare("
    SELECT od.*, p.title 
    FROM tbl_order_details od
    JOIN tblproduct p ON od.product_id = p.p_id
    WHERE od.order_id = ?
");
$stmt_items->bind_param("i", $order_id);
$stmt_items->execute();
$items = $stmt_items->get_result();

/* ================= STATUS LABEL ================= */
function paymentBadge($status) {
    return match($status) {
        'paid' => '<span class="badge bg-success">Paid</span>',
        'waiting_confirm' => '<span class="badge bg-warning text-dark">Waiting Confirmation</span>',
        default => '<span class="badge bg-secondary">Unpaid</span>',
    };
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Order #<?= $order_id ?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
.order-box {
    background: #fff;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 0 10px rgba(0,0,0,.05);
}
</style>
</head>
<body>

<div class="container my-5">
    <h3 class="mb-4">📦 Order Details #<?= $order_id ?></h3>

    <div class="order-box mb-4">
        <h5>🧾 Order Information</h5>
        <p><strong>Date:</strong> <?= $order['created_at'] ?></p>
        <p><strong>Shipping Address:</strong> <?= htmlspecialchars($order['shipping_address']) ?></p>
        <p><strong>Payment Method:</strong> <?= htmlspecialchars($order['payment_method']) ?></p>
        <p><strong>Payment Status:</strong> <?= paymentBadge($order['status']) ?></p>
        <p><strong>Order Status:</strong> <?= htmlspecialchars($order['status']) ?></p>
        <p class="fw-bold">Total: $<?= number_format($order['total'], 2) ?></p>
    </div>

    <div class="order-box mb-4">
        <h5>🛍 Products</h5>
        <ul class="list-group">
            <?php while ($item = $items->fetch_assoc()): ?>
                <li class="list-group-item d-flex justify-content-between">
                    <?= htmlspecialchars($item['title']) ?> × <?= $item['quantity'] ?>
                    <span>$<?= number_format($item['quantity'] * $item['unit_price'], 2) ?></span>
                </li>
            <?php endwhile; ?>
        </ul>
    </div>

    <div class="mt-4">
        <a href="order.php" class="btn btn-outline-secondary">← Back to My Orders</a>
    </div>
</div>

</body>
</html>
