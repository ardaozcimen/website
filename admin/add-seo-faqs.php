<?php
require_once __DIR__ . '/../db.php';

$faqs = [
    [
        'question' => 'Konya Novafertil tüp bebek tedavisi ücretli mi?',
        'answer' => 'Evet, Konya Novafertil Tüp Bebek Merkezi özel bir sağlık kuruluşu olup, uygulanan tedaviler ücretlidir. Ancak kliniğimizde, hastalarımızın bütçelerini yormadan, tamamen onlara özel (kişiselleştirilmiş) ve yüksek başarı hedeflenen tedavi protokolleri oluşturulmaktadır. Op. Dr. Necati Özçimen yönetimiyle şeffaf bir süreç yürütülür.'
    ],
    [
        'question' => 'Konya\'da bir tüp bebek kaç TL?',
        'answer' => 'Tüp bebek fiyatları; hastanın yaşına, kullanılacak ilaç dozlarına ve PGT (Genetik Tarama), embriyo dondurma (rahim dinlendirme) gibi ek laboratuvar teknolojilerine göre değişmektedir. Yasal düzenlemeler gereği web sitemiz üzerinden net bir fiyat veya paket ücreti paylaşılması uygun değildir. Size en uygun tedavi planı ve güncel maliyetler için Konya tüp bebek merkezimizle iletişime geçebilirsiniz.'
    ],
    [
        'question' => 'Tüp bebek tedavisi %100 tutar mı (başarılı olur mu)?',
        'answer' => 'Tıbbın hiçbir alanında, özellikle üreme sağlığında "%100 garanti" vermek hem bilimsel olarak mümkün değildir hem de yasalara aykırıdır. Ancak Op. Dr. Necati Özçimen’in çeyrek asırlık tecrübesi, milimetrik ilaç dozlamaları ve ileri düzey laboratuvar teknolojilerimiz (mikroçip, embriyo havuzlama) sayesinde gebelik elde etme oranlarımız dünya standartlarında ve oldukça yüksektir.'
    ],
    [
        'question' => 'Novafertil\'de tüp bebek ücretli mi?',
        'answer' => 'Konya Novafertil Tüp Bebek Merkezi olarak sunduğumuz tüm muayene, tahlil ve ileri düzey tüp bebek (IVF/ICSI) işlemleri ücretlidir. Standart ve herkese aynı olan paketler yerine, sadece size gerekli olan tedavinin uygulandığı "kişiye özel" fiyatlandırma yapılmaktadır.'
    ],
    [
        'question' => 'Konya Novafertil tüp bebek fiyatı ne kadar?',
        'answer' => 'Tüp bebek tedavi fiyatımız, çiftin kısırlık (infertilite) nedenine ve laboratuvarımızda uygulanacak ek mikroskobik işlemlere göre belirlenmektedir. En doğru ve güvenilir fiyat bilgisini, Op. Dr. Necati Özçimen ile yapacağınız detaylı ilk görüşme ve muayene sonrasında öğrenebilirsiniz.'
    ],
    [
        'question' => 'Tüp bebekte her denemede ücret ödenir mi?',
        'answer' => 'Tüp bebek sürecinde, sıfırdan başlanan her yumurta büyütme ve toplama (OPU) işlemi yeni bir tedavidir ve ücretlendirilir. Ancak kliniğimizde uyguladığımız "embriyo dondurma" yöntemi sayesinde, laboratuvarımızda dondurulmuş sağlıklı embriyolarınız varsa, bir sonraki denemede baştan tedaviye gerek kalmaz; sadece çok daha düşük maliyetli olan "donmuş embriyo transferi" işlemi gerçekleştirilir.'
    ],
    [
        'question' => 'Tüp bebek tedavisini Novafertil yapıyor mu?',
        'answer' => 'Evet, Konya Novafertil Tüp Bebek Merkezi, sadece üreme sağlığı ve tüp bebek (IVF) alanında uzmanlaşmış, tam donanımlı bir merkezdir. Op. Dr. Necati Özçimen önderliğinde; aşılama, tüp bebek, genetik tarama, yumurta dondurma ve erkek kısırlığı (Mikro TESE) dahil olmak üzere tüm ileri düzey üreme tedavileri merkezimizde başarıyla uygulanmaktadır.'
    ],
    [
        'question' => 'Novafertil tüp bebek maliyeti ne kadar?',
        'answer' => 'Maliyetler; kullanılacak hormon ilaçlarının miktarına ve uygulanacak teknolojik işlemlere göre farklılık gösterir. Sağlık Bakanlığı mevzuatları gereğince dijital platformlarda fiyat listesi yayınlamak yasaktır. Konya tüp bebek tedavi sürecinizle ilgili en güncel maliyet bilgisi için iletişim numaralarımızdan bize ulaşabilirsiniz.'
    ],
    [
        'question' => 'Konya Novafertil kadın hastalıkları ve tüp bebek polikliniği neye bakar?',
        'answer' => 'Polikliniğimiz başta "çocuk sahibi olamama (infertilite)" olmak üzere; polikistik over sendromu (PCOS), düşük yumurtalık rezervi (Düşük AMH), çikolata kisti (endometriozis), tekrarlayan düşükler, açıklanamayan kısırlık ve erkek kaynaklı üreme problemleri (azospermi vb.) gibi tüm üreme sağlığı konularında tanı ve tedavi hizmeti vermektedir.'
    ],
    [
        'question' => 'Konya Novafertil Merkezinde aile planlaması var mı?',
        'answer' => 'Konya Novafertil Tüp Bebek Merkezi, temel olarak gebeliği önleyici aile planlaması yöntemlerinden ziyade; çocuk sahibi olmak isteyen ancak doğal yollarla gebe kalamayan çiftlere yönelik kısırlık (infertilite) tedavileri ve ileri düzey üreme teknolojileri (tüp bebek, aşılama) üzerine yoğunlaşmış özel bir merkezdir.'
    ],
    [
        'question' => 'Tüp bebek tedavisi kimlerde tutmaz?',
        'answer' => 'Tüp bebek; rahim iç duvarında embriyonun tutunmasına kesin olarak engel olan anatomik bozukluklarda veya operasyonla dahi hiç sperm/sağlıklı yumurta elde edilemeyen çok nadir vakalarda sonuç vermeyebilir. Ancak günümüzün gelişmiş PGT (Genetik Tarama) ve rahim dinlendirme teknikleriyle, daha önce umutsuz görülen birçok hastamızda gebelik elde edebilmekteyiz.'
    ],
    [
        'question' => 'İlk tüp bebek tedavisinde başarı şansı yüzde kaçtır?',
        'answer' => 'İlk denemedeki başarı oranı öncelikle anne adayının yaşına, yumurta rezervine ve baba adayının sperm kalitesine bağlıdır. 35 yaş altı kadınlarda bu oran çok daha yüksektir. Op. Dr. Necati Özçimen\'in hastalara standart bir liste vermek yerine, "kişiye özel" uyguladığı tedavi protokolleri sayesinde ilk deneme başarı oranlarımız oldukça üst seviyelerdedir.'
    ],
    [
        'question' => 'Tüp bebek için kaç kilo olmak gerekir?',
        'answer' => 'Tüp bebek tedavisine başlamak için şart koşulan kesin bir kilo rakamı yoktur. Fakat Vücut Kitle İndeksinin (VKİ) obezite sınırında veya aşırı zayıf seviyede olması, yumurta kalitesini düşürüp hormon dengesini bozabilir. Tedavi öncesi ideal kiloya yaklaşmak, Op. Dr. Necati Özçimen gözetiminde vücudu sürece hazırlamak gebelik şansınızı belirgin oranda artıracaktır.'
    ]
];

$successCount = 0;

try {
    $stmt = $db->prepare("INSERT INTO faqs (question, answer) VALUES (?, ?)");
    
    foreach ($faqs as $faq) {
        $checkStmt = $db->prepare("SELECT COUNT(*) FROM faqs WHERE question = ?");
        $checkStmt->execute([$faq['question']]);
        $exists = $checkStmt->fetchColumn();
        
        if ($exists == 0) {
            $stmt->execute([$faq['question'], $faq['answer']]);
            $successCount++;
        }
    }
    
    echo "<div style='font-family: Arial; padding: 30px; background-color: #d4edda; color: #155724; border-radius: 8px; border: 1px solid #c3e6cb; margin: 20px;'>";
    echo "<h2>İşlem Başarılı!</h2>";
    echo "<p>Tamamen SEO odaklı, ceza riskinden arındırılmış ve markanıza (Konya Novafertil & Op. Dr. Necati Özçimen) özel olarak uyarlanmış <strong>$successCount adet</strong> yeni SSS veritabanına eklendi.</p>";
    echo "<p>Artık bu dosyayı sunucunuzdan silebilirsiniz.</p>";
    echo "</div>";
    
} catch (PDOException $e) {
    echo "<div style='font-family: Arial; padding: 30px; background-color: #f8d7da; color: #721c24; border-radius: 8px; border: 1px solid #f5c6cb; margin: 20px;'>";
    echo "<h2>Hata Oluştu</h2>";
    echo "<p>" . $e->getMessage() . "</p>";
    echo "</div>";
}
?>
