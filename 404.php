<?php
http_response_code(404);
$seo_title = "404 Sayfa Bulunamadı | Konya Tüp Bebek Merkezi";
$seo_desc = "Aradığınız sayfa bulunamadı. Konya Tüp Bebek Merkezi ana sayfasına dönebilir veya tedavilerimizi inceleyebilirsiniz.";

// Hangi dosyadan çağrıldığına bağlı olarak header yolunu ayarla
$header_path = file_exists('includes/header.php') ? 'includes/header.php' : '../includes/header.php';
$sidebar_path = file_exists('includes/sidebar.php') ? 'includes/sidebar.php' : '../includes/sidebar.php';
$footer_path = file_exists('includes/footer.php') ? 'includes/footer.php' : '../includes/footer.php';

if (file_exists($header_path)) {
    include $header_path;
    include $sidebar_path;
}
?>

<div class="page-banner" style="background-color: #2c3e50; color: #fff;">
    <div class="container" style="text-align: center;">
        <h1 style="font-size: 48px; margin-bottom: 10px;">404</h1>
        <p style="font-size: 20px;">Sayfa Bulunamadı</p>
    </div>
</div>

<section class="section-padding bg-light" style="min-height: 50vh; display: flex; align-items: center; justify-content: center;">
    <div class="container" style="text-align: center;">
        <h2 style="color: #2c3e50; margin-bottom: 20px;">Üzgünüz, Aradığınız Sayfaya Ulaşılamıyor</h2>
        <p style="font-size: 16px; color: #555; max-width: 600px; margin: 0 auto 30px auto; line-height: 1.6;">
            Girmeye çalıştığınız sayfa kaldırılmış, adresi değiştirilmiş veya geçici olarak ulaşılamıyor olabilir. 
            Lütfen bağlantıyı kontrol edin veya aşağıdaki hızlı bağlantılardan yararlanın.
        </p>
        
        <div style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
            <a href="<?= defined('BASE_URL') ? BASE_URL : '/' ?>" class="btn-primary" style="padding: 12px 25px; border-radius: 8px; text-decoration: none; font-weight: bold;">Ana Sayfaya Dön</a>
            <a href="<?= defined('BASE_URL') ? BASE_URL : '/' ?>#tedaviler" class="btn-secondary" style="padding: 12px 25px; background-color: #fff; color: #2c3e50; border: 2px solid #2c3e50; border-radius: 8px; text-decoration: none; font-weight: bold; transition: 0.3s;">Tedavilerimiz</a>
            <a href="<?= defined('BASE_URL') ? BASE_URL : '/' ?>blog.php" class="btn-secondary" style="padding: 12px 25px; background-color: #fff; color: #2c3e50; border: 2px solid #2c3e50; border-radius: 8px; text-decoration: none; font-weight: bold; transition: 0.3s;">Blog</a>
        </div>
    </div>
</section>

<?php 
if (file_exists($footer_path)) {
    include $footer_path; 
} else {
    echo '</body></html>';
}
?>
