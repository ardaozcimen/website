<?php
session_start();
require_once '../db.php';

$message = '';
$error = '';
$valid_token = false;
$admin_id = null;

if (isset($_GET['token']) && !empty($_GET['token'])) {
    $token = $_GET['token'];
    
    // Token'ı ve süresini kontrol et
    $current_time = date('Y-m-d H:i:s');
    $stmt = $db->prepare("SELECT id FROM admins WHERE reset_token = ? AND reset_expires >= ?");
    $stmt->execute([$token, $current_time]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($admin) {
        $valid_token = true;
        $admin_id = $admin['id'];
    } else {
        $error = 'Geçersiz veya süresi dolmuş bir şifre sıfırlama bağlantısı kullandınız.';
    }
} else {
    $error = 'Şifre sıfırlama bağlantısı eksik.';
}

if (isset($_POST['reset_password']) && $valid_token) {
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];
    
    if (empty($password) || empty($password_confirm)) {
        $error = 'Lütfen tüm alanları doldurun.';
    } elseif ($password !== $password_confirm) {
        $error = 'Şifreler birbiriyle eşleşmiyor.';
    } elseif (strlen($password) < 6) {
        $error = 'Şifreniz en az 6 karakter olmalıdır.';
    } else {
        // Şifreyi şifrele (BCRYPT)
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Veritabanını güncelle ve tokenları temizle
        $updateStmt = $db->prepare("UPDATE admins SET password_hash = ?, reset_token = NULL, reset_expires = NULL WHERE id = ?");
        
        if ($updateStmt->execute([$hashed_password, $admin_id])) {
            $message = 'Şifreniz başarıyla güncellendi! Artık yeni şifrenizle giriş yapabilirsiniz.';
            $valid_token = false; // Formu tekrar göstermemek için
        } else {
            $error = 'Şifre güncellenirken bir hata oluştu.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yeni Şifre Belirle - Yönetim Paneli</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2c3e50;
            --accent-color: #3498db;
            --error-color: #e74c3c;
            --success-color: #2ecc71;
            --bg-gradient: linear-gradient(135deg, #2c3e50 0%, #1a252f 100%);
            --card-bg: rgba(255, 255, 255, 0.95);
        }
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Inter', sans-serif; }
        body { background: var(--bg-gradient); display: flex; justify-content: center; align-items: center; min-height: 100vh; padding: 20px; }
        .login-container { width: 100%; max-width: 400px; background: var(--card-bg); padding: 40px; border-radius: 16px; box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3); }
        .login-header { text-align: center; margin-bottom: 30px; }
        .login-header h2 { color: var(--primary-color); font-size: 26px; font-weight: 700; margin-bottom: 8px; }
        .login-header p { color: #7f8c8d; font-size: 14px; margin-bottom: 20px; line-height: 1.5; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; color: var(--primary-color); font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
        input { width: 100%; padding: 12px 16px; background: #f8f9fa; border: 1px solid #dcdde1; border-radius: 8px; font-size: 14px; color: #2c3e50; transition: all 0.3s ease; outline: none; }
        input:focus { border-color: var(--accent-color); background: #fff; box-shadow: 0 0 0 4px rgba(52, 152, 219, 0.15); }
        button { width: 100%; padding: 14px; background: var(--accent-color); color: #fff; border: none; border-radius: 8px; font-size: 15px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; }
        button:hover { background: #2980b9; transform: translateY(-2px); }
        .err { background: rgba(231, 76, 60, 0.1); color: var(--error-color); padding: 12px; border-radius: 6px; font-size: 13px; margin-bottom: 25px; text-align: center; }
        .succ { background: rgba(46, 204, 113, 0.1); color: var(--success-color); padding: 12px; border-radius: 6px; font-size: 13px; margin-bottom: 25px; text-align: center; }
        .back-link { display: block; text-align: center; margin-top: 20px; font-size: 13px; color: var(--primary-color); text-decoration: none; }
    </style>
</head>
<body>
<div class="login-container">
    <div class="login-header">
        <h2>Yeni Şifre Belirle</h2>
        <?php if($valid_token): ?>
            <p>Lütfen yeni şifrenizi girin ve onaylayın.</p>
        <?php endif; ?>
    </div>
    
    <?php if($error): ?> <div class="err"><?= $error ?></div> <?php endif; ?>
    <?php if($message): ?> <div class="succ"><?= $message ?></div> <?php endif; ?>
    
    <?php if($valid_token): ?>
    <form action="" method="POST">
        <div class="form-group">
            <label for="password">Yeni Şifre</label>
            <input type="password" id="password" name="password" placeholder="Yeni şifrenizi girin" required>
        </div>
        <div class="form-group">
            <label for="password_confirm">Yeni Şifre (Tekrar)</label>
            <input type="password" id="password_confirm" name="password_confirm" placeholder="Yeni şifrenizi tekrar girin" required>
        </div>
        <button type="submit" name="reset_password">Şifreyi Güncelle</button>
    </form>
    <?php endif; ?>
    
    <a href="login.php" class="back-link">← Giriş sayfasına dön</a>
</div>
</body>
</html>
