<?php
include('includes/dbconnection.php');

// Kiểm tra tham số order_id
if (!isset($_GET['order_id']) || empty($_GET['order_id'])) {
    echo "<script>alert('Thiếu mã đơn hàng!');window.location='manage-orders.php';</script>";
    exit;
}

$order_id = intval($_GET['order_id']);

// Lấy thông tin đơn hàng
$stmt = $con->prepare("SELECT o.*, u.FirstName, u.email 
                       FROM tblorders o 
                       LEFT JOIN tbluser u ON o.user_id = u.id
                       WHERE o.id = ?");
$stmt->bind_param("i", $order_id);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();

if (!$order) {
    echo "<script>alert('Không tìm thấy đơn hàng!');window.location='manage-orders.php';</script>";
    exit;
}

// Lấy danh sách sản phẩm trong đơn hàng
$query = "SELECT d.*, p.title, p.img 
          FROM tbl_order_details d
          LEFT JOIN tblproduct p ON d.product_id = p.p_id
          WHERE d.order_id = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$details = $stmt->get_result();
?>

<h2>🧾 Chi tiết đơn hàng #<?= $order_id ?></h2>

<div class="order-info">
    <p><strong>👤 Khách hàng:</strong> <?= htmlspecialchars($order['FirstName'] ?? 'Khách lẻ') ?></p>
    <p><strong>📧 Email:</strong> <?= htmlspecialchars($order['email'] ?? '-') ?></p>
    <p><strong>📍 Địa chỉ giao hàng:</strong> <?= nl2br(htmlspecialchars($order['shipping_address'])) ?></p>
    <p><strong>💳 Phương thức thanh toán:</strong> <?= htmlspecialchars($order['payment_method']) ?></p>
    <p><strong>💰 Tổng tiền:</strong> <?= number_format($order['total'], 0, ',', '.') ?> ₫</p>
    <p><strong>📦 Trạng thái:</strong> 
        <span class="status <?= $order['status'] ?>">
            <?= ucfirst($order['status']) ?>
        </span>
    </p>
    <p><strong>⏰ Ngày tạo:</strong> <?= $order['created_at'] ?></p>
</div>

<h3>📋 Danh sách sản phẩm</h3>

<table border="1" cellspacing="0" cellpadding="10" width="100%">
    <thead style="background:#f4f4f4;">
        <tr>
            <th>Ảnh</th>
            <th>Tên sản phẩm</th>
            <th>Số lượng</th>
            <th>Đơn giá</th>
            <th>Thành tiền</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $total = 0;
        while ($row = $details->fetch_assoc()): 
            $subtotal = $row['unit_price'] * $row['quantity'];
            $total += $subtotal;
        ?>
        <tr>
            <td>
                <?php if ($row['img']): ?>
                    <img src="../assets/images/<?= htmlspecialchars($row['img']) ?>" width="80" style="border-radius:6px;border:1px solid #ccc;">
                <?php else: ?>
                    <i>Không có ảnh</i>
                <?php endif; ?>
            </td>
            <td><?= htmlspecialchars($row['title'] ?? 'Sản phẩm đã xóa') ?></td>
            <td><?= $row['quantity'] ?></td>
            <td><?= number_format($row['unit_price'], 0, ',', '.') ?> ₫</td>
            <td><?= number_format($subtotal, 0, ',', '.') ?> ₫</td>
        </tr>
        <?php endwhile; ?>
    </tbody>
    <tfoot>
        <tr style="font-weight:bold;background:#fafafa;">
            <td colspan="4" align="right">Tổng cộng:</td>
            <td><?= number_format($total, 0, ',', '.') ?> ₫</td>
        </tr>
    </tfoot>
</table>

<a href="manage-orders.php" class="back-btn">← Quay lại danh sách đơn hàng</a>

<style>
h2 {
    font-size: 22px;
    margin-bottom: 15px;
}
h3 {
    margin-top: 30px;
}
.order-info {
    background: #f9f9f9;
    padding: 15px;
    border-radius: 8px;
    margin-bottom: 20px;
    line-height: 1.6;
}
table {
    border-collapse: collapse;
    width: 100%;
    background: #fff;
    box-shadow: 0 0 8px rgba(0,0,0,0.1);
}
th, td {
    text-align: left;
    padding: 8px 10px;
}
tr:nth-child(even) {
    background: #f9f9f9;
}
.status {
    font-weight: bold;
    padding: 3px 8px;
    border-radius: 4px;
}
.status.pending { background: #ffe8a1; color: #856404; }
.status.processing { background: #b8daff; color: #004085; }
.status.completed { background: #d4edda; color: #155724; }
.status.cancelled { background: #f8d7da; color: #721c24; }
.back-btn {
    display: inline-block;
    margin-top: 20px;
    background: #007bff;
    color: #fff;
    padding: 8px 14px;
    border-radius: 5px;
    text-decoration: none;
}
.back-btn:hover {
    background: #0056b3;
}
</style>
