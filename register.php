<?php
$page_title = "Регистрация";
include('includes/header.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $name = $_POST['name'];
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];

    if ($password !== $password_confirm) {
        echo "Пароли не совпадают!";
    } else {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (email, name, password) VALUES (?, ?, ?)");
        $stmt->execute([$email, $name, $password_hash]);
        header("Location: login.php");
        exit();
    }
}
?>

<form method="POST">
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="text" name="name" placeholder="Имя" required><br>
    <input type="password" name="password" placeholder="Пароль" required><br>
    <input type="password" name="password_confirm" placeholder="Повторите пароль" required><br>
    <button type="submit">Зарегистрироваться</button>
</form>

<?php
include('includes/footer.php');