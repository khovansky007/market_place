<?php
$other_css = "product.css";
include('includes/header.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$stmt = $pdo->prepare("SELECT * FROM products WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$products = $stmt->fetchAll();
?>

<h1>Мои товары</h1>
<div style="margin-bottom: 50px;">
    <p>Всего товаров: <?php echo count($products); ?></p>
    <a href="create_product.php">Добавить товар</a>
</div>
<?php foreach ($products as $product): ?>
    <div class="product">
        <div class="left">
            <h2><?= $product['name'] ?></h2>
            <p><?= $product['description'] ?></p>
            <p class="price"><?= $product['price'] ?> руб.</p>
        </div>
        <div class="right">
            <img src="images/<?= $product['image_path'] ?>" alt="<?= $product['name'] ?>" width="200">
        </div>
        <div class="manage_item">
            <a href="edit_product.php?id=<?= $product['id'] ?>"><div>Редактировать</div></a>
            <a href="delete_product.php?id=<?= $product['id'] ?>"><div>Удалить</div></a>
        </div>
    </div>
<?php endforeach; ?>

<?php
include('includes/footer.php');