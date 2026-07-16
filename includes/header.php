<?php require_once dirname(__FILE__) . '/../db.php'; ?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo !empty($seo_title) ? htmlspecialchars($seo_title) : 'Op. Dr. Necati Özçimen - Konya Tüp Bebek Merkezi'; ?></title>
    <meta name="description" content="<?php echo !empty($seo_desc) ? htmlspecialchars($seo_desc) : 'Konya Novafertil Tüp Bebek Merkezi uzmanlarından Op. Dr. Necati Özçimen klinik web sitesi.'; ?>">
    
    <!-- Open Graph (Sosyal Medya Paylaşım) Etiketleri -->
    <meta property="og:title" content="<?php echo !empty($seo_title) ? htmlspecialchars($seo_title) : 'Op. Dr. Necati Özçimen - Konya Tüp Bebek Merkezi'; ?>">
    <meta property="og:description" content="<?php echo !empty($seo_desc) ? htmlspecialchars($seo_desc) : 'Konya Novafertil Tüp Bebek Merkezi uzmanlarından Op. Dr. Necati Özçimen klinik web sitesi.'; ?>">
    <meta property="og:image" content="<?= 'https://www.konyatupbebek.com' . BASE_URL . 'uploads/dr_necati_ozcimen_tup_bebek.webp' ?>">
    <meta property="og:url" content="<?= 'https://www.konyatupbebek.com' . $_SERVER['REQUEST_URI'] ?>">
    <meta property="og:type" content="website">

    <!-- Google Search Console Doğrulama Etiketi (Kullanıcı Tarafından HTML Dosyası İle Doğrulandı) -->

    <link rel="stylesheet" href="<?= BASE_URL ?>style.css?v=2">
    <!-- Schema.org MedicalClinic -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "MedicalClinic",
      "name": "Op. Dr. Necati Özçimen - Konya Tüp Bebek Merkezi",
      "image": "<?= BASE_URL ?>uploads/dr_necati_ozcimen_tup_bebek.webp",
      "@id": "<?= BASE_URL ?>",
      "url": "<?= BASE_URL ?>",
      "telephone": "+903323235151",
      "priceRange": "$$",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "Ateşbaz-ı Veli Mh. Yeni Meram Cd. No:75",
        "addressLocality": "Meram",
        "addressRegion": "Konya",
        "addressCountry": "TR"
      },
      "geo": {
        "@type": "GeoCoordinates",
        "latitude": 37.8628,
        "longitude": 32.4493
      },
      "openingHoursSpecification": {
        "@type": "OpeningHoursSpecification",
        "dayOfWeek": [
          "Monday",
          "Tuesday",
          "Wednesday",
          "Thursday",
          "Friday",
          "Saturday"
        ],
        "opens": "09:00",
        "closes": "17:00"
      },
      "medicalSpecialty": ["Gynecologic", "Reproductive"],
      "founder": {
        "@type": "Physician",
        "name": "Op. Dr. Necati Özçimen",
        "url": "<?= BASE_URL ?>hakkimizda.php"
      }
    }
    </script>
</head>
<body>

<header class="main-header">
    <div class="header-top">
        <div class="hashtag">
            <a href="<?= BASE_URL ?>" class="header-top-link">#HayaliniHisset</a>
        </div>
        <div class="header-contact">
            <a href="tel:+903323235151" onclick="if(!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)){ window.open('https://api.whatsapp.com/send?phone=905063701222', '_blank'); return false; }" class="header-top-link phone-action-link">
                <svg viewBox="0 0 24 24" class="phone-icon-svg">
                    <path d="M21.384 17.791l-3.75-3.419c-.437-.4-.1.139-1.17.659-.974.509-1.424.419-2.385-.439l-2.615-2.34c-.95-.85-1.04-1.3-.435-2.27.525-1.06 1.065-.72.66-1.159l-3.454-3.725c-.41-.441-1.095-.441-1.505 0l-1.635 1.76c-.905.975-1.045 2.375-.335 3.865 1.54 3.25 4.385 6.455 7.665 7.9 1.485.66 2.875.5 3.84-.415l1.645-1.66c.415-.42.415-1.095 0-1.515z"/>
                </svg>
                <span>Bilgi:+90 (332) 323 51 51</span>
            </a>
            
            <a href="tel:+903323235151" onclick="if(!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)){ window.open('https://api.whatsapp.com/send?phone=905063701222', '_blank'); return false; }" class="btn-header-randevu">
                HEMEN RANDEVU AL
            </a>
        </div>
    </div>
    
    <div class="header-bottom">
        <div class="logo-area">
            <a href="<?= BASE_URL ?>" class="logo-link">
                <img src="<?= BASE_URL ?>uploads/dr_necati_ozcimen_tup_bebek.webp" alt="Op. Dr. Necati Özçimen - Konya Tüp Bebek Merkezi" class="site-logo">            
            </a>
        </div>

        <nav class="desktop-main-nav">
            <ul>
                <li><a href="<?= BASE_URL ?>">Anasayfa</a></li>
                <li class="dropdown-parent">
                    <a href="#" class="dropdown-toggle">Hakkımızda <span class="arrow">▾</span></a>
                    <ul class="dropdown-menu-list">
                        <li><a href="<?= BASE_URL ?>hakkimizda.php">Doktor Özgeçmişi</a></li>
                        <li><a href="<?= BASE_URL ?>blog.php">Blog Yazıları</a></li>
                    </ul>
                </li>
                <li class="dropdown-parent">
                    <a href="<?= BASE_URL ?>#kisirlik-nedenleri" class="dropdown-toggle">Kısırlık Nedenleri <span class="arrow">▾</span></a>
                    <ul class="dropdown-menu-list">
                        <li class="dropdown-submenu">
                            <a href="#">Kadına Bağlı Kısırlık <span class="right-arrow">›</span></a>
                            <ul class="dropdown-submenu-list">
                                <li><a href="<?= BASE_URL ?>detay.php?sayfa=endometriozis">Endometriozis</a></li>
                                <li><a href="<?= BASE_URL ?>detay.php?sayfa=vajinismus">Vajinismus</a></li>
                                <li><a href="<?= BASE_URL ?>detay.php?sayfa=erken-menopoz">Erken Menopoz</a></li>
                                <li><a href="<?= BASE_URL ?>detay.php?sayfa=amh">Yumurta Rezerv Düşüklüğü (Amh)</a></li>
                                <li><a href="<?= BASE_URL ?>detay.php?sayfa=tubal-faktor">Tubal Faktör</a></li>
                                <li><a href="<?= BASE_URL ?>detay.php?sayfa=cift-rahim">Çift Rahim Nedir, Tedavisi Nasıldır?</a></li>
                                <li><a href="<?= BASE_URL ?>detay.php?sayfa=septum">Septum</a></li>
                                <li><a href="<?= BASE_URL ?>detay.php?sayfa=pcos">Polikistik Over PCOS</a></li>
                                <li><a href="<?= BASE_URL ?>detay.php?sayfa=aciklanamayan-kisirlik">Açıklanamayan Kısırlık</a></li>
                            </ul>
                        </li>
                        <li class="dropdown-submenu">
                            <a href="#">Erkeğe Bağlı Kısırlık <span class="right-arrow">›</span></a>
                            <ul class="dropdown-submenu-list">
                                <li><a href="<?= BASE_URL ?>detay.php?sayfa=hormonal-bozukluklar">Hormonal Bozukluklar</a></li>
                                <li><a href="<?= BASE_URL ?>detay.php?sayfa=azospermi">Azospermi</a></li>
                                <li><a href="<?= BASE_URL ?>detay.php?sayfa=klinefelter">Klinefelter Sendromu</a></li>
                                <li><a href="<?= BASE_URL ?>detay.php?sayfa=sperm-dusuklugu">Sperm Sayısı Düşüklüğü</a></li>
                                <li><a href="<?= BASE_URL ?>detay.php?sayfa=varikosel">Varikosel</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                
                <li class="dropdown-parent">
                    <a href="<?= BASE_URL ?>#tedaviler" class="dropdown-toggle">Tedaviler <span class="arrow">▾</span></a>
                    <ul class="dropdown-menu-list">
                        <li><a href="<?= BASE_URL ?>detay.php?sayfa=tup-bebek">Tüp Bebek Tedavisi</a></li>
                        <li><a href="<?= BASE_URL ?>detay.php?sayfa=asilama">Aşılama (İnseminasyon)</a></li>
                        <li><a href="<?= BASE_URL ?>detay.php?sayfa=embriyo-dondurma">Embriyo Dondurma</a></li>
                        <li><a href="<?= BASE_URL ?>detay.php?sayfa=genetik-tup-bebek">NGS/Genetik Tüp Bebek</a></li>
                        <li><a href="<?= BASE_URL ?>detay.php?sayfa=mikro-enjeksiyon">Micro Enjeksiyon (ICSI)</a></li>
                        <li><a href="<?= BASE_URL ?>detay.php?sayfa=rahim-dinlendirme">Rahim Dinlendirme</a></li>
                        <li><a href="<?= BASE_URL ?>detay.php?sayfa=sperm-dondurma">Sperm Dondurma</a></li>
                        <li><a href="<?= BASE_URL ?>detay.php?sayfa=yumurta-dondurma">Yumurta Dondurma</a></li>
                    </ul>
                </li>
                
                <li class="dropdown-parent">
                    <a href="#" class="dropdown-toggle">Tüp Bebek Merkezi <span class="arrow">▾</span></a>
                    <ul class="dropdown-menu-list">
                        <li><a href="<?= BASE_URL ?>detay.php?sayfa=tup-bebek">Tüp Bebek Süreci</a></li>
                        <li><a href="<?= BASE_URL ?>bebeklerimiz.php">Bebeklerimiz</a></li>
                        <li><a href="<?= BASE_URL ?>tup-bebek-tedavi-asamalari.php">Tüp Bebek Tedavi Aşamaları</a></li>
                        <li><a href="<?= BASE_URL ?>sss.php">Sıkça Sorulan Sorular</a></li>
                    </ul>
                </li>
                <li><a href="<?= BASE_URL ?>iletisim.php">İletişim</a></li>
            </ul>
        </nav>
        
        <div class="header-actions">
            <button class="burger-menu" id="burgerBtn" onclick="toggleSidebar()">
                <span></span>
                <span></span>
                <span></span>
            </button>
            
            <div class="social-icons-right">
                <a href="https://facebook.com/konyatupbebek" target="_blank" title="Facebook">
                    <svg viewBox="0 0 24 24" width="22" height="22" fill="currentColor"><path d="M22.675 0h-21.35c-.732 0-1.325.593-1.325 1.325v21.351c0 .731.593 1.324 1.325 1.324h11.495v-9.294h-3.128v-3.622h3.128v-2.671c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.312h3.587l-.467 3.622h-3.12v9.293h6.116c.73 0 1.323-.593 1.323-1.325v-21.35c0-.732-.593-1.325-1.325-1.325z"/></svg>
                </a>
                
                <a href="https://instagram.com/konyatupbebek" target="_blank" title="Instagram">
                    <svg viewBox="0 0 24 24" width="22" height="22" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                </a>
                
                <a href="https://www.youtube.com/@op.dr.necatiozcimen8399/shorts" target="_blank" title="YouTube">
                    <svg viewBox="0 0 24 24" width="22" height="22" fill="currentColor"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .501 6.186C0 8.07 0 12 0 12s0 3.93.501 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.377.505 9.377.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                </a>
            </div>
        </div>
    </div>
</header>