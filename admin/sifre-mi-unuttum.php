<?php
session_start();
require_once '../db.php';

$message = '';
$error = '';

if (isset($_POST['reset_request'])) {
    // Tüm adminleri bul (sistemde genelde tek admin var, biz en yetkilisini (id=1) veya genel olarak admini alıyoruz)
    $stmt = $db->query("SELECT * FROM admins LIMIT 1");
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin) {
        // Token oluştur (64 karakter)
        if (function_exists('random_bytes')) {
            $token = bin2hex(random_bytes(32));
        } else if (function_exists('openssl_random_pseudo_bytes')) {
            $token = bin2hex(openssl_random_pseudo_bytes(32));
        } else {
            $token = md5(uniqid(rand(), true));
        }
        
        // 1 saat geçerlilik süresi
        $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));

        // Veritabanına kaydet
        $updateStmt = $db->prepare("UPDATE admins SET reset_token = ?, reset_expires = ? WHERE id = ?");
        $updateStmt->execute([$token, $expires, $admin['id']]);

        // PHPMailer Entegrasyonu
        require_once '../includes/PHPMailer/Exception.php';
        require_once '../includes/PHPMailer/PHPMailer.php';
        require_once '../includes/PHPMailer/SMTP.php';

        $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
        try {
            $mail->CharSet = 'UTF-8';
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = SMTP_USER;
            $mail->Password   = SMTP_PASS;
            $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;

            $mail->setFrom(SMTP_USER, 'konyatupbebek.com');
            $mail->addAddress('nozcimendr@yahoo.com');
            $mail->addAddress('ardaozcimen@yahoo.com');

            $mail->isHTML(true);
            $mail->Subject = 'Yönetim Paneli - Şifre Sıfırlama Talebi';
            
            $reset_link = "https://" . str_replace("www.", "", $_SERVER['HTTP_HOST']) . dirname($_SERVER['PHP_SELF']) . "/sifre-yenile.php?token=" . $token;
            
            // HTML Mail Şablonu
            $mail->Body = '
            <div style="font-family: Arial, sans-serif; background-color: #f4f7f6; padding: 40px 20px; color: #2c3e50;">
                <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
                    <div style="background-color: #2c3e50; padding: 30px; text-align: center;">
                        <h1 style="color: #ffffff; margin: 0; font-size: 24px; font-weight: 600;">Konya Tüp Bebek Merkezi</h1>
                    </div>
                    <div style="padding: 40px 30px;">
                        <h2 style="margin-top: 0; color: #2c3e50; font-size: 20px;">Şifre Sıfırlama Talebi</h2>
                        <p style="font-size: 15px; line-height: 1.6; color: #555;">Merhaba,</p>
                        <p style="font-size: 15px; line-height: 1.6; color: #555;">Yönetim paneli hesabınız için bir şifre sıfırlama talebinde bulundunuz. Yeni şifrenizi belirlemek için aşağıdaki butona tıklayabilirsiniz:</p>
                        
                        <div style="text-align: center; margin: 35px 0;">
                            <a href="'.$reset_link.'" style="display: inline-block; padding: 14px 30px; background-color: #3498db; color: #ffffff; text-decoration: none; border-radius: 8px; font-weight: bold; font-size: 16px; transition: background-color 0.3s;">Şifremi Yenile</a>
                        </div>
                        
                        <p style="font-size: 13px; color: #999; text-align: center;">Veya şu bağlantıyı tarayıcınıza kopyalayabilirsiniz:<br>
                        <a href="'.$reset_link.'" style="color: #3498db; word-break: break-all;">'.$reset_link.'</a></p>
                        
                        <hr style="border: none; border-top: 1px solid #eee; margin: 30px 0;">
                        <p style="font-size: 13px; line-height: 1.5; color: #7f8c8d; margin: 0;">Bu bağlantı güvenliğiniz için <strong>1 saat</strong> boyunca geçerlidir. Eğer bu talebi siz yapmadıysanız, lütfen bu e-postayı dikkate almayın. Hesabınız güvendedir.</p>
                    </div>
                </div>
                <div style="text-align: center; margin-top: 20px; color: #aaa; font-size: 12px;">
                    &copy; '.date("Y").' Konya Novafertil Tüp Bebek Merkezi - OAÖ
                </div>
            </div>';

            $mail->send();
            $message = 'Şifre sıfırlama bağlantısı kayıtlı e-posta adreslerinize gönderildi.';
        } catch (Exception $e) {
            $error = 'E-posta gönderilemedi. Hata (Muhtemelen Google Uygulama Şifresi gerekiyor): ' . $mail->ErrorInfo;
        }
    } else {
        $error = 'Sistemde kayıtlı bir yönetici bulunamadı.';
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Şifremi Unuttum - Yönetim Paneli</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2c3e50;
            --accent-color: #3498db;
            --error-color: #e74c3c;
            --success-color: #2ecc71;
            --bg-gradient: linear-gradient(135deg, #2c3e50 0%, #1a252f 100%);
            --card-bg: rgba(255, 255, 255, 0.95);
        }
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Inter', sans-serif; }
        body { background: var(--bg-gradient); display: flex; justify-content: center; align-items: center; min-height: 100vh; padding: 20px; }
        .login-container { width: 100%; max-width: 400px; background: var(--card-bg); padding: 40px; border-radius: 16px; box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3); }
        .login-header { text-align: center; margin-bottom: 30px; }
        .login-header h2 { color: var(--primary-color); font-size: 26px; font-weight: 700; margin-bottom: 8px; }
        .login-header p { color: #7f8c8d; font-size: 14px; margin-bottom: 20px; line-height: 1.5; }
        button { width: 100%; padding: 14px; background: var(--accent-color); color: #fff; border: none; border-radius: 8px; font-size: 15px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; }
        button:hover { background: #2980b9; transform: translateY(-2px); }
        .err { background: rgba(231, 76, 60, 0.1); color: var(--error-color); padding: 12px; border-radius: 6px; font-size: 13px; margin-bottom: 25px; text-align: center; }
        .succ { background: rgba(46, 204, 113, 0.1); color: var(--success-color); padding: 12px; border-radius: 6px; font-size: 13px; margin-bottom: 25px; text-align: center; }
        .back-link { display: block; text-align: center; margin-top: 20px; font-size: 13px; color: var(--primary-color); text-decoration: none; }
    </style>
</head>
<body>
<div class="login-container">
    <div class="login-header">
        <h2>Şifre Sıfırlama</h2>
        <p>Hesabınızın şifresini sıfırlamak için kayıtlı e-posta adreslerinize <strong>(n********r@y***.com, a********n@y***.com)</strong> bir bağlantı göndereceğiz.</p>
    </div>
    
    <?php if($error): ?> <div class="err"><?= $error ?></div> <?php endif; ?>
    <?php if($message): ?> <div class="succ"><?= $message ?></div> <?php endif; ?>
    
    <?php if(!$message): ?>
    <form action="" method="POST">
        <button type="submit" name="reset_request">Şifre Sıfırlama Bağlantısı Gönder</button>
    </form>
    <?php endif; ?>
    
    <a href="login.php" class="back-link">← Giriş sayfasına dön</a>
</div>
</body>
</html>
