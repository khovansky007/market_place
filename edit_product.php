<?php
include('includes/header.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ? AND user_id = ?");
$stmt->execute([$id, $_SESSION['user_id']]);
$product = $stmt->fetch();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image = $_FILES['image_path']['name'];
    $is_published = isset($_POST['is_published']) ? 1 : 0; // Если чекбокс отмечен, товар публикуется

    // Обработка изображения
    if ($image) {
        move_uploaded_file($_FILES['image_path']['tmp_name'], "images/$image");
    } else {
        $image = $product['image_path']; // Если изображение не было загружено, оставляем старое
    }

    // Обновляем товар в базе данных
    $stmt = $pdo->prepare("UPDATE products SET name = ?, description = ?, price = ?, image_path = ?, is_published = ? WHERE id = ?");
    $stmt->execute([$name, $description, $price, $image, $is_published, $id]);

    header("Location: my_products.php");
    exit();
}
?>

<div class="container">
    <h2>Редактировать товар</h2>
    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required><br>
        <textarea name="description" required><?= htmlspecialchars($product['description']) ?></textarea><br>
        <input type="number" name="price" value="<?= htmlspecialchars($product['price']) ?>" required placeholder="Цена товара, руб."><br>
        <input type="file" name="image_path"><br>
        
        <!-- Добавляем чекбокс для публикации товара -->
        <label>
            <input type="checkbox" name="is_published" <?php echo $product['is_published'] == 1 ? 'checked' : ''; ?>> Опубликовать товар
        </label><br>

        <button type="submit">Сохранить изменения</button>
    </form>
</div>

<?php
include('includes/footer.php');
?>
