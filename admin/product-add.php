<?php
include('includes/dbconnection.php');

if (isset($_POST['form_add'])) {
    $valid = 1;

    $p_name = trim($_POST['p_name']);
    $p_price = trim($_POST['p_price']);
    $p_qty = trim($_POST['p_qty']);
    $p_category = $_POST['p_category'];

    // Validate
    if ($p_name == '') {
        $valid = 0;
        $error_message = "Tên sản phẩm không được để trống<br>";
    }

    if ($valid == 1) {
        // Upload file
        $photo = '';
        if (!empty($_FILES['photo']['name'])) {
            $photo = time() . '_' . $_FILES['photo']['name'];
            $path = '../assets/images/' . $photo;
            move_uploaded_file($_FILES['photo']['tmp_name'], $path);
        }

        // Insert vào DB
        $stmt = $con->prepare("INSERT INTO tblproduct (title,price, slogan, img) VALUES (?, ?, ?, ?)");
        $stmt->execute([$p_name, $p_price, $p_category, $photo]);

        echo "<script>alert('Thêm sản phẩm thành công!');window.location='add-product.php';</script>";
    }
}
?>

<h2>➕ Thêm sản phẩm</h2>
<form action="" method="post" enctype="multipart/form-data">
    <div>
        <label>Tên sản phẩm</label>
        <input type="text" name="p_name" required>
    </div>
    <div>
        <label>Giá</label>
        <input type="number" name="p_price" required>
    </div>
    <div>
        <label>Số lượng</label>
        <input type="number" name="p_qty" required>
    </div>
    <div>
        <label>Danh mục</label>
        <input type="text" name="p_category" required>
    </div>
    <div>
        <label>Ảnh</label>
        <input type="file" name="photo">
    </div>
    <div>
        <input type="submit" name="form_add" value="Thêm">
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
    transition: border-color 0.3s ease;
}

input[type="text"]:focus,
input[type="number"]:focus,
input[type="file"]:focus {
    outline: none;
    border-color: #007bff;
}

input[type="submit"] {
    background: #007bff;
    color: #fff;
    border: none;
    padding: 10px 20px;
    font-size: 16px;
    border-radius: 6px;
    cursor: pointer;
    transition: background 0.3s ease, transform 0.1s ease;
}

input[type="submit"]:hover {
    background: #0056b3;
    transform: scale(1.02);
}

input[type="submit"]:active {
    transform: scale(0.98);
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

