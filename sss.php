<?php 
// 🚀 SEO Optimizasyonu: Arama motorları için özel başlık ve açıklama
$seo_title = 'Sıkça Sorulan Sorular | Op. Dr. Necati Özçimen - Konya Tüp Bebek Merkezi';
$seo_desc = 'Tüp bebek, kısırlık tedavisi ve kadın hastalıkları hakkında en çok merak edilen soruların detaylı cevapları.';

include 'includes/header.php'; 
include 'includes/sidebar.php'; 
?>

<div class="page-banner">
    <div class="container">
        <h1>Sıkça Sorulan Sorular</h1>
        <ul class="breadcrumb">
            <li><a href="<?= BASE_URL ?>">Anasayfa</a></li>
            <li>/</li>
            <li>SSS</li>
        </ul>
    </div>
</div>

<section id="sss" class="section-padding bg-light">
    <div class="container">
        <div class="faq-container" style="max-width: 800px; margin: 0 auto;">
            <?php
            $stmtFaqs = $db->query("SELECT * FROM faqs ORDER BY id ASC");
            $schema_faqs = [];
            while ($faq = $stmtFaqs->fetch(PDO::FETCH_ASSOC)) {
                $schema_faqs[] = [
                    "@type" => "Question",
                    "name" => strip_tags($faq['question']),
                    "acceptedAnswer" => [
                        "@type" => "Answer",
                        "text" => strip_tags($faq['answer'])
                    ]
                ];
                echo "<div class='faq-item'>";
                echo "<button class='faq-question'>" . htmlspecialchars($faq['question']) . "<span class='faq-icon'>+</span></button>";
                echo "<div class='faq-answer'><p>" . nl2br(htmlspecialchars($faq['answer'])) . "</p></div>";
                echo "</div>";
            }
            
            // FAQ Schema.org JSON-LD Output
            if (count($schema_faqs) > 0) {
                $faq_schema = [
                    "@context" => "https://schema.org",
                    "@type" => "FAQPage",
                    "mainEntity" => $schema_faqs
                ];
                echo "<script type='application/ld+json'>" . json_encode($faq_schema, JSON_UNESCAPED_UNICODE) . "</script>";
            }
            ?>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
