<?php
// Gelen JSON isteklerini dinle
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Güvenlik: Özel API Anahtarı
$SECRET_API_KEY = "KONYA_NOVAFERTIL_GIZLI_ANAHTAR_2026";

// JSON verisini al (Token'i JSON'dan da alabilmek için önce bunu parse ediyoruz)
$data = json_decode(file_get_contents("php://input"), true);
$token = '';

// 1. JSON Body içinden API Key kontrolü (Hosting firmaları header sildiğinde kurtarıcıdır)
if (isset($data['api_key'])) {
    $token = $data['api_key'];
} 
// 2. HTTP Header Kontrolleri (Standart yöntem)
else {
    $headers = null;
    if (function_exists('apache_request_headers')) {
        $headers = apache_request_headers();
    }
    
    $authHeader = '';
    if ($headers && isset($headers['Authorization'])) {
        $authHeader = $headers['Authorization'];
    } elseif ($headers && isset($headers['authorization'])) {
        $authHeader = $headers['authorization'];
    } elseif (isset($_SERVER['HTTP_AUTHORIZATION'])) {
        $authHeader = $_SERVER['HTTP_AUTHORIZATION'];
    } elseif (isset($_SERVER['REDIRECT_HTTP_AUTHORIZATION'])) {
        $authHeader = $_SERVER['REDIRECT_HTTP_AUTHORIZATION'];
    }
    
    if (strpos($authHeader, 'Bearer') !== false) {
        $token = trim(str_replace('Bearer', '', $authHeader));
    } else {
        $token = trim($authHeader);
    }
}

// Token Doğrulaması
if ($token !== $SECRET_API_KEY) {
    http_response_code(401);
    echo json_encode(["message" => "Yetkisiz Erişim. Geçersiz API Anahtarı.", "status" => "error"]);
    exit();
}

require_once '../db.php';

if (!$data || !isset($data['action'])) {
    http_response_code(400);
    echo json_encode(["message" => "Eksik parametreler veya hatalı JSON formatı.", "status" => "error"]);
    exit();
}

$action = $data['action'];

// Slug oluşturucu fonksiyon
function createSlug($text) {
    $find = ['Ç', 'Ş', 'Ğ', 'Ü', 'İ', 'Ö', 'ç', 'ş', 'ğ', 'ü', 'ö', 'ı', '+', '#'];
    $replace = ['c', 's', 'g', 'u', 'i', 'o', 'c', 's', 'g', 'u', 'o', 'i', 'plus', 'sharp'];
    $text = str_replace($find, $replace, $text);
    $text = preg_replace('/[^a-zA-Z0-9\s-]/', '', $text);
    $text = preg_replace('/[\s-]+/', '-', $text);
    $text = trim($text, '-');
    return strtolower($text);
}

// ----------------------------------------------------
// 1. BLOG EKLEME (action: add_blog)
// ----------------------------------------------------
if ($action === 'add_blog') {
    $title = isset($data['title']) ? trim($data['title']) : '';
    $content = isset($data['content']) ? trim($data['content']) : '';
    $seo_title = isset($data['seo_title']) ? trim($data['seo_title']) : '';
    $seo_description = isset($data['seo_description']) ? trim($data['seo_description']) : '';
    $remote_image_url = isset($data['image_url']) ? trim($data['image_url']) : '';

    if (empty($title) || empty($content)) {
        http_response_code(400);
        echo json_encode(["message" => "Başlık ve içerik alanları zorunludur.", "status" => "error"]);
        exit();
    }

    $slug = createSlug($title);
    
    // Sabit görsel (Necati Özçimen'in fotoğrafı) her blogda varsayılan olarak kullanılacak
    $local_image_path = 'uploads/blog_1783859991_3886.jpeg';

    try {
        $stmt = $db->prepare("INSERT INTO blogs (title, slug, content, seo_title, seo_description, image_url) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$title, $slug, $content, $seo_title, $seo_description, $local_image_path]);
        
        http_response_code(201);
        echo json_encode(["message" => "Blog başarıyla eklendi.", "status" => "success", "slug" => $slug]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(["message" => "Veritabanı hatası: " . $e->getMessage(), "status" => "error"]);
    }
} 
// ----------------------------------------------------
// 2. SSS EKLEME (action: add_faq)
// ----------------------------------------------------
elseif ($action === 'add_faq') {
    $question = isset($data['question']) ? trim($data['question']) : '';
    $answer = isset($data['answer']) ? trim($data['answer']) : '';

    if (empty($question) || empty($answer)) {
        http_response_code(400);
        echo json_encode(["message" => "Soru ve cevap alanları zorunludur.", "status" => "error"]);
        exit();
    }

    try {
        $stmt = $db->prepare("INSERT INTO faqs (question, answer) VALUES (?, ?)");
        $stmt->execute([$question, $answer]);
        
        http_response_code(201);
        echo json_encode(["message" => "SSS başarıyla eklendi.", "status" => "success"]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(["message" => "Veritabanı hatası: " . $e->getMessage(), "status" => "error"]);
    }
} else {
    http_response_code(400);
    echo json_encode(["message" => "Geçersiz işlem (action) türü.", "status" => "error"]);
}
