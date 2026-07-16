<?php
// Hata Ayıklama Motoru
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if (!isset($_SESSION['logged_in'])) { header('Location: login.php'); exit; }

if (isset($_POST['kaydet'])) {
    try {
        require_once '../db.php';
        
        $title = $_POST['title'];
        $content = $_POST['content'];
        $seo_title = $_POST['seo_title'];
        $seo_description = $_POST['seo_description'];
        $image_path = '';

        // PHP Slugify helper
        function slugify($text) {
            $find = array('Ç', 'Ş', 'Ğ', 'Ü', 'İ', 'Ö', 'ç', 'ş', 'ğ', 'ü', 'ö', 'ı', '+', '#');
            $replace = array('c', 's', 'g', 'u', 'i', 'o', 'c', 's', 'g', 'u', 'o', 'i', 'plus', 'sharp');
            $text = str_replace($find, $replace, $text);
            $text = preg_replace('/[^a-zA-Z0-9\s-]/', '', $text);
            $text = preg_replace('/[\s-]+/', ' ', $text);
            $text = trim($text);
            $text = str_replace(' ', '-', $text);
            $text = strtolower($text);
            return $text;
        }

        $slug = !empty($_POST['slug']) ? slugify($_POST['slug']) : slugify($title);
        
        // Benzersiz slug denetimi
        $checkStmt = $db->prepare("SELECT COUNT(*) FROM blogs WHERE slug = ?");
        $checkStmt->execute([$slug]);
        if ($checkStmt->fetchColumn() > 0) {
            $slug .= '-' . time();
        }

        if (isset($_FILES['blog_image']) && $_FILES['blog_image']['error'] == 0) {
            $upload_dir = '../uploads/';
            if (!file_exists($upload_dir)) { mkdir($upload_dir, 0777, true); }
            
            $tmp_name = $_FILES['blog_image']['tmp_name'];
            $image_info = getimagesize($tmp_name);
            $mime_type = $image_info['mime'];
            
            // WebP Dönüştürme Kontrolü
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
                    $file_ext = pathinfo($_FILES['blog_image']['name'], PATHINFO_EXTENSION);
                    $new_file_name = 'blog_' . time() . '_' . rand(1000, 9999) . '.' . $file_ext;
                    $target_file = $upload_dir . $new_file_name;
                    if (move_uploaded_file($tmp_name, $target_file)) {
                        $image_path = 'uploads/' . $new_file_name;
                    }
                }
            } else {
                $file_ext = pathinfo($_FILES['blog_image']['name'], PATHINFO_EXTENSION);
                $new_file_name = 'blog_' . time() . '_' . rand(1000, 9999) . '.' . $file_ext;
                $target_file = $upload_dir . $new_file_name;
                if (move_uploaded_file($tmp_name, $target_file)) {
                    $image_path = 'uploads/' . $new_file_name;
                }
            }
        }

        // Veritabanına Kaydetme (slug ile birlikte)
        $stmt = $db->prepare("INSERT INTO blogs (title, slug, content, seo_title, seo_description, image_url) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$title, $slug, $content, $seo_title, $seo_description, $image_path]);
        
        header('Location: index.php');
        exit;
        
    } catch (Exception $e) {
        die("<h2 style='color:red; font-family:Arial;'>Kritik Veritabanı Hatası:</h2><p>" . $e->getMessage() . "</p>");
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SEO Uyumlu Blog Ekle - Yönetim Paneli</title>
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2c3e50;
            --accent-color: #3498db;
            --success-color: #2ecc71;
            --danger-color: #e74c3c;
            --bg-color: #f5f6fa;
            --card-bg: #ffffff;
            --text-color: #2c3e50;
            --sidebar-width: 260px;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-color);
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Gelişmiş Navigasyon */
        .sidebar {
            width: var(--sidebar-width);
            background: var(--primary-color);
            color: #fff;
            padding: 30px 20px;
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100vh;
            left: 0;
            top: 0;
            box-shadow: 4px 0 15px rgba(0, 0, 0, 0.05);
            z-index: 100;
        }

        .sidebar-brand {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 40px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding-bottom: 20px;
            letter-spacing: 0.5px;
        }

        .sidebar-brand span {
            display: block;
            font-size: 12px;
            font-weight: 400;
            color: rgba(255, 255, 255, 0.6);
            margin-top: 5px;
        }

        .sidebar-menu {
            list-style: none;
            flex-grow: 1;
        }

        .sidebar-menu li {
            margin-bottom: 10px;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            color: rgba(255, 255, 255, 0.75);
            padding: 12px 16px;
            text-decoration: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .sidebar-menu a:hover, .sidebar-menu a.active {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
        }

        .sidebar-menu svg {
            margin-right: 12px;
            width: 18px;
            height: 18px;
        }

        .sidebar-footer {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 20px;
        }

        .btn-logout {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: 12px;
            background: var(--danger-color);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(231, 76, 60, 0.2);
        }

        .btn-logout:hover {
            background: #c0392b;
            transform: translateY(-2px);
        }

        /* Ana İçerik Alanı */
        .main-content {
            margin-left: var(--sidebar-width);
            flex-grow: 1;
            padding: 40px;
            width: calc(100% - var(--sidebar-width));
        }

        .header-section {
            margin-bottom: 30px;
        }

        .header-section h1 {
            font-size: 28px;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 5px;
        }

        .header-section p {
            color: #7f8c8d;
            font-size: 14px;
        }

        /* Form Kartı */
        .form-card {
            background: var(--card-bg);
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
            max-width: 800px;
        }

        form label {
            display: block;
            margin-bottom: 8px;
            font-size: 13px;
            font-weight: 600;
            color: var(--primary-color);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        form input[type="text"], form textarea, form input[type="file"] {
            width: 100%;
            padding: 12px 16px;
            background: #f8f9fa;
            border: 1px solid #dcdde1;
            border-radius: 8px;
            font-size: 14px;
            color: var(--text-color);
            margin-bottom: 25px;
            transition: all 0.3s ease;
            outline: none;
        }

        form input:focus, form textarea:focus {
            border-color: var(--accent-color);
            background: #fff;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
        }

        form textarea {
            height: 180px;
            resize: vertical;
        }

        /* SEO Kutusu */
        .seo-box {
            background: #f8f9fa;
            border-left: 4px solid var(--accent-color);
            padding: 25px;
            border-radius: 8px;
            margin-bottom: 30px;
        }

        .seo-box h3 {
            font-size: 16px;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 5px;
        }

        .seo-box p {
            font-size: 13px;
            color: #7f8c8d;
            margin-bottom: 20px;
        }

        .btn-submit {
            display: inline-flex;
            align-items: center;
            background: var(--success-color);
            color: #fff;
            padding: 14px 28px;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(46, 204, 113, 0.25);
            transition: all 0.3s ease;
        }

        .btn-submit:hover {
            background: #27ae60;
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(46, 204, 113, 0.35);
        }

        .btn-submit svg {
            margin-right: 8px;
            width: 16px;
            height: 16px;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            margin-top: 20px;
            color: #7f8c8d;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .back-link:hover {
            color: var(--primary-color);
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <div class="sidebar-brand">
        Necati Özçimen
        <span>Yönetim Paneli</span>
    </div>
    <ul class="sidebar-menu">
        <li>
            <a href="index.php">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="9"/><rect x="14" y="3" width="7" height="5"/><rect x="14" y="12" width="7" height="9"/><rect x="3" y="16" width="7" height="5"/></svg>
                Kontrol Paneli
            </a>
        </li>
        <li>
            <a href="blog-ekle.php" class="active">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
                Blog Yazısı Ekle
            </a>
        </li>
        <li>
            <a href="../" target="_blank">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z"/><circle cx="12" cy="12" r="3"/></svg>
                Siteyi Görüntüle
            </a>
        </li>
    </ul>
    <div class="sidebar-footer">
        <a href="logout.php" class="btn-logout" onclick="return confirm('Çıkış yapmak istediğinize emin misiniz?')">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:16px;height:16px;margin-right:8px;"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4M16 17l5-5-5-5M21 12H9"/></svg>
            Güvenli Çıkış
        </a>
    </div>
</div>

<!-- Main Content -->
<div class="main-content">
    <div class="header-section">
        <h1>Yeni Makale Yayınla</h1>
        <p>SEO uyumlu blog yazıları oluşturup sitenizi Google aramalarında öne çıkarın.</p>
    </div>

    <div class="form-card">
        <form action="" method="POST" enctype="multipart/form-data">
            
            <label for="title">Makale Başlığı</label>
            <input type="text" id="title" name="title" required placeholder="Sitede görünecek ana başlık">
            
            <label for="slug">Makale URL Adresi (Slug / Kısa Adı)</label>
            <input type="text" id="slug" name="slug" placeholder="Otomatik oluşturulur, dilerseniz değiştirebilirsiniz">
            
            <label for="blog_image">Kapak Fotoğrafı</label>
            <input type="file" id="blog_image" name="blog_image" accept="image/*">
            
            <label for="content">Makale İçeriği</label>
            <textarea id="content" name="content" required placeholder="Tüm makale metnini buraya giriniz..."></textarea>
            
            <div class="seo-box">
                <h3>Google Arama Motoru (SEO) Ayarları</h3>
                <p>Bu alanlar sitenizin Google sıralamasını iyileştirmek için gereklidir.</p>
                
                <label for="seo_title">Arama Başlığı (Meta Title)</label>
                <input type="text" id="seo_title" name="seo_title" required placeholder="Örn: Konya Tüp Bebek Tedavi Süreçleri | Op. Dr. Necati Özçimen">
                
                <label for="seo_description">Arama Özeti (Meta Description)</label>
                <textarea id="seo_description" name="seo_description" required placeholder="Arama sonuçlarında başlığın altında görüntülenecek 160 karakterlik özet metin..." style="height: 80px;"></textarea>
            </div>
            
            <button type="submit" name="kaydet" class="btn-submit">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                Makaleyi Canlıya Al
            </button>
        </form>
        
        <a href="index.php" class="back-link">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:16px;height:16px;margin-right:6px;vertical-align:middle;"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
            Yönetim Paneline Geri Dön
        </a>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const imageInput = document.getElementById('blog_image');
    
    form.addEventListener('submit', function(e) {
        if (imageInput.files.length === 0) {
            if (!confirm("Blogu fotosuz yüklüyorum emin misiniz?")) {
                e.preventDefault(); // Form gönderimini durdur
            }
        }
    });

    const titleInput = document.getElementById('title');
    const slugInput = document.getElementById('slug');
    let userEditedSlug = false;

    slugInput.addEventListener('input', function() {
        userEditedSlug = true;
    });

    titleInput.addEventListener('input', function() {
        if (!userEditedSlug) {
            slugInput.value = slugify(titleInput.value);
        }
    });

    function slugify(text) {
        const find = ['Ç', 'Ş', 'Ğ', 'Ü', 'İ', 'Ö', 'ç', 'ş', 'ğ', 'ü', 'ö', 'ı', '+', '#'];
        const replace = ['c', 's', 'g', 'u', 'i', 'o', 'c', 's', 'g', 'u', 'o', 'i', 'plus', 'sharp'];
        for (let i = 0; i < find.length; i++) {
            text = text.replace(new RegExp(find[i], 'g'), replace[i]);
        }
        return text.toLowerCase()
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/[\s-]+/g, ' ')
            .trim()
            .replace(/\s/g, '-');
    }
});
</script>
</body>
</html>