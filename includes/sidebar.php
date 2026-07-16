<div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

<nav class="sidebar-menu" id="sidebarMenu">
    <div class="sidebar-header">
        <h3>MENÜ</h3>
        <button class="close-btn" onclick="toggleSidebar()">&times;</button>
    </div>
    <ul class="menu-list">
        <li><a href="<?= BASE_URL ?>">Anasayfa</a></li>
        <li class="menu-title">Hakkımızda</li>
        <li><a href="<?= BASE_URL ?>hakkimizda.php">Doktor Özgeçmişi</a></li>
        <li><a href="<?= BASE_URL ?>blog.php">Blog Yazıları</a></li>
        
        <li class="menu-title">Kısırlık Nedenleri</li>
        <li class="sub-menu-title">Kadına Bağlı Kısırlık Nedenleri</li>
        <li><a href="<?= BASE_URL ?>detay.php?sayfa=amh">Yumurta Rezerv Düşüklüğü (Amh)</a></li>
        <li><a href="<?= BASE_URL ?>detay.php?sayfa=vajinismus">Vajinismus</a></li>
        <li><a href="<?= BASE_URL ?>detay.php?sayfa=erken-menopoz">Erken Menopoz</a></li>
        <li><a href="<?= BASE_URL ?>detay.php?sayfa=endometriozis">Endometriozis</a></li>
        <li><a href="<?= BASE_URL ?>detay.php?sayfa=aciklanamayan-kisirlik">Açıklanamayan Kısırlık</a></li>
        <li><a href="<?= BASE_URL ?>detay.php?sayfa=pcos">Polikistik Over PCOS Nedir?</a></li>
        <li><a href="<?= BASE_URL ?>detay.php?sayfa=septum">Septum</a></li>
        <li><a href="<?= BASE_URL ?>detay.php?sayfa=cift-rahim">Çift Rahim</a></li>
        <li><a href="<?= BASE_URL ?>detay.php?sayfa=tubal-faktor">Tubal Faktör</a></li>
        
        <li class="sub-menu-title">Erkeğe Bağlı Kısırlık Nedenleri</li>
        <li><a href="<?= BASE_URL ?>detay.php?sayfa=hormonal-bozukluklar">Hormonal Bozukluklar</a></li>
        <li><a href="<?= BASE_URL ?>detay.php?sayfa=azospermi">Azospermi</a></li>
        <li><a href="<?= BASE_URL ?>detay.php?sayfa=klinefelter">Klinefelter Sendromu</a></li>
        <li><a href="<?= BASE_URL ?>detay.php?sayfa=sperm-dusuklugu">Sperm Sayısı Düşüklüğü</a></li>
        <li><a href="<?= BASE_URL ?>detay.php?sayfa=varikosel">Varikosel</a></li>
        
        <li class="menu-title">Tedaviler</li>
        <li><a href="<?= BASE_URL ?>detay.php?sayfa=asilama">Aşılama (İnseminasyon)</a></li>
        <li><a href="<?= BASE_URL ?>detay.php?sayfa=embriyo-dondurma">Embriyo Dondurma</a></li>
        <li><a href="<?= BASE_URL ?>detay.php?sayfa=genetik-tup-bebek">NGS/Genetik Tüp Bebek</a></li>
        <li><a href="<?= BASE_URL ?>detay.php?sayfa=mikro-enjeksiyon">Mikro Enjeksiyon (ICSI)</a></li>
        <li><a href="<?= BASE_URL ?>detay.php?sayfa=rahim-dinlendirme">Rahim Dinlendirme</a></li>
        <li><a href="<?= BASE_URL ?>detay.php?sayfa=sperm-dondurma">Sperm Dondurma</a></li>
        <li><a href="<?= BASE_URL ?>detay.php?sayfa=tup-bebek">Tüp Bebek Tedavisi</a></li>
        <li><a href="<?= BASE_URL ?>detay.php?sayfa=yumurta-dondurma">Yumurta Dondurma</a></li>
        
        <li class="menu-title">Tüp Bebek Merkezi</li>
        <li><a href="<?= BASE_URL ?>detay.php?sayfa=tup-bebek">Tüp Bebek Süreci</a></li>
        <li><a href="<?= BASE_URL ?>bebeklerimiz.php">Bebeklerimiz</a></li>
        <li><a href="<?= BASE_URL ?>tup-bebek-tedavi-asamalari.php" onclick="toggleSidebar()">Tüp Bebek Tedavi Aşamaları</a></li>
        
        <li class="menu-title">Diğer</li>
        <li><a href="<?= BASE_URL ?>#istatistikler" onclick="toggleSidebar()">İstatistikler</a></li>
        <li><a href="<?= BASE_URL ?>sss.php" onclick="toggleSidebar()">Sıkça Sorulan Sorular</a></li>
        <li><a href="<?= BASE_URL ?>#galeri" onclick="toggleSidebar()">Galeri</a></li>
        <li><a href="<?= BASE_URL ?>iletisim.php">İletişim</a></li>
    </ul>
</nav>

<script>
function toggleSidebar() {
    const sidebar = document.getElementById('sidebarMenu');
    const overlay = document.getElementById('sidebarOverlay');
    const burger = document.getElementById('burgerBtn');
    
    if(sidebar) sidebar.classList.toggle('active');
    if(overlay) overlay.classList.toggle('active');
    if(burger) burger.classList.toggle('open');
}
</script>