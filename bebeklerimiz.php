<?php 
// SEO Optimizasyonu
$seo_title = 'Bebeklerimiz - Op. Dr. Necati Özçimen | Konya Tüp Bebek Merkezi';
$seo_desc = 'Op. Dr. Necati Özçimen ve Novafertil Tüp Bebek Merkezi ailesine katılan, tedavi sonrası dünyaya gelen bebeklerimizin mutlu kareleri.';

include 'includes/header.php'; 
include 'includes/sidebar.php'; 
?>

<div class="page-banner">
    <div class="container">
        <h1>Bebeklerimiz</h1>
        <ul class="breadcrumb">
            <li><a href="<?= BASE_URL ?>">Anasayfa</a></li>
            <li>/</li>
            <li>Bebeklerimiz</li>
        </ul>
    </div>
</div>

<section class="section-padding bg-light" itemscope itemtype="http://schema.org/ImageGallery">
    <div class="container text-center">
        <h2 class="section-title">Mutlu Ailelerimiz</h2>
        <p class="section-subtitle" style="margin-bottom: 50px;">
            Uzun ve hassas bir tedavi sürecinin ardından kucağınıza aldığınız o ilk an, bizim en büyük motivasyonumuzdur. Novafertil Konya Tüp Bebek Merkezi olarak, binlerce ailenin hayalini hissetmesine vesile olmanın gururunu yaşıyoruz. İşte o mutlu sonlardan bazıları...
        </p>

        <div class="grid-container gallery-grid">
            
            <?php
            // 1'den 204'e kadar dönen otomatik galeri oluşturucu
            for ($i = 1; $i <= 204; $i++) {
                // Senin belirttiğin dosya ismi formatı
                $resimYolu = "uploads/bebeklerimiz/konya_tup_bebek_necati_ozcimen_bebeklerimiz_" . $i . ".webp";
                $tamResimYolu = BASE_URL . $resimYolu;
                $altMetni = "Konya Tüp Bebek Merkezi Bebeklerimiz - Op. Dr. Necati Özçimen Mutlu Aile Tablosu " . $i;
                
                echo '<figure class="gallery-item" itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">';
                
                // Eğer döngü 204. (en son) fotoğrafa ulaştıysa bunu İLETİŞİM LİNKİ olarak bas
                if ($i == 204) {
                    echo '<a href="' . BASE_URL . 'iletisim.php" style="display:block; width:100%; height:100%; cursor:pointer;" title="Sıra Sizde! Hemen İletişime Geçin" itemprop="contentUrl">';
                    echo '<img src="' . $tamResimYolu . '" alt="Sıra Sizde - Konya Tüp Bebek Merkezi" title="Sıra Sizde - Tüp Bebek Tedavisi İçin Randevu Alın" itemprop="thumbnail" loading="lazy" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s ease;" onerror="this.parentElement.parentElement.style.display=\'none\';">';
                    echo '</a>';
                    echo '<figcaption itemprop="caption description" style="display:none;">Sıra Sizde! Konya Novafertil Tüp Bebek Merkezi ile Hayalini Hisset.</figcaption>';
                } 
                // Eğer 204'ten küçükse standart resim olarak bas
                else {
                    // loading="lazy" özelliği resimlerin aynı anda yüklenip siteyi dondurmasını engeller
                    echo '<img src="' . $tamResimYolu . '" alt="' . $altMetni . '" title="' . $altMetni . '" itemprop="thumbnail" loading="lazy" onerror="this.parentElement.style.display=\'none\';">';
                    echo '<meta itemprop="contentUrl" content="' . 'https://www.konyatupbebek.com' . $tamResimYolu . '">';
                    echo '<figcaption itemprop="caption description" style="display:none;">' . $altMetni . '</figcaption>';
                }
                
                echo '</figure>';
            }
            ?>
            
        </div>
        
        <div class="appointment-callout" style="margin-top: 60px;">
            <h3>Sağlıklı Bir Gebelik Süreci İçin Yanınızdayız</h3>
            <p>Hayallerinizi ertelemeyin. Kişiye özel tedavi planlaması ve detaylı ön görüşme için uzman ekibimizle tanışın.</p>
            <a href="<?= BASE_URL ?>iletisim.php" class="btn-primary">Hemen Randevu Alın</a>
        </div>
        
    </div>
</section>

<?php include 'includes/footer.php'; ?>