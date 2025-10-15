<?php
include('includes/dbconnection.php');

if (!isset($_GET['p_id']) || empty($_GET['p_id'])) {
    header('Location: add-product.php');
    exit;
}

$p_id = intval($_GET['p_id']);

// Lấy dữ liệu sản phẩm hiện tại
$stmt = $con->prepare("SELECT * FROM tblproduct WHERE p_id = ?");
$stmt->bind_param("i", $p_id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if (!$product) {
    echo "<script>alert('Không tìm thấy sản phẩm!');window.location='add-product.php';</script>";
    exit;
}

if (isset($_POST['form_edit'])) {
    $valid = 1;
    $title = trim($_POST['title']);
    $slogan = trim($_POST['slogan']);
    $price = trim($_POST['price']);

    if ($title == '') {
        $valid = 0;
        $error_message = "Tên sản phẩm không được để trống<br>";
    }

    if ($valid == 1) {
        $photo = $product['img'];

        // Nếu có upload ảnh mới
        if (!empty($_FILES['photo']['name'])) {
            // Xóa ảnh cũ nếu có
            if ($photo != '' && file_exists('../assets/images/' . $photo)) {
                unlink('../assets/images/' . $photo);
            }

            $photo = time() . '_' . $_FILES['photo']['name'];
            $path = '../assets/images/' . $photo;
            move_uploaded_file($_FILES['photo']['tmp_name'], $path);
        }

        // Cập nhật dữ liệu
        $stmt = $con->prepare("UPDATE tblproduct SET title=?, slogan=?, price=?, img=? WHERE p_id=?");
        $stmt->execute([$title, $slogan, $price, $photo, $p_id]);

        echo "<script>alert('Cập nhật sản phẩm thành công!');window.location='add-product.php';</script>";
    }
}
?>

<h2>✏️ Sửa sản phẩm</h2>

<form action="" method="post" enctype="multipart/form-data">
    <div>
        <label>Tên sản phẩm</label>
        <input type="text" name="title" value="<?= htmlspecialchars($product['title']) ?>" required>
    </div>
    <div>
        <label>Slogan / Mô tả ngắn</label>
        <input type="text" name="slogan" value="<?= htmlspecialchars($product['slogan']) ?>" required>
    </div>
    <div>
        <label>Giá</label>
        <input type="number" name="price" value="<?= htmlspecialchars($product['price']) ?>" required>
    </div>
    <div>
        <label>Ảnh hiện tại</label><br>
        <?php if ($product['img']): ?>
            <img src="../assets/images/<?= htmlspecialchars($product['img']) ?>" width="120" style="border-radius:6px;border:1px solid #ccc;"><br><br>
        <?php else: ?>
            <p><i>Chưa có ảnh</i></p>
        <?php endif; ?>
        <input type="file" name="photo">
    </div>
    <div>
        <input type="submit" name="form_edit" value="Cập nhật">
    </div>
</form>

<style>
body {
    font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
    background: #f5f7fa;
    margin: 0;
    padding: 40px;
}

h2 {
    text-align: center;
    color: #333;
    margin-bottom: 30px;
}

form {
    max-width: 600px;
    margin: 0 auto;
    background: #fff;
    padding: 25px 35px;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}

form:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 16px rgba(0,0,0,0.15);
}

form div {
    margin-bottom: 18px;
}

label {
    display: block;
    font-weight: 600;
    margin-bottom: 6px;
    color: #444;
}

input[type="text"],
input[type="number"],
input[type="file"] {
    width: 100%;
    padding: 10px 12px;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-size: 15px;
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
}

input[type="text"]:focus,
input[type="number"]:focus,
input[type="file"]:focus {
    outline: none;
    border-color: #28a745;
    box-shadow: 0 0 6px rgba(40,167,69,0.3);
}

input[type="submit"] {
    background: #28a745;
    color: #fff;
    border: none;
    padding: 10px 22px;
    font-size: 16px;
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.3s ease;
    width: 100%;
    font-weight: bold;
    letter-spacing: 0.5px;
}

input[type="submit"]:hover {
    background: #218838;
    transform: scale(1.02);
}

input[type="submit"]:active {
    transform: scale(0.98);
}

img {
    border-radius: 6px;
    border: 1px solid #ddd;
    transition: all 0.2s ease;
}

img:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 10px rgba(0,0,0,0.2);
}

.error {
    background: #f8d7da;
    color: #842029;
    padding: 10px;
    border-radius: 5px;
    margin-bottom: 15px;
    border: 1px solid #f5c2c7;
}
</style>

