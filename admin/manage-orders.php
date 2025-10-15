<?php
include('includes/dbconnection.php');

// Lấy danh sách đơn hàng cùng tên user (nếu có bảng user)
$query = "SELECT o.*, u.FirstName
          FROM tblorders o 
          LEFT JOIN tbluser u ON o.user_id = u.id
          ORDER BY o.created_at DESC";
$result = $con->query($query);
?>

<h2>📦 Quản lý đơn hàng</h2>

<table border="1" cellspacing="0" cellpadding="10" width="100%">
    <thead style="background: #f4f4f4;">
        <tr>
            <th>ID</th>
            <th>Khách hàng</th>
            <th>Tổng tiền</th>
            <th>Phương thức thanh toán</th>
            <th>Địa chỉ giao hàng</th>
            <th>Trạng thái</th>
            <th>Ngày tạo</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['FirstName'] ?? 'Khách lẻ') ?></td>
                <td><?= number_format($row['total'], 0, ',', '.') ?> ₫</td>
                <td><?= htmlspecialchars($row['payment_method']) ?></td>
                <td><?= nl2br(htmlspecialchars($row['shipping_address'])) ?></td>
                <td>
                    <form method="post" action="order-status-update.php" style="display:inline;">
                        <input type="hidden" name="order_id" value="<?= $row['id'] ?>">
                        <select name="status" onchange="this.form.submit()">
                            <option value="pending" <?= $row['status'] == 'pending' ? 'selected' : '' ?>>⏳ Chờ xử lý</option>
                            <option value="processing" <?= $row['status'] == 'processing' ? 'selected' : '' ?>>🔄 Đang xử lý</option>
                            <option value="completed" <?= $row['status'] == 'completed' ? 'selected' : '' ?>>✅ Hoàn thành</option>
                            <option value="cancelled" <?= $row['status'] == 'cancelled' ? 'selected' : '' ?>>❌ Đã hủy</option>
                        </select>
                    </form>
                </td>
                <td><?= $row['created_at'] ?></td>
                <td><a href="order-details.php?order_id=<?= $row['id'] ?>">🔍 Xem chi tiết</a></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<style>
h2 {
    font-size: 22px;
    margin-bottom: 15px;
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
select {
    padding: 4px 6px;
    border-radius: 4px;
}
tr:nth-child(even) {
    background: #f9f9f9;
}
a {
    text-decoration: none;
    color: #007bff;
}
a:hover {
    text-decoration: underline;
}
</style>
