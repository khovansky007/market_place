<?php
session_start();
include('includes/db.php');
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?php echo isset($page_title) ? $page_title : 'Мой маркетплейс'; ?></title>
    <link rel="stylesheet" href="css/base.css">
    <?php echo isset($other_css) ? '<link rel="stylesheet" href="css/' . $other_css . '">' : ''; ?>
</head>
<body>
    <header>
        <div class="wrapper">
            <?php if (isset($_SESSION['user_id'])): ?>
                <div style="display: flex; justify-content: space-between;">
                    <div>Здравствуйте, <?= $_SESSION['name'] ?>!</div>
                    <p><a href="index.php">Главная</a> | <a href="logout.php">Выйти</a> | <a href="my_products.php">Мои товары</a></p>
                </div>
            <?php else: ?>
                <p><a href="index.php">Главная</a> | <a href="login.php">Войти</a> | <a href="register.php">Зарегистрироваться</a></p>
            <?php endif; ?>
        </div>
    </header>
    <div class="wrapper">
    