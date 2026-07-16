<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

require_once '../db.php';

$response = [
    'status' => 'success',
    'data' => [
        'slider' => [
            ['id' => 1, 'image' => 'https://via.placeholder.com/800x400?text=Konya+Tup+Bebek+Slider+1', 'title' => 'Hayallerinize Bir Adım Daha Yakın'],
            ['id' => 2, 'image' => 'https://via.placeholder.com/800x400?text=Konya+Tup+Bebek+Slider+2', 'title' => 'Profesyonel Tedavi Yöntemleri']
        ],
        'blogs' => [],
        'statistics' => [],
        'testimonials' => []
    ]
];

try {
    // Get latest 5 blogs
    $stmtBlogs = $db->prepare("SELECT id, title, image_url, created_at, slug FROM blogs ORDER BY created_at DESC LIMIT 5");
    $stmtBlogs->execute();
    $blogs = $stmtBlogs->fetchAll(PDO::FETCH_ASSOC);
    
    // Add base url to images
    foreach ($blogs as &$blog) {
        if ($blog['image_url']) {
            $blog['image_url'] = BASE_URL . $blog['image_url'];
        }
    }
    $response['data']['blogs'] = $blogs;

    // Get statistics
    $stmtStats = $db->prepare("SELECT * FROM statistics ORDER BY id ASC");
    $stmtStats->execute();
    $response['data']['statistics'] = $stmtStats->fetchAll(PDO::FETCH_ASSOC);

    // Get testimonials
    $stmtTesti = $db->prepare("SELECT id, patient_name as name, message FROM testimonials ORDER BY id DESC LIMIT 5");
    $stmtTesti->execute();
    $response['data']['testimonials'] = $stmtTesti->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    $response['status'] = 'error';
    $response['message'] = 'Database error: ' . $e->getMessage();
}

echo json_encode($response);
?>
