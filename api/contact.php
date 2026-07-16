<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');

require_once '../db.php';

// Include PHPMailer
require_once '../includes/PHPMailer/Exception.php';
require_once '../includes/PHPMailer/PHPMailer.php';
require_once '../includes/PHPMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle contact form submission
    $data = json_decode(file_get_contents("php://input"), true);
    
    // If not JSON, try $_POST
    $name = isset($data['name']) ? $data['name'] : (isset($_POST['name']) ? $_POST['name'] : '');
    $email = isset($data['email']) ? $data['email'] : (isset($_POST['email']) ? $_POST['email'] : '');
    $phone = isset($data['phone']) ? $data['phone'] : (isset($_POST['phone']) ? $_POST['phone'] : '');
    $messageBody = isset($data['message']) ? $data['message'] : (isset($_POST['message']) ? $_POST['message'] : '');

    if (empty($name) || empty($phone)) {
        echo json_encode(['status' => 'error', 'message' => 'İsim ve Telefon numarası zorunludur.']);
        exit;
    }

    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; 
        $mail->SMTPAuth   = true;
        $mail->Username   = SMTP_USER;
        $mail->Password   = SMTP_PASS;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        // Recipients
        $mail->setFrom(SMTP_USER, 'Konya Tüp Bebek Mobil Uygulama');
        $mail->addAddress('bilgi@novafertil.com', 'Novafertil'); // Add a recipient
        
        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Mobil Uygulamadan Yeni Iletisim Formu: ' . $name;
        $mail->Body    = "
            <h3>Yeni İletişim Formu Mesajı</h3>
            <p><strong>İsim:</strong> {$name}</p>
            <p><strong>E-posta:</strong> {$email}</p>
            <p><strong>Telefon:</strong> {$phone}</p>
            <p><strong>Mesaj:</strong><br>{$messageBody}</p>
        ";

        $mail->send();
        echo json_encode(['status' => 'success', 'message' => 'Mesajınız başarıyla gönderildi.']);
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => "Mesaj gönderilemedi. Mailer Error: {$mail->ErrorInfo}"]);
    }
} else {
    // Return static contact information
    $response = [
        'status' => 'success',
        'data' => [
            'address' => 'Novafertil Konya Tüp Bebek Merkezi, Ateşbaz-I Veli Mh. Yeni Meram Cd. No:75 Meram/Konya',
            'phone' => '+90 (332) 323 51 51',
            'email' => 'bilgi@novafertil.com',
            'working_hours' => 'Pazartesi - Cumartesi: 09.00 - 17.00, Pazar: Kapalı',
            'coordinates' => [
                'latitude' => 37.8628455,
                'longitude' => 32.4493335
            ]
        ]
    ];
    echo json_encode($response);
}
?>
