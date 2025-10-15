<?php
session_start();
include('includes/dbconnection.php');

// Kiểm tra đăng nhập
if (strlen($_SESSION['bpmsaid'] == 0)) {
    header('location:logout.php');
    exit();
}

// --- Cấu hình phân trang ---
$limit = 10; // số sản phẩm mỗi trang
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

// --- Lấy tổng số sản phẩm ---
$total_query = mysqli_query($con, "SELECT COUNT(*) as total FROM tblproduct");
$total_row = mysqli_fetch_assoc($total_query);
$total = $total_row['total'];
$pages = ceil($total / $limit);

// --- Lấy dữ liệu sản phẩm ---
$query = mysqli_query($con, "SELECT * FROM tblproduct ORDER BY p_id DESC LIMIT $start, $limit");
?>

<!DOCTYPE HTML>
<html>

<head>
    <title>Quản lý sản phẩm</title>
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="css/font-awesome.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet" type="text/css">
</head>

<body>
    <div class="main-content">
        <?php include_once('includes/sidebar.php'); ?>
        <?php include_once('includes/header.php'); ?>

        <div id="page-wrapper">
            <div class="main-page">

                <div class="table-responsive" style="display: flex; justify-content: flex-end; flex-direction: column; align-items: flex-end;">
                    <div style="display: flex; margin-top: 100px">
                    <h3 class="title1" style="margin-right: 800px">Danh sách sản phẩm</h3>
                    <div class="mb-3 text-end">
                        <a href="product-add.php" class="btn btn-success">
                            <i class="fa fa-plus"></i> Thêm mới
                        </a>
                    </div>
                    </div>
                    <table class="table table-bordered table-striped" style="width: 1203px; max-height: 400px;">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Ảnh</th>
                                <th>Tên sản phẩm</th>
                                <th>Slogan</th>
                                <th>Giá</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (mysqli_num_rows($query) > 0) {
                                $count = $start + 1;
                                while ($row = mysqli_fetch_assoc($query)) {
                            ?>
                                    <tr>
                                        <td><?php echo $count++; ?></td>
                                        <td>
                                            <?php if (!empty($row['img'])) { ?>
                                                <img src="../assets/images/<?php echo htmlspecialchars($row['img']); ?>" alt="Product Image" width="60">
                                            <?php } else { ?>
                                                <span class="text-muted">No Image</span>
                                            <?php } ?>
                                        </td>
                                        <td><?php echo htmlspecialchars($row['title']); ?></td>
                                        <td><?php echo htmlspecialchars($row['slogan']); ?></td>
                                        <td><?php echo number_format($row['price'], 2); ?> đ</td>
                                        <td>
                                            <a href="product-edit.php?p_id=<?php echo $row['p_id']; ?>" class="btn btn-primary btn-sm">
                                                <i class="fa fa-edit"></i> Sửa
                                            </a>
                                            <a href="product-delete.php?p_id=<?php echo $row['p_id']; ?>"
                                                onclick="return confirm('Bạn có chắc muốn xoá sản phẩm này?');"
                                                class="btn btn-danger btn-sm">
                                                <i class="fa fa-trash"></i> Xoá
                                            </a>
                                        </td>
                                    </tr>
                            <?php
                                }
                            } else {
                                echo '<tr><td colspan="6" class="text-center text-muted">Không có sản phẩm nào</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                    <nav aria-label="Page navigation" style="margin-right: 1169px;">
                    <ul class="pagination justify-content-center">
                        <?php for ($i = 1; $i <= $pages; $i++): ?>
                            <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                                <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </nav>
                </div>

            </div>
        </div>

        <?php include_once('includes/footer.php'); ?>
    </div>

    <script src="js/bootstrap.js"></script>
</body>

</html>