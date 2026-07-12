<?php
session_start();
$error = '';

// Güvenliğiniz için giriş bilgileriniz
$admin_user = 'admin';
$admin_pass = 'Necati123!'; 

if (isset($_POST['login'])) {
    if ($_POST['username'] === $admin_user && $_POST['password'] === $admin_pass) {
        $_SESSION['logged_in'] = true;
        header('Location: index.php');
        exit;
    } else {
        $error = 'Hatalı kullanıcı adı veya şifre!';
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Admin Girişi</title>
    <style>
        body { background: #f4f6f9; font-family: Arial; display: flex; justify-content: center; align-items: center; height: 100vh; margin:0; }
        .login-box { background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); width: 320px; }
        input { width: 100%; padding: 10px; margin: 10px 0; box-sizing: border-box; }
        button { width: 100%; padding: 10px; background: #3498db; color: #fff; border: none; cursor: pointer; font-weight: bold; }
        .err { color: red; font-size: 14px; }
    </style>
</head>
<body>
<div class="login-box">
    <h2>Yönetim Paneli</h2>
    <?php if($error): ?> <p class="err"><?= $error ?></p> <?php endif; ?>
    <form action="" method="POST">
        <input type="text" name="username" placeholder="Kullanıcı Adı" required>
        <input type="password" name="password" placeholder="Şifre" required>
        <button type="submit" name="login">Giriş Yap</button>
    </form>
</div>
</body>
</html>