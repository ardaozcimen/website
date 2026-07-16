<?php 

$seo_title = 'Blog | Op. Dr. Necati Özçimen - Konya Tüp Bebek Merkezi';
$seo_desc = 'Op. Dr. Necati Özçimen\'in tüp bebek, kadın hastalıkları ve kısırlık tedavileri hakkında yazdığı güncel makaleler ve blog yazıları.';

include 'includes/header.php'; 
include 'includes/sidebar.php'; 
?>

<div class="page-banner">
    <div class="container">
        <h1>Blog Yazıları</h1>
        <ul class="breadcrumb">
            <li><a href="<?= BASE_URL ?>">Anasayfa</a></li>
            <li>/</li>
            <li>Blog</li>
        </ul>
    </div>
</div>

<section class="section-padding bg-light">
    <div class="container">
        
        <div class="blog-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 30px;">
            <?php
            $stmt = $db->query("SELECT * FROM blogs ORDER BY id DESC");
            $blogs = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (count($blogs) > 0) {
                foreach ($blogs as $blog) {
                    $img = !empty($blog['image_url']) ? BASE_URL . $blog['image_url'] : 'https://images.unsplash.com/photo-1579684385127-1ef15d508118?w=500';
                    echo "<div class='blog-card-new' style='width: 100%; margin: 0;'>";
                    echo "<div class='blog-card-img-box'><img src='".$img."' alt='".htmlspecialchars($blog['title'])."'></div>";
                    // Tarih Formatı (Gün Ay Yıl)
                    $date = new DateTime($blog['created_at']);
                    $formatter = new IntlDateFormatter('tr_TR', IntlDateFormatter::LONG, IntlDateFormatter::NONE);
                    $formattedDate = $formatter->format($date);
                    
                    echo "<div class='blog-card-body'>";
                    echo "<span style='font-size:12px; color:#7f8c8d; display:block; margin-bottom:5px;'>📅 " . $formattedDate . "</span>";
                    echo "<h3>" . htmlspecialchars($blog['title']) . "</h3>";
                    echo "<p>" . htmlspecialchars($blog['seo_description']) . "</p>";
                    echo "<div class='blog-card-footer'>";
                    echo "<a href='".BASE_URL."blog-detay.php?slug=".$blog['slug']."' class='btn-readmore' target='_blank'>Devamını Oku →</a>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "<p style='text-align:center; width:100%; color:#777; grid-column: 1 / -1;'>Henüz blog yazısı eklenmedi.</p>";
            }
            ?>
        </div>

    </div>
</section>

<?php include 'includes/footer.php'; ?>
