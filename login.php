<?php
session_start();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($username === 'admin' && $password === 'MiniShop@03') {
        $_SESSION['auth'] = true;
        $_SESSION['username'] = 'admin';
        header('Location: dashboard.php');
        exit;
    } else {
        $error = 'Sai username hoac password!';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>MiniShop — Login</title>
</head>
<body>
    <h1>MiniShop — Dang nhap</h1>

    <?php if ($error !== ''): ?>
        <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form method="POST" action="login.php">
        <p>
            <label>Username:</label><br>
            <input type="text" name="username">
        </p>
        <p>
            <label>Password:</label><br>
            <input type="password" name="password">
        </p>
        <button type="submit">Dang nhap</button>
    </form>
</body>
</html>