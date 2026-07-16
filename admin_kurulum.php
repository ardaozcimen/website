<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'db.php';

try {
    // 1. Admins tablosunu oluştur
    global $isLocal;
    
    if (isset($isLocal) && $isLocal) {
        // SQLite uyumlu (Yerel Ortam)
        $sql_create = "CREATE TABLE IF NOT EXISTS `admins` (
            `id` INTEGER PRIMARY KEY AUTOINCREMENT,
            `username` VARCHAR(50) NOT NULL UNIQUE,
            `password_hash` VARCHAR(255) NOT NULL,
            `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
        );";
    } else {
        // MySQL uyumlu (Canlı Sunucu)
        $sql_create = "CREATE TABLE IF NOT EXISTS `admins` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `username` VARCHAR(50) NOT NULL UNIQUE,
            `password_hash` VARCHAR(255) NOT NULL,
            `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
    }
    
    $db->exec($sql_create);
    echo "<h3>1. Admins tablosu başarıyla oluşturuldu veya zaten var.</h3>";

    // 2. Admin kullanıcısını ekle
    $username = 'admin';
    $password = 'Necati123!';
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Kullanıcının zaten olup olmadığını kontrol et
    $stmtCheck = $db->prepare("SELECT id FROM admins WHERE username = ?");
    $stmtCheck->execute([$username]);
    
    if ($stmtCheck->rowCount() == 0) {
        $stmtInsert = $db->prepare("INSERT INTO admins (username, password_hash) VALUES (?, ?)");
        $stmtInsert->execute([$username, $hashed_password]);
        echo "<h3>2. 'admin' kullanıcısı şifrelenerek başarıyla sisteme eklendi.</h3>";
    } else {
        // Eğer kullanıcı varsa şifresini güncelle
        $stmtUpdate = $db->prepare("UPDATE admins SET password_hash = ? WHERE username = ?");
        $stmtUpdate->execute([$hashed_password, $username]);
        echo "<h3>2. 'admin' kullanıcısı zaten vardı, şifresi yeniden güncellendi.</h3>";
    }

    echo "<p style='color:green; font-weight:bold;'>İşlem Tamamlandı! Artık güvenli bir şekilde admin panelinden giriş yapabilirsiniz.</p>";
    echo "<p style='color:red;'>ÖNEMLİ: Bu dosyayı (admin_kurulum.php) sunucunuzdan güvenliğiniz için silmeyi unutmayın!</p>";

} catch (PDOException $e) {
    echo "HATA OLUŞTU: " . $e->getMessage();
}
?>
