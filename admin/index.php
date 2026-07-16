<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if (!isset($_SESSION['logged_in'])) { header('Location: login.php'); exit; }

try {
    require_once '../db.php';

    // SİLME İŞLEMLERİ
    if (isset($_GET['sil'])) {
        $id = (int)$_GET['sil'];
        $stmtImg = $db->prepare("SELECT image_url FROM blogs WHERE id = ?");
        $stmtImg->execute([$id]);
        $blog = $stmtImg->fetch(PDO::FETCH_ASSOC);
        if ($blog && !empty($blog['image_url'])) {
            $file_path = '../' . $blog['image_url']; 
            if (file_exists($file_path)) unlink($file_path);
        }
        $db->prepare("DELETE FROM blogs WHERE id = ?")->execute([$id]);
        header('Location: index.php'); exit;
    }
    
    if (isset($_GET['sil_sss'])) { $db->prepare("DELETE FROM faqs WHERE id=?")->execute([$_GET['sil_sss']]); header("Location: index.php"); exit; }
    if (isset($_GET['sil_stat'])) { $db->prepare("DELETE FROM statistics WHERE id=?")->execute([$_GET['sil_stat']]); header("Location: index.php"); exit; }


    // EKLEME İŞLEMLERİ (CREATE)
    if (isset($_POST['ekle_sss'])) {
        $stmt = $db->prepare("INSERT INTO faqs (question, answer) VALUES (?, ?)");
        $stmt->execute([$_POST['soru'], $_POST['cevap']]);
        header("Location: index.php"); exit;
    }
    if (isset($_POST['ekle_stat'])) {
        $stmt = $db->prepare("INSERT INTO statistics (title, count_value) VALUES (?, ?)");
        $stmt->execute([$_POST['baslik'], $_POST['sayi']]);
        header("Location: index.php"); exit;
    }

    // LİSTELEME SORGULARI VE GOOGLE YORUMLARI
    $blogs = $db->query("SELECT * FROM blogs ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
    $faqs = $db->query("SELECT * FROM faqs")->fetchAll(PDO::FETCH_ASSOC);
    $stats = $db->query("SELECT * FROM statistics")->fetchAll(PDO::FETCH_ASSOC);


} catch (PDOException $e) {
    die("Veritabanı Erişim Hatası: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yönetim Paneli - Op. Dr. Necati Özçimen</title>
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2c3e50;
            --accent-color: #3498db;
            --success-color: #2ecc71;
            --danger-color: #e74c3c;
            --warning-color: #f1c40f;
            --bg-color: #f5f6fa;
            --card-bg: #ffffff;
            --text-color: #2c3e50;
            --sidebar-width: 260px;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-color);
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Gelişmiş Navigasyon */
        .sidebar {
            width: var(--sidebar-width);
            background: var(--primary-color);
            color: #fff;
            padding: 30px 20px;
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100vh;
            left: 0;
            top: 0;
            box-shadow: 4px 0 15px rgba(0, 0, 0, 0.05);
            z-index: 100;
        }

        .sidebar-brand {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 40px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding-bottom: 20px;
            letter-spacing: 0.5px;
        }

        .sidebar-brand span {
            display: block;
            font-size: 12px;
            font-weight: 400;
            color: rgba(255, 255, 255, 0.6);
            margin-top: 5px;
        }

        .sidebar-menu {
            list-style: none;
            flex-grow: 1;
        }

        .sidebar-menu li {
            margin-bottom: 10px;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            color: rgba(255, 255, 255, 0.75);
            padding: 12px 16px;
            text-decoration: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .sidebar-menu a:hover, .sidebar-menu a.active {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
        }

        .sidebar-menu svg {
            margin-right: 12px;
            width: 18px;
            height: 18px;
        }

        .sidebar-footer {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 20px;
        }

        .btn-logout {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: 12px;
            background: var(--danger-color);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(231, 76, 60, 0.2);
        }

        .btn-logout:hover {
            background: #c0392b;
            transform: translateY(-2px);
        }

        /* Ana İçerik Alanı */
        .main-content {
            margin-left: var(--sidebar-width);
            flex-grow: 1;
            padding: 40px;
            width: calc(100% - var(--sidebar-width));
        }

        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
        }

        .header-section h1 {
            font-size: 28px;
            font-weight: 700;
            color: var(--primary-color);
        }

        .btn-add-blog {
            display: inline-flex;
            align-items: center;
            background: var(--accent-color);
            color: #fff;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            box-shadow: 0 4px 12px rgba(52, 152, 219, 0.25);
            transition: all 0.3s ease;
            font-size: 14px;
        }

        .btn-add-blog:hover {
            background: #2980b9;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(52, 152, 219, 0.35);
        }

        .btn-add-blog svg {
            margin-right: 8px;
            width: 16px;
            height: 16px;
        }

        /* İstatistik Kartları */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: var(--card-bg);
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .stat-info h3 {
            font-size: 32px;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 4px;
        }

        .stat-info p {
            font-size: 13px;
            color: #7f8c8d;
            font-weight: 500;
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .stat-icon.blue { background: rgba(52, 152, 219, 0.1); color: var(--accent-color); }
        .stat-icon.green { background: rgba(46, 204, 113, 0.1); color: var(--success-color); }
        .stat-icon.orange { background: rgba(241, 196, 15, 0.1); color: var(--warning-color); }
        .stat-icon.purple { background: rgba(155, 89, 182, 0.1); color: #9b59b6; }

        /* Grid Paneli */
        .dashboard-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 30px;
            margin-bottom: 40px;
        }

        @media (max-width: 1024px) {
            .dashboard-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Panel Kartları */
        .panel-card {
            background: var(--card-bg);
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
            margin-bottom: 30px;
        }

        .panel-card h2 {
            font-size: 18px;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 20px;
            border-bottom: 2px solid #f5f6fa;
            padding-bottom: 12px;
            display: flex;
            align-items: center;
        }

        /* Form Elemanları */
        form input[type="text"], form input[type="number"], form textarea, form input[type="file"] {
            width: 100%;
            padding: 12px 16px;
            background: #f8f9fa;
            border: 1px solid #dcdde1;
            border-radius: 8px;
            font-size: 14px;
            color: var(--text-color);
            margin-bottom: 15px;
            transition: all 0.3s ease;
            outline: none;
        }

        form input:focus, form textarea:focus {
            border-color: var(--accent-color);
            background: #fff;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
        }

        form textarea {
            height: 100px;
            resize: vertical;
        }

        .btn-submit {
            width: 100%;
            padding: 12px;
            background: var(--accent-color);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(52, 152, 219, 0.2);
        }

        .btn-submit:hover {
            background: #2980b9;
            transform: translateY(-1px);
        }

        /* Tablo Stilleri */
        .table-container {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            margin-top: 10px;
        }

        th {
            background: #f8f9fa;
            color: #7f8c8d;
            font-weight: 600;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 14px 16px;
            border-bottom: 2px solid #eaeded;
        }

        td {
            padding: 14px 16px;
            border-bottom: 1px solid #eaeded;
            font-size: 14px;
            color: #34495e;
        }

        tr:hover td {
            background: #fafbfc;
        }

        .btn-action-delete {
            color: var(--danger-color);
            background: rgba(231, 76, 60, 0.08);
            padding: 6px 12px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            transition: all 0.2s ease;
            display: inline-block;
        }

        .btn-action-delete:hover {
            background: var(--danger-color);
            color: #fff;
        }

        .btn-action-edit {
            color: var(--accent-color);
            background: rgba(52, 152, 219, 0.08);
            padding: 6px 12px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            transition: all 0.2s ease;
            display: inline-block;
            margin-right: 5px;
        }

        .btn-action-edit:hover {
            background: var(--accent-color);
            color: #fff;
        }

        .list-table {
            margin-top: 20px;
            border: 1px solid #eaeded;
            border-radius: 8px;
            overflow: hidden;
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <div class="sidebar-brand">
        Necati Özçimen
        <span>Yönetim Paneli</span>
    </div>
    <ul class="sidebar-menu">
        <li>
            <a href="index.php" class="active">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="9"/><rect x="14" y="3" width="7" height="5"/><rect x="14" y="12" width="7" height="9"/><rect x="3" y="16" width="7" height="5"/></svg>
                Kontrol Paneli
            </a>
        </li>
        <li>
            <a href="blog-ekle.php">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
                Blog Yazısı Ekle
            </a>
        </li>
        <li>
            <a href="../" target="_blank">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z"/><circle cx="12" cy="12" r="3"/></svg>
                Siteyi Görüntüle
            </a>
        </li>
    </ul>
    <div class="sidebar-footer">
        <a href="logout.php" class="btn-logout" onclick="return confirm('Çıkış yapmak istediğinize emin misiniz?')">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:16px;height:16px;margin-right:8px;"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4M16 17l5-5-5-5M21 12H9"/></svg>
            Güvenli Çıkış
        </a>
    </div>
</div>

<!-- Main Content -->
<div class="main-content">
    <div class="header-section">
        <div>
            <h1>Genel Bakış</h1>
        </div>
        <a href="blog-ekle.php" class="btn-add-blog">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
            Yeni Blog Ekle
        </a>
    </div>

    <!-- İstatistik Kartları -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-info">
                <h3><?= count($blogs) ?></h3>
                <p>Toplam Blog</p>
            </div>
            <div class="stat-icon blue">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:24px;height:24px;"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-info">
                <h3><?= count($faqs) ?></h3>
                <p>Sıkça Sorulan Soru</p>
            </div>
            <div class="stat-icon orange">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:24px;height:24px;"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-info">
                <h3><?= count($stats) ?></h3>
                <p>Aktif İstatistik</p>
            </div>
            <div class="stat-icon purple">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:24px;height:24px;"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
            </div>
        </div>
    </div>

    <!-- Dashboard Grid -->
    <div class="dashboard-grid">
        
        <!-- Sol Bölüm: Mevcut Bloglar Listesi -->
        <div>
            <div class="panel-card">
                <h2>Yayınlanan Blog Yazıları</h2>
                <div class="table-container">
                    <table class="list-table">
                        <thead>
                            <tr>
                                <th style="width: 80px;">ID</th>
                                <th>Başlık</th>
                                <th style="width: 180px;">Yayınlanma Tarihi</th>
                                <th style="width: 180px; text-align: center;">İşlemler</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(count($blogs) > 0): ?>
                                <?php foreach ($blogs as $blog): ?>
                                <tr>
                                    <td><strong>#<?= $blog['id'] ?></strong></td>
                                    <td><?= htmlspecialchars($blog['title']) ?></td>
                                    <td><?= date('d.m.Y H:i', strtotime($blog['created_at'])) ?></td>
                                    <td style="text-align: center; white-space: nowrap;">
                                        <a href="blog-duzenle.php?id=<?= $blog['id'] ?>" class="btn-action-edit">Düzenle</a>
                                        <a href="index.php?sil=<?= $blog['id'] ?>" class="btn-action-delete" onclick="return confirm('Bu makaleyi silmek istediğinize emin misiniz?')">Sil</a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="4" style="text-align: center; color: #7f8c8d;">Henüz blog yazısı yayınlanmamış.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>


        </div>

        <!-- Sağ Bölüm: Ekleme Modülleri -->
        <div>
            <!-- İstatistik Ekleme -->
            <div class="panel-card">
                <h2>İstatistik Ekle</h2>
                <form method="POST" style="margin-bottom: 20px;">
                    <input type="text" name="baslik" placeholder="Başlık (Örn: Başarılı Tüp Bebek)" required>
                    <input type="number" name="sayi" placeholder="Değer (Örn: 5000)" required>
                    <button type="submit" name="ekle_stat" class="btn-submit">Ekle</button>
                </form>
                
                <table class="list-table">
                    <tbody>
                        <?php foreach($stats as $s): ?>
                        <tr>
                            <td><strong><?= htmlspecialchars($s['title']) ?></strong> (<?= htmlspecialchars($s['count_value']) ?>+)</td>
                            <td style="width: 60px; text-align: center;">
                                <a href="?sil_stat=<?= $s['id'] ?>" class="btn-action-delete" style="padding:4px 8px; font-size:11px;">Sil</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- SSS Ekleme -->
            <div class="panel-card">
                <h2>Sıkça Sorulan Soru Ekle</h2>
                <form method="POST" style="margin-bottom: 20px;">
                    <input type="text" name="soru" placeholder="Soru (Örn: Tedavi ne kadar sürer?)" required>
                    <textarea name="cevap" placeholder="Detaylı cevabı yazın..." required></textarea>
                    <button type="submit" name="ekle_sss" class="btn-submit">Ekle</button>
                </form>

                <table class="list-table">
                    <tbody>
                        <?php foreach($faqs as $f): ?>
                        <tr>
                            <td><?= htmlspecialchars(mb_strimwidth($f['question'], 0, 45, "...")) ?></td>
                            <td style="width: 130px; text-align: center; white-space: nowrap;">
                                <a href="sss-duzenle.php?id=<?= $f['id'] ?>" class="btn-action-edit" style="padding:4px 8px; font-size:11px; margin-right: 5px;">Düzenle</a>
                                <a href="?sil_sss=<?= $f['id'] ?>" class="btn-action-delete" style="padding:4px 8px; font-size:11px;" onclick="return confirm('Silmek istediğinize emin misiniz?');">Sil</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>


        </div>

    </div>
</div>

</body>
</html>