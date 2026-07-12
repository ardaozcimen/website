<?php
// Gelen isteklerin JSON olduğunu belirtiyoruz
header('Content-Type: application/json');

// Güvenlik: Sadece bu anahtarı bilen (Make.com) istek yapabilir
$api_key = "KONYATUPBEBEK_SECRET_API_KEY_2026!";

// Gelen header'ları kontrol et
$headers = apache_request_headers();
$auth_header = isset($headers['Authorization']) ? $headers['Authorization'] : '';

if ($auth_header !== $api_key) {
    http_response_code(401);
    echo json_encode(["status" => "error", "message" => "Yetkisiz erisim. API Anahtari hatali."]);
    exit;
}

// Veritabanı bağlantısı
$db = new PDO('sqlite:../db/konyatupbebek.db');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$method = $_SERVER['REQUEST_METHOD'];
$data = json_decode(file_get_contents('php://input'), true);

// 1. BLOG EKLEME (POST İsteği)
if ($method === 'POST') {
    if(isset($data['title']) && isset($data['content'])) {
        $title = $data['title'];
        $content = $data['content'];
        $seo_title = isset($data['seo_title']) ? $data['seo_title'] : '';
        $seo_desc = isset($data['seo_description']) ? $data['seo_description'] : '';
        $image_url = isset($data['image_url']) ? $data['image_url'] : ''; // Otomasyondan resim linki gelirse

        $stmt = $db->prepare("INSERT INTO blogs (title, content, seo_title, seo_description, image_url) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$title, $content, $seo_title, $seo_desc, $image_url]);

        echo json_encode(["status" => "success", "message" => "Blog eklendi.", "id" => $db->lastInsertId()]);
    } else {
        http_response_code(400);
        echo json_encode(["status" => "error", "message" => "Baslik ve icerik zorunludur."]);
    }
} 
// 2. BLOG SİLME (DELETE İsteği)
elseif ($method === 'DELETE') {
    if(isset($data['id'])) {
        $stmt = $db->prepare("DELETE FROM blogs WHERE id = ?");
        $stmt->execute([$data['id']]);
        echo json_encode(["status" => "success", "message" => "Blog silindi."]);
    } else {
        http_response_code(400);
        echo json_encode(["status" => "error", "message" => "Silinecek ID belirtilmedi."]);
    }
}
?>