<?php 
require_once 'db.php';

// Tarayıcıdan gelen slug veya id'yi yakala (Örn: /blog/slug-adi veya blog-detay.php?id=4)
$blog_slug = isset($_GET['slug']) ? $_GET['slug'] : '';
$blog_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if (!empty($blog_slug)) {
    $stmt = $db->prepare("SELECT * FROM blogs WHERE slug = ?");
    $stmt->execute([$blog_slug]);
} else {
    $stmt = $db->prepare("SELECT * FROM blogs WHERE id = ?");
    $stmt->execute([$blog_id]);
}
$blog = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$blog) {
    include '404.php';
    exit;
}

// 🚀 EN KRİTİK NOKTA: Header.php dahil edilmeden önce SEO verilerini değişkenlere atıyoruz!
$seo_title = $blog['seo_title'];
$seo_desc = $blog['seo_description'];

include 'includes/header.php'; 
include 'includes/sidebar.php'; 

if ($blog) {
    // GEO: Article Schema
    $article_schema = [
        "@context" => "https://schema.org",
        "@type" => "Article",
        "headline" => htmlspecialchars($blog['title']),
        "description" => $seo_desc,
        "image" => !empty($blog['image_url']) ? "https://www.konyatupbebek.com/" . $blog['image_url'] : "https://www.konyatupbebek.com/uploads/dr_necati_ozcimen_tup_bebek.webp",
        "datePublished" => date("c", strtotime($blog['created_at'])),
        "dateModified" => !empty($blog['updated_at']) ? date("c", strtotime($blog['updated_at'])) : date("c", strtotime($blog['created_at'])),
        "author" => [
            "@type" => "Physician",
            "name" => "Op. Dr. Necati Özçimen",
            "url" => "https://www.konyatupbebek.com/hakkimizda.php"
        ],
        "publisher" => [
            "@type" => "MedicalClinic",
            "name" => "Konya Novafertil Tüp Bebek Merkezi",
            "logo" => [
                "@type" => "ImageObject",
                "url" => "https://www.konyatupbebek.com/uploads/dr_necati_ozcimen_tup_bebek.webp"
            ]
        ],
        "mainEntityOfPage" => [
            "@type" => "WebPage",
            "@id" => "https://www.konyatupbebek.com/blog/" . $blog_slug
        ]
    ];
    echo "<script type='application/ld+json'>" . json_encode($article_schema, JSON_UNESCAPED_UNICODE) . "</script>\n";
}
?>

<div class="page-banner blog-banner">
    <div class="container">
        <h1><?php echo htmlspecialchars($blog['title']); ?></h1>
        <ul class="breadcrumb">
            <li><a href="<?= BASE_URL ?>">Anasayfa</a></li>
            <li>/</li>
            <li><a href="<?= BASE_URL ?>#blog">Blog</a></li>
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
                    <?php
                    $date = new DateTime($blog['created_at']);
                    $formatter = new IntlDateFormatter('tr_TR', IntlDateFormatter::LONG, IntlDateFormatter::NONE);
                    $formattedDate = $formatter->format($date);
                    ?>
                    <span class="blog-date">📅 Yayınlanma Tarihi: <?php echo $formattedDate; ?></span>
                </div>
                
                <h2 class="blog-inner-title"><?php echo htmlspecialchars($blog['title']); ?></h2>
                
                <div class="blog-main-text">
                    <?php echo $blog['content']; ?>
                </div>
                
                <div class="appointment-callout" style="margin-top:50px;">
                    <h3>Op. Dr. Necati Özçimen ile İletişime Geçin</h3>
                    <p>Bu makalede yer alan tıbbi durumlar, belirtiler ve tedavi süreçleri hakkında kişiselleştirilmiş doktor görüşü almak için Konya Novafertil Tüp Bebek Merkezi bünyesinde randevunuzu kolayca planlayabilirsiniz.</p>
                    <a href="<?= BASE_URL ?>#iletisim" class="btn-primary">Hemen Randevu Alın</a>
                </div>
            </div>
            
        </article>
    </div>
</section>

<?php 
include 'includes/footer.php'; 
?>