<?php
$other_css = "product.css";
include('includes/header.php');

$stmt = $pdo->query("SELECT * FROM products WHERE is_published = 1");
$products = $stmt->fetchAll();
?>



<h1>Все товары</h1>
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
    </div>
<?php endforeach; ?>


<?php
include('includes/footer.php');