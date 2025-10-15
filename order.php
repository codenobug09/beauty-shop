<?php
session_start();
include('includes/dbconnection.php');

// Lấy user_id từ session (bpmsuid)
$user_id = isset($_SESSION['bpmsuid']) && intval($_SESSION['bpmsuid']) > 0 ? intval($_SESSION['bpmsuid']) : 0;

// Lưu session token (nếu cần track session)
$session_token = session_id();

// Kiểm tra đăng nhập
if ($user_id === 0) {
    echo "<script>alert('Vui lòng đăng nhập để xem đơn hàng của bạn!');window.location='login.php';</script>";
    exit;
}

// Lấy danh sách đơn hàng theo user_id
$stmt = $con->prepare("SELECT * FROM tblorders WHERE user_id = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$orders = $result->fetch_all(MYSQLI_ASSOC); // ✅ Lấy toàn bộ kết quả thành mảng
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đơn hàng của tôi</title>
    <link rel="stylesheet" href="assets/css/order.css">
    <style>
        body { font-family: Arial, sans-serif; background: #f8f9fa; padding: 30px; }
        h2 { margin-bottom: 25px; }
        .order-box {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 25px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
        .status { font-weight: bold; text-transform: capitalize; }
        .status.pending { color: orange; }
        .status.processing { color: blue; }
        .status.completed { color: green; }
        .status.cancelled { color: red; }
        table { border-collapse: collapse; width: 100%; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: center; }
        th { background-color: #f1f1f1; }
        img { border-radius: 5px; }
    </style>
</head>
<body>

<h2>📦 Đơn hàng của tôi</h2>

<?php if (!empty($orders)): ?>
    <?php foreach ($orders as $order): ?>
        <div class="order-box">
            <h3>🧾 Mã đơn: #<?php echo $order['id']; ?></h3>
            <p><strong>Trạng thái:</strong> 
                <span class="status <?php echo strtolower($order['status']); ?>">
                    <?php echo ucfirst($order['status']); ?>
                </span>
            </p>
            <p><strong>Tổng tiền:</strong> <?php echo number_format($order['total'], 0, ',', '.'); ?> ₫</p>
            <p><strong>Phương thức thanh toán:</strong> <?php echo htmlspecialchars($order['payment_method']); ?></p>
            <p><strong>Địa chỉ giao hàng:</strong> <?php echo nl2br(htmlspecialchars($order['shipping_address'])); ?></p>
            <p><strong>Ngày đặt:</strong> <?php echo date('d/m/Y H:i', strtotime($order['created_at'])); ?></p>

            <h4>🛍 Sản phẩm trong đơn</h4>
            <table>
                <tr>
                    <th>Tên sản phẩm</th>
                    <th>Ảnh</th>
                    <th>Số lượng</th>
                    <th>Đơn giá</th>
                    <th>Thành tiền</th>
                </tr>
                <?php
                $stmt_details = $con->prepare("
                    SELECT d.*, p.title AS p_name, p.img
                    FROM tbl_order_details d
                    JOIN tblproduct p ON d.product_id = p.p_id
                    WHERE d.order_id = ?
                ");
                $stmt_details->bind_param("i", $order['id']);
                $stmt_details->execute();
                $result_details = $stmt_details->get_result();
                while ($item = $result_details->fetch_assoc()):
                ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['p_name']); ?></td>
                        <td>
                            <?php if (!empty($item['photo'])): ?>
                                <?php echo $item['photo'] ?>
                                <img src="assets/images/<?php echo htmlspecialchars($item['photo']); ?>">
                            <?php endif; ?>
                        </td>
                        <td><?php echo intval($item['quantity']); ?></td>
                        <td><?php echo number_format($item['unit_price'], 0, ',', '.'); ?> ₫</td>
                        <td><?php echo number_format($item['quantity'] * $item['unit_price'], 0, ',', '.'); ?> ₫</td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </div>
    <?php endforeach; ?>

<?php else: ?>
    <p>Bạn chưa có đơn hàng nào.</p>
<?php endif; ?>

</body>
</html>
