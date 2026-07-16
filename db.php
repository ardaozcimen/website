<?php
// Merkezi Veritabanı Bağlantı ve Çevre Algılama Dosyası

// İstek yapılan host adına veya CLI (Komut Satırı) durumuna göre yerel/canlı çevre tespiti
$isLocal = (php_sapi_name() === 'cli') || (isset($_SERVER['HTTP_HOST']) && ($_SERVER['HTTP_HOST'] === 'localhost' || $_SERVER['HTTP_HOST'] === '127.0.0.1'));

// Dinamik Web Kök Dizini (BASE_URL) Belirleme
if ($isLocal) {
    // Yerel (localhost) ortam
    define('BASE_URL', '/konyatupbebek/');
} else {
    // Canlı sunucu ortamı
    define('BASE_URL', '/');
}

if (!$isLocal) {
    // CANLI SUNUCU (MySQL Bağlantısı)
    $host = 'localhost';
    $dbname = 'konyatup';
    $username = 'konyatup';
    $password = '_T2bc4Xwfp*cuW7k';

    try {
        // UTF-8 karakter desteği ile MySQL bağlantısı
        $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        // Veritabanı bağlantı hatası durumunda bilgilendirme basıp durdur
        die("<h3 style='color:red;font-family:Arial;'>Canlı Sunucu Veritabanı Bağlantı Hatası:</h3><p style='font-family:Arial;'>" . htmlspecialchars($e->getMessage()) . "</p>");
    }
} else {
    // YEREL ÇEVRE (Localhost / XAMPP)
    // Kolaylık olması açısından önce yerel klasördeki SQLite veritabanını dene
    $sqlitePath = dirname(__FILE__) . '/db/konyatupbebek.db';
    
    if (file_exists($sqlitePath)) {
        try {
            $db = new PDO("sqlite:" . $sqlitePath);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("<h3 style='color:red;font-family:Arial;'>Yerel SQLite Bağlantı Hatası:</h3><p style='font-family:Arial;'>" . htmlspecialchars($e->getMessage()) . "</p>");
        }
    } else {
        // Eğer yerel SQLite dosyası bulunamazsa, XAMPP varsayılan MySQL bağlantısını dene
        $host = 'localhost';
        $dbname = 'konyatup';
        $username = 'root';
        $password = '';

        try {
            $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("<h3 style='color:red;font-family:Arial;'>Yerel Veritabanı Bağlantı Hatası:</h3>"
                . "<p style='font-family:Arial;'>Yerel SQLite veritabanı dosyası ($sqlitePath) bulunamadı ve yerel MySQL (XAMPP) sunucusuna bağlanılamadı. Hata: " . htmlspecialchars($e->getMessage()) . "</p>");
        }
    }
}

// Güvenlik Nedeniyle SMTP E-posta Ayarları Merkezi Yapılandırma Dosyasına Taşındı
define('SMTP_USER', 'ivf.tupbebekkonya@gmail.com');
define('SMTP_PASS', 'iawwivketdzskino');
