<?php 
// SEO verilerini header'dan önce tanımlıyoruz
$seo_title = 'İletişim - Op. Dr. Necati Özçimen | Konya Tüp Bebek Merkezi';
$seo_desc = 'Op. Dr. Necati Özçimen ile iletişime geçin. Konya Novafertil Tüp Bebek Merkezi adres, telefon ve e-posta bilgileri ile harita üzerindeki konumu.';

include 'includes/header.php'; 
include 'includes/sidebar.php'; 
?>

<div class="page-banner">
    <div class="container">
        <h1>İletişim</h1>
        <ul class="breadcrumb">
            <li><a href="index.php">Anasayfa</a></li>
            <li>/</li>
            <li>İletişim</li>
        </ul>
    </div>
</div>

<section class="section-padding bg-light">
    <div class="container">
        <div class="contact-page-wrapper">
            
            <!-- Sol Taraf: İnteraktif Google Haritası -->
            <div class="contact-map-box">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3148.066060144596!2d32.4467585759082!3d37.86284971203001!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14d0857f2b1e84b5%3A0xb685386acdb08f04!2zT3AuIERyLiBOZWNhdGkgw5Zaw4fEsE1FTg!5e0!3m2!1str!2str!4v1715421542154!5m2!1str!2str" width="100%" height="100%" style="border:0; min-height: 450px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>

            <!-- Sağ Taraf: İletişim Bilgileri -->
            <div class="contact-info-box">
                <h3>İletişim Bilgilerimiz</h3>
                
                <div class="contact-detail-item">
    <div class="icon">📍</div>
    <div class="text">
        <h4>Klinik Adresi</h4>
        <!-- Doğrudan yol tarifi başlatan Google Maps Linki -->
        <a href="https://www.google.com/maps/dir/?api=1&destination=37.8628455,32.4493335" target="_blank" title="Yol Tarifi Al">
            Novafertil Konya Tüp Bebek Merkezi<br>Ateşbaz-I Veli Mh. Yeni Meram Cd. No:75 Meram/Konya
        </a>
    </div>
</div>

                <div class="contact-detail-item">
                    <div class="icon">📞</div>
                    <div class="text">
                        <h4>Telefon Numarası</h4>
                        <a href="tel:+903323235151">+90 (332) 323 51 51</a>
                    </div>
                </div>

                <div class="contact-detail-item">
                    <div class="icon">✉️</div>
                    <div class="text">
                        <h4>E-Posta Adresi</h4>
                        <a href="mailto:bilgi@novafertil.com">bilgi@novafertil.com</a>
                    </div>
                </div>
                
                <div class="contact-detail-item">
                    <div class="icon">🕒</div>
                    <div class="text">
                        <h4>Çalışma Saatleri</h4>
                        <p>Pazartesi - Cumartesi: 09.00 - 17.00<br>Pazar: Kapalı</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>