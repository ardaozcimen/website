<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if (!isset($_SESSION['logged_in'])) { header('Location: login.php'); exit; }

try {
    $db = new PDO('sqlite:../db/konyatupbebek.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Tablo Oluşturmaları
    $db->exec("CREATE TABLE IF NOT EXISTS testimonials (id INTEGER PRIMARY KEY AUTOINCREMENT, patient_name TEXT, message TEXT, image_url TEXT, created_at DATETIME DEFAULT CURRENT_TIMESTAMP)");
    $db->exec("CREATE TABLE IF NOT EXISTS statistics (id INTEGER PRIMARY KEY AUTOINCREMENT, title TEXT, count_value INTEGER)");
    $db->exec("CREATE TABLE IF NOT EXISTS faqs (id INTEGER PRIMARY KEY AUTOINCREMENT, question TEXT, answer TEXT)");

    $statCheck = $db->query("SELECT COUNT(*) FROM statistics")->fetchColumn();
    if ($statCheck == 0) {
        $db->exec("INSERT INTO statistics (title, count_value) VALUES ('Yıllık Tecrübe', 25)");
        $db->exec("INSERT INTO statistics (title, count_value) VALUES ('Başarılı Tüp Bebek', 5000)");
        $db->exec("INSERT INTO statistics (title, count_value) VALUES ('Mutlu Aile', 15000)");
    }

    // SİLME İŞLEMLERİ
    if (isset($_GET['sil'])) {
        $id = (int)$_GET['sil'];
        $stmtImg = $db->prepare("SELECT image_url FROM blogs WHERE id = ?");
        $stmtImg->execute([$id]);
        $blog = $stmtImg->fetch(PDO::FETCH_ASSOC);
        if ($blog && !empty($blog['image_url'])) {
            $file_path = '../' . $blog['image_url']; 
            if (file_exists($file_path)) unlink($file_path);
        }
        $db->prepare("DELETE FROM blogs WHERE id = ?")->execute([$id]);
        header('Location: index.php'); exit;
    }
    
    if (isset($_GET['sil_sss'])) { $db->prepare("DELETE FROM faqs WHERE id=?")->execute([$_GET['sil_sss']]); header("Location: index.php"); exit; }
    if (isset($_GET['sil_stat'])) { $db->prepare("DELETE FROM statistics WHERE id=?")->execute([$_GET['sil_stat']]); header("Location: index.php"); exit; }
    if (isset($_GET['sil_test'])) { 
        // Yorum silinirken fotoğrafı da sil
        $stmtImg = $db->prepare("SELECT image_url FROM testimonials WHERE id = ?");
        $stmtImg->execute([$_GET['sil_test']]);
        $testData = $stmtImg->fetch(PDO::FETCH_ASSOC);
        if ($testData && !empty($testData['image_url'])) {
            $file_path = '../' . $testData['image_url'];
            if (file_exists($file_path)) unlink($file_path);
        }
        $db->prepare("DELETE FROM testimonials WHERE id=?")->execute([$_GET['sil_test']]); 
        header("Location: index.php"); exit; 
    }

    // EKLEME İŞLEMLERİ (CREATE)
    if (isset($_POST['ekle_sss'])) {
        $stmt = $db->prepare("INSERT INTO faqs (question, answer) VALUES (?, ?)");
        $stmt->execute([$_POST['soru'], $_POST['cevap']]);
        header("Location: index.php"); exit;
    }
    if (isset($_POST['ekle_stat'])) {
        $stmt = $db->prepare("INSERT INTO statistics (title, count_value) VALUES (?, ?)");
        $stmt->execute([$_POST['baslik'], $_POST['sayi']]);
        header("Location: index.php"); exit;
    }
    if (isset($_POST['ekle_test'])) {
        $image_url = '';
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
            $upload_dir = '../uploads/';
            $new_name = 'yorum_' . time() . '_' . basename($_FILES['foto']['name']);
            if (move_uploaded_file($_FILES['foto']['tmp_name'], $upload_dir . $new_name)) {
                $image_url = 'uploads/' . $new_name;
            }
        }
        $stmt = $db->prepare("INSERT INTO testimonials (patient_name, message, image_url) VALUES (?, ?, ?)");
        $stmt->execute([$_POST['isim'], $_POST['mesaj'], $image_url]);
        header("Location: index.php"); exit;
    }

    // LİSTELEME SORGULARI
    $blogs = $db->query("SELECT * FROM blogs ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
    $faqs = $db->query("SELECT * FROM faqs")->fetchAll(PDO::FETCH_ASSOC);
    $stats = $db->query("SELECT * FROM statistics")->fetchAll(PDO::FETCH_ASSOC);
    $testimonials = $db->query("SELECT * FROM testimonials")->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Veritabanı Erişim Hatası: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Yönetim Paneli Ana Sayfa</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; background: #f8f9fa; }
        .nav { margin-bottom: 20px; background: #fff; padding: 15px; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
        .btn { background: #2ecc71; color: white; padding: 10px 15px; text-decoration: none; border-radius: 4px; font-weight: bold; border:none; cursor:pointer;}
        .btn-logout { background: #e74c3c; float: right; }
        table { width: 100%; background: #fff; border-collapse: collapse; margin-top: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
        th, td { padding: 12px; border: 1px solid #ddd; text-align: left; }
        th { background: #34495e; color: white; }
        .btn-delete { background: #e74c3c; color: white; padding: 5px 10px; text-decoration: none; border-radius: 3px; font-size: 13px; }
        
        /* Grid Sistemleri */
        .grid-modules { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; margin-top: 40px; }
        .module-card { background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .module-card input, .module-card textarea { width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing:border-box; }
        .module-card h3 { color:#34495e; margin-top:0; border-bottom: 2px solid #eee; padding-bottom:10px; }
    </style>
</head>
<body>

<div class="nav">
    <strong>Konyatupbebek.com Admin Paneli</strong>
    <a href="logout.php" class="btn btn-logout">Çıkış Yap</a>
    <a href="blog-ekle.php" class="btn">Yeni Blog Yazısı Ekle</a>
</div>

<h2>Mevcut Blog Yazıları</h2>
<table>
    <tr><th>ID</th><th>Başlık</th><th>Tarih</th><th>İşlemler</th></tr>
    <?php foreach ($blogs as $blog): ?>
    <tr>
        <td><?= $blog['id'] ?></td>
        <td><?= htmlspecialchars($blog['title']) ?></td>
        <td><?= $blog['created_at'] ?></td>
        <td><a href="index.php?sil=<?= $blog['id'] ?>" class="btn-delete" onclick="return confirm('Bu yazıyı silmek istediğinize emin misiniz?')">Sil</a></td>
    </tr>
    <?php endforeach; ?>
</table>

<div class="grid-modules">
    <div class="module-card">
        <h3>İstatistik Ekle</h3>
        <form method="POST">
            <input type="text" name="baslik" placeholder="Başlık (Örn: Mutlu Aile)" required>
            <input type="number" name="sayi" placeholder="Sayı (Örn: 15000)" required>
            <button type="submit" name="ekle_stat" class="btn" style="background:#3498db; width:100%;">Ekle</button>
        </form>
        <table>
            <?php foreach($stats as $s): ?>
            <tr><td><?= htmlspecialchars($s['title']) ?> (<?= $s['count_value'] ?>+)</td><td style="width:50px;"><a href="?sil_stat=<?= $s['id'] ?>" class="btn-delete">Sil</a></td></tr>
            <?php endforeach; ?>
        </table>
    </div>

    <div class="module-card">
        <h3>Sıkça Sorulan Soru (SSS) Ekle</h3>
        <form method="POST">
            <input type="text" name="soru" placeholder="Soru (Örn: Tedavi Acıtır Mı?)" required>
            <textarea name="cevap" placeholder="Cevabı buraya yazın..." required></textarea>
            <button type="submit" name="ekle_sss" class="btn" style="background:#3498db; width:100%;">Ekle</button>
        </form>
        <table>
            <?php foreach($faqs as $f): ?>
            <tr><td><?= htmlspecialchars($f['question']) ?></td><td style="width:50px;"><a href="?sil_sss=<?= $f['id'] ?>" class="btn-delete">Sil</a></td></tr>
            <?php endforeach; ?>
        </table>
    </div>

    <div class="module-card">
        <h3>Hasta Yorumu / Başarı Hikayesi Ekle</h3>
        <form method="POST" enctype="multipart/form-data">
            <input type="text" name="isim" placeholder="Hasta İsim-Soyisim" required>
            <textarea name="mesaj" placeholder="Kısa Hasta Yorumu..." required></textarea>
            <input type="file" name="foto" accept="image/*">
            <button type="submit" name="ekle_test" class="btn" style="background:#3498db; width:100%;">Yorum Ekle</button>
        </form>
        <table>
            <?php foreach($testimonials as $t): ?>
            <tr><td><?= htmlspecialchars($t['patient_name']) ?></td><td style="width:50px;"><a href="?sil_test=<?= $t['id'] ?>" class="btn-delete">Sil</a></td></tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>

</body>
</html>