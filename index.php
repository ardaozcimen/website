<?php 
require_once 'db.php';

include 'includes/header.php'; 
include 'includes/sidebar.php'; 
?>

<section class="hero">
    <div class="hero-slider">
    <div class="slide active" style="background-image: url('uploads/necati_ozcimen_header_photo_tup_bebek_konya2.webp');"></div>
    <div class="slide" style="background-image: url('uploads/slider_2.webp');"></div>
    <div class="slide" style="background-image: url('uploads/slider_3.webp');"></div>
    <div class="slide" style="background-image: url('uploads/slider_4.webp');"></div>
</div>

    <div class="hero-content">
        <h2>Tüp Bebekte</h2>
        <h3>Bilimsel Yaklaşımla Sağlıklı Başlangıçlar</h3>
        <p>Deneyimli kadromuzla sağlıklı gebelik süreçleri için yanınızdayız. Aile mutluluğunuza katkıda bulunmak için buradayız.</p>
        
        <div class="hero-buttons">
            <a href="https://www.google.com/maps/place/Op.+Dr.+Necati+ÖZÇİMEN/@37.8628497,32.4467586,17z/data=!3m1!4b1!4m6!3m5!1s0x14d0857f2b1e84b5:0xb685386acdb08f04!8m2!3d37.8628455!4d32.4493335!16s%2Fg%2F11smfz38q2?entry=ttu&g_ep=EgoyMDI2MDcwNy4wIKXMDSoASAFQAw%3D%3D" target="_blank" class="btn-primary">YOL TARİFİ AL</a>
            <a href="tel:+903323235151" onclick="if(!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)){ window.open('https://api.whatsapp.com/send?phone=905063701222', '_blank'); return false; }" class="btn-hero-randevu">HEMEN RANDEVU AL</a>
        </div>
    </div>
</section>

<script>
document.addEventListener("DOMContentLoaded", function() {
    let slides = document.querySelectorAll('.hero-slider .slide');
    if (slides.length > 0) {
        let currentSlide = 0;
        setInterval(() => {
            slides[currentSlide].classList.remove('active');
            currentSlide = (currentSlide + 1) % slides.length;
            slides[currentSlide].classList.add('active');
        }, 4000); 
    }
});
</script>

<section id="kisirlik-nedenleri" class="section-padding bg-white">
    <div class="container">
        <h2 class="section-title">Kısırlık Nedenleri</h2>
        <p class="section-subtitle">Kısırlık nedenleri, genellikle erkeğe ve kadına bağlı olarak iki ana kategoriye ayrılır. Kadınlarda, endometriozis, polikistik over sendromu (PCOS/PMOS), rahim içi septum gibi anatomik veya hormonal sorunlar, yumurtlama bozuklukları ve tüplerin tıkanıklığı gibi faktörler kısırlığa neden olabilir. Erkeklerde ise sperm üretiminde veya sperm kalitesindeki sorunlar, genetik faktörler veya hormonal dengesizlikler erkek kısırlığına yol açabilir.</p>
        <h3 class="category-title">Kadına Bağlı Kısırlık Nedenleri</h3>
        <div class="grid-container">
            <div class="card border-left"><h3><a href="detay.php?sayfa=amh">Yumurta Rezerv Düşüklüğü (AMH)</a></h3><p>Yumurtalıklardaki yumurta sayısının veya kalitesinin azaldığı durumu ifade eder.</p></div>
            <div class="card border-left"><h3><a href="detay.php?sayfa=vajinismus">Vajinismus</a></h3><p>Vajinal kasların istemsiz kasılması sonucu cinsel ilişkinin imkansız veya çok ağrılı olması durumudur.</p></div>
            <div class="card border-left"><h3><a href="detay.php?sayfa=erken-menopoz">Erken Menopoz</a></h3><p>Genellikle 40 yaşından önce başlayan ve adet dönemlerinin sona erdiği durumudur.</p></div>
            <div class="card border-left"><h3><a href="detay.php?sayfa=endometriozis">Endometriozis</a></h3><p>Rahim içi dokunun rahim dışında büyümesi durumudur ve ciddi kısırlık nedenidir.</p></div>
            <div class="card border-left"><h3><a href="detay.php?sayfa=aciklanamayan-kisirlik">Açıklanamayan Kısırlık</a></h3><p>Herhangi bir tıbbi neden bulunamadan gebe kalınamaması durumunu ifade eder.</p></div>
            <div class="card border-left"><h3><a href="detay.php?sayfa=pcos">Polikistik Over (PCOS/PMOS)</a></h3><p>Hormonal dengesizliklere yol açarak düzensiz adet döngüleri ve kısırlığa neden olan tablodur.</p></div>
            <div class="card border-left"><h3><a href="detay.php?sayfa=septum">Septum</a></h3><p>Rahim içi perde, bu boşluğun içinde kalın bir zarla bölünmesi durumunu ifade eder.</p></div>
            <div class="card border-left"><h3><a href="detay.php?sayfa=cift-rahim">Çift Rahim</a></h3><p>Kadın rahminin doğuştan gelen bir anomali sonucu ikiye bölünmüş olması durumudur.</p></div>
            <div class="card border-left"><h3><a href="detay.php?sayfa=tubal-faktor">Tubal Faktör</a></h3><p>Fallop tüplerinin tıkanması veya hasar görmesi sonucu oluşan kadın kısırlık faktörüdür.</p></div>
        </div>

        <h3 class="category-title" style="margin-top: 60px;">Erkeğe Bağlı Kısırlık Nedenleri</h3>
        <div class="grid-container">
            <div class="card border-left"><h3><a href="detay.php?sayfa=hormonal-bozukluklar">Hormonal Bozukluklar</a></h3><p>Erkeklerin üreme organları, cinsel fonksiyonları ve hormonal dengeleriyle ilgili sorunları teşhis ve tedavi eden tıp dalıdır.</p></div>
            <div class="card border-left"><h3><a href="detay.php?sayfa=azospermi">Azospermi</a></h3><p>Sperm analizinde hiçbir canlı sperm hücresi bulunmaması durumudur. Sperm sayısı sıfırdır.</p></div>
            <div class="card border-left"><h3><a href="detay.php?sayfa=klinefelter">Klinefelter Sendromu</a></h3><p>Genellikle erkeklerde görülen bir genetik bozukluktur. Bireyin cinsiyet kromozomlarının normalden farklı dağıldığı durumu ifade eder.</p></div>
            <div class="card border-left"><h3><a href="detay.php?sayfa=sperm-dusuklugu">Sperm Sayısı Düşüklüğü</a></h3><p>Bir erkeğin ejakülasyon sırasında ürettiği sperm hücresi miktarının normalden daha az olduğu durumudur.</p></div>
            <div class="card border-left"><h3><a href="detay.php?sayfa=varikosel">Varikosel</a></h3><p>Testislerin etrafındaki damarlarda meydana gelen genişlemeleri ifade eden bir tıbbi terimdir.</p></div>
        </div>
    </div>
</section>

<section id="tedaviler" class="section-padding bg-white">
    <div class="container">
        <h2 class="section-title">Tedaviler</h2>
        <div class="grid-container">
            <div class="card border-top"><h3><a href="detay.php?sayfa=yumurta-dondurma">Yumurta Dondurma</a></h3><p>Yumurtalıklardan yumurtaların toplanıp dondurularak saklanması işlemidir.</p></div>
            <div class="card border-top"><h3><a href="detay.php?sayfa=tup-bebek">Tüp Bebek Tedavisi</a></h3><p>Tıbbi müdahale kullanarak kısırlığı aşmayı amaçlayan laboratuvar ortamında dölleme yöntemidir.</p></div>
            <div class="card border-top"><h3><a href="detay.php?sayfa=sperm-dondurma">Sperm Dondurma</a></h3><p>Erkeklerin sperm örneklerini dondurarak uzun süre saklamalarına olanak tanıyan yöntemdir.</p></div>
            <div class="card border-top"><h3><a href="detay.php?sayfa=genetik-tup-bebek">NGS/Genetik Tüp Bebek</a></h3><p>Preimplantasyon Genetik Tanı (PGT) ve NGS Kapsamlı Kromozom Taraması ile embriyoların genetik kontrolünün yapılmasıdır.</p></div>
            <div class="card border-top"><h3><a href="detay.php?sayfa=embriyo-dondurma">Embriyo Dondurma</a></h3><p>Tüp bebek tedavisinde artan sağlıklı embriyoların dondurularak saklanması prosedürüdür.</p></div>
            <div class="card border-top"><h3><a href="detay.php?sayfa=rahim-dinlendirme">Rahim Dinlendirme</a></h3><p>Rahim iç tabakasının transfer öncesi dinlendirilmesi ve optimize edilmesi işlemidir.</p></div>
            <div class="card border-top"><h3><a href="detay.php?sayfa=mikro-enjeksiyon">Mikro Enjeksiyon (ICSI)</a></h3><p>Tek bir spermin doğrudan yumurta içine enjekte edilmesi tekniğidir.</p></div>
            <div class="card border-top"><h3><a href="detay.php?sayfa=asilama">Aşılama</a></h3><p>Sperm örneklerinin özel işlemlerden geçirilerek doğrudan rahim içine yerleştirilmesi işlemidir.</p></div>
        </div>
    </div>
</section>

<section id="istatistikler" class="section-padding" style="background: var(--primary-color); color: #fff;">
    <div class="container">
        <div class="counter-grid">
            <?php
            $stmtStats = $db->query("SELECT * FROM statistics");
            while ($stat = $stmtStats->fetch(PDO::FETCH_ASSOC)) {
                echo "<div class='counter-box'>";
                echo "<div class='counter-number' data-target='" . $stat['count_value'] . "'>0</div>";
                echo "<span>+</span>";
                echo "<p class='counter-text'>" . htmlspecialchars($stat['title']) . "</p>";
                echo "</div>";
            }
            ?>
        </div>
    </div>
</section>

<section id="tup-bebek-asama" class="section-padding bg-white">
    <div class="container">
        <h2 class="section-title"><a href="tup-bebek-tedavi-asamalari.php" style="color: inherit; text-decoration: none;">Adım Adım Tüp Bebek Tedavi Süreci</a></h2>
        <p class="section-subtitle">Op. Dr. Necati Özçimen yönetimindeki kliniğimizde, tüp bebek (IVF) ve mikroenjeksiyon (ICSI) süreçleri bilimsel standartlarda titizlikle yürütülür.</p>
        
        <style>
        .process-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-top: 40px;
        }
        .process-card-link {
            text-decoration: none;
            color: inherit;
            display: block;
        }
        .process-card {
            background: #fdfdfd;
            padding: 30px;
            border-radius: 12px;
            border: 1px solid #eee;
            box-shadow: 0 5px 20px rgba(0,0,0,0.02);
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
            overflow: hidden;
            height: 100%;
        }
        .process-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; height: 4px;
            background: var(--accent-color);
        }
        .process-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        }
        .process-step {
            width: 60px;
            height: 60px;
            background: rgba(52, 152, 219, 0.1);
            color: var(--accent-color);
            font-size: 24px;
            font-weight: 700;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px auto;
        }
        .process-card h3 {
            font-size: 18px;
            margin-bottom: 15px;
            color: var(--primary-color);
            font-weight: 600;
        }
        .process-card p {
            font-size: 14px;
            color: #555;
            line-height: 1.6;
        }
        </style>
        
        <div class="process-grid">
            <a href="tup-bebek-tedavi-asamalari.php" class="process-card-link">
                <div class="process-card">
                    <div class="process-step">1</div>
                    <h3>İlk Muayene ve Teşhis</h3>
                    <p>Çiftlerin üreme sağlığı geçmişi, sperm analizi (spermiyogram) ve yumurtalık rezervi değerlendirilerek en uygun infertilite tedavi protokolü belirlenir.</p>
                </div>
            </a>
            <a href="tup-bebek-tedavi-asamalari.php" class="process-card-link">
                <div class="process-card">
                    <div class="process-step">2</div>
                    <h3>Yumurta Geliştirme (Stimülasyon)</h3>
                    <p>Kişiye özel hormon iğneleri kullanılarak anne adayının yumurtalıklarındaki foliküllerin büyütülmesi ve olgunlaşması sağlanır.</p>
                </div>
            </a>
            <a href="tup-bebek-tedavi-asamalari.php" class="process-card-link">
                <div class="process-card">
                    <div class="process-step">3</div>
                    <h3>Yumurta Toplama (OPU)</h3>
                    <p>Olgunlaşan yumurtalar hafif anestezi altında (OPU işlemi) toplanır. Aynı gün baba adayından alınan en kaliteli spermler laboratuvar ortamına hazırlanır.</p>
                </div>
            </a>
            <a href="tup-bebek-tedavi-asamalari.php" class="process-card-link">
                <div class="process-card">
                    <div class="process-step">4</div>
                    <h3>Mikroenjeksiyon (ICSI)</h3>
                    <p>En sağlıklı spermler, embriyologlarımız tarafından her bir yumurtanın içine tek tek enjekte edilerek (ICSI) laboratuvarda döllenme işlemi gerçekleştirilir.</p>
                </div>
            </a>
            <a href="tup-bebek-tedavi-asamalari.php" class="process-card-link">
                <div class="process-card">
                    <div class="process-step">5</div>
                    <h3>Embriyo Transferi</h3>
                    <p>Laboratuvar ortamında blastosist evresine ulaşan en kaliteli embriyo, ağrısız bir işlemle rahim içine transfer edilir. Kalan sağlıklı embriyolar dondurulur.</p>
                </div>
            </a>
            <a href="tup-bebek-tedavi-asamalari.php" class="process-card-link">
                <div class="process-card">
                    <div class="process-step">6</div>
                    <h3>Gebelik Testi ve Takip</h3>
                    <p>Transfer işleminden yaklaşık 10-12 gün sonra kanda Beta HCG testi yapılarak mutlu habere ulaşılır. Gebelik oluştuktan sonra süreci yakından takip ediyoruz.</p>
                </div>
            </a>
        </div>
        <div style="text-align: center; margin-top: 40px;">
            <a href="tup-bebek-tedavi-asamalari.php" class="btn-header-randevu" style="display: inline-block; padding: 15px 30px; font-size: 16px;">Tüm Aşamaları Detaylı İncele</a>
        </div>
    </div>
</section>

<section id="blog" class="section-padding bg-light">
    <div class="container">
        <h2 class="section-title">Güncel Blog Yazıları</h2>
        
        <div class="blog-slider-container">
            <button class="slider-btn prev-btn" onclick="moveBlogSlider(-1)">❮</button>
            <div class="blog-wrapper" id="blogWrapper">
                <?php
                $stmt = $db->query("SELECT * FROM blogs ORDER BY id DESC");
                $blogs = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if (count($blogs) > 0) {
                    foreach ($blogs as $blog) {
                        $img = !empty($blog['image_url']) ? BASE_URL . $blog['image_url'] : 'https://images.unsplash.com/photo-1579684385127-1ef15d508118?w=500';
                        echo "<div class='blog-card-new'>";
                        echo "<div class='blog-card-img-box'><img src='".$img."' alt='".htmlspecialchars($blog['title'])."'></div>";
                        echo "<div class='blog-card-body'>";
                        echo "<h3>" . htmlspecialchars($blog['title']) . "</h3>";
                        echo "<p>" . htmlspecialchars($blog['seo_description']) . "</p>";
                        echo "<div class='blog-card-footer'>";
                        echo "<a href='".BASE_URL."blog-detay.php?slug=".$blog['slug']."' class='btn-readmore' target='_blank'>Devamını Oku →</a>";
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                    }
                } else {
                    echo "<p style='text-align:center; width:100%; color:#777;'>Henüz blog yazısı eklenmedi.</p>";
                }
                ?>
            </div>
            <button class="slider-btn next-btn" onclick="moveBlogSlider(1)">❯</button>
        </div>
    </div>
</section>

<section id="galeri" class="section-padding bg-white">
    <div class="container">
        <h2 class="section-title">Galeri</h2>
        <p class="section-subtitle">Merkezimizden ve mutlu ailelerimizden kareler.</p>
        <div class="grid-container gallery-grid">
            <div class="gallery-item"><img src="uploads/necati_ozcimen_ekip_konyatupbebek_doktor.webp" alt="Klinik Görsel 1"></div>
            <div class="gallery-item"><img src="uploads/uzman_doktor.webp" alt="Klinik Görsel 2"></div>
            <div class="gallery-item"><img src="uploads/necati_ozcimen_ekip_2.webp" alt="Klinik Görsel 3"></div>
            <div class="gallery-item"><img src="uploads/konyanecatiozcimentupbebek.webp" alt="Klinik Görsel 4"></div>
            <div class="gallery-item"><img src="uploads/bebeklerimiz/konya_tup_bebek_necati_ozcimen_2.webp" alt="Klinik Görsel 5"></div>
            <div class="gallery-item"><img src="uploads/konya_tup_bebek_necati_ozcimen_3.webp" alt="Klinik Görsel 6"></div>
        </div>

        <div class="cta-banner" style="margin-top: 50px; background: linear-gradient(135deg, rgba(52, 152, 219, 0.05), rgba(46, 204, 113, 0.05)); padding: 40px 20px; border-radius: 15px; text-align: center; border: 1px solid rgba(52, 152, 219, 0.15);">
            <h3 style="color: var(--primary-color); font-size: 24px; margin-bottom: 15px;">Tedavi Sonrası Mutlu Ailelerimiz</h3>
            <p style="color: #555; margin-bottom: 25px; font-size: 16px; max-width: 600px; margin-left: auto; margin-right: auto;">Kliniğimizde tedavi görerek bebeklerine kavuşan mutlu ailelerimizin ve dünyaya gelen bebeklerimizin fotoğraflarını incelemek ister misiniz?</p>
            <a href="<?= BASE_URL ?>bebeklerimiz.php" class="btn-primary" style="padding: 15px 35px; font-size: 16px; border-radius: 30px; box-shadow: 0 5px 15px rgba(52, 152, 219, 0.3);">Bebeklerimiz Sayfasına Git</a>
        </div>
    </div>
</section>

<section id="sss" class="section-padding bg-light" style="text-align: center;">
    <div class="container">
        <h2 class="section-title">Sıkça Sorulan Sorular</h2>
        <p class="section-subtitle">Tüp bebek ve kadın hastalıkları hakkında merak ettiğiniz tüm soruların cevapları için SSS sayfamızı ziyaret edebilirsiniz.</p>
        <a href="<?= BASE_URL ?>sss.php" class="btn-primary" style="display: inline-block; margin-top: 20px;">Tüm Soruları Göster</a>
    </div>
</section>

<?php include 'includes/footer.php'; ?>