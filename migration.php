<?php
// Otomatik SQLite -> MySQL Veri Taşıma Scripti

header('Content-Type: text/html; charset=utf-8');
ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "<h2>Konya Tüp Bebek Veri Taşıma (Migration) Sistemi</h2>";

// 1. MySQL Bağlantısını Yükle
if (!file_exists('db.php')) {
    die("<p style='color:red;'>Hata: db.php dosyası bulunamadı. Lütfen önce db.php dosyasını yükleyin.</p>");
}
require_once 'db.php'; // $db değişkenini sağlar (MySQL bağlantısı)

$sqlitePath = 'db/konyatupbebek.db';

// 2. Eğer SQLite dosyası yoksa, konyatupbebek.zip dosyasından çıkarmayı dene
if (!file_exists($sqlitePath)) {
    echo "<p>SQLite veritabanı bulunamadı, konyatupbebek.zip arşivinden çıkarılması deneniyor...</p>";
    
    $zipPath = 'konyatupbebek.zip';
    if (!file_exists($zipPath)) {
        // Alternatif olarak Archive.zip'i de deneyelim
        $zipPath = 'Archive.zip';
    }

    if (file_exists($zipPath)) {
        $zip = new ZipArchive;
        if ($zip->open($zipPath) === TRUE) {
            // db klasörünü oluştur
            if (!file_exists('db')) {
                mkdir('db', 0777, true);
            }
            
            // Sadece db/konyatupbebek.db dosyasını çıkar
            $extracted = false;
            for ($i = 0; $i < $zip->numFiles; $i++) {
                $filename = $zip->getNameIndex($i);
                if (strpos($filename, 'konyatupbebek.db') !== false) {
                    copy("zip://".$zipPath."#".$filename, $sqlitePath);
                    $extracted = true;
                    echo "<p style='color:green;'>Başarılı: Eski veritabanı dosyası ($filename) arşivden çıkarıldı.</p>";
                    break;
                }
            }
            $zip->close();
            
            if (!$extracted) {
                echo "<p style='color:red;'>Hata: Arşiv dosyasında konyatupbebek.db bulunamadı.</p>";
                echo "<h3>Arşiv İçeriğindeki Dosyaların Listesi ($zipPath):</h3><ul>";
                for ($j = 0; $j < $zip->numFiles; $j++) {
                    echo "<li>" . htmlspecialchars($zip->getNameIndex($j)) . "</li>";
                }
                echo "</ul>";
                die();
            }
        } else {
            die("<p style='color:red;'>Hata: Arşiv dosyası ($zipPath) açılamadı.</p>");
        }
    } else {
        die("<p style='color:red;'>Hata: Sunucuda konyatupbebek.db veya konyatupbebek.zip dosyası bulunamadı. Lütfen eski konyatupbebek.db dosyasını db/ klasörüne yükleyin.</p>");
    }
}

// 3. SQLite Bağlantısını Kur
try {
    $sqliteDb = new PDO('sqlite:' . $sqlitePath);
    $sqliteDb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<p style='color:green;'>SQLite veritabanına bağlanıldı. Veri aktarımı başlıyor...</p>";
} catch (PDOException $e) {
    die("<p style='color:red;'>SQLite Bağlantı Hatası: " . $e->getMessage() . "</p>");
}

// 4. Verileri Taşıma Fonksiyonu
function migrateTable($sqliteDb, $mysqlDb, $tableName, $insertQuery, $fields) {
    try {
        // Önce MySQL'deki eski verileri temizle (çakışmayı önlemek için)
        $mysqlDb->exec("TRUNCATE TABLE `$tableName`");
        
        // SQLite'tan verileri çek
        $stmtSelect = $sqliteDb->query("SELECT * FROM `$tableName`");
        $rows = $stmtSelect->fetchAll(PDO::FETCH_ASSOC);
        
        if (count($rows) > 0) {
            $stmtInsert = $mysqlDb->prepare($insertQuery);
            foreach ($rows as $row) {
                $params = [];
                foreach ($fields as $field) {
                    $params[] = isset($row[$field]) ? $row[$field] : null;
                }
                $stmtInsert->execute($params);
            }
            echo "<p style='color:green;'>✓ <b>$tableName</b> tablosu aktarıldı (" . count($rows) . " kayıt).</p>";
        } else {
            echo "<p style='color:orange;'>! <b>$tableName</b> tablosunda aktarılacak kayıt bulunamadı.</p>";
        }
    } catch (Exception $e) {
        echo "<p style='color:red;'>Hata ($tableName): " . $e->getMessage() . "</p>";
    }
}

// 5. Her Tabloyu Sırayla Aktar
// BLOGLAR
migrateTable(
    $sqliteDb, $db, 'blogs',
    "INSERT INTO blogs (id, title, content, seo_title, seo_description, image_url, created_at) VALUES (?, ?, ?, ?, ?, ?, ?)",
    ['id', 'title', 'content', 'seo_title', 'seo_description', 'image_url', 'created_at']
);

// HASTA YORUMLARI
migrateTable(
    $sqliteDb, $db, 'testimonials',
    "INSERT INTO testimonials (id, patient_name, message, image_url, created_at) VALUES (?, ?, ?, ?, ?)",
    ['id', 'patient_name', 'message', 'image_url', 'created_at']
);

// SIKÇA SORULAN SORULAR
migrateTable(
    $sqliteDb, $db, 'faqs',
    "INSERT INTO faqs (id, question, answer) VALUES (?, ?, ?)",
    ['id', 'question', 'answer']
);

// İSTATİSTİKLER
migrateTable(
    $sqliteDb, $db, 'statistics',
    "INSERT INTO statistics (id, title, count_value) VALUES (?, ?, ?)",
    ['id', 'title', 'count_value']
);

// SAYFALAR (Eski özel düzenlemeleriniz varsa)
migrateTable(
    $sqliteDb, $db, 'pages',
    "INSERT INTO pages (slug, title, content) VALUES (?, ?, ?)",
    ['slug', 'title', 'content']
);

echo "<h3 style='color:green;'>Aktarım Tamamlandı!</h3>";
echo "<p>Lütfen ana sayfanızı yenileyin. Verilerinizi başarıyla MySQL veritabanına taşıdık.</p>";
echo "<p style='color:gray; font-size:12px;'>Güvenliğiniz için işlem bittikten sonra bu migration.php dosyasını FTP/Plesk üzerinden siliniz.</p>";
