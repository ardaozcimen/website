<?php 
require_once 'db.php';

// Tarayıcıdan gelen 'sayfa' parametresini yakala (Örn: amh)
$get_slug = isset($_GET['sayfa']) ? $_GET['sayfa'] : '';

// Veritabanından bu slug'a ait veriyi çek
$stmt = $db->prepare("SELECT * FROM pages WHERE slug = ?");
$stmt->execute([$get_slug]);
$page = $stmt->fetch(PDO::FETCH_ASSOC);

if ($page) {
    $seo_title = $page['title'] . ' - Op. Dr. Necati Özçimen | Konya Tüp Bebek Merkezi';
    $clean_content = preg_replace('/\s+/', ' ', strip_tags($page['content']));
    $seo_desc = mb_substr($clean_content, 0, 155, 'UTF-8') . '...';
    
    // SEO Optimizasyonu İçin Sayfaya Özel Görsel Eşleştirme
    $seo_alts = [
        'amh' => 'Yumurta Rezerv Düşüklüğü (AMH) Testi ve Tedavisi Konya',
        'vajinismus' => 'Konya Vajinismus Tedavisi ve Psikolojik Destek',
        'erken-menopoz' => 'Erken Menopoz Teşhisi ve Gebelik Tedavisi',
        'endometriozis' => 'Endometriozis Çikolata Kisti Tedavisi Konya',
        'aciklanamayan-kisirlik' => 'Açıklanamayan Kısırlık (İnfertilite) ve Tüp Bebek',
        'pcos' => 'Polikistik Over Sendromu (PCOS) Belirtileri ve Tedavisi',
        'septum' => 'Rahim İçi Perde (Septum) Ameliyatı ve Gebelik',
        'cift-rahim' => 'Çift Rahim Anomalisi ve Doğurganlık',
        'tubal-faktor' => 'Tüplerin Tıkalı Olması (Tubal Faktör) Tüp Bebek',
        'hormonal-bozukluklar' => 'Erkeklerde Hormonal Bozukluklar ve Kısırlık Tedavisi',
        'azospermi' => 'Azospermi Tedavisi, Mikro TESE ve Sperm Bulma',
        'klinefelter' => 'Klinefelter Sendromu ve Tüp Bebek ile Gebelik',
        'sperm-dusuklugu' => 'Sperm Sayısı Düşüklüğü (Oligospermi) Tedavisi',
        'varikosel' => 'Varikosel Ameliyatı ve Erkek Kısırlığı',
        'asilama' => 'Aşılama (İnseminasyon) Tedavisi Süreci Konya',
        'embriyo-dondurma' => 'Embriyo Dondurma ve Saklama İşlemi',
        'genetik-tup-bebek' => 'NGS Kapsamlı Kromozom Taraması ve Genetik Tüp Bebek',
        'mikro-enjeksiyon' => 'Mikro Enjeksiyon (ICSI) Yöntemi ile Tüp Bebek',
        'rahim-dinlendirme' => 'Rahim Dinlendirme Yöntemi ile Başarılı Gebelik',
        'sperm-dondurma' => 'Sperm Dondurma İşlemi ve Saklama Koşulları',
        'tup-bebek' => 'Konya Tüp Bebek Tedavisi Süreçleri - Op. Dr. Necati Özçimen',
        'yumurta-dondurma' => 'Yumurta Dondurma (Oosit Kriyoprezervasyonu) İşlemi'
    ];
    
    $local_img_path = 'uploads/tedaviler/' . $get_slug . '.webp';
    if (file_exists($local_img_path)) {
        $current_img = BASE_URL . $local_img_path;
    } else {
        $current_img = 'https://images.unsplash.com/photo-1579684385127-1ef15d508118?q=80&w=800'; // Fallback
    }
    
    $current_alt = isset($seo_alts[$get_slug]) ? $seo_alts[$get_slug] : htmlspecialchars($page['title']) . ' - Konya Tüp Bebek';
}

include 'includes/header.php'; 
include 'includes/sidebar.php'; 

if ($page) {
    // GEO: MedicalWebPage Schema
    $medical_schema = [
        "@context" => "https://schema.org",
        "@type" => "MedicalWebPage",
        "name" => htmlspecialchars($page['title']),
        "description" => $seo_desc,
        "url" => "https://www.konyatupbebek.com/detay/" . $get_slug,
        "about" => [
            "@type" => "MedicalCondition",
            "name" => htmlspecialchars($page['title'])
        ],
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
        ]
    ];
    echo "<script type='application/ld+json'>" . json_encode($medical_schema, JSON_UNESCAPED_UNICODE) . "</script>\n";
}

// Eğer veritabanında böyle bir sayfa yoksa hata ver
if (!$page) {
    include '404.php';
    exit;
} else {
    // Sayfa bulunduysa içeriği ekrana bas
?>

<div class="page-banner">
    <div class="container">
        <h1><?php echo htmlspecialchars($page['title']); ?></h1>
        <ul class="breadcrumb">
            <li><a href="<?= BASE_URL ?>">Anasayfa</a></li>
            <li>/</li>
            <li><?php echo htmlspecialchars($page['title']); ?></li>
        </ul>
    </div>
</div>

<section class="section-padding bg-white">
    <div class="container single-page-content">
        <div class="content-box">
            <h2><?php echo htmlspecialchars($page['title']); ?> </h2>
            <img src="<?php echo $current_img; ?>" alt="<?php echo $current_alt; ?>" title="<?php echo $current_alt; ?>" style="width: 100%; max-height: 400px; object-fit: cover; border-radius: 12px; margin-bottom: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
            <p class="lead-text"><?php echo nl2br(htmlspecialchars($page['content'])); ?></p>
            
            <script type="application/ld+json">
            {
              "@context": "https://schema.org",
              "@type": "MedicalWebPage",
              "headline": "<?php echo htmlspecialchars($page['title']); ?>",
              "image": "<?php echo $current_img; ?>",
              "description": "<?php echo str_replace('"', '\"', $seo_desc); ?>"
            }
            </script>
            
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