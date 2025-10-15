<?php
session_start();
include('includes/dbconnection.php');

$user_id = isset($_SESSION['bpmsuid']) && intval($_SESSION['bpmsuid']) > 0 ? intval($_SESSION['bpmsuid']) : 0;
if ($user_id == 0) {
    header("Location: cart.php");
    exit;
}

// Lấy order_id từ URL
$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
if ($order_id <= 0) {
    $_SESSION['cart_error'] = "Invalid order.";
    header("Location: cart.php");
    exit;
}

// Lấy thông tin order
$stmt_order = $con->prepare("
    SELECT * FROM tblorders WHERE id = ? AND user_id = ?
");
$stmt_order->bind_param("ii", $order_id, $user_id);
$stmt_order->execute();
$res_order = $stmt_order->get_result();

if ($res_order->num_rows === 0) {
    $_SESSION['cart_error'] = "Order not found.";
    header("Location: cart.php");
    exit;
}

$order = $res_order->fetch_assoc();

// Lấy chi tiết order
$stmt_details = $con->prepare("
    SELECT od.*, p.title, p.img
    FROM tbl_order_details od
    JOIN tblproduct p ON od.product_id = p.p_id
    WHERE od.order_id = ?
");
$stmt_details->bind_param("i", $order_id);
$stmt_details->execute();
$res_details = $stmt_details->get_result();

$items = [];
while ($row = $res_details->fetch_assoc()) {
    $items[] = $row;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Success</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-5">
    <h3 class="text-success">Thank you! Your order has been placed.</h3>
    <p>Order ID: <strong>#<?php echo $order['id']; ?></strong></p>
    <p>Order Date: <strong><?php echo $order['created_at']; ?></strong></p>
    <p>Order Status: <strong><?php echo ucfirst($order['status']); ?></strong></p>

    <h5 class="mt-4">Shipping Information</h5>
    <p><?php echo nl2br(htmlspecialchars($order['shipping_address'])); ?></p>
    <p>Payment Method: <strong><?php echo htmlspecialchars($order['payment_method']); ?></strong></p>

    <h5 class="mt-4">Order Details</h5>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Product</th>
            <th>Image</th>
            <th>Unit Price</th>
            <th>Quantity</th>
            <th>Total</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($items as $item): ?>
            <tr>
                <td><?php echo htmlspecialchars($item['title']); ?></td>
                <td><img src="assets/images/<?php echo htmlspecialchars($item['img']); ?>" width="60" alt=""></td>
                <td>$<?php echo number_format($item['unit_price'],2); ?></td>
                <td><?php echo intval($item['quantity']); ?></td>
                <td>$<?php echo number_format($item['unit_price'] * $item['quantity'],2); ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
        <tfoot>
        <tr>
            <th colspan="4" class="text-end">Total:</th>
            <th>$<?php echo number_format($order['total'],2); ?></th>
        </tr>
        </tfoot>
    </table>

    <a href="index.php" class="btn btn-primary mt-3">Continue Shopping</a>
</div>
</body>
</html>
