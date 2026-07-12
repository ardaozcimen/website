<?php 
include 'includes/header.php'; 
include 'includes/sidebar.php'; 

// Veritabanı Bağlantısı
$db = new PDO('sqlite:db/konyatupbebek.db');

// Tarayıcıdan gelen 'sayfa' parametresini yakala (Örn: amh)
$get_slug = isset($_GET['sayfa']) ? $_GET['sayfa'] : '';

// Veritabanından bu slug'a ait veriyi çek
$stmt = $db->prepare("SELECT * FROM pages WHERE slug = ?");
$stmt->execute([$get_slug]);
$page = $stmt->fetch(PDO::FETCH_ASSOC);

// Eğer veritabanında böyle bir sayfa yoksa ana sayfaya yönlendir veya hata ver
if (!$page) {
    echo "<section class='section-padding'><div class='container'><h2>Sayfa Bulunamadı!</h2><p>Aradığınız içerik sistemde mevcut değil.</p><a href='index.php'>Ana Sayfaya Dön</a></div></section>";
} else {
    // Sayfa bulunduysa içeriği ekrana bas
?>

<div class="page-banner">
    <div class="container">
        <h1><?php echo htmlspecialchars($page['title']); ?></h1>
        <ul class="breadcrumb">
            <li><a href="index.php">Anasayfa</a></li>
            <li>/</li>
            <li><?php echo htmlspecialchars($page['title']); ?></li>
        </ul>
    </div>
</div>

<section class="section-padding bg-white">
    <div class="container single-page-content">
        <div class="content-box">
            <h2><?php echo htmlspecialchars($page['title']); ?> </h2>
            <p class="lead-text"><?php echo nl2br(htmlspecialchars($page['content'])); ?></p>
            
            <div class="appointment-callout">
                <h3>Detaylı Bilgi ve Randevu</h3>
                <p>Op. Dr. Necati Özçimen ile iletişime geçmek ve tedavi süreçleri hakkında randevu almak için hemen formumuzu doldurabilirsiniz.</p>
                <a href="tel:+903323235151" onclick="if(!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)){ window.open('https://api.whatsapp.com/send?phone=905063701222', '_blank'); return false; }" class="btn-primary">İletişime Geçin</a>
            </div>
        </div>
    </div>
</section>

<?php 
}
include 'includes/footer.php'; 
?>