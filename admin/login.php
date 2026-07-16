<?php
session_start();
require_once '../db.php';
$error = '';

if (isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $stmt = $db->prepare("SELECT * FROM admins WHERE username = ?");
    $stmt->execute([$username]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin && password_verify($password, $admin['password_hash'])) {
        $_SESSION['logged_in'] = true;
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_username'] = $admin['username'];
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yönetim Paneli Girişi</title>
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2c3e50;
            --accent-color: #3498db;
            --error-color: #e74c3c;
            --bg-gradient: linear-gradient(135deg, #2c3e50 0%, #1a252f 100%);
            --card-bg: rgba(255, 255, 255, 0.95);
        }
        
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
        }

        body {
            background: var(--bg-gradient);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .login-container {
            width: 100%;
            max-width: 400px;
            background: var(--card-bg);
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: transform 0.3s ease;
        }

        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-header h2 {
            color: var(--primary-color);
            font-size: 26px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .login-header p {
            color: #7f8c8d;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: var(--primary-color);
            font-size: 13px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        input {
            width: 100%;
            padding: 12px 16px;
            background: #f8f9fa;
            border: 1px solid #dcdde1;
            border-radius: 8px;
            font-size: 14px;
            color: #2c3e50;
            transition: all 0.3s ease;
            outline: none;
        }

        input:focus {
            border-color: var(--accent-color);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(52, 152, 219, 0.15);
        }

        button {
            width: 100%;
            padding: 14px;
            background: var(--accent-color);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            margin-top: 10px;
            box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);
        }

        button:hover {
            background: #2980b9;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(52, 152, 219, 0.4);
        }

        button:active {
            transform: translateY(0);
        }

        .err {
            background: rgba(231, 76, 60, 0.1);
            color: var(--error-color);
            border-left: 4px solid var(--error-color);
            padding: 12px;
            border-radius: 6px;
            font-size: 13px;
            margin-bottom: 25px;
            font-weight: 500;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="login-container">
    <div class="login-header">
        <h2>Yönetim Paneli</h2>
        <p>Op. Dr. Necati Özçimen</p>
    </div>
    
    <?php if($error): ?> 
        <div class="err"><?= htmlspecialchars($error) ?></div> 
    <?php endif; ?>
    
    <form action="" method="POST">
        <div class="form-group">
            <label for="username">Kullanıcı Adı</label>
            <input type="text" id="username" name="username" placeholder="Kullanıcı adınızı girin" required>
        </div>
        <div class="form-group">
            <label for="password">Şifre</label>
            <input type="password" id="password" name="password" placeholder="Şifrenizi girin" required>
            <div style="text-align: right; margin-top: 8px;">
                <a href="sifre-mi-unuttum.php" style="font-size: 13px; color: var(--accent-color); text-decoration: none;">Şifremi Unuttum</a>
            </div>
        </div>
        <button type="submit" name="login">Giriş Yap</button>
    </form>
</div>
</body>
</html>