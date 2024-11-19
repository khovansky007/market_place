<?php
include('includes/header.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    
    $image = $_FILES['image_path']['name'];
    $image_tmp = $_FILES['image_path']['tmp_name'];
    $image_error = $_FILES['image_path']['error'];

    if ($image_error !== UPLOAD_ERR_OK) {
        echo "Ошибка загрузки изображения: " . $image_error;
        exit();
    }

    $allowed_extensions = ['jpg', 'jpeg', 'png'];
    $image_extension = strtolower(pathinfo($image, PATHINFO_EXTENSION));

    if (!in_array($image_extension, $allowed_extensions)) {
        echo "Неподдерживаемый формат изображения. Разрешены только JPG, JPEG, PNG.";
        exit();
    }

    $image_new_name = uniqid('product_', true) . '.' . $image_extension;
    
    if (move_uploaded_file($image_tmp, "images/$image_new_name")) {
        $stmt = $pdo->prepare("INSERT INTO products (user_id, name, description, price, image_path) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$_SESSION['user_id'], $name, $description, $price, $image_new_name]);

        header("Location: my_products.php");
        exit();
    } else {
        echo "Не удалось загрузить изображение.";
        exit();
    }
}
?>

<div class="container">
    <h2>Добавить товар</h2>
    <form action="create_product.php" method="POST" enctype="multipart/form-data">
        <input type="text" name="name" placeholder="Название товара" required><br>
        <textarea name="description" placeholder="Описание товара" required></textarea><br>
        <input type="number" name="price" placeholder="Цена товара, руб." step="0.01" required><br>
        <input type="file" name="image_path" required><br>
        <button type="submit">Добавить товар</button>
    </form>
</div>

<?php
include('includes/footer.php');
?>
