<?php
// Hata Ayıklama Motoru (Beyaz ekran yerine hatayı gösterir)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if (!isset($_SESSION['logged_in'])) { header('Location: login.php'); exit; }

if (isset($_POST['kaydet'])) {
    try {
        $db = new PDO('sqlite:../db/konyatupbebek.db');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $title = $_POST['title'];
        $content = $_POST['content'];
        $seo_title = $_POST['seo_title'];
        $seo_description = $_POST['seo_description'];
        $image_path = '';

        if (isset($_FILES['blog_image']) && $_FILES['blog_image']['error'] == 0) {
            $upload_dir = '../uploads/';
            if (!file_exists($upload_dir)) { mkdir($upload_dir, 0777, true); }
            
            $tmp_name = $_FILES['blog_image']['tmp_name'];
            $image_info = getimagesize($tmp_name);
            $mime_type = $image_info['mime'];
            
            // XAMPP/MAMP WebP destekliyor mu kontrolü (Çökmeyi %100 engeller)
            if (function_exists('imagewebp')) {
                $image = null;
                if ($mime_type == 'image/jpeg' || $mime_type == 'image/jpg') {
                    $image = imagecreatefromjpeg($tmp_name);
                } elseif ($mime_type == 'image/png') {
                    $image = imagecreatefrompng($tmp_name);
                    imagepalettetotruecolor($image);
                    imagealphablending($image, true);
                    imagesavealpha($image, true);
                } elseif ($mime_type == 'image/webp') {
                    $image = imagecreatefromwebp($tmp_name);
                } elseif ($mime_type == 'image/gif') {
                    $image = imagecreatefromgif($tmp_name);
                }

                if ($image !== null) {
                    $new_file_name = 'blog_' . time() . '_' . rand(1000, 9999) . '.webp';
                    $target_file = $upload_dir . $new_file_name;
                    
                    if (imagewebp($image, $target_file, 80)) {
                        $image_path = 'uploads/' . $new_file_name; 
                    }
                    imagedestroy($image);
                } else {
                    // Resim desteklenmeyen özel bir formattaysa normal yükle
                    $file_ext = pathinfo($_FILES['blog_image']['name'], PATHINFO_EXTENSION);
                    $new_file_name = 'blog_' . time() . '_' . rand(1000, 9999) . '.' . $file_ext;
                    $target_file = $upload_dir . $new_file_name;
                    if (move_uploaded_file($tmp_name, $target_file)) {
                        $image_path = 'uploads/' . $new_file_name;
                    }
                }
            } else {
                // WebP motoru yoksa (yerel sunucuda) sistemi çökertmeden klasik yükleme yap
                $file_ext = pathinfo($_FILES['blog_image']['name'], PATHINFO_EXTENSION);
                $new_file_name = 'blog_' . time() . '_' . rand(1000, 9999) . '.' . $file_ext;
                $target_file = $upload_dir . $new_file_name;
                if (move_uploaded_file($tmp_name, $target_file)) {
                    $image_path = 'uploads/' . $new_file_name;
                }
            }
        }

        // Veritabanına Kaydetme
        $stmt = $db->prepare("INSERT INTO blogs (title, content, seo_title, seo_description, image_url) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$title, $content, $seo_title, $seo_description, $image_path]);
        
        header('Location: index.php');
        exit;
        
    } catch (Exception $e) {
        // Beyaz ekran vermek yerine hatayı kırmızı harflerle basar
        die("<h2 style='color:red; font-family:Arial;'>Kritik Veritabanı Hatası:</h2><p>" . $e->getMessage() . "</p>");
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Gelişmiş SEO Uyumlu Blog Ekle</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; background: #f8f9fa; }
        .form-container { background: #fff; padding: 25px; border-radius: 6px; max-width: 700px; margin: 0 auto; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        input[type="text"], textarea, input[type="file"] { width: 100%; padding: 12px; margin: 10px 0 20px 0; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        textarea { height: 150px; }
        .seo-section { background: #f1f3f5; padding: 15px; border-radius: 5px; margin-bottom: 20px; border-left: 4px solid #3498db; }
        button { background: #3498db; color: white; padding: 12px 20px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; font-weight:bold; }
        .back-link { display: inline-block; margin-top: 15px; color: #777; text-decoration:none; }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Gelişmiş SEO Uyumlu Blog Yazısı Yayınlama</h2>
    <form action="" method="POST" enctype="multipart/form-data">
        
        <label><strong>Makale Başlığı</strong></label>
        <input type="text" name="title" required placeholder="Sitede görünecek ana başlık">
        
        <label><strong>Kapak Fotoğrafı (Sistem otomatik olarak optimize edecektir)</strong></label>
        <input type="file" name="blog_image" accept="image/*" required>
        
        <label><strong>Uzun Makale İçeriği</strong></label>
        <textarea name="content" required placeholder="Tüm detaylı makale içeriğini buraya giriniz..."></textarea>
        
        <div class="seo-section">
            <h3>Google Arama Motoru (SEO) Ayarları</h3>
            <p style="font-size:13px; color:#666; margin-bottom:10px;">Bu alanlar Google aramalarında sitenizin üst sıralara çıkmasını sağlar.</p>
            
            <label>Google Arama Başlığı (Meta Title)</label>
            <input type="text" name="seo_title" required placeholder="Örn: Konya Tüp Bebek Başarı Oranları | Op. Dr. Necati Özçimen">
            
            <label>Google Arama Özeti (Meta Description / Sitedeki Kısa Özet)</label>
            <textarea name="seo_description" required placeholder="Maksimum 160 karakterlik, aramalarda başlığın altında çıkacak olan dikkat çekici özet metin..." style="height:80px;"></textarea>
        </div>
        
        <button type="submit" name="kaydet">Makaleyi Canlıya Al</button>
    </form>
    <a href="index.php" class="back-link">← Yönetim Paneline Geri Dön</a>
</div>

</body>
</html>