<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}

require_once '../db.php';

// Check ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = (int)$_GET['id'];

// Update Logic
if (isset($_POST['guncelle_sss'])) {
    $soru = trim($_POST['soru']);
    $cevap = trim($_POST['cevap']);

    try {
        $stmt = $db->prepare("UPDATE faqs SET question = ?, answer = ? WHERE id = ?");
        $stmt->execute([$soru, $cevap, $id]);
        $success_msg = "Sıkça sorulan soru başarıyla güncellendi!";
    } catch (PDOException $e) {
        $error_msg = "Hata oluştu: " . $e->getMessage();
    }
}

// Fetch existing data
$stmt = $db->prepare("SELECT * FROM faqs WHERE id = ?");
$stmt->execute([$id]);
$faq = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$faq) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>SSS Düzenle - Yönetim Paneli</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f4f6f9; margin: 0; padding: 20px; }
        .container { max-width: 800px; margin: 0 auto; background: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
        h1 { color: #2c3e50; font-size: 24px; margin-top: 0; border-bottom: 2px solid #ecf0f1; padding-bottom: 15px; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; font-weight: bold; margin-bottom: 8px; color: #34495e; }
        .form-control { width: 100%; padding: 12px; border: 1px solid #bdc3c7; border-radius: 5px; box-sizing: border-box; font-family: inherit; }
        textarea.form-control { min-height: 150px; resize: vertical; }
        .btn-submit { background: #3498db; color: #fff; border: none; padding: 12px 25px; border-radius: 5px; cursor: pointer; font-size: 16px; font-weight: bold; transition: background 0.3s; }
        .btn-submit:hover { background: #2980b9; }
        .btn-back { background: #95a5a6; color: #fff; text-decoration: none; padding: 12px 25px; border-radius: 5px; font-size: 16px; margin-right: 10px; display: inline-block; }
        .alert { padding: 15px; margin-bottom: 20px; border-radius: 5px; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-danger { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
    </style>
</head>
<body>

<div class="container">
    <h1>Sıkça Sorulan Soru Düzenle</h1>
    
    <?php if(isset($success_msg)): ?>
        <div class="alert alert-success"><?= $success_msg ?></div>
    <?php endif; ?>
    
    <?php if(isset($error_msg)): ?>
        <div class="alert alert-danger"><?= $error_msg ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label for="soru">Soru</label>
            <input type="text" id="soru" name="soru" class="form-control" value="<?= htmlspecialchars($faq['question']) ?>" required>
        </div>
        
        <div class="form-group">
            <label for="cevap">Cevap</label>
            <textarea id="cevap" name="cevap" class="form-control" required><?= htmlspecialchars($faq['answer']) ?></textarea>
        </div>
        
        <div style="margin-top: 30px;">
            <a href="index.php" class="btn-back">İptal / Geri Dön</a>
            <button type="submit" name="guncelle_sss" class="btn-submit">Değişiklikleri Kaydet</button>
        </div>
    </form>
</div>

</body>
</html>
