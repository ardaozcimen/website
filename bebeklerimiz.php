<?php 
// SEO Optimizasyonu
$seo_title = 'Bebeklerimiz - Op. Dr. Necati Özçimen | Konya Tüp Bebek Merkezi';
$seo_desc = 'Op. Dr. Necati Özçimen ve Novafertil Tüp Bebek Merkezi ailesine katılan, mucizelerle dünyaya gelen bebeklerimizin mutlu kareleri.';

include 'includes/header.php'; 
include 'includes/sidebar.php'; 
?>

<div class="page-banner">
    <div class="container">
        <h1>Bebeklerimiz</h1>
        <ul class="breadcrumb">
            <li><a href="index.php">Anasayfa</a></li>
            <li>/</li>
            <li>Bebeklerimiz</li>
        </ul>
    </div>
</div>

<section class="section-padding bg-light">
    <div class="container text-center">
        <h2 class="section-title">Mucizelerimiz</h2>
        <p class="section-subtitle" style="margin-bottom: 50px;">
            Uzun ve hassas bir tedavi sürecinin ardından kucağınıza aldığınız o ilk an, bizim en büyük motivasyonumuzdur. Novafertil Konya Tüp Bebek Merkezi olarak, binlerce ailenin hayalini hissetmesine vesile olmanın gururunu yaşıyoruz. İşte o mutlu sonlardan bazıları...
        </p>

        <div class="grid-container gallery-grid">
            
            <?php
            // 1'den 204'e kadar dönen otomatik galeri oluşturucu
            for ($i = 1; $i <= 204; $i++) {
                // Senin belirttiğin dosya ismi formatı
                $resimYolu = "uploads/bebeklerimiz/konya_tup_bebek_necati_ozcimen_bebeklerimiz_" . $i . ".webp";
                
                echo '<div class="gallery-item">';
                
                // Eğer döngü 204. (en son) fotoğrafa ulaştıysa bunu İLETİŞİM LİNKİ olarak bas
                if ($i == 204) {
                    echo '<a href="iletisim.php" style="display:block; width:100%; height:100%; cursor:pointer;" title="Sıra Sizde! Hemen İletişime Geçin">';
                    // Resim klasörde yoksa, <a> etiketinin de kapsayıcısı olan .gallery-item div'ini tamamen gizlemek için parentElement.parentElement kullanılır.
                    echo '<img src="' . $resimYolu . '" alt="Sıra Sizde - Konya Novafertil" loading="lazy" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s ease;" onerror="this.parentElement.parentElement.style.display=\'none\';">';
                    echo '</a>';
                } 
                // Eğer 204'ten küçükse standart resim olarak bas
                else {
                    // loading="lazy" özelliği resimlerin aynı anda yüklenip siteyi dondurmasını engeller
                    echo '<img src="' . $resimYolu . '" alt="Konya Novafertil Tüp Bebek - Bebeklerimiz ' . $i . '" loading="lazy" onerror="this.parentElement.style.display=\'none\';">';
                }
                
                echo '</div>';
            }
            ?>
            
        </div>
        
        <div class="appointment-callout" style="margin-top: 60px;">
            <h3>Sıradaki Mucize Sizin Bebeğiniz Olabilir</h3>
            <p>Hayallerinizi ertelemeyin. Kişiye özel tedavi planlaması ve detaylı ön görüşme için uzman ekibimizle tanışın.</p>
            <a href="iletisim.php" class="btn-primary">Hemen Randevu Alın</a>
        </div>
        
    </div>
</section>

<?php include 'includes/footer.php'; ?>