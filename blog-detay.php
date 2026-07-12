<?php 
// Veritabanı Bağlantısı
$db = new PDO('sqlite:db/konyatupbebek.db');

// Tarayıcıdan gelen id'yi yakala (Örn: blog-detay.php?id=3)
$blog_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$stmt = $db->prepare("SELECT * FROM blogs WHERE id = ?");
$stmt->execute([$blog_id]);
$blog = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$blog) {
    include 'includes/header.php';
    include 'includes/sidebar.php';
    echo "<section class='section-padding'><div class='container' style='text-align:center;'><h2>Makale Bulunamadı!</h2><p>Aradığınız yazı sistemden kaldırılmış olabilir.</p><a href='index.php'>Ana Sayfaya Dön</a></div></section>";
    include 'includes/footer.php';
    exit;
}

// 🚀 EN KRİTİK NOKTA: Header.php dahil edilmeden önce SEO verilerini değişkenlere atıyoruz!
$seo_title = $blog['seo_title'];
$seo_desc = $blog['seo_description'];

include 'includes/header.php'; 
include 'includes/sidebar.php'; 
?>

<div class="page-banner blog-banner">
    <div class="container">
        <h1><?php echo htmlspecialchars($blog['title']); ?></h1>
        <ul class="breadcrumb">
            <li><a href="index.php">Anasayfa</a></li>
            <li>/</li>
            <li><a href="index.php#blog">Blog</a></li>
            <li>/</li>
            <li>Makale Detayı</li>
        </ul>
    </div>
</div>

<section class="section-padding bg-white">
    <div class="container single-blog-wrapper">
        <article class="blog-detailed-box">
            
            <?php if(!empty($blog['image_url'])): ?>
            <div class="blog-main-image-area">
                <img src="<?php echo $blog['image_url']; ?>" alt="<?php echo htmlspecialchars($blog['title']); ?>">
            </div>
            <?php endif; ?>
            
            <div class="blog-detailed-body">
                <div class="blog-meta-info">
                    <span class="blog-date">📅 Yayınlanma Tarihi: <?php echo $blog['created_at']; ?></span>
                </div>
                
                <h2 class="blog-inner-title"><?php echo htmlspecialchars($blog['title']); ?></h2>
                
                <div class="blog-main-text">
                    <p><?php echo nl2br(htmlspecialchars($blog['content'])); ?></p>
                </div>
                
                <div class="appointment-callout" style="margin-top:50px;">
                    <h3>Op. Dr. Necati Özçimen ile İletişime Geçin</h3>
                    <p>Bu makalede yer alan tıbbi durumlar, belirtiler ve tedavi süreçleri hakkında kişiselleştirilmiş doktor görüşü almak için Konya Novafertil Tüp Bebek Merkezi bünyesinde randevunuzu kolayca planlayabilirsiniz.</p>
                    <a href="index.php#iletisim" class="btn-primary">Hemen Randevu Alın</a>
                </div>
            </div>
            
        </article>
    </div>
</section>

<?php 
include 'includes/footer.php'; 
?>