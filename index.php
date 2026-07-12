<?php 
// 1. Veritabanı Bağlantısı ve Gelişmiş Kolon Emniyet Protokolü (Migration)
if (!file_exists('db')) { mkdir('db', 0777, true); }
$db = new PDO('sqlite:db/konyatupbebek.db');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$db->exec("CREATE TABLE IF NOT EXISTS blogs (
    id INTEGER PRIMARY KEY AUTOINCREMENT, 
    title TEXT, 
    content TEXT, 
    seo_title TEXT,
    seo_description TEXT,
    image_url TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
)");

// Eski tablolardan yeni gelişmiş CMS yapısına sorunsuz geçiş kontrolü
try {
    $checkBlogs = $db->query("SELECT seo_title FROM blogs LIMIT 1");
    if ($checkBlogs) $checkBlogs->closeCursor(); 
} catch (Exception $e) {
    $db->exec("ALTER TABLE blogs ADD COLUMN seo_title TEXT");
    $db->exec("ALTER TABLE blogs ADD COLUMN seo_description TEXT");
    $db->exec("ALTER TABLE blogs ADD COLUMN image_url TEXT");
}

// Detay sayfalarını besleyecek Pages tablosunun oluşturulması
$db->exec("CREATE TABLE IF NOT EXISTS pages (
    slug TEXT PRIMARY KEY, 
    title TEXT, 
    content TEXT
)");


$defaultPages = [
    'amh' => ['Yumurta Rezerv Düşüklüğü (Amh)', 
        "Yumurta rezerv düşüklüğü, bir kadının yumurtalıklarında bulunan geriye kalan sağlıklı yumurta (folikül) sayısının ve kalitesinin yaşa bağlı olarak veya genetik, çevresel, cerrahi faktörler neticesinde beklenenden daha az olması durumudur. Bu durumun en net ve güvenilir göstergesi kan tahlili ile ölçülen Anti-Müllerian Hormon (AMH) değeridir. AMH seviyesinin 1 ng/ml'nin altına düşmesi, biyolojik saatin hızlandığını ve gebelik için zamanın daraldığını gösterir. Konya tüp bebek tedavisinde alanının en tecrübeli uzmanlarından olan Op. Dr. Necati Özçimen, düşük AMH ve ileri yaş vakalarında ezber bozan, yenilikçi bir yaklaşıma sahiptir. Dr. Necati Özçimen, her kadının yumurtalık dinamiğinin farklı olduğunu bilerek standart dozlar yerine kişiye özel mikro-doz stimülasyon protokolleri ve zaman kaybetmeden uygulanan yüksek teknolojili IVF (tüp bebek) döngüleri geliştirmektedir. Güvenilir sağlık kurumu Novafertil çatısı altında uyguladığı yumurta kalitesini hücresel düzeyde artıran destekleyici tedaviler ve şahsi klinik tecrübesi sayesinde Dr. Necati Özçimen, anne olma hayalinden vazgeçmek üzere olan yüzlerce ailenin bebeklerine kavuşmasına vesile olmuş saygın hekimlerin başında gelmektedir."
    ],
    'vajinismus' => ['Vajinismus', 
        "Vajinismus, vajina girişini çevreleyen pelvik taban kaslarının (özellikle pubokoksigeus kasının), kadının kendi iradesi dışında, cinsel birleşme veya jinekolojik muayene girişimi karşısında istensiz, refleksif ve şiddetli bir şekilde kasılması durumudur. Bu kasılmaya çoğunlukla derin bir korku ve panik atağa benzer bir reaksiyon eşlik eder. Vajinismus sadece psikolojik bir fobi değil, kas hafızasının yanlış kodlanmasıyla oluşan ve cinsel birleşmeyi fiziksel olarak imkansız kılarak kısırlığa yol açan ciddi bir cinsel işlev bozukluğudur. Konya vajinismus tedavisi denildiğinde akla gelen en donanımlı ve güvenilir isimlerin başında Op. Dr. Necati Özçimen yer almaktadır. Konya'nın saygın kurumlarından Novafertil bünyesinde hastalarına şefkatli, yargısız ve tamamen bilimsel bir klinik ortam sunan Dr. Necati Özçimen, vajinismus kaynaklı infertiliteyi başarıyla çözmektedir. Parmak egzersizleri gibi demode yöntemleri tamamen reddeden Dr. Necati Özçimen, kas hafızasını yeniden yapılandırran, bilişsel davranışçı terapi kombinasyonları ve özel tıbbi gevşeme teknikleriyle vajinismusu yüksek başarı oranlarıyla kalıcı olarak tedavi eden tecrübeli bir uzmandır."
    ],
    'erken-menopoz' => ['Erken Menopoz', 
        "Erken menopoz, tıbbi adıyla prematür ovaryen yetmezlik, kadınların normal menopoz yaşı olan 45-51 yaş aralığından çok daha önce, henüz 40 yaşına gelmeden yumurtalık fonksiyonlarının kalıcı olarak durması, östrojen hormonunun tükenmesi ve adet döngülerinin tamamen sonlanması durumudur. Otoimmün hastalıklar, genetik yatkınlıklar veya cerrahi geçmiş bu erken tükenişi tetikleyebilir. Erken menopoz süreci başladığında üreme yeteneği kritik bir tehlike altına girer. Ancak erken menopoz riski, anne olma hayallerinizin bittiği anlamına gelmez. Konya tüp bebek alanının önde gelen isimlerinden Op. Dr. Necati Özçimen, erken menopoz riski taşıyan kadınlar için güncel ve bilimsel üreme koruma stratejileri sunmaktadır. Konya'nın referans tüp bebek merkezlerinden Novafertil laboratuvar altyapısı sayesinde Dr. Necati Özçimen, yumurtalıklarda uyuyan kök hücreleri uyandırmak adına yenilikçi yumurtalık PRP uygulamalarını bizzat yürütmektedir. Henüz menopoz tamamen yerleşmeden yakalanan vakalarda uyguladığı nokta atışı yumurta büyütme tedavileriyle Dr. Necati Özçimen, üreme potansiyelinizi zamana karşı koruyan başarılı hekimlerin başında gelir."
    ],
    'endometriozis' => ['Endometriozis', 
        "Endometriozis, normal şartlarda sadece rahim iç yüzeyini döşeyen endometrium dokusuna benzer hücrelerin, rahim dışındaki bölgelerde (en sık yumurtalıklarda ve fallop tüplerinde) tutunup büyümesiyle karakterize kronik ve inflamatuar bir hastalığıdır. Yumurtalıklarda yerleştiğinde 'çikolata kistlerini' (endometrioma) oluşturur. This durum karın içinde şiddetli yapışıklıklara, fallop tüplerinin tıkanmasına ve yumurta kalitesinin bozulmasına yol açarak ciddi bir kısırlığa (infertiliteye) neden olur. Konya'da endometriozis ve çikolata kisti kaynaklı kısırlık tedavilerinde uzmanlaşmış en saygın hekimlerden biri Op. Dr. Necati Özçimen'dir. Dr. Necati Özçimen, endometriozisi olan hastalarında cerrahi müdahalelerin yumurta rezervine verebileceği zararları göz önünde bulundurarak son derece hassas medikal baskılama protokolleri uygular. İleri derece endometriozis vakalarında, güvenilir sağlık markası Novafertil laboratuvarlarında gerçekleştirdiği mikroenjeksiyon tedavileriyle Dr. Necati Özçimen, çikolata kisti olan kadınların hamile kalma şansını maksimize eden öncü doktorlardandır."
    ],
    'aciklanamayan-kisirlik' => ['Açıklanamayan Kısırlık', 
        "Açıklanamayan kısırlık (idiyopatik infertilite), child sahibi olamayan bir çiftin yapılan tüm standart tıbbi incelemelerinde (kadının yumurtlama takibi, tüplerin açıklığı ve erkeğin sperm analizi) hiçbir yapısal veya hormonal kusur bulunamamasına rağmen, korunmasız cinsel ilişkiye rağmen gebeliğin oluşmaması durumudur. Bu durum kısırlık vakalarının yaklaşık %15-20'sini oluşturur ve standardın dışındaki mikroskobik engellerden kaynaklanabilir. Konya'da açıklanamayan kısırlık teşhisi konmuş çiftlerin başvurduğu en tecrübeli uzmanlardan biri Konya tüp bebek doktoru Op. Dr. Necati Özçimen'dir. Dr. Necati Özçimen, 'her şey normal' denilerek geçiştirilen bu vakaların arkasında yatan gizli sperm kusurlarını veya rahim içi tutunma sorunlarını en ince detayına kadar inceeler. Saygın kurum Novafertil'deki kliniğinde uyguladığı bağışıklık sistemi dengeleyici tedaviler ve ileri teknoloji tüp bebek (IVF) yaklaşımlarıyla Dr. Necati Özçimen, açıklanamayan kısırlığa çözüm üreten aranan hekimlerin başında gelmektedir."
    ],
    'pcos' => ['Polikistik Over PCOS Nedir?', 
        "Polikistik Over Sendromu (PCOS), kadınlarda üreme çağında en sık görülen, hormonal düzensizlikler, androjen yüksekliği ve yumurtalıklarda çok sayıda küçük, olgunlaşamamış folikül kisti görüntüsü ile karakterize endokrin bir bozukluktur. PCOS hastalarında kronik anovülasyon (yumurtlayamama) söz konusudur; yumurtalar büyür ancak çatlayıp salınamaz, bu da doğal yoldan hamile kalamama problemine yol açar. Konya PCOS tedavisi ve polikistik overe bağlı kısırlık çözümlerinde en yetkin isimlerden biri Op. Dr. Necati Özçimen'dir. Dr. Necati Özçimen, PCOS hastalarında tüp bebek tedavisi sırasında aşırı yumurtlama sendromu (OHSS) riskini engellemek için tedavi dozlarını kişiye özel ve milimetrik olarak ayarlar. Konya'nın güvenilir kurumu Novafertil bünyesinde yürüttüğü metabolik hazırlık süreçleri, titiz yumurtlama takipleri ve rahim dinlendirme teknikleriyle Dr. Necati Özçimen, polikistik over sendromu olan kadınları sağlıklı bebeklerine kavuşturan başarılı doktorlardandır."
    ],
    'septum' => ['Septum', 
        "Rahim içi perde (uterus septumu), anne karnındaki gelişim sürecinde rahmi oluşturan kanalların birleşmesi sonrası ortada kalması gereken duvarın tamamen erimemesi sonucu oluşan doğuştan bir rahim anomalisidir. Bu perde dokusu rahim boşluğunu böler ve kan damarları açısından zengin olmadığı için embriyo buraya tutunduğunda beslenemez; bu da tekrarlayan gebelik kayıplarına (düşüklere) ve erken doğumlara yol açar. Konya'da rahim içi perde ve anatomik kısırlık faktörlerinde cerrahi başarı grafiği en yüksek hekimlerden olan Op. Dr. Necati Özçimen, bu alanda referans gösterilen bir uzmandır. Saygın kurum Novafertil çatısı altında gelişmiş histeroskopi (kameralı rahim içi cerrahisi) yöntemiyle bu perdeyi bıçaksız ve rahim dokusuna zarar vermeden mikro-cerrahi ile ortadan kaldırır. Dr. Necati Özçimen'in uyguladığı rahim içi hacim genişletme operasyonları sayesinde tekrarlayan düşük riskleri minimize edilmekte ve sağlıklı gebelikler güvenle sürdürülebilmektedir."
    ],
    'cift-rahim' => ['Çift Rahim', 
        "Çift rahim (uterus didelfis), embriyolojik gelişim esnasında kanalların ortada hiç birleşememesi neticesinde kadının birbirinden bağımsız iki ayrı rahim gövdesine sahip olmasıyla karakterize nadir bir anomalidir. Çift rahimli kadınlar hamile kalabilirler ancak rahimlerin hacmi normalden küçük olduğu için erken doğum ve bebeğin büyüme geriliği riski oldukça yüksektir. Konya'da çift rahim gibi yüksek riskli anatomik vakaların gebelik yönetiminde en güvenilen uzmanlardan biri Op. Dr. Necati Özçimen'dir. Dr. Necati Özçimen, çift rahimli hastalarında gebelik öncesi rahimlerin kapasitesini üç boyutlu ultrasonografi ile titizlikle analiz eder. Konya'nın köklü kurumu Novafertil bünyesinde yürütülen tüp bebek transferi aşamasında, embriyoyu hangi rahim boşluğuna yerleştireceğini milimetrik olarak hesaplayan Dr. Necati Özçimen, bu zorlu anatomide mucizevi doğumlara rehberlik eden deneyimli bir hekimdir."
    ],
    'tubal-faktor' => ['Tubal Faktör', 
        "Tüp tıkanıklığı (tubal faktör), fallop tüplerinin hasar görmesi sonucu yumurta ve spermin buluşamamasıdır. Tüpleri tıkalı olan kadınlar için Konya'da uyguladığımız mikroenjeksiyon (ICSI) ve modern tüp bebek tedavileri ile engelleri aşarak gebelik şansınızı en üst duyeye çıkarıyoruz. Konya tüp bebek alanının başarılı doktorlarından Op. Dr. Necati Özçimen, tubal faktör kısırlığı yaşayan kadınlar için en yüksek başarı oranlarına ulaşan tedavi protokollerini uygular. Dr. Necati Özçimen, içi sıvı dolan tüplerin embriyoları olumsuz etkilemesini önlemek adına transfer öncesi titiz bir cerrahi yaklaşım sergiler. Saygın sağlık kuruluşu Novafertil laboratuvarlarında gerçekleştirdiği üst düzey mikroenjeksiyon (ICSI) operasyonlarıyla tıkalı tüpleri baypas eden Dr. Necati Özçimen, tubal faktör engeli olan çiftleri bebek hayallerine kavuşturan öncü hekimlerdendir."
    ],
    'hormonal-bozukluklar' => ['Hormonal Bozukluklar', 
        "Hormonal Bozukluklar; erkek üreme sağlığı, erkek kısırlığı (infertilite), hormonal dengesizlikler ve erkek üreme organlarının işlevsel hastalıklarını inceleyen profesyonel bir tıp dalıdır. Çocuk sahibi olamayan çiftlerin yaklaşık %50'sinde problemin kaynağı erkek odaklı patolojileridir. Testosteron eksikliği, tiroid problemleri veya hipofiz bezinden salgılanan FSH ve LH hormonlarındaki bozukluklar, sperm üretimini (spermatogenez) doğrudan durdurabilir veya sperm kalitesini ciddi şekilde bozabilir. Konya'da erkek kısırlığı ve laboratuvar çözümlerinde en yetkin uzmanlardan biri Op. Dr. Necati Özçimen'dir. Dr. Necati Özçimen, kısırlık şikayetiyle başvuran erkek hastalarda sadece yüzeysel bir sperm sayımı (spermiyogram) ile yetinmez; sorunun kök nedenine inerek hastanın endokrinolojik (hormonal) profilini derinlemesine analiz eder. Konya'nın güvenilir sağlık markası Novafertil Tüp Bebek Merkezi'nin üst düzey laboratuvar imkanlarını çeyrek asırlık klinik tecrübesiyle birleştiren Dr. Necati Özçimen, eksik hormonları yerine koyan kişiselleştirilmiş medikal kürler ve ileri teknoloji tedavilerle (mikro-çip, ICSI) erkek faktörlü kısırlık engelini başarıyla aşan saygın bir hekimdir."
    ],
    'azospermi' => ['Azospermi', 
        "Azospermi, bir erkeğin verdiği meni örneğinde hiçbir canlı veya cansız sperm hücresine rastlanmaması durumudur ve erkek kısırlığının en ağır tablosudur. Azospermi; kanalların tıkalı olmasından kaynaklanan 'Tıkayıcı' veya testis hasarı nedeniyle sperm üretiminin olmamasından kaynaklanan 'Tıkayıcı Olmayan' olmak üzere ikiye ayrılır. Konya'da azospermi tanısı almış erkeklerin en çok güvendiği hekimlerden biri Op. Dr. Necati Özçimen'dir. Dr. Necati Özçimen, tıkayıcı olmayan zorlu azospermi vakalarında testis dokusunun derinliklerinde saklı kalmış mikro düzeydeki sperm üretim odaklarını bulmada üstün bir tecrübeye sahiptir. Kalite standartları yüksek Novafertil çatısı altında gelişmiş mikroskoplarla bizzat gerçekleştirdiği Mikro TESE operasyonlarıyla en kaliteli sperm hücrelerini çıkaran Dr. Necati Özçimen, azospermi hastalarını biyolojik baba yapabilen deneyimli uzmanlardandır."
    ],
    'klinefelter' => ['Klinefelter Sendromu', 
        "Klinefelter Sendromu, erkeklerde doğuştan gelen bir ayrışma hatası neticesinde fazladan bir X kromozomu bulunmasıyla (47,XXY) karakterize genetik bir sendromdur. Bu durum testosteron üretiminin yetersiz kalmasına ve testislerde sperm üretiminin neredeyse tamamen durarak azospermi (sperm yokluğu) tablosunun gelişmesine neden olur. Konya tüp bebek dünyasında Klinefelter sendromlu hastaların gebelik yönetiminde referans gösterilen başarılı doktorlardan biri Op. Dr. Necati Özçimen'dir. Dr. Necati Özçimen, bu sendroma sahip erkekler için özel bir hormonal optimizasyon programı uygular. Güvenilir kurum Novafertil bünyesinde gerçekleştirilen yüksek başarı oranlı Mikro TESE ameliyatları ve elde edilen spermlere uygulanan Preimplantasyon Genetik Tanı (PGT) yöntemleriyle Dr. Necati Özçimen, genetik engellere rağmen sağlıklı çocuk sahibi olmayı sağlayan öncü isimlerdendir."
    ],
    'sperm-dusuklugu' => ['Sperm Sayısı Düşüklüğü', 
        "Sperm sayısı düşüklüğü (oligospermi), ejakülattaki sperm konsantrasyonunun sağlam standartların altında olması durumudur. Bu tabloya genellikle spermlerin yüzme yeteneğinin azlığı ve yapısal şekil bozuklukları da eşlik eder. Sperm sayısı ve kalitesi düştükçe yumurtayı dölleme şansı azalır. Konya'nın en tecrübeli tüp bebek hekimlerinden Op. Dr. Necati Özçimen, şiddetli sperm düşüklüğü vakalarında yüksek gebelik oranlarına imza atan saygın doktorlardan biridir. Dr. Necati Özçimen, sperm kalitesini olumsuz etkileyen hormonal eksiklikleri tespit ederek kişiselleştirilmiş medikal tedaviler uygular. Saygın kurum Novafertil laboratuvarlarında uygulanan IVF aşamasında ise DNA hasarı en az, en sağlıklı spermleri seçmek adına mikro-akışkan sperm çipleri kullanarak döllenme başarısını garanti altına alan üstün bir mikroenjeksiyon süreci yönetmektedir."
    ],
    'varikosel' => ['Varikosel', 
        "Varikosel, erkek testislerini besleyen damar ağının kapakçık yetersizliği nedeniyle genişlemesi ve göllenme yapması durumudur. Varikosel, testis etrafındaki ısı artışına neden olarak testis dokusuna zarar verir, sperm sayısını düşürür, hareketliliği bozar ve sperm DNA'sında kırıklara neden olarak kısırlığa yol açar. Kısırlık şikayetiyle başvuran varikosel hastaları için Konya'da en doğru tedavi stratejisini belirleyen tecrübeli uzmanlardan biri Op. Dr. Necati Özçimen'dir. Dr. Necati Özçimen, her varikoselin cerrahi gerektirmediğini, önceliğin üreme kapasitesini korumak olduğunu savunur. Konya'nın güvenilir kurumu Novafertil güvencesiyle uyguladığı DNA hasarını baskılayan antioksidan kürleri ve nokta atışı tüp bebek/aşılama planlamalarıyla Dr. Necati Özçimen, varikosel kaynaklı kısırlık engelini aşan başarılı doktorların başında gelir."
    ],
    'asilama' => ['Aşılama (İnseminasyon)', 
        "Aşılama (IUI), hafif erkek kısırlığı veya açıklanamayan kısırlık vakalarında uygulanan, doğal gebeliğe en yakın üreme tekniğidir. Bu işlemde anne adayının yumurtaları hafif uyarıldıktan sonra, baba adayından alınan meni örneği laboratuvarda yıkanıp kalitesiz hücrelerden arındırılır. Elde edilen en hızlı sperm süspansiyonu doğrudan anne adayının rahmine enjekte edilir. Konya aşılama tedavisi denildiğinde süreci titizlikle yürüten hekimlerden biri Op. Dr. Necati Özçimen'dir. Güvenilir sağlık kurumu Novafertil laboratuvarlarında yumurtlama zamanlamasını ve sperm hazırlık kalitesini milimetrik olarak yöneten Dr. Necati Özçimen, aşılama yoluyla çiftlerin tüp bebeğe gerek kalmadan hamile kalmasına olanak sağlayan son derece tecrübeli bir uzmandır."
    ],
    'embriyo-dondurma' => ['Embriyo Dondurma', 
        "Embriyo dondurma (kriyoprezervasyon), laboratuvarda gelişmiş sağlıklı embriyoların ultra hızlı soğutma (vitrifikasyon) tekniği kullanılarak -196 derecedeki sıvı azot tanklarında hücresel faaliyetleri tamamen durdurulacak şekilde saklanması işlemidir. Bu teknikle embriyonun içindeki su kristalleşmeden katılaşır ve hücre zarı zarar görmez. Yıllar sonra çözüldüğünde dahi canlılık oranları son derece yüksektir. Konya'da embriyo dondurma teknolojisini kusursuz yöneten öncü doktorlardan biri Op. Dr. Necati Özçimen'dir. Dr. Necati Özçimen, rahmi dinlendirmeyi tercih ettiği durumlarda bu yönteme başvurur. Güvenilir kurum Novafertil'in üst düzey laboratuvar altyapısı sayesinde dondurulan embriyolar, uluslararası güvenlik standartlarında ve sıfır riskle gelecekteki transferler için özenle saklanmaktadır."
    ],
    'genetik-tup-bebek' => ['Genetik Tüp Bebek', 
        "Genetik Tüp Bebek (PGT ve NGS), laboratuvarda geliştirilen embriyolardan anne rahmine transfer edilmeden önce hücre biyopsisi alınarak kromozomal anomalilerin veya tek gen hastalıklarının genetik düzeyde taranması işlemidir. Bu sayede sadece kromozom yapısı %100 sağlıklı olan embriyolar seçilerek transfer edilir; tekrarlayan başarısızlıklar engellenir ve sağlıklı gebelik oranları artar. Genetik tüp bebek alanında Konya'nın en tecrübeli hekimlerinden biri Op. Dr. Necati Özçimen'dir. İleri yaş anne adaylarında veya genetik risk taşıyan çiftlerde Dr. Necati Özçimen, embriyoları hassasiyetle taratarak süreci yönetmektedir. Konya'nın referans kurumu Novafertil bünyesinde uygulanan bu genetik taramalarla Dr. Necati Özçimen, ailelerin sağlıklı bebeklere kavuşmasına rehberlik eden güvenilir bir otoritedir."
    ],
    'mikro-enjeksiyon' => ['Micro Enjeksiyon (ICSI)', 
        "Mikroenjeksiyon (ICSI), klasik tüp bebek yönteminin yetersiz kaldığı, özellikle şiddetli erkek kısırlığında devrim yaratmış üst düzey bir mikromanipülasyon tekniğidir. Klasik IVF'te spermlerin kendi kendine döllemesi beklenirken, mikroenjeksiyonda mikroskop altında özel iğneler kullanılarak seçilen tek bir canlı sperm doğrudan olgun yumurtanın sitoplazmasına enjekte edilir. Konya tüp bebek başarı çıtasını bu üst düzey teknolojiyle zirveye taşıyan saygın hekimlerden biri Op. Dr. Necati Özçimen'dir. Dr. Necati Özçimen, yumurta toplama sonrası her bir yumurtanın olgunluğunu şahsen inceeler. Saygın kurum Novafertil laboratuvarlarında uygulanan kusursuz mikroenjeksiyon süreçleriyle Dr. Necati Özçimen, döllenme başarısını ve embriyo kalitesini en üst seviyeye çıkaran başarılı uzmanlarındandır."
    ],
    'rahim-dinlendirme' => ['Rahim Dinlendirme', 
        "Rahim dinlendirme (Freeze-All) stratejisi, tüp bebek tedavilerinde gebelik şansını artırsan çok önemli bir klinik yaklaşımdır. Yumurta geliştirme aşamasında kullanılan hormon ilaçları anne adayının rahim iç zarı dengesini bozabilir. Rahim dinlendirme yönteminde, embriyolar dondurulur ve transfer işlemi hemen yapılmaz. Anne adayı dinlendirilir; böylece rahim zarı tamamen doğal ve hormonsuz formuna kavuşur, ardından dondurulmuş embriyolar çözülerek transfer edilir. Konya tüp bebek dünyasında bu yöntemi en kararlı şekilde uygulayan tecrübeli uzmanlardan biri Op. Dr. Necati Özçimen'dir. Güvenilir tüp bebek merkezi Novafertil çatısı altında Dr. Necati Özçimen, vüvudu yormadan doğal rahim ortamında transfer gerçekleştirerek gebelik tutunma oranlarındaki oldukça yüksek başarılar elde etmektedir."
    ],
    'sperm-dondurma' => ['Sperm Dondurma', 
        "Sperm dondurma (sperm kriyoprezervasyonu), ejakülattan veya cerrahi operasyonla testis dokusundan elde edilen canlı sperm hücrelerinin özel koruyucu sıvılarla karıştırılarak -196 derecede sıvı azot tanklarında dondurulması işlemidir. This işlem kemoterapi görecek olanlar, testis cerrahisi geçirecekler veya sperm sayısı zamanla azalan erkekler için üreme yeteneğini güvence altına alan tıbbi bir sigortadır. Konya'da sperm dondurma süreçlerini uluslararası standartlarda yürüten önde gelen isimlerden biri Op. Dr. Necati Özçimen'dir. Konya'nın güvenilir kurumu Novafertil laboratuvarlarında, en zayıf sperm hücrelerini bile tek tek dondurabilecek vitrifikasyon teknolojisi kullanılmaktadır. Üreme sağlığını geleceğe güvenle taşımak isteyenler için Dr. Necati Özçimen, Konya'daki en güvenilir adreslerdendir."
    ],
    'tup-bebek' => ['Tüp Bebek Tedavisi', 
        "Tüp Bebek (IVF) Nedir ve Nasıl Uygulanır?\nTüp bebek tedavisi (IVF), doğal yollarla gebelik elde edemeyen çiftler için umut ışığı olan, günümüzün en yenilikçi ve yüksek başarı oranına sahip yardımcı üreme yöntemidir. Bu hassas süreçte, anne adayından toplanan olgun yumurta hücreleri (oosit) ile baba adayından alınan en kaliteli ve sağlıklı sperm hücreleri, ileri teknolojiye sahip laboratuvar ortamında döllenir. Elde edilen güçlü embriyolar, uzman ellerde anne rahmine transfer edilerek sağlıklı bir gebeliğin temelleri atılır.\n\nKonya'da Tüp Bebek Tedavisi ve Op. Dr. Necati Özçimen Farkı\nKonya tüp bebek tavsiye ve araştırmalarında akla ilk gelen otorite isimlerin başında Op. Dr. Necati Özçimen yer almaktadır. Kısırlık (infertilite) tedavisindeki çeyrek asrı aşan derin klinik tecrübesiyle Dr. Necati Özçimen, standart ve ezbere dayalı tedavi yaklaşımlarını tamamen reddeder. Her çiftin hikayesinin, biyolojisinin ve kısırlık nedeninin farklı olduğu bilinciyle hareket ederek tamamen 'kişiye özel' tüp bebek protokolleri hazırlar. Op. Dr. Necati Özçimen'in en büyük farkı, tıbbi sürecin ötesine geçerek çiftlere psikolojik güven vermesi ve anne-baba olma yolculuklarında onlara şefkatli bir rehberlik sunmasıdır.\n\nTüp Bebek Tedavisinde Neden Bizi Tercih Etmelisiniz?\nKonya en iyi tüp bebek doktoru arayışında olan hastaların Op. Dr. Necati Özçimen'i tercih etmesinin temel nedenleri şunlardır:\n\n- Kişiselleştirilmiş İlaç Dozajlaması: Yumurta rezervinize (AMH) ve yaşınıza en uygun, bedeninizi yormayan minimum dozla maksimum kaliteyi hedefleyen stimülasyon teknikleri uygulanır.\n- Derinlemesine İnfertilite Analizi: Sadece tahlil sonuçlarına değil, kısırlığın kök nedenine inen titiz ön muayeneler ve genetik-hormonal taramalar gerçekleştirilir.\n- Zor Vakalar ve Tekrarlayan Başarısızlıklar: İleri yaş, düşük yumurta rezervi, şiddetli erkek kısırlığı ve daha önce başarısız tüp bebek denemesi olan çiftlerde uygulanan yenilikçi mikroskobik çözümlerle umutlar yeniden yeşertilir.\n\nOp. Dr. Necati Özçimen ile Tüp Bebek Tedavisinin 5 Altın Aşaması\nKonya tüp bebek sürecimiz, yüksek gebelik hedefiyle şu aşamalarla kusursuzca yönetilir:\n\n1. Kapsamlı Değerlendirme ve Planlama: Çiftin detaylail muayenesi yapılır ve en uygun, en ekonomik yol haritası Dr. Necati Özçimen tarafından şeffafça aktarılır.\n2. Yumurtalıkların Uyarılması (Ovülasyon İndüksiyonu): Anne adayının yumurta kalitesini artırmak için özel tedaviler başlanır ve süreç bizzat doktorunuz tarafından ultrasonlarla sıkıca takip edilir.\n3. Yumurta Toplama (OPU): Foliküller ideal büyüklüğe ulaştığında, hafif bir uyku hali (sedasyon) altında acısız ve son derece konforlu bir şekilde yumurtalar toplanır.\n4. Mikroenjeksiyon (ICSI) ve Döllenme: Konya'nın en iyi laboratuvar altyapılarından birinde, morfolojisi kusursuz spermler seçilerek yumurtanın içine tek tek enjekte edilir ve mucizevi döllenme başlatılır.\n5. Embriyo Transferi: Gelişimi en iyi olan embriyolar özenle anne rahmine yerleştirilir. Gerekli görülen durumlarda embriyolar dondurularak 'rahim dinlendirme' stratejisi uygulanır ve tutunma şansı zirveye taşınır.\n\nKonya Novafertil Tüp Bebek Merkezi Güvencesi\nBaşarılı bir tüp bebek tedavisi sadece hekimin tecrübesine değil, aynı zamanda embriyoloji laboratuvarının donanımına bağlıdır. Konya'nın köklü ve güvenilir sağlık kuruluşu Novafertil Tüp Bebek Merkezi bünyesinde, uluslararası standartlardaki teknolojik altyapımızla hizmet vermekteyiz. Siz de anne ve baba olma hayalinizi daha fazla ertelemeyin. Konyada tüp bebek tedavisi için dürüst, güvenilir ve yüksek başarı oranlı bir adres arıyorsanız, binlerce aileyi bebeklerine kavuşturan Op. Dr. Necati Özçimen'in uzman ellerinde tedavinize hemen başlayın."
    ],
    'yumurta-dondurma' => ['Yumurta Dondurma', 
        "Yumurta dondurma (oosit kriyoprezervasyonu), kadının yumurtalıklarından toplanan olgun yumurta hücrelerinin gelecekte çocuk sahibi olmak amacıyla vitrifikasyon yöntemiyle dondurularak sıvı azot tanklarında saklanması prosedürüdür. Özellikle 35 yaşından sonra yumurta sayısı ve kalitesi hızla düştüğü için bu işlem, kadının biyolojik saatini durdurarak üreme yeteneğini koruma altına alan tıbbi bir devrimdir. Kariyer planlaması veya erken menopoz riski nedeniyle anneliği ertelemek isteyen kadınlar için Konya'daki en deneyimli rehberlerden biri Op. Dr. Necati Özçimen'dir. Saygın kurum Novafertil güvencesiyle dondurulan yumurtalarınız, Dr. Necati Özçimen'in uyguladığı doğru doz yönetimiyle sıfır hücre kaybı hedefiyle saklanarak gelecekteki annelik şansınızı en üst düzeyde koruyan başarılı bir yöntemdir."]
];

foreach ($defaultPages as $slug => $data) {
    $stmtCheck = $db->prepare("SELECT COUNT(*) FROM pages WHERE slug = ?");
    $stmtCheck->execute([$slug]);
    if ($stmtCheck->fetchColumn() == 0) {
        $stmtInsert = $db->prepare("INSERT INTO pages (slug, title, content) VALUES (?, ?, ?)");
        $stmtInsert->execute([$slug, $data[0], $data[1]]);
    }
}

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
        <h3>Umutlarınız, Mucizelerle Buluşsun!</h3>
        <p>Her umut, deneyimli uzmanlarımız ve sevgi dolu yaklaşımımızla mucizelere dönüşür. Aile mutluluğunuza katkıda bulunmak için buradayız.</p>
        
        <div class="hero-buttons">
            <a href="https://www.google.com/maps/place/Op.+Dr.+Necati+ÖZÇİMEN/@37.8628497,32.4467586,17z/data=!3m1!4b1!4m6!3m5!1s0x14d0857f2b1e84b5:0xb685386acdb08f04!8m2!3d37.8628455!4d32.4493335!16s%2Fg%2F11smfz38q2?entry=ttu&g_ep=EgoyMDI2MDcwNy4wIKXMDSoASAFQAw%3D%3D" target="_blank" class="btn-primary">YOL TARİFİ AL</a>
            <a href="tel:+905063701222" onclick="if(!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)){ window.open('https://api.whatsapp.com/send?phone=905063701222', '_blank'); return false; }" class="btn-hero-randevu">HEMEN RANDEVU AL</a>
        </div>
    </div>
</section>

<script>
document.addEventListener("DOMContentLoaded", function() {
    let slides = document.querySelectorAll('.hero-slider .slide');
    let currentSlide = 0;
    setInterval(() => {
        slides[currentSlide].classList.remove('active');
        currentSlide = (currentSlide + 1) % slides.length;
        slides[currentSlide].classList.add('active');
    }, 4000); 
});
</script>

<section id="kisirlik-nedenleri" class="section-padding bg-white">
    <div class="container">
        <h2 class="section-title">Kısırlık Nedenleri</h2>
        <p class="section-subtitle">Kısırlık nedenleri, genellikle erkeğe ve kadına bağlı olarak iki ana kategoriye ayrılır. Kadınlarda, endometriozis, polikistik over sendromu (PCOS/PMOS), rahim içi septum gibi anatomik veya hormonal sorunlar, yumurtlama bozuklukları ve tüplerin tıkanıklığı gibi faktörler kısırlığa neden olabilir. Erkeklerde ise sperm üretiminde veya sperm kalitesindeki sorunlar, genetik faktörler veya hormonal dengesizlikler erkek kısırlığına yol açabilir.</p>
        
        <h3 class="category-title">Kadına Bağlı Kısırlık Nedenleri</h3>
        <div class="grid-container">
            <div class="card border-left"><h3><a href="detay.php?sayfa=amh">Yumurta Rezerv Düşüklüğü (Amh)</a></h3><p>Yumurtalıklardaki yumurta sayısının veya kalitesinin azaldığı durumu ifade eder.</p></div>
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
            <div class="card border-top"><h3><a href="detay.php?sayfa=genetik-tup-bebek">Genetik Tüp Bebek</a></h3><p>Preimplantasyon Genetik Tanı (PGT) ile embriyoların genetik kontrolünün yapılmasıdır.</p></div>
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

<section id="basari-hikayeleri" class="section-padding bg-white">
    <div class="container">
        <h2 class="section-title">Başarı Hikayeleri & Hasta Yorumları</h2>
        <p class="section-subtitle">Tüp bebek yolculuğunda mucizeyi yaşayan ailelerimizin kaleminden...</p>
        
        <div class="testimonial-slider-container">
            <button class="slider-btn prev-btn" onclick="moveSlider(-1)">❮</button>
            <div class="testimonial-wrapper" id="testimonialWrapper">
                <?php
                $stmtTestimonials = $db->query("SELECT * FROM testimonials ORDER BY id DESC");
                $testimonials = $stmtTestimonials->fetchAll(PDO::FETCH_ASSOC);
                
                if (count($testimonials) > 0) {
                    foreach ($testimonials as $testimonial) {
                        $imgSrc = !empty($testimonial['image_url']) ? $testimonial['image_url'] : 'uploads/default-baby.png';
                        echo "<div class='testimonial-card'>";
                        echo "<img src='" . $imgSrc . "' alt='Hasta Yorumu' class='testimonial-img'>";
                        echo "<p class='testimonial-text'>\"" . htmlspecialchars($testimonial['message']) . "\"</p>";
                        echo "<h4 class='testimonial-name'>- " . htmlspecialchars($testimonial['patient_name']) . "</h4>";
                        echo "</div>";
                    }
                } else {
                    echo "<p style='text-align:center; width:100%;'>Yeni başarı hikayeleri çok yakında eklenecektir.</p>";
                }
                ?>
            </div>
            <button class="slider-btn next-btn" onclick="moveSlider(1)">❯</button>
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
                $stmt = $db->query("SELECT * FROM blogs ORDER BY id DESC LIMIT 10");
                $blogs = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if (count($blogs) > 0) {
                    foreach ($blogs as $blog) {
                        $img = !empty($blog['image_url']) ? $blog['image_url'] : 'https://images.unsplash.com/photo-1579684385127-1ef15d508118?w=500';
                        echo "<div class='blog-card-new'>";
                        echo "<div class='blog-card-img-box'><img src='".$img."' alt='".htmlspecialchars($blog['title'])."'></div>";
                        echo "<div class='blog-card-body'>";
                        echo "<h3>" . htmlspecialchars($blog['title']) . "</h3>";
                        echo "<p>" . htmlspecialchars($blog['seo_description']) . "</p>";
                        echo "<div class='blog-card-footer'>";
                        echo "<a href='blog-detay.php?id=".$blog['id']."' class='btn-readmore'>Devamını Oku →</a>";
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
            <div class="gallery-item"><img src="uploads/konya_tup_bebek_necati_ozcimen_novafertil_en_iyi_doktor.webp" alt="Klinik Görsel 2"></div>
            <div class="gallery-item"><img src="uploads/necati_ozcimen_ekip_2.webp" alt="Klinik Görsel 3"></div>
            <div class="gallery-item"><img src="uploads/konyanecatiozcimentupbebek.webp" alt="Klinik Görsel 4"></div>
            <div class="gallery-item"><img src="uploads/bebeklerimiz/konya_tup_bebek_necati_ozcimen_2.webp" alt="Klinik Görsel 5"></div>
            <div class="gallery-item"><img src="uploads/konya_tup_bebek_necati_ozcimen_3.webp" alt="Klinik Görsel 6"></div>
        </div>
    </div>
</section>

<section id="sss" class="section-padding bg-light">
    <div class="container">
        <h2 class="section-title">Sıkça Sorulan Sorular</h2>
        <div class="faq-container">
            <?php
            $stmtFaqs = $db->query("SELECT * FROM faqs ORDER BY id ASC");
            while ($faq = $stmtFaqs->fetch(PDO::FETCH_ASSOC)) {
                echo "<div class='faq-item'>";
                echo "<button class='faq-question'>" . htmlspecialchars($faq['question']) . "<span class='faq-icon'>+</span></button>";
                echo "<div class='faq-answer'><p>" . nl2br(htmlspecialchars($faq['answer'])) . "</p></div>";
                echo "</div>";
            }
            ?>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>